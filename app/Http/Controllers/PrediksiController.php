<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perenang;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PrediksiController extends Controller
{
    public function show($id)
    {
        $atlet = Perenang::findOrFail($id);
        return view('prediksi', compact('atlet'));
    }

   public function calculate(Request $request)
    {
        $request->validate([
            'atlet_id' => 'required|exists:perenangs,id',
            'gaya'     => 'required|string',
            'jarak'    => 'required|string',
        ]);

        $perenang = Perenang::find($request->atlet_id);
        if (!$perenang) {
            return response()->json(['error' => 'Data perenang tidak ditemukan.'], 404);
        }

        // Pastikan perenang ini milik user yang sedang login sebelum melakukan prediksi
        if ($perenang->user_id !== auth()->id()) {
            return response()->json(['error' => 'Akses tidak sah.'], 403);
        }

        $usia_asli = Carbon::parse($perenang->tanggal_lahir)->age;
        $usia = $this->kategoriUsia($usia_asli);
        $jenis_kelamin_numeric = ($perenang->jenis_kelamin === 'Laki-laki') ? 0 : 1;
        $gaya_numeric = $this->mapGayaToNumeric($request->gaya);

        $jarak = $request->jarak; // Contoh: 50m, 100m
        $jarak_label = str_replace('m', ' meter', $jarak); // Untuk ditampilkan ke pengguna
        $jarak_numeric = $this->mapJarakToNumeric($jarak);

        $features_for_model = array_map('floatval',[
            $usia,
            $jenis_kelamin_numeric,
            $perenang->tinggi,
            $perenang->berat,
            $perenang->panjang_lengan_kiri,
            $perenang->panjang_lengan_kanan,
            $perenang->panjang_armspan,
            $perenang->panjang_kaki,
            $jarak_numeric,
            $gaya_numeric
        ]);

        Log::info('Fitur yang dikirim ke microservice:', $features_for_model);

        $flask_microservice_url = 'https://itsshun-coba-test.hf.space/predict';

        try {
            $client = new Client();
            $response = $client->post($flask_microservice_url, [
                'json'    => ['fitur' => $features_for_model],
                'timeout' => 30,
                'headers' => ['Accept' => 'application/json']
            ]);

            $data = json_decode($response->getBody(), true);
            $predictedTimeRaw = $data['hasil_prediksi'] ?? null;

            if (!is_numeric($predictedTimeRaw) || $predictedTimeRaw <= 0) {
                Log::error('Hasil prediksi tidak valid dari microservice.', ['response' => $data]);
                return response()->json([
                    'error' => 'Hasil prediksi tidak valid dari microservice.',
                    'debug_response' => $data
                ], 500);
            }

            $kelompok = $this->mapKategoriUsiaToLabel($usia);
            $jk = $perenang->jenis_kelamin === 'Laki-laki' ? 'M' : 'W';
            $gaya_label_qet = $this->mapGayaToQETKey($request->gaya); // Gunakan nama variabel yang berbeda agar tidak ambigu

            Log::info("Parameter QET:", [
                'kelompok' => $kelompok,
                'jk'       => $jk,
                'gaya'     => $gaya_label_qet,
                'jarak'    => $jarak
            ]);

            $qetTime = $this->getQetTime($kelompok, $jk, $gaya_label_qet, $jarak);

            $predictedPerformance = 'Unknown'; // Default
            if ($qetTime !== null) {
                // Pastikan $predictedTimeRaw tidak nol untuk menghindari pembagian dengan nol
                if ($predictedTimeRaw > 0) {
                    $performancePercentage = ($qetTime / $predictedTimeRaw) * 100;

                    $predictedPerformance = match (true) {
                        $performancePercentage > 100     => 'Very High',
                        $performancePercentage >= 90     => 'High',
                        $performancePercentage >= 60     => 'Medium',
                        default                          => 'Low',
                    };
                } else {
                    Log::warning("Waktu prediksi mentah adalah nol, tidak dapat menghitung persentase performa.");
                }
            } else {
                Log::warning("QET tidak ditemukan untuk kombinasi key:", compact('kelompok', 'jk', 'gaya_label_qet', 'jarak'));
            }

            // Mengubah prediksi waktu model menjadi format menit:detik.milidetik
            $menit = floor($predictedTimeRaw / 60);
            $detik = $predictedTimeRaw - ($menit * 60);
            $formattedTime = sprintf("%d:%05.2f", $menit, $detik); // Format: M:SS.ms

            // --- Bagian Penting: Menyimpan hasil prediksi ke database ---
            $perenang->last_prediction_gaya = $request->gaya;   
            $perenang->last_prediction_jarak = $request->jarak; 
            $perenang->last_prediction_time = $predictedTimeRaw; // Simpan waktu mentah (detik)
            $perenang->last_prediction_performance = $predictedPerformance;
            $perenang->last_prediction_percentage  = round($performancePercentage, 2);
            $perenang->last_prediction_date = Carbon::now()->toDateString(); // Simpan tanggal hari ini
            $perenang->save();
            // --- Akhir Bagian Penting ---

            return response()->json([
                'predicted_time'        => $formattedTime,
                'predicted_performance' => $predictedPerformance,
                'performance_percentage' => round($performancePercentage, 2),
                'gaya_label'            => $this->labelGaya($request->gaya),
                'jarak_label'           => $jarak_label,
                'raw_time'              => $predictedTimeRaw // Opsional: untuk debugging
            ]);

        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            Log::error('Koneksi ke microservice gagal: ' . $e->getMessage());
            return response()->json([
                'error'   => 'Koneksi ke microservice gagal. Pastikan microservice berjalan.',
                'message' => $e->getMessage()
            ], 500);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            Log::error('Microservice mengembalikan error klien: ' . $e->getResponse()?->getBody()?->getContents());
            return response()->json([
                'error'   => 'Microservice mengembalikan error klien.',
                'message' => $e->getResponse()?->getBody()?->getContents()
            ], 400);
        } catch (\Exception $e) {
            Log::error('Terjadi kesalahan tidak terduga di PrediksiController@calculate: ' . $e->getMessage());
            return response()->json([
                'error'   => 'Terjadi kesalahan tidak terduga.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function kategoriUsia(int $usia): int
    {
        return match (true) {
            $usia >= 6 && $usia <= 11 => 1,
            $usia >= 12 && $usia <= 13 => 2,
            $usia >= 14 && $usia <= 15 => 3,
            default => 0,
        };
    }

    private function mapKategoriUsiaToLabel(int $kategori): string
    {
        return match ($kategori) {
            1 => 'AG4',
            2 => 'AG3',
            3 => 'AG2',
            default => 'SENIOR',
        };
    }

    private function mapGayaToNumeric(string $gaya): int
    {
        return match ($gaya) {
            'gaya_bebas'    => 1,
            'gaya_dada'     => 2,
            'gaya_punggung' => 3,
            'gaya_kupu'     => 4,
            'gaya_medley'   => 5,
            default         => 0,
        };
    }

    private function mapGayaToQETKey(string $gaya): string
    {
        return match ($gaya) {
            'gaya_bebas'    => 'FREE',
            'gaya_dada'     => 'BREAST',
            'gaya_punggung' => 'BACK',
            'gaya_kupu'     => 'FLY',
            'gaya_medley'   => 'MEDLEY',
            default         => '',
        };
    }

    private function labelGaya(string $gaya): string
    {
        return match ($gaya) {
            'gaya_bebas'    => 'Gaya Bebas',
            'gaya_dada'     => 'Gaya Dada',
            'gaya_punggung' => 'Gaya Punggung',
            'gaya_kupu'     => 'Gaya Kupu-kupu',
            'gaya_medley'   => 'Gaya Medley',
            default         => $gaya,
        };
    }

    private function mapJarakToNumeric(string $jarak): int
    {
        return match ($jarak) {
            '50m'  => 50,
            '100m' => 100,
            '200m' => 200,
            '400m' => 400,
            default => 0,
        };
    }

    private function getQetTime(string $kelompok, string $jk, string $gaya, string $jarak): ?float
    {
        // Gunakan data QET dari skripsimu
        $qetTable = [
            'FREE' => [
                '50m' => [
                    'SENIOR' => ['M' => '00:26.35', 'W' => '00:30.43'],
                    'AG1'    => ['M' => '00:26.92', 'W' => '00:30.43'],
                    'AG2'    => ['M' => '00:28.32', 'W' => '00:31.15'],
                    'AG3'    => ['M' => '00:29.82', 'W' => '00:32.71'],
                    'AG4'    => ['M' => '00:34.86', 'W' => '00:37.93'],
                ],
                '100m' => [
                    'SENIOR' => ['M' => '00:58.31', 'W' => '01:06.22'],
                    'AG1'    => ['M' => '00:59.51', 'W' => '01:06.22'],
                    'AG2'    => ['M' => '01:02.47', 'W' => '01:07.80'],
                    'AG3'    => ['M' => '01:05.28', 'W' => '01:11.19'],
                    'AG4'    => ['M' => '01:16.91', 'W' => '01:22.54'],
                ],
                '200m' => [
                    'SENIOR' => ['M' => '02:08.31', 'W' => '02:22.72'],
                    'AG1'    => ['M' => '02:11.37', 'W' => '02:22.72'],
                    'AG2'    => ['M' => '02:17.94', 'W' => '02:26.12'],
                    'AG3'    => ['M' => '02:25.20', 'W' => '02:33.42'],
                    'AG4'    => ['M' => '02:49.77', 'W' => '02:57.88'],
                ],
                '400m' => [
                    'SENIOR' => ['M' => '04:25.95', 'W' => '04:58.65'],
                    'AG1'    => ['M' => '04:36.38', 'W' => '04:58.65'],
                    'AG2'    => ['M' => '04:50.20', 'W' => '05:05.76'],
                    'AG3'    => ['M' => '05:05.47', 'W' => '05:21.05'],
                    'AG4'    => ['M' => '05:57.17', 'W' => '06:12.23'],
                ],
                '800m' => [
                    'SENIOR' => ['M' => '09:22.64', 'W' => '10:19.53'],
                    'AG1'    => ['M' => '09:46.38', 'W' => '10:19.53'],
                    'AG2'    => ['M' => '10:14.54', 'W' => '10:34.12'],
                    'AG3'    => ['M' => '10:36.67', 'W' => '11:06.00'],
                ],
                '1500m' => [
                    'SENIOR' => ['M' => '17:44.85', 'W' => '19:52.30'],
                    'AG1'    => ['M' => '18:10.20', 'W' => '19:52.30'],
                    'AG2'    => ['M' => '18:53.19', 'W' => '19:54.71'],
                    'AG3'    => ['M' => '20:04.96', 'W' => '21:21.73'],
                ],
            ],
            'BACK' => [
                '50m' => [
                    'SENIOR' => ['M' => '00:29.08', 'W' => '00:33.59'],
                    'AG1'    => ['M' => '00:29.77', 'W' => '00:33.59'],
                    'AG2'    => ['M' => '00:31.26', 'W' => '00:34.39'],
                    'AG3'    => ['M' => '00:32.91', 'W' => '00:36.11'],
                    'AG4'    => ['M' => '00:38.55', 'W' => '00:41.85'],
                ],
                '100m' => [
                    'SENIOR' => ['M' => '01:03.88', 'W' => '01:13.47'],
                    'AG1'    => ['M' => '01:05.40', 'W' => '01:13.47'],
                    'AG2'    => ['M' => '01:08.68', 'W' => '01:15.21'],
                    'AG3'    => ['M' => '01:12.29', 'W' => '01:18.98'],
                    'AG4'    => ['M' => '01:24.52', 'W' => '01:31.57'],
                ],
                '200m' => [
                    'SENIOR' => ['M' => '02:20.88', 'W' => '02:37.83'],
                    'AG1'    => ['M' => '02:24.74', 'W' => '02:37.83'],
                    'AG2'    => ['M' => '02:31.45', 'W' => '02:46.58'],
                    'AG3'    => ['M' => '02:39.42', 'W' => '02:49.66'],
                ],
            ],
            'BREAST' => [
                '50m' => [
                    'SENIOR' => ['M' => '00:31.37', 'W' => '00:37.36'],
                    'AG1'    => ['M' => '00:32.14', 'W' => '00:37.36'],
                    'AG2'    => ['M' => '00:33.73', 'W' => '00:38.25'],
                    'AG3'    => ['M' => '00:35.50', 'W' => '00:40.16'],
                    'AG4'    => ['M' => '00:47.51', 'W' => '00:50.57'],
                ],
                '100m' => [
                    'SENIOR' => ['M' => '01:11.81', 'W' => '01:21.14'],
                    'AG1'    => ['M' => '01:14.32', 'W' => '01:21.14'],
                    'AG2'    => ['M' => '01:17.20', 'W' => '01:23.07'],
                    'AG3'    => ['M' => '01:21.26', 'W' => '01:27.22'],
                    'AG4'    => ['M' => '01:35.02', 'W' => '01:41.13'],
                ],
                '200m' => [
                    'SENIOR' => ['M' => '02:37.40', 'W' => '02:57.01'],
                    'AG1'    => ['M' => '02:41.14', 'W' => '02:57.01'],
                    'AG2'    => ['M' => '02:49.20', 'W' => '02:58.10'],
                    'AG3'    => ['M' => '02:58.11', 'W' => '03:10.27'],
                ],
            ],
            'FLY' => [
                '50m' => [
                    'SENIOR' => ['M' => '00:27.72', 'W' => '00:31.86'],
                    'AG1'    => ['M' => '00:28.38', 'W' => '00:31.86'],
                    'AG2'    => ['M' => '00:29.80', 'W' => '00:32.62'],
                    'AG3'    => ['M' => '00:31.37', 'W' => '00:34.25'],
                ],
                '100m' => [
                    'SENIOR' => ['M' => '01:01.36', 'W' => '01:10.41'],
                    'AG1'    => ['M' => '01:02.84', 'W' => '01:10.41'],
                    'AG2'    => ['M' => '01:05.96', 'W' => '01:12.08'],
                    'AG3'    => ['M' => '01:09.43', 'W' => '01:15.69'],
                    'AG4'    => ['M' => '01:21.18', 'W' => '01:27.75'],
                ],
                '200m' => [
                    'SENIOR' => ['M' => '02:19.14', 'W' => '02:34.47'],
                    'AG1'    => ['M' => '02:22.45', 'W' => '02:34.47'],
                    'AG2'    => ['M' => '02:29.57', 'W' => '02:38.14'],
                    'AG3'    => ['M' => '02:37.45', 'W' => '02:46.05'],
                ],
            ],
            'MEDLEY' => [
                '200m' => [
                    'SENIOR' => ['M' => '02:21.53', 'W' => '02:38.64'],
                    'AG1'    => ['M' => '02:24.90', 'W' => '02:38.64'],
                    'AG2'    => ['M' => '02:32.15', 'W' => '02:42.42'],
                    'AG3'    => ['M' => '02:40.16', 'W' => '02:50.54'],
                    'AG4'    => ['M' => '03:07.26', 'W' => '03:17.72'],
                ],
                '400m' => [
                    'SENIOR' => ['M' => '05:03.84', 'W' => '05:35.48'],
                    'AG1'    => ['M' => '05:11.07', 'W' => '05:35.48'],
                    'AG2'    => ['M' => '05:26.63', 'W' => '05:43.62'],
                    'AG3'    => ['M' => '06:00.64', 'W' => '06:18.97'],
                    'AG4'    => ['M' => '06:42.00', 'W' => '06:58.13'],
                ],
            ],
        ];

        $timeString = $qetTable[$gaya][$jarak][$kelompok][$jk] ?? null;

        if (!$timeString) return null;

        [$menit, $detik] = explode(':', $timeString);
        return floatval($menit) * 60 + floatval(str_replace(',', '.', $detik));
    }
    public function showPredictionHistory($id)
    {
        $perenang = Perenang::findOrFail($id);

        // Pastikan perenang ini milik user yang sedang login
        if ($perenang->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $controller = $this;

        return view('history', compact('perenang')); // Akan membuat view history.blade.php
    }
}
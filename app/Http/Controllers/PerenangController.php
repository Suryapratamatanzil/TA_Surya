<?php

namespace App\Http\Controllers;

use App\Models\Perenang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Penting: Import Auth facade
use Carbon\Carbon; // Import Carbon jika digunakan di sini untuk tanggal_lahir

// Jika Anda menggunakan Guzzle untuk microservice, pastikan ini juga diimport
// use GuzzleHttp\Client;

class PerenangController extends Controller
{
    /**
     * Konstruktor untuk melindungi controller dengan middleware 'auth'.
     * Ini memastikan hanya user yang login yang bisa mengakses metode di controller ini.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * Metode ini perlu disesuaikan jika Anda menampilkan daftar perenang di sini,
     * yaitu dengan memfilter berdasarkan Auth::id().
     * Jika Anda menampilkan daftar di HomeController, maka tidak perlu diubah di sini.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     * User harus login untuk mengakses halaman tambah perenang.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tambah');
    }

    /**
     * Store a newly created resource in storage.
     * Data perenang baru akan disimpan dengan user_id dari user yang sedang login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'tinggi' => 'required|numeric|min:1',
            'berat' => 'required|numeric|min:1',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'panjang_kaki' => 'required|numeric|min:1',
            'panjang_lengan_kiri' => 'required|numeric|min:1',
            'panjang_lengan_kanan' => 'required|numeric|min:1',
            'panjang_armspan' => 'required|numeric|min:1',
        ]);

        // Tambahkan user_id dari user yang sedang login ke data yang akan disimpan
        $validatedData['user_id'] = Auth::id();

        Perenang::create($validatedData);

        // Mengarahkan kembali ke halaman beranda (home) setelah berhasil menyimpan
        return redirect()->route('beranda')->with('success', 'Data perenang berhasil ditambahkan!');
        // Catatan: Pastikan ada route dengan nama 'home' yang mengarah ke halaman beranda Anda
        // yang sudah menampilkan data perenang berdasarkan user yang login.
    }

    /**
     * Display the specified resource.
     * @param  \App\Models\Perenang  $perenang
     * @return \Illuminate\Http\Response
     */
    public function show(Perenang $perenang)
    {
        // Metode ini biasanya digunakan untuk menampilkan detail satu perenang.
        // Jika Anda menggunakan route model binding ($perenang), Laravel akan otomatis mengambil perenang.
        // Namun, untuk keamanan, pastikan user yang login memiliki akses ke perenang ini.
        if ($perenang->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.'); // Forbidden
        }
        return view('perenang.show', compact('perenang')); // Contoh view untuk detail
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \App\Models\Perenang  $perenang
     * @return \Illuminate\Http\Response
     */
    public function edit(Perenang $perenang)
    {
        // Pastikan user yang login memiliki akses untuk mengedit perenang ini
        if ($perenang->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }
        return view('perenang.edit', compact('perenang')); // Contoh view untuk edit
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Perenang  $perenang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Perenang $perenang)
    {
        // Pastikan user yang login memiliki akses untuk mengupdate perenang ini
        if ($perenang->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $validatedData = $request->validate([
            // Validasi seperti di store, tanpa user_id karena tidak berubah
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'tinggi' => 'required|numeric|min:1',
            'berat' => 'required|numeric|min:1',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'panjang_kaki' => 'required|numeric|min:1',
            'panjang_lengan_kiri' => 'required|numeric|min:1',
            'panjang_lengan_kanan' => 'required|numeric|min:1',
            'panjang_armspan' => 'required|numeric|min:1',
        ]);

        $perenang->update($validatedData);

        return redirect()->route('home')->with('success', 'Data perenang berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     * @param  \App\Models\Perenang  $perenang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Perenang $perenang)
    {
        // Pastikan user yang login memiliki akses untuk menghapus perenang ini
        if ($perenang->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $perenang->delete();

        return redirect()->route('home')->with('success', 'Data perenang berhasil dihapus!');
    }

    /**
     * Menampilkan halaman prediksi untuk atlet spesifik.
     * Ini adalah metode yang Anda gunakan untuk halaman prediksi.
     */
    public function prediksi(Request $request, $id)
    {
        // Cari data atlet (Perenang) berdasarkan ID dan PASTIKAN MILIK USER YANG LOGIN
        $atlet = Perenang::where('id', $id)
                         ->where('user_id', Auth::id())
                         ->firstOrFail(); // Akan throw ModelNotFoundException (404) jika tidak ditemukan atau bukan milik user

        // Komentar dan kode HttpClient sebelumnya telah dihapus dari sini
        // karena logika pemanggilan microservice ada di PrediksiController@calculate
        // dan metode ini hanya untuk menampilkan halaman prediksi.

        return view('prediksi', compact('atlet'));
    }
}
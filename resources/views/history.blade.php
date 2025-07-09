<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Prediksi - {{ $perenang->nama }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .header-back {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            color: #343a40;
            text-decoration: none;
            font-size: 1.2rem;
            font-weight: bold;
        }
        .header-back i {
            margin-right: 10px;
        }
        h2 {
            font-weight: bold;
            color: #004478;
            margin-bottom: 20px;
            text-align: center;
        }
        h3 {
            font-weight: bold;
            color: #343a40;
            margin-bottom: 25px;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }
        .data-perenang-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .data-perenang-table th, .data-perenang-table td {
            border: 1px solid #dee2e6;
            padding: 10px;
            text-align: center;
            vertical-align: middle;
        }
        .data-perenang-table th {
            background-color: #e9ecef;
            font-weight: bold;
            color: #495057;
        }
        .prediction-header-container { /* Kontainer untuk judul dan tanggal prediksi */
            display: flex;
            justify-content: center;
            align: center;
            text-align: center;
            align-items: baseline; /* Menyelaraskan teks dasar */
            margin-bottom: 20px; /* Jarak bawah */
        }
        .prediction-header-container h4 {
            font-weight: bold;
            color: #343a40;
            margin-bottom: 0; /* Hapus margin bawah default h4 */
        }
        .prediction-date {
            color: #6c757d; /* Warna teks abu-abu */
            align : center;
            margin-left: 5px;
        }
        .prediction-section {
            display: flex;
            justify-content: space-around;
            align-items: flex-start;
            flex-wrap: wrap;
            margin-bottom: 40px;
            padding: 20px;
            border: 1px solid #f0f0f0;
            border-radius: 8px;
            background-color: #fcfcfc;
        }
        .prediction-item {
            text-align: center;
            padding: 15px;
            flex: 1;
            min-width: 250px;
        }
        .prediction-item h5 {
            color: #6c757d;
            font-weight: normal;
            font-size: 1rem;
            margin-bottom: 10px;
        }
        .prediction-item .value {
            font-size: 2.5rem;
            font-weight: bold;
            color: #004478;
            margin-top: 5px;
        }
        .btn-predict-ulang {
            background-color:rgb(0, 0, 0);
            color: #ffffff;
            font-weight: bold;
            padding: 12px 30px;
            border-radius: 5px;
            border: none;
            display: block;
            margin: 0 auto;
            width: fit-content;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-predict-ulang:hover {
            background-color: rgb(0, 0, 0);
            color: #ffffff;
        }
        .btn-predict-ulang i {
            margin-right: 10px;
        }
        /* Styling untuk pesan sukses/error */
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 0.25rem;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 0.25rem;
        }
        /* CSS untuk Hasil Prediksi */
        .result-section {
            text-align: center;
            margin-top: 40px;
        }
        .prediction-box {
            background-color: #fff;
            padding: 25px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-top: 20px;
            text-align: left;
        }
        .prediction-box h4 {
            font-size: 1rem;
            color: #666;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        .prediction-box h4 i {
            margin-right: 8px;
            color: #007bff;
        }
        .prediction-box .value {
            font-size: 2.5rem;
            font-weight: bold;
            color: #333;
            line-height: 1;
            margin-bottom: 5px;
        }
        .prediction-box .unit {
            font-size: 1rem;
            color: #666;
        }
        .prediction-box .performance-label {
            font-size: 2.5rem; /* Ukuran font lebih besar seperti di gambar */
            font-weight: bold;
        }
        .performance-options span {
            font-size: 0.9rem;
            color: #999;
            margin-left: 5px;
            font-weight: normal; /* Pastikan tidak bold secara default */
        }
        /* Style untuk opsi Very High, High, Medium, Low */
        .performance-options .very-high { color: #004d00; font-weight: bold; } /* Hijau tua/Dark Green */
        .performance-options .high { color: #28a745; font-weight: bold; } /* Hijau */
        .performance-options .medium { color: #ffc107; font-weight: bold; } /* Kuning */
        .performance-options .low { color: #dc3545; font-weight: bold; } /* Merah */

        /* Untuk styling background label high/medium/low */
        .performance-options .active-label {
            /* Anda bisa tambahkan background atau border jika diinginkan,
                tapi gambar hanya menunjukkan perubahan warna teks dan bold */
            font-weight: bold;
        }

    </style>
</head>
<body>

<div class="container my-5">
    <a href="{{ route('beranda') }}" class="header-back">
        <i class="fas fa-arrow-left mr-4"></i> History
    </a>

    {{-- Menampilkan pesan sukses atau error --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <h3>{{ strtoupper($perenang->nama) }}</h3>

    <div class="table-responsive">
        <table class="data-perenang-table">
            <thead>
                <tr>
                    <th rowspan="2">Usia</th>
                    <th rowspan="2">Jenis Kelamin</th>
                    <th rowspan="2">Tinggi Badan</th>
                    <th rowspan="2">Berat Badan</th>
                    <th rowspan="2">Panjang Tungkai</th>
                    <th colspan="3">Armspan</th>
                </tr>
                <tr>
                    <th>Kiri</th>
                    <th>Kanan</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ \Carbon\Carbon::parse($perenang->tanggal_lahir)->age }}</td>
                    <td>{{ $perenang->jenis_kelamin }}</td>
                    <td>{{ $perenang->tinggi }}</td>
                    <td>{{ $perenang->berat }}</td>
                    <td>{{ $perenang->panjang_kaki }}</td>
                    <td>{{ $perenang->panjang_lengan_kiri }}</td>
                    <td>{{ $perenang->panjang_lengan_kanan }}</td>
                    <td>{{ $perenang->panjang_armspan }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    @if($perenang->last_prediction_time && $perenang->last_prediction_performance && $perenang->last_prediction_date)
    <div class="prediction-header-container">
    <h4>
        Hasil Prediksi
         {{ $perenang->last_prediction_gaya ? ' ' . $perenang->label_gaya : 'Gaya' }}
        {{ $perenang->last_prediction_jarak ?? '' }}

    </h4>
    <h4 class="prediction-date" style="color: #6c757d">
        {{ \Carbon\Carbon::parse($perenang->last_prediction_date)->format('Y/m/d') }}
    </h4>
    </div>
            
       <div class="row justify-content-center">
    <!-- Prediksi Waktu -->
    <div class="col-lg-5 col-md-6 mb-4">
        <div class="prediction-box">
            <h4><i class="far fa-clock"></i> Prediksi Waktu <span class="unit">Detik</span></h4>
            <div class="value">
                @php
                    $menit = floor($perenang->last_prediction_time / 60);
                    $detik = $perenang->last_prediction_time - ($menit * 60);
                    $formattedTime = sprintf("%d:%05.2f", $menit, $detik);
                @endphp
                {{ $formattedTime }}
            </div>
        </div>
    </div>

    <!-- Prediksi Performa -->
    <div class="col-lg-5 col-md-6 mb-4">
        <div class="prediction-box">
            <h4><i class="fas fa-chart-line"></i> Prediksi Performa
                <span class="performance-options">
                    <span class="{{ $perenang->last_prediction_performance === 'Very High' ? 'very-high' : '' }}">VeryHigh</span>
                    <span class="{{ $perenang->last_prediction_performance === 'High' ? 'high' : '' }}">High</span>
                    <span class="{{ $perenang->last_prediction_performance === 'Medium' ? 'medium' : '' }}">Medium</span>
                    <span class="{{ $perenang->last_prediction_performance === 'Low' ? 'low' : '' }}">Low</span>
                </span>
            </h4>
            <!-- Performance percentage sebagai nilai utama -->
            <div class="value performance-label">
                {{ $perenang->last_prediction_performance }} ({{ number_format($perenang->last_prediction_percentage ?? 0, 2) }}%)
            </div>
        </div>
    </div>
</div>
    @else
        <div class="prediction-header-container">
            <h4>Hasil Prediksi</h4>
        </div>
        <div class="prediction-section">
            <div class="prediction-item" style="width: 100%;">
                <p class="text-muted">Belum ada hasil prediksi untuk perenang ini.</p>
            </div>
        </div>
    @endif

    <!-- {{-- Form untuk Prediksi Ulang --}}
    <form action="{{ route('prediksi.show', $perenang->id) }}" method="GET">
        @csrf
        <input type="hidden" name="atlet_id" value="{{ $perenang->id }}">
        {{-- Menggunakan gaya dan jarak dari prediksi terakhir jika ada, atau nilai default --}}
        <input type="hidden" name="gaya" value="{{ $perenang->last_prediction_gaya ?? 'gaya_bebas' }}">
        <input type="hidden" name="jarak" value="{{ $perenang->last_prediction_jarak ?? '50m' }}">

        <button type="submit" class="btn btn-predict-ulang">
            <i class="bi bi-arrow-repeat"></i> Prediksi Ulang
        </button>
    </form> -->
   <form action="{{ route('perenang.prediksi', $perenang->id) }}">
    <button type="submit" class="btn btn-predict-ulang">
        <i class="bi bi-arrow-repeat"></i> Prediksi Ulang
    </button>
</form>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
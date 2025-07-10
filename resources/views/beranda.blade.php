<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama - SwimLytics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-image: url('/images/Background.png');
            background-size: cover;
            background-repeat: no-repeat;
            padding: 12px 30px;
            padding-right: 0px;
        }
        .navbar-brand {
            color: #ffffff !important;
            font-weight: bold;
            font-size: 1.8rem;
            display: flex;
            align-items: center;
        }
        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }
        .navbar-nav .nav-link {
            color: #ffffff !important;
            margin-left: 20px;
            font-weight: 500;
        }
        .navbar-nav .nav-link:hover {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        .dropdown-toggle {
            color: #ffffff !important;
            font-weight: bold;
            font-size: 1.1rem;
        }
        .dropdown-menu {
            background-color: #FF0000;
            border-radius: 0px;
            padding-right: 0px;
            margin-top: 50px;
        }
        .content-section {
            padding: 30px;
            margin-top: 20px;
        }
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        .section-header h4 {
            font-weight: bold;
            color: #343a40;
        }
        .btn-add {
            background-color: #004478;
            color: #ffffff;
            font-weight: bold;
            padding: 10px 25px;
            border-radius: 5px;
            border: none;
        }
        .btn-add:hover {
            background-color: rgb(3, 51, 88);
            color: #ffffff;
        }
        .table-responsive {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }
        .table {
            margin-bottom: 0;
        }
        .table th {
            background-color: #e9ecef;
            font-weight: bold;
            color: #495057;
            padding: 15px;
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
        }
        .table td {
            padding: 12px;
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
        }
        .empty-table-message {
            text-align: center;
            padding: 50px;
            color: #6c757d;
            font-style: italic;
        }
        .custom-logout-item {
            color: rgb(255, 255, 255);
            font-weight: bold;
            text-align: center;
        }
        .custom-logout-item:hover,
        .custom-logout-item:focus {
            background-color: #FF0000 !important;
            color: #ffffff !important;
        }
        .container-fluid {
            padding-right: 0px;
        }
        /* Gaya baru untuk tautan nama perenang */
        .swimmer-name-link {
            color: #004478; /* Warna teks tautan */
            text-decoration: none; /* Hapus garis bawah default */
            font-weight: bold; /* Opsional: membuat nama lebih menonjol */
        }
        .swimmer-name-link:hover {
            text-decoration: underline; /* Tambahkan garis bawah saat hover */
            color: #002e50; /* Sedikit lebih gelap saat hover */
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('images/Logo.png') }}" alt="SwimLytics Logo">
            SWIMLYTICS
        </a>
        <div class="ms-auto">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        {{ auth()->user()->name ?? 'Guest' }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end mt-3" aria-labelledby="navbarDropdown">
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item custom-logout-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container content-section">
    <div class="section-header">
        <h4>Data atlet perenang</h4>
        <a href="{{ route('perenang.create') }}" class="btn btn-add">Tambahkan</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th rowspan="2">Nama</th>
                <th rowspan="2">Usia</th>
                <th rowspan="2">Jenis Kelamin</th>
                <th rowspan="2">Tinggi Badan</th>
                <th rowspan="2">Berat Badan</th>
                <th rowspan="2">Panjang Tungkai</th>
                <th colspan="3">Armspan</th>
                <th rowspan="2">Tanggal Terdaftar</th>
                <th rowspan="2">Prediksi</th>
            </tr>
            <tr>
                <th>Kiri</th>
                <th>Kanan</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($perenang as $atlet)
                <tr>
                    {{-- Ini adalah perubahan utama: membungkus nama dengan tautan --}}
                    <td>
                        <a href="{{ route('perenang.prediksi.history', $atlet->id) }}" class="swimmer-name-link">
                            {{ $atlet->nama }}
                        </a>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($atlet->tanggal_lahir)->age }} tahun</td>
                    <td>{{ $atlet->jenis_kelamin }}</td>
                    <td>{{ $atlet->tinggi }} cm</td>
                    <td>{{ $atlet->berat }} kg</td>
                    <td>{{ $atlet->panjang_kaki }} cm</td>
                    <td>{{ $atlet->panjang_lengan_kiri }} cm</td>
                    <td>{{ $atlet->panjang_lengan_kanan }} cm</td>
                    <td>{{ $atlet->panjang_armspan }} cm</td>
                    <td>{{ $atlet->created_at->format('d-m-Y') }}</td>
                    <td>
                        {{-- Tombol prediksi tetap ada jika Anda ingin dua cara akses --}}
                        <a href="{{ route('perenang.prediksi', $atlet->id) }}" class="btn btn-sm btn-dark">
                            <img src="{{ asset('images/icon_prediksi.png') }}" alt="Prediksi">
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" class="empty-table-message">Belum ada perenang</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
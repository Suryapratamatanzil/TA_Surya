<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Halaman Utama - SwimLytics</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <style>
    body {
      background-color: #f8f9fa;
      padding-top: 56px;
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

    .navbar .dropdown {
      position: relative;
    }

    .navbar .dropdown-menu {
      position: absolute;
      top: 100%;
      right: 0;
      left: auto;
      margin-top: 17px;
      background-color: #FF0000;
      border-radius: 0px;
      min-width: 160px;
      z-index: 9999;
    }

    .custom-logout-item {
  background-color: transparent !important;
  color: #ffffff !important;
  font-weight: bold;
  text-align: center;
}

.custom-logout-item:hover,
.custom-logout-item:focus {
  background-color: #c40000 !important;
  color: #ffffff !important;
}

.dropdown-menu .dropdown-item {
  background-color: transparent !important;
}
    .container-fluid {
      padding-right: 0px;
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

    .btn-guide {
      background-color: #28a745;
      color: white;
      border: none;
      padding: 8px 15px;
      border-radius: 5px;
      font-weight: bold;
      transition: all 0.3s ease;
      margin-left: 10px;
    }

    .btn-guide:hover {
      background-color: #218838;
      color: white;
      transform: translateY(-1px);
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

    .swimmer-name-link {
      color: #004478;
      text-decoration: none;
      font-weight: bold;
    }

    .swimmer-name-link:hover {
      text-decoration: underline;
      color: #002e50;
    }

    /* Guide Modal Styles */
    .guide-modal {
      display: none;
      position: fixed;
      z-index: 10000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.8);
      backdrop-filter: blur(5px);
      animation: fadeIn 0.3s ease;
    }

    .guide-modal.show {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    .guide-container {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
      max-width: 900px;
      max-height: 90vh;
      overflow: hidden;
      animation: slideIn 0.3s ease;
      margin: 20px;
    }

    @keyframes slideIn {
      from { 
        transform: scale(0.8) translateY(-50px);
        opacity: 0;
      }
      to { 
        transform: scale(1) translateY(0);
        opacity: 1;
      }
    }

    .guide-header {
      background: linear-gradient(45deg, #004478, #0066cc);
      color: white;
      padding: 30px;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .guide-header::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="white" opacity="0.1"/></svg>') repeat;
      animation: float 20s linear infinite;
    }

    @keyframes float {
      0% { transform: translateX(-50px) translateY(-50px); }
      100% { transform: translateX(50px) translateY(50px); }
    }

    .guide-header h1 {
      font-size: 2.2rem;
      font-weight: bold;
      margin: 0;
      position: relative;
      z-index: 2;
    }

    .guide-header p {
      font-size: 1rem;
      margin: 10px 0 0 0;
      opacity: 0.9;
      position: relative;
      z-index: 2;
    }

    .guide-content {
      padding: 30px;
      max-height: 60vh;
      overflow-y: auto;
    }

    .guide-content::-webkit-scrollbar {
      width: 8px;
    }

    .guide-content::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 4px;
    }

    .guide-content::-webkit-scrollbar-thumb {
      background: #004478;
      border-radius: 4px;
    }

    .step-card {
      background: white;
      border-radius: 15px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
      border-left: 5px solid #004478;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    .step-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 25px rgba(0, 0, 0, 0.12);
    }

    .step-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
      background: linear-gradient(90deg, #004478, #0066cc, #004478);
      background-size: 200% 100%;
      animation: shimmer 3s ease-in-out infinite;
    }

    @keyframes shimmer {
      0%, 100% { background-position: 200% 0; }
      50% { background-position: -200% 0; }
    }

    .step-number {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 35px;
      height: 35px;
      background: linear-gradient(45deg, #004478, #0066cc);
      color: white;
      border-radius: 50%;
      font-weight: bold;
      font-size: 1.1rem;
      margin-bottom: 12px;
      box-shadow: 0 4px 10px rgba(0, 68, 120, 0.3);
    }

    .step-title {
      font-size: 1.2rem;
      font-weight: bold;
      color: #004478;
      margin-bottom: 8px;
    }

    .step-description {
      color: #555;
      line-height: 1.5;
      margin-bottom: 12px;
      font-size: 0.95rem;
    }

    .highlight-box {
      background: linear-gradient(45deg, #fff3cd, #ffeaa7);
      border: 2px solid #ffd93d;
      border-radius: 8px;
      padding: 12px;
      margin: 12px 0;
      position: relative;
      font-size: 0.9rem;
    }

    .highlight-box::before {
      content: '💡';
      font-size: 1.2rem;
      position: absolute;
      top: -8px;
      left: 12px;
      background: white;
      padding: 0 4px;
    }

    .highlight-box .highlight-title {
      font-weight: bold;
      color: #856404;
      margin-bottom: 6px;
      margin-left: 20px;
    }

    .highlight-box .highlight-text {
      color: #856404;
      margin-left: 20px;
      font-size: 0.85rem;
    }

    .warning-box {
      background: linear-gradient(45deg, #f8d7da, #f5c2c7);
      border: 2px solid #dc3545;
      border-radius: 8px;
      padding: 12px;
      margin: 12px 0;
      position: relative;
      font-size: 0.9rem;
    }

    .warning-box::before {
      content: '⚠️';
      font-size: 1.2rem;
      position: absolute;
      top: -8px;
      left: 12px;
      background: white;
      padding: 0 4px;
    }

    .warning-box .warning-title {
      font-weight: bold;
      color: #721c24;
      margin-bottom: 6px;
      margin-left: 20px;
    }

    .warning-box .warning-text {
      color: #721c24;
      margin-left: 20px;
      font-size: 0.85rem;
    }

    .feature-list {
      list-style: none;
      padding: 0;
      font-size: 0.9rem;
    }

    .feature-list li {
      padding: 6px 0;
      color: #555;
      position: relative;
      padding-left: 25px;
    }

    .feature-list li::before {
      content: '✓';
      color: #28a745;
      font-weight: bold;
      position: absolute;
      left: 0;
      top: 6px;
      width: 18px;
      height: 18px;
      background: rgba(40, 167, 69, 0.1);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.7rem;
    }

    .age-info {
      background: linear-gradient(45deg, #e3f2fd, #bbdefb);
      border: 2px solid #2196f3;
      border-radius: 12px;
      padding: 18px;
      margin: 18px 0;
      text-align: center;
      position: relative;
    }

    .age-info::before {
      content: '👶👧🧒';
      font-size: 1.5rem;
      position: absolute;
      top: -12px;
      left: 50%;
      transform: translateX(-50%);
      background: white;
      padding: 0 8px;
    }

    .age-info h4 {
      color: #1565c0;
      font-weight: bold;
      margin: 12px 0 8px 0;
      font-size: 1.1rem;
    }

    .age-info p {
      color: #1565c0;
      margin: 0;
      font-size: 1rem;
    }

    .close-btn {
      position: absolute;
      top: 15px;
      right: 15px;
      background: rgba(255, 255, 255, 0.9);
      border: none;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      font-size: 1.2rem;
      color: #004478;
      cursor: pointer;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
      z-index: 10001;
    }

    .close-btn:hover {
      background: white;
      transform: scale(1.1);
      color: #dc3545;
    }

    .progress-bar {
      height: 4px;
      background: #e9ecef;
      border-radius: 2px;
      margin: 20px 0;
      overflow: hidden;
    }

    .progress-fill {
      height: 100%;
      background: linear-gradient(90deg, #004478, #0066cc);
      border-radius: 2px;
      animation: progress 2s ease-in-out;
    }

    @keyframes progress {
      from { width: 0; }
      to { width: 100%; }
    }

    .btn-demo {
      background: linear-gradient(45deg, #004478, #0066cc);
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 20px;
      font-weight: bold;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(0, 68, 120, 0.3);
      font-size: 0.9rem;
    }

    .btn-demo:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(0, 68, 120, 0.4);
      color: white;
    }

    @media (max-width: 768px) {
      .guide-container {
        margin: 10px;
        max-height: 95vh;
      }
      
      .guide-content {
        padding: 20px;
        max-height: 70vh;
      }
      
      .step-card {
        padding: 15px;
      }
      
      .guide-header h1 {
        font-size: 1.8rem;
      }

      .guide-header {
        padding: 20px;
      }
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
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
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
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
    <div>
      <button class="btn btn-guide" onclick="showGuide()">
        <i class="fas fa-question-circle me-1"></i>Panduan
      </button>
      <a href="{{ route('perenang.create') }}" class="btn btn-add">Tambahkan</a>
    </div>
  </div>

  <p class="text-muted fst-italic mb-2">
    *Untuk melihat riwayat seorang perenang, klik nama perenang yang ingin dilihat
  </p>
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

<!-- Guide Modal -->
<div id="guideModal" class="guide-modal">
  <div class="guide-container">
    <button class="close-btn" onclick="closeGuide()" title="Tutup Panduan">
      <i class="fas fa-times"></i>
    </button>
    
    <div class="guide-header">
      <img src="{{ asset('images/Logo.png') }}" alt="SwimLytics Logo"></i>
      <p>Panduan Lengkap Penggunaan Aplikasi SwimLytics</p>
    </div>

    <div class="guide-content">
      <div class="age-info">
        <h4>Informasi Penting Tentang Usia Perenang</h4>
        <p>Aplikasi ini dirancang khusus untuk prediksi bakat perenang berusia <strong>6-14 tahun</strong><br>
        untuk hasil prediksi yang optimal dan akurat</p>
      </div>

      <div class="progress-bar">
        <div class="progress-fill"></div>
      </div>

      <!-- Step 1 -->
      <div class="step-card">
        <div class="step-number">1</div>
        <div class="step-title">Masuk ke Halaman Beranda</div>
        <div class="step-description">
          Setelah login berhasil, Anda akan diarahkan ke halaman beranda yang menampilkan daftar data atlet perenang yang telah terdaftar.
        </div>
        <div class="highlight-box">
          <div class="highlight-title">Mulai Dari Sini!</div>
          <div class="highlight-text">Jika ini adalah kali pertama Anda menggunakan aplikasi, daftar perenang akan kosong. Jangan khawatir, kita akan menambahkan data perenang pada langkah selanjutnya.</div>
        </div>
      </div>

      <!-- Step 2 -->
      <div class="step-card">
        <div class="step-number">2</div>
        <div class="step-title">Tambah Data Perenang Baru</div>
        <div class="step-description">
          Klik tombol <strong>"Tambahkan"</strong> di halaman beranda untuk menambah data perenang baru. Anda akan diarahkan ke formulir pendaftaran perenang.
        </div>
        <ul class="feature-list">
          <li>Isi semua data yang diperlukan dengan lengkap dan akurat</li>
          <li>Pastikan data antropometri (tinggi, berat, panjang kaki, armspan) diukur dengan teliti</li>
          <li>Gunakan satuan yang benar (cm untuk panjang, kg untuk berat)</li>
        </ul>
        <div class="warning-box">
          <div class="warning-title">Perhatian Khusus untuk Usia</div>
          <div class="warning-text">Pastikan usia perenang berada dalam rentang <strong>6-14 tahun</strong> untuk mendapatkan prediksi yang akurat. Sistem akan memberikan peringatan jika usia di luar rentang optimal.</div>
        </div>
      </div>

      <!-- Step 3 -->
      <div class="step-card">
        <div class="step-number">3</div>
        <div class="step-title">Panduan Pengisian Data Antropometri</div>
        <div class="step-description">
          Sistem akan memberikan indikator visual jika proporsi tubuh tidak sesuai dengan standar ideal:
        </div>
        <ul class="feature-list">
          <li><strong>Panjang Kaki:</strong> Idealnya 52-64% dari tinggi badan</li>
          <li><strong>Armspan Kiri/Kanan:</strong> Masing-masing 44-55% dari tinggi badan</li>
          <li><strong>Armspan Total:</strong> Idealnya 95-110% dari tinggi badan</li>
        </ul>
        <div class="highlight-box">
          <div class="highlight-title">Tips Pengukuran</div>
          <div class="highlight-text">Lakukan pengukuran pada kondisi tubuh yang rileks dan menggunakan alat ukur yang akurat untuk hasil terbaik.</div>
        </div>
      </div>

      <!-- Step 4 -->
      <div class="step-card">
        <div class="step-number">4</div>
        <div class="step-title">Simpan Data Perenang</div>
        <div class="step-description">
          Setelah semua data terisi dengan benar, klik tombol <strong>"Tambah"</strong> untuk menyimpan data. Sistem akan memvalidasi data dan menyimpannya ke database.
        </div>
        <div class="highlight-box">
          <div class="highlight-title">Validasi Otomatis</div>
          <div class="highlight-text">Sistem akan memeriksa kelengkapan dan validitas data sebelum menyimpan. Pastikan tidak ada field yang kosong.</div>
        </div>
      </div>

      <!-- Step 5 -->
      <div class="step-card">
        <div class="step-number">5</div>
        <div class="step-title">Kembali ke Beranda & Lakukan Prediksi</div>
        <div class="step-description">
          Setelah data tersimpan, Anda akan kembali ke halaman beranda. Data perenang yang baru ditambahkan akan muncul dalam tabel.
        </div>
        <div class="warning-box">
          <div class="warning-title">Langkah Penting - Lakukan Prediksi!</div>
          <div class="warning-text">
            Untuk melakukan prediksi bakat renang, klik tombol <strong>prediksi</strong> 
            <span style="background: #343a40; color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.8rem;">
              <i class="fas fa-chart-line"></i>
            </span> 
            pada kolom "Prediksi" di baris perenang yang ingin diprediksi.
          </div>
        </div>
      </div>

      <!-- Step 6 -->
      <div class="step-card">
        <div class="step-number">6</div>
        <div class="step-title">Lihat Hasil Prediksi & Riwayat</div>
        <div class="step-description">
          Setelah prediksi selesai, Anda dapat melihat hasil prediksi dan mengakses riwayat prediksi dengan mengklik nama perenang di tabel.
        </div>
        <ul class="feature-list">
          <li>Hasil prediksi menampilkan gaya renang yang paling sesuai</li>
          <li>Riwayat prediksi tersimpan untuk tracking perkembangan</li>
          <li>Data dapat digunakan untuk analisis lebih lanjut</li>
        </ul>
      </div>

      <div class="text-center mt-4">
        <button class="btn btn-demo" onclick="closeGuide()">
          <i class="fas fa-check me-2"></i>Saya Mengerti
        </button>
      </div>

      <div class="highlight-box mt-4">
        <div class="highlight-title">Butuh Bantuan?</div>
        <div class="highlight-text">
          Jika Anda mengalami kesulitan atau memiliki pertanyaan, jangan ragu untuk menghubungi administrator sistem atau merujuk pada dokumentasi teknis aplikasi.
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function showGuide() {
    const modal = document.getElementById('guideModal');
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
    
    // Animate cards on show
    const cards = document.querySelectorAll('.step-card');
    cards.forEach((card, index) => {
      card.style.opacity = '0';
      card.style.transform = 'translateY(30px)';
      setTimeout(() => {
        card.style.transition = 'all 0.6s ease';
        card.style.opacity = '1';
        card.style.transform = 'translateY(0)';
      }, index * 100);
    });
  }

  function closeGuide() {
    const modal = document.getElementById('guideModal');
    const container = modal.querySelector('.guide-container');
    
    // Animate close
    container.style.transform = 'scale(0.8) translateY(-50px)';
    container.style.opacity = '0';
    
    setTimeout(() => {
      modal.classList.remove('show');
      document.body.style.overflow = 'auto';
      // Reset animation
      container.style.transform = '';
      container.style.opacity = '';
    }, 300);
  }

  // Close modal when clicking outside
  document.getElementById('guideModal').addEventListener('click', function(e) {
    if (e.target === this) {
      closeGuide();
    }
  });

  // Close modal with Escape key
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      const modal = document.getElementById('guideModal');
      if (modal.classList.contains('show')) {
        closeGuide();
      }
    }
  });

  // Auto-show guide on first visit (optional)
  // You can remove this if you don't want auto-show
  document.addEventListener('DOMContentLoaded', function() {
    // Check if user has seen the guide before (using sessionStorage instead)
    const hasSeenGuide = sessionStorage.getItem('swimlytics_guide_seen');
    if (!hasSeenGuide) {
      setTimeout(() => {
        showGuide();
        sessionStorage.setItem('swimlytics_guide_seen', 'true');
      }, 1000);
    }
  });
</script>
</body>
</html>
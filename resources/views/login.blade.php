<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platform Login SwimLytics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background-image: url('{{ asset('images/Background.png') }}');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .login-container {
            background-color:rgb(255, 255, 255);
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            /* Hapus display: flex dan width di sini, akan diatur oleh Bootstrap grid */
            /* width: 750px; */ 
            overflow: hidden;
            /* Tambahkan max-width untuk desktop, agar tidak terlalu lebar */
            max-width: 750px; 
            width: 90%; /* Ambil 90% lebar layar, responsif */
        }
        /* Gunakan flexbox pada .row di dalam .login-container untuk mengontrol tata letak */
        .login-container .row {
            min-height: 100%; /* Pastikan row mengisi tinggi container */
        }

        .login-left {
            background-color: #f8f9fa;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            /* Hapus width: 40%; akan diatur oleh col-md-5 */
            /* width: 40%; */ 
            border-right: 1px solid #e0e0e0;
        }
        /* Atur ulang border-right untuk mobile */
        @media (max-width: 767.98px) { /* Untuk breakpoint di bawah md (mobile) */
            .login-left {
                border-right: none; /* Hapus border kanan */
                border-bottom: 1px solid #e0e0e0; /* Tambahkan border bawah */
            }
        }

        .login-left img {
            max-width: 150px;
            margin-bottom: 20px;
            height: auto; /* Pastikan gambar responsif */
        }
        .login-left h2 {
            color: #007bff;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .login-left p {
            color: #6c757d;
            font-size: 0.9em;
            text-align: center;
        }
        .login-right {
            padding: 40px;
            /* Hapus width: 60%; akan diatur oleh col-md-7 */
            /* width: 60%; */ 
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-right h3 {
            color: #343a40;
            margin-bottom: 30px;
            text-align: center;
            font-size: 1.5em;
            font-weight: normal;
        }
        .form-control {
            border-radius: 5px;
            padding: 12px 15px;
            font-size: 1em;
        }
        .form-label {
            font-weight: bold;
            color: #495057;
        }
        .input-group-text {
            background-color: #e9ecef;
            border-right: none;
        }

        /* Gaya default tombol saat disabled atau input kosong (warna abu-abu dengan border) */
        .btn-login {
            background-color: #CECECE; /* Latar belakang abu-abu */
            padding: 12px;
            border-radius: 5px;
            font-size: 1.1em;
            font-weight: bold;
            color: white; /* Tulisan putih */
            width: 100%;
            margin-top: 20px;
            cursor: not-allowed; /* Kursor default saat disabled */
        }

        /* Gaya untuk button saat aktif (email & password terisi - warna biru) */
        .btn-login.active {
            background-color: #0088FF; /* Latar belakang biru */
            border: 1px solid #0077EE; /* Border biru gelap */
            color: white; /* Tulisan putih */
            cursor: pointer; /* Kursor menjadi pointer saat aktif */
        }
        .btn-login.active:hover {
            background-color: #0066CC; /* Warna biru sedikit lebih gelap saat di-hover aktif */
            border-color: #0055BB; /* Border juga berubah saat hover aktif */
        }

        .form-check-label {
            font-size: 0.9em;
            color: #495057;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Menggunakan Bootstrap Grid System untuk Responsif -->
        <div class="row g-0"> <!-- g-0 untuk menghilangkan gutter antar kolom -->
            <div class="col-md-5 col-12 login-left"> <!-- col-md-5 untuk desktop, col-12 untuk mobile -->
                <img src="{{ asset('images/Logo.png') }}" alt="SwimLytics Logo">
                <h2>LOGIN</h2>
                <p>Masuk ke akun SwimLyticsmu</p>
            </div>
            <div class="col-md-7 col-12 login-right"> <!-- col-md-7 untuk desktop, col-12 untuk mobile -->
                <h3>Platform Login SwimLytics</h3>
                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label visually-hidden">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" maxlength="100" required autofocus>
                        </div>
                        @error('email')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label visually-hidden">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" maxlength="50" required>
                        </div>
                        @error('password')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Ingat saya</label>
                    </div>
                    <button type="submit" class="btn-login" id="loginButton" disabled>Login</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const loginButton = document.getElementById('loginButton');

        function checkInputs() {
            const emailValue = emailInput.value.trim();
            const passwordValue = passwordInput.value.trim();

            if (emailValue !== '' && passwordValue !== '') {
                loginButton.disabled = false;
                loginButton.classList.add('active'); // Tambahkan kelas 'active'
            } else {
                loginButton.disabled = true;
                loginButton.classList.remove('active'); // Hapus kelas 'active'
            }
        }

        emailInput.addEventListener('input', checkInputs);
        passwordInput.addEventListener('input', checkInputs);
        document.addEventListener('DOMContentLoaded', checkInputs);
    </script>
</body>
</html>
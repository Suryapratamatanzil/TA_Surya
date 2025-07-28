<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tambah Perenang</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <style>
    body {
      background-color:#f8f9fa;
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      min-height: 100vh;
    }

    .form-input {
      background-color: white;
      border: 1px solid #ccc;
      color: black;
      border-radius: 0.5rem;
      padding: 0.75rem 1rem;
      width: 100%; 
      transition: all 0.3s;
      font-size: 1rem; 
      height: 3.5rem; 
    }

    .form-input:focus {
      background-color: white;
      outline: none;
      border-color: rgba(59, 130, 246, 0.7);
      z-index: 1; 
    }

    .form-input::placeholder {
      color: #999;
    }

    .form-label {
      color: black;
      font-weight: 500;
      margin-bottom: 0.5rem;
      display: block;
      font-size: 1rem; 
    }

    select.form-input {
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23000000' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
      background-position: right 0.75rem center; 
      background-repeat: no-repeat;
      background-size: 1.5em 1.5em;
      padding-right: 2.5rem;
    }

    .flex .form-input.rounded-r-none {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        border-right: none;
    }

    .flex .form-input.rounded-l-none {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    .flex .form-input.rounded-r-none:focus {
        border-right-color: transparent; 
    }

    .flex .form-input.rounded-r-none:focus + .form-input.rounded-l-none {
        border-left-color: rgba(59, 130, 246, 0.7); 
    }

    .flatpickr-input {
      height: 3.5rem !important; 
      padding-right: 2.5rem; 
    }

    .flatpickr-wrapper {
        position: relative; 
        flex-grow: 1; 
    }
    .flatpickr-wrapper .flatpickr-input {
        width: 100%; 
    }
    .flatpickr-wrapper .flatpickr-input ~ span.flatpickr-calendar-icon,
    .flatpickr-wrapper .flatpickr-input ~ a.flatpickr-calendar-icon {
        position: absolute;
        right: 1rem; 
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #999;
        font-size: 1.25rem;
        pointer-events: none; 
    }

    .w-full {
      padding: 30px; 
    }

    .info-icon-wrapper {
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
    }
    .info-icon-wrapper.show-icon {
        opacity: 1;
        visibility: visible;
    }

    /* Style untuk tooltip yang lebih baik */
    .tooltip {
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        margin-bottom: 8px;
        padding: 8px 12px;
        background-color: #1f2937;
        color: white;
        font-size: 12px;
        border-radius: 6px;
        white-space: nowrap;
        z-index: 1000;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
    }

    .tooltip::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        border: 4px solid transparent;
        border-top-color: #1f2937;
    }

    .info-icon-wrapper:hover .tooltip {
        opacity: 1;
        visibility: visible;
    }
  </style>
</head>
<body class="text-white flex items-center justify-center min-h-screen">
    <div class="w-full">
  <div class="flex items-center mb-8 px-6 pt-6">
    <a href="{{ route('beranda') }}" class="text-xl text-black">
      <i class="fas fa-arrow-left mr-4 text-black"></i>Tambah perenang
    </a>
  </div>

    <form action="{{ route('perenang.store') }}" method="POST" class="w-full px-6 pb-10">
      @csrf
      <div class="flex flex-col md:flex-row gap-8">
        <div class="w-full md:w-1/2">

          @if(session('success'))
            <div class="bg-green-500/30 border border-green-500 text-green-300 px-4 py-3 rounded-lg relative mb-4">
              <span class="block sm:inline">{{ session('success') }}</span>
            </div>
          @endif

          @if ($errors->any())
            <div class="bg-red-500/30 border border-red-500 text-red-300 px-4 py-3 rounded-lg relative mb-4">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <div class="mb-4">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" id="nama" name="nama" class="form-input" placeholder="Nama" value="{{ old('nama') }}" maxlength="50">
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
            <div class="relative group col-span-1">
              <label for="tanggal_lahir" class="form-label flex items-center gap-1">
                Tanggal Lahir
                <span id="ageInfoIconWrapper" class="relative text-red-500 cursor-pointer info-icon-wrapper">
                  <i class="fas fa-info-circle"></i>
                  <div class="tooltip">
                    Untuk hasil prediksi yang akurat, pastikan usia perenang berada dalam rentang 6 hingga 14 tahun.
                  </div>
                </span>
              </label>
              <div class="flex items-center mt-1">
                <input type="text" id="tanggal_lahir" name="tanggal_lahir"
                       class="form-input rounded-r-none border-r-0" placeholder="dd/mm/yyyy"
                       value="{{ old('tanggal_lahir') }}">
                <input type="text" id="usia" name="usia"
                       class="form-input rounded-l-none bg-gray-100 text-gray-700 cursor-not-allowed w-1/2"
                       placeholder="Usia" readonly>
              </div>
              </div>

            <div class="col-span-1">
              <label for="tinggi" class="form-label">Tinggi (cm)</label>
              <input type="number" id="tinggi" name="tinggi" class="form-input mt-1" placeholder="Tinggi" value="{{ old('tinggi') }}" maxlength="5" step="0.1">
            </div>

            <div class="col-span-1">
              <label for="berat" class="form-label">Berat (kg)</label>
              <input type="number" id="berat" name="berat" class="form-input mt-1" placeholder="Berat" value="{{ old('berat') }}" maxlength="5" step="0.1">
            </div>
          </div>

          <div class="mb-4">
            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
            <select id="jenis_kelamin" name="jenis_kelamin" class="form-input">
              <option value="" disabled selected>Pilih Jenis Kelamin</option>
              <option value="Laki-laki" @if(old('jenis_kelamin') == 'Laki-laki') selected @endif>Laki-laki</option>
              <option value="Perempuan" @if(old('jenis_kelamin') == 'Perempuan') selected @endif>Perempuan</option>
            </select>
          </div>

          <div class="mb-4 relative">
            <label for="panjang_kaki" class="form-label flex items-center gap-2">
              Panjang Kaki (cm)
              <span id="iconPanjangKaki" class="text-red-500 cursor-pointer info-icon-wrapper">
                <i class="fas fa-info-circle"></i>
                <div class="tooltip">
                  Panjang kaki tidak proporsional (disarankan 45-50% dari tinggi badan)
                </div>
              </span>
            </label>
            <input type="number" id="panjang_kaki" name="panjang_kaki" class="form-input" placeholder="Panjang Kaki" value="{{ old('panjang_kaki') }}" maxlength="5" step="0.1">
          </div>

          <div>
            <!-- Armspan Section -->
            <label class="form-label block mb-2 font-semibold text-gray-700">Armspan (cm)</label>
            <div class="grid grid-cols-3 gap-4 items-start">

              <!-- Lengan Kiri -->
              <div class="relative">
                <input type="number" id="panjang_lengan_kiri" name="panjang_lengan_kiri"
                  class="form-input w-full rounded border border-gray-300 px-3 py-2"
                  placeholder="Kiri" value="{{ old('panjang_lengan_kiri') }}" step="0.1">
                <span id="iconLenganKiri" class="absolute -top-6 right-0 text-red-500 cursor-pointer info-icon-wrapper">
                  <i class="fas fa-info-circle"></i>
                  <div class="tooltip">
                    Panjang armspan kiri tidak proporsional (disarankan 30-35% dari tinggi badan)
                  </div>
                </span>
              </div>

              <!-- Lengan Kanan -->
              <div class="relative">
                <input type="number" id="panjang_lengan_kanan" name="panjang_lengan_kanan"
                  class="form-input w-full rounded border border-gray-300 px-3 py-2"
                  placeholder="Kanan" value="{{ old('panjang_lengan_kanan') }}" step="0.1">
                <span id="iconLenganKanan" class="absolute -top-6 right-0 text-red-500 cursor-pointer info-icon-wrapper">
                  <i class="fas fa-info-circle"></i>
                  <div class="tooltip">
                    Panjang armspan kanan tidak proporsional (disarankan 30-35% dari tinggi badan)
                  </div>
                </span>
              </div>

              <!-- Armspan Total -->
              <div class="relative">
                <input type="number" id="panjang_armspan" name="panjang_armspan"
                  class="form-input w-full rounded border border-gray-300 px-3 py-2"
                  placeholder="Total" value="{{ old('panjang_armspan') }}" step="0.1">
                <span id="iconArmspanTotal" class="absolute -top-6 right-0 text-red-500 cursor-pointer info-icon-wrapper">
                  <i class="fas fa-info-circle"></i>
                  <div class="tooltip">
                    Armspan total tidak proporsional (disarankan 95-110% dari tinggi badan, ideal ~100%)
                  </div>
                </span>
              </div>
            </div>
          </div>

          <div class="mt-8">
            <button id="submitBtn" type="submit" disabled class="w-full bg-gray-400 text-white font-bold py-3 px-4 rounded-lg transition-colors text-lg cursor-not-allowed flex items-center justify-center">
              Tambah <img src="{{ asset('images/Logotambah.png') }}" alt="Tambah" class="inline w-6 h-6 ml-2">
            </button>
          </div>

        </div>

        <div class="w-full md:w-1/2 flex items-center justify-center p-6">
          <img src="{{ asset('images/Logotambahv2.png') }}" alt="User Illustration">
        </div>
      </div>
    </form>
  </div>

  <script>
    flatpickr("#tanggal_lahir", {
      dateFormat: "Y-m-d",
      altInput: true,
      altFormat: "d/m/Y",
      yearRange: [1950, new Date().getFullYear()],
      maxDate: "today",
      allowInput: true,
      onChange: function(selectedDates, dateStr, instance) {
        calculateAge(selectedDates[0]);
        validateForm();
      }
    });

    function calculateAge(birthDate) {
      const usiaInput = document.getElementById('usia');
      if (!birthDate) {
        usiaInput.value = '';
        return;
      }

      const today = new Date();
      let age = today.getFullYear() - birthDate.getFullYear();
      const m = today.getMonth() - birthDate.getMonth();

      if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
      }
      usiaInput.value = age + ' th';
    }

    const requiredFields = [
      'nama',
      'tanggal_lahir',
      'tinggi',
      'berat',
      'jenis_kelamin',
      'panjang_kaki',
      'panjang_lengan_kiri',
      'panjang_lengan_kanan',
      'panjang_armspan'
    ];

    const submitBtn = document.getElementById('submitBtn');
    const ageInfoIconWrapper = document.getElementById('ageInfoIconWrapper'); 
    
    function validateProporsionalitas() {
      const tinggi = parseFloat(document.getElementById('tinggi').value);
      const kaki = parseFloat(document.getElementById('panjang_kaki').value);
      const kiri = parseFloat(document.getElementById('panjang_lengan_kiri').value);
      const kanan = parseFloat(document.getElementById('panjang_lengan_kanan').value);
      const total = parseFloat(document.getElementById('panjang_armspan').value);

      const iconKaki = document.getElementById('iconPanjangKaki');
      const iconKiri = document.getElementById('iconLenganKiri');
      const iconKanan = document.getElementById('iconLenganKanan');
      const iconTotal = document.getElementById('iconArmspanTotal');

      // Sembunyikan semua icon dulu
      [iconKaki, iconKiri, iconKanan, iconTotal].forEach(el => el.classList.remove('show-icon'));

      let isValid = true;

      // Validasi hanya jika tinggi badan sudah diisi (sebagai referensi)
      if (!isNaN(tinggi) && tinggi > 0) {
        
        // Validasi panjang kaki berdasarkan persentase tinggi badan
        // Normal: 45-50% dari tinggi badan (sesuai literatur RSLL & SHR, antropometri modern)
        if (!isNaN(kaki) && kaki > 0) {
          const persentaseKaki = (kaki / tinggi) * 100;
          if (persentaseKaki < 52 || persentaseKaki > 64) {
            iconKaki.classList.add('show-icon');
          }
        }

        // Validasi armspan kiri berdasarkan persentase tinggi badan
        // Normal: 30-35% dari tinggi badan (setiap lengan ~30-35% dari total ~60-65%)
        if (!isNaN(kiri) && kiri > 0) {
          const persentaseKiri = (kiri / tinggi) * 100;
          if (persentaseKiri < 44 || persentaseKiri > 55) {
            iconKiri.classList.add('show-icon');
          }
        }

        // Validasi armspan kanan berdasarkan persentase tinggi badan
        // Normal: 30-35% dari tinggi badan (setiap lengan ~30-35% dari total ~60-65%)
        if (!isNaN(kanan) && kanan > 0) {
          const persentaseKanan = (kanan / tinggi) * 100;
          if (persentaseKanan < 44 || persentaseKanan > 55) {
            iconKanan.classList.add('show-icon');
          }
        }

        // Validasi armspan total (fingertip to fingertip) berdasarkan persentase tinggi badan
        // Normal: 95-110% dari tinggi badan, ideal sekitar 100% (arm-span ≈ tinggi badan)
        if (!isNaN(total) && total > 0) {
          const persentaseTotal = (total / tinggi) * 100;
          if (persentaseTotal < 95 || persentaseTotal > 110) {
            iconTotal.classList.add('show-icon');
          }
        }
      }

      return isValid;
    }

    function validateForm() {
      let allFieldsValid = requiredFields.every(id => {
        const el = document.getElementById(id);
        if (!el) return true;

        if (id === 'tanggal_lahir') {
            const fpInstance = el._flatpickr;
            return fpInstance && fpInstance.selectedDates.length > 0 && fpInstance.selectedDates[0] instanceof Date;
        }

        if (el.tagName === 'SELECT') {
          return el.value !== '' && el.value !== null && el.value !== el.querySelector('option[disabled]')?.value;
        }
        
        return el.value.trim() !== '';
      });

      const usiaInput = document.getElementById('usia');
      const usiaValue = parseInt(usiaInput.value);
      
      const minAge = 6;
      const maxAge = 14;

      let isAgeWithinRange = true;

      // Reset age icon
      ageInfoIconWrapper.classList.remove('show-icon');

      if (isNaN(usiaValue) || usiaValue < 0) { 
          isAgeWithinRange = false; 
      } else if (usiaValue < minAge || usiaValue > maxAge) {
          isAgeWithinRange = false;
          ageInfoIconWrapper.classList.add('show-icon');
      }

      // Validasi proporsionalitas hanya untuk menampilkan alert, tidak mempengaruhi submit
      validateProporsionalitas();

      if (allFieldsValid && isAgeWithinRange) {
        submitBtn.disabled = false;
        submitBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
        submitBtn.classList.add('bg-blue-600', 'hover:bg-blue-700', 'cursor-pointer');
      } else {
        submitBtn.disabled = true;
        submitBtn.classList.remove('bg-blue-600', 'hover:bg-blue-700', 'cursor-pointer');
        submitBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
      }
    }

    // Event listeners untuk semua field
    requiredFields.forEach(id => {
      const el = document.getElementById(id);
      if (el) {
        if (el.tagName === 'SELECT') {
          el.addEventListener('change', validateForm);
        } else {
          el.addEventListener('input', validateForm);
          // Tambahan: validasi saat field kehilangan fokus untuk memastikan alert muncul
          el.addEventListener('blur', validateForm);
        }
      }
    });

    // Event listener khusus untuk field proportional yang perlu validasi real-time
    // Termasuk tinggi badan karena menjadi referensi perhitungan persentase
    const proportionalFields = ['tinggi', 'panjang_kaki', 'panjang_lengan_kiri', 'panjang_lengan_kanan', 'panjang_armspan'];
    proportionalFields.forEach(id => {
      const el = document.getElementById(id);
      if (el) {
        // Validasi saat mengetik
        el.addEventListener('input', function() {
          // Delay sedikit untuk memberikan waktu user mengetik
          setTimeout(() => {
            validateProporsionalitas();
            validateForm();
          }, 500);
        });
        
        // Validasi saat field kehilangan fokus
        el.addEventListener('blur', function() {
          validateProporsionalitas();
          validateForm();
        });
      }
    });

    document.addEventListener('DOMContentLoaded', function() {
      const tanggalLahirInput = document.getElementById('tanggal_lahir');
      const initialDateValue = tanggalLahirInput.value;

      const fpInstance = tanggalLahirInput._flatpickr;

      if (fpInstance && fpInstance.selectedDates.length > 0) {
          calculateAge(fpInstance.selectedDates[0]);
      } else if (initialDateValue && initialDateValue.trim() !== '') {
          const parts = initialDateValue.split('-');
          if (parts.length === 3) {
              const dateObj = new Date(parts[0], parts[1] - 1, parts[2]);
              calculateAge(dateObj);
          }
      }
      validateForm(); 
    });

  </script>

</body>
</html>
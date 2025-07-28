<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Fitur Prediksi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    {{-- Pastikan ini terhubung dengan benar ke CDN Font Awesome terbaru --}}

    <style>
        body { background-color: #f8f9fa; }
        .table-bordered th, .table-bordered td { vertical-align: middle; text-align: center; }
        .form-label { font-weight: 500; }
        .btn-prediksi {
            background-color: #212529;
            color: white;
            padding: 10px 24px;
            font-size: 1.1rem;
            display: inline-flex; 
            align-items: center; 
            justify-content: center; 
        }
        .btn-prediksi:hover {
            background-color: #343a40;
            color: white;
        }
        .btn-prediksi img {
            height: 1.2em; 
            margin-left: 0.5em; 
        }

        .loading-circle-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 250px; 
            text-align: center;
            flex-direction: column;
            color: #333; 
        }
        .loading-circle {
            width: 150px;
            height: 150px;
            border: 5px solid #e0e0e0;
            border-top: 5px solid #007bff; 
            border-radius: 50%;
            animation: spin 1s linear infinite; 
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
            position: relative;
        }
        .loading-text {
            font-size: 2rem; 
            font-weight: bold;
            color: #333;
            position: absolute;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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
            font-size: 2.5rem; 
            font-weight: bold;
        }
        .performance-options span {
            font-size: 0.9rem;
            color: #999;
            margin-left: 5px;
            font-weight: normal; 
        }
        .performance-options .very-high { color: #004d00; font-weight: bold; } 
        .performance-options .high { color: #28a745; font-weight: bold; } 
        .performance-options .medium { color: #ffc107; font-weight: bold; } 
        .performance-options .low { color: #dc3545; font-weight: bold; } 
        .performance-options .active-label {
            font-weight: bold;
        }
        #loadingStatusText {
            font-size: 1.2rem;
            color: #555;
            margin-top: 10px;
        }
        .btn-prediksi:disabled {
            background-color: #6c757d; 
            cursor: not-allowed;
            opacity: 0.65; 
        }

    </style>
</head>
<body>

<div class="container my-5">
    {{-- Header Halaman --}}
    <div class="d-flex align-items-center mb-4">
        <a href="{{ url()->previous() }}" class="btn btn-light me-3">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="mb-0">Prediksi</h2>
    </div>

    {{-- Nama Atlet --}}
    <h3 class="mb-4">{{ strtoupper($atlet->nama) }}</h3>

    {{-- Form Prediksi (Wrapper untuk seluruh input dan tombol) --}}
    <div id="predictionFormSection">
        <form id="predictionForm" action="{{ route('prediksi.calculate') }}" method="POST">
            @csrf
            <input type="hidden" name="atlet_id" value="{{ $atlet->id }}">

            <div class="row g-4">
                {{-- Kolom Tunggal untuk Data Atlet --}}
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th rowspan="2">Usia</th>
                                    <th rowspan="2">Jenis Kelamin</th>
                                    <th rowspan="2">Tinggi Badan (cm)</th>
                                    <th rowspan="2">Berat Badan (kg)</th>
                                    <th rowspan="2">Panjang Tungkai (cm)</th>
                                    <th colspan="3">Armspan (cm)</th>
                                </tr>
                                <tr>
                                    <th>Kiri</th>
                                    <th>Kanan</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($atlet->tanggal_lahir)->age }}</td>
                                    <td>{{ $atlet->jenis_kelamin }}</td>
                                    <td>{{ $atlet->tinggi }}</td>
                                    <td>{{ $atlet->berat }}</td>
                                    <td>{{ $atlet->panjang_kaki }}</td>
                                    <td>{{ $atlet->panjang_lengan_kiri }}</td>
                                    <td>{{ $atlet->panjang_lengan_kanan }}</td>
                                    <td>{{ $atlet->panjang_armspan }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Baris Baru untuk Input Gaya dan Jarak (di bawah tabel) --}}
                <div class="col-lg-12 mt-4">
                    <div class="row g-3">
                        <div class="col-lg-6 col-md-6">
                            <div class="mb-3">
                                <label for="gaya" class="form-label">Gaya</label>
                                <select class="form-select" id="gaya" name="gaya" required>
                                    <option selected disabled value="">Pilih Gaya...</option>
                                    <option value="gaya_bebas">Gaya Bebas</option>
                                    <option value="gaya_dada">Gaya Dada</option>
                                    <option value="gaya_punggung">Gaya Punggung</option>
                                    <option value="gaya_kupu">Gaya Kupu-kupu</option>
                                    <option value="gaya_medley">Gaya Medley</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="mb-3">
                                <label for="jarak" class="form-label">Jarak</label>
                                <select class="form-select" id="jarak" name="jarak" required disabled>
                                    <option selected disabled value="">Pilih Jarak...</option>
                                    {{-- Opsi jarak akan diisi secara dinamis oleh JavaScript --}}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tombol Prediksi --}}
            <div class="mt-4 text-start" id="predictButtonContainer">
                <button type="submit" class="btn btn-prediksi" id="submitPredictionBtn" disabled>
                    Prediksi
                    <img src="{{ asset('images/icon_prediksi.png') }}" alt="Prediksi">
                </button>
            </div>
        </form>
    </div>

    {{-- Area Animasi Loading --}}
    <div id="loadingAnimation" class="loading-circle-container" style="display: none;">
        <div class="loading-circle">
            <span class="loading-text" id="loadingPercentage">0%</span>
        </div>
        <p id="loadingStatusText">predicting...</p>
    </div>

    {{-- Area Hasil Prediksi --}}
    <div id="predictionResult" class="result-section" style="display: none;">
        <h3 class="mb-4" id="resultTitle"></h3> {{-- Akan diisi dengan "Hasil Prediksi Gaya Bebas 25 m" --}}

        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6 mb-4">
                <div class="prediction-box">
                    <h4><i class="far fa-clock"></i> Prediksi Waktu <span class="unit">Detik</span></h4>
                    <div class="value" id="predictedTime"></div>
                </div>
            </div>
            <div class="col-lg-5 col-md-6 mb-4">
                <div class="prediction-box">
                    <h4><i class="fas fa-chart-line"></i> Prediksi Performa
                        <span class="performance-options">
                            <span id="performanceVeryHigh">VeryHigh</span>
                            <span id="performanceHigh">High</span>
                            <span id="performanceMedium">Medium</span>
                            <span id="performanceLow">Low</span>
                        </span>
                    </h4>
                   <div class="value performance-label" id="performanceOutput"></div>
                </div>
            </div>
        </div>

        {{-- Tombol Aksi Setelah Prediksi --}}
        <div class="row mt-4">
            <div class="col-12 text-center d-flex justify-content-center gap-3">
                <button type="button" class="btn btn-prediksi btn-lg" id="predictAgainButton">
                    <i class="fas fa-redo me-2"></i>
                    Prediksi Ulang
                </button>
                <a href="{{ route('beranda') }}" class="btn btn-prediksi btn-lg" id="backToHomeButton"> {{-- Sesuaikan dengan route halaman utama Anda --}}
                    <i class="fas fa-home me-2"></i>
                    Kembali ke Halaman utama
                </a>
            </div>
        </div>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> {{-- Sertakan jQuery --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    const formSection = $('#predictionFormSection');
    const loadingAnimation = $('#loadingAnimation');
    const predictionResult = $('#predictionResult');
    const loadingPercentage = $('#loadingPercentage');
    const loadingStatusText = $('#loadingStatusText');
    const predictAgainButton = $('#predictAgainButton');
    const gayaSelect = $('#gaya');
    const jarakSelect = $('#jarak');
    const submitPredictionBtn = $('#submitPredictionBtn');

    const distanceOptions = {
        'gaya_bebas': [
            { value: '50m', text: '50 meter' },
            { value: '100m', text: '100 meter' }
        ],
        'gaya_dada': [
            { value: '50m', text: '50 meter' }
        ],
        'gaya_punggung': [
            { value: '50m', text: '50 meter' }
        ],
        'gaya_kupu': [
            { value: '50m', text: '50 meter' }
        ],
        'gaya_medley': [
            { value: '200m', text: '200 meter' }
        ]
    };

    function resetForm() {
        predictionResult.hide();
        loadingAnimation.hide();
        formSection.show();
        
        $('#performanceVeryHigh, #performanceHigh, #performanceMedium, #performanceLow').removeClass('very-high high medium low').css('color', '#999');
        
        
        gayaSelect.val(''); 
        jarakSelect.val('');
        jarakSelect.prop('disabled', true); 
        jarakSelect.find('option:not(:first)').remove(); 
        updateSubmitButtonStatus(); 
    }

    
    function updateJarakOptions() {
        const selectedGaya = gayaSelect.val();
        jarakSelect.empty(); 
        jarakSelect.append('<option selected disabled value="">Pilih Jarak...</option>'); 

        if (selectedGaya && distanceOptions[selectedGaya]) {
            distanceOptions[selectedGaya].forEach(option => {
                jarakSelect.append(`<option value="${option.value}">${option.text}</option>`);
            });
            jarakSelect.prop('disabled', false);
        } else {
            jarakSelect.prop('disabled', true); 
        }
        jarakSelect.val(''); 
        updateSubmitButtonStatus(); 
    }

    function updateSubmitButtonStatus() {
        const selectedGaya = gayaSelect.val();
        const selectedJarak = jarakSelect.val();

        if (selectedGaya && selectedGaya !== "" && selectedJarak && selectedJarak !== "") {
            submitPredictionBtn.prop('disabled', false);
            submitPredictionBtn.removeClass('btn-secondary').addClass('btn-prediksi'); 
        } else {
            submitPredictionBtn.prop('disabled', true);
            submitPredictionBtn.removeClass('btn-prediksi').addClass('btn-secondary'); 
        }
    }

    gayaSelect.on('change', function() {
        updateJarakOptions();
    });

    jarakSelect.on('change', function() {
        updateSubmitButtonStatus();
    });


    resetForm();
    updateSubmitButtonStatus(); 


    $('#predictionForm').on('submit', function(e) {
        e.preventDefault(); 

        if (submitPredictionBtn.prop('disabled')) {
            alert('Mohon pilih Gaya dan Jarak yang valid.');
            return;
        }

        formSection.hide(); 
        loadingAnimation.show(); 
        loadingPercentage.text('0%');
        loadingStatusText.text('predicting...');

        let percentage = 0;
        const interval = setInterval(() => {
            percentage += 10;
            if (percentage <= 90) { 
                loadingPercentage.text(percentage + '%');
            } else {
                clearInterval(interval);
            }
        }, 300); 

        $.ajax({
            url: $(this).attr('action'), 
            method: $(this).attr('method'), 
            data: $(this).serialize(), 
            success: function(response) {
                clearInterval(interval);

                loadingPercentage.text('100%');
                loadingStatusText.text('finish');

                setTimeout(() => {
                    loadingAnimation.hide(); 

                    $('#resultTitle').text(`Hasil Prediksi ${response.gaya_label} ${response.jarak_label}`);
                    $('#predictedTime').text(response.predicted_time);
                    $('#performanceOutput').text(`${response.predicted_performance} (${response.performance_percentage}%)`);

                    $('#performanceVeryHigh, #performanceHigh, #performanceMedium, #performanceLow').removeClass('very-high high medium low').css('color', '#999');

                    
                    if (response.predicted_performance === 'Very High') {
                        $('#performanceVeryHigh').addClass('very-high').css('color', '#004d00'); // Warna untuk Very High
                    } else if (response.predicted_performance === 'High') {
                        $('#performanceHigh').addClass('high').css('color', '#28a745');
                    } else if (response.predicted_performance === 'Medium') {
                        $('#performanceMedium').addClass('medium').css('color', '#ffc107');
                    } else if (response.predicted_performance === 'Low') {
                        $('#performanceLow').addClass('low').css('color', '#dc3545');
                    }
                    predictionResult.show(); 
                }, 800); 

            },
            error: function(xhr, status, error) {
                clearInterval(interval); 
                loadingAnimation.hide();
                formSection.show(); 
                alert('Terjadi kesalahan saat memproses prediksi: ' + xhr.responseText);
                console.error('AJAX error:', status, error, xhr.responseText);
            }
        });
    });

    predictAgainButton.on('click', function() {
        resetForm(); 
    });
});
</script>

</body>
</html>
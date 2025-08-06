<link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
<link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Inter:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
<!-- Custom styles for this template-->
<link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<title>Edit data Simulasi Kredit - SAHABAT GROUP AUTO ADMINISTRATOR</title>

<body>
    <div id="wrapper">

        @include('layouts.admin_views.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                @include('layouts.admin_views.header')
                <h4 style="text-align:center;color:black;font-weight:bold;">Edit Data Simulasi Kredit</h4>
                <div class="form-group-content">

                    @foreach ($credit_simulation as $credit)
                        <form id="credit_form" class="form_input" method="POST"
                            action="{{ route('update_credit_simulation.update', $credit->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label>Unit</label>
                                <input type="text" class="form-control" name="vehicle_id"
                                    value="{{ $credit->vehicle_id }}" hidden readonly autocomplete="off">
                                <input type="text" class="form-control" value="{{ $credit->unit }}" readonly
                                    autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="">Harga Kredit</label>
                                <input class="form-control" name="credit_price" type="text" id="credit_price"
                                    value="{{ $credit->credit_price }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="">Jenis Insurance Saat ini</label>
                                <input id="input_insurance" name="insurance_id" type="text" class="form-control"
                                    value="{{ $credit->insurance_id }}" hidden readonly autocomplete="off">
                                <input type="text" class="form-control" id="insuranceName"
                                    value="{{ $credit->insurance_name }}" readonly autocomplete="off">
                                <br>

                                <label for="">Pilih Insurance</label>
                                <select class="form-control" name="insurance_select" id="insuranceSelect">
                                    <option value="">--- pilih insurance ---</option>
                                    @foreach ($insurance as $insurances)
                                        <option value="{{ $insurances->id }}">{{ $insurances->insurance_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <p style="font-style: italic; color:red;font-size:12px;">*pilih asuransi jika ingin
                                    merubah</p>
                            </div>

                            <div class="form-group">
                                <label for="">Total DP Saat ini (%)</label>
                                <input id="input_dp" name="down_payment" class="form-control" type="text"
                                    value="{{ $credit->down_payment }}" hidden readonly>

                                <input type="text" class="form-control" id="downpaymentresult"
                                    value="{{ $credit->down_payment }}" readonly autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label>Harga DP</label>
                                <select class="form-control" name="down_payment_selected" id="down_payment">
                                    <option value="">--- Pilih Total DP ---</option>
                                    <option value="20">20%</option>
                                    <option value="30">30%</option>
                                    <option value="40">40%</option>
                                    <option value="50">50%</option>
                                    <option value="60">60%</option>
                                    <option value="70">70%</option>
                                    <option value="80">80%</option>
                                </select>
                                <p style="font-style: italic; color:red;font-size:12px;">*pilih total besar DP jika
                                    ingin merubah</p>
                            </div>

                            <div class="form-group">
                                <label>Bunga Pinjaman Saat ini (%)</label>
                                <input id="input_interestrate" type="text" name="interest_rate" class="form-control"
                                    value="{{ $credit->interest_rate }}" autocomplete="off" hidden readonly>

                                <input type="text" class="form-control" id="interestrateresult"
                                    value="{{ $credit->interest_rate }}" readonly autocomplete="off">
                                <p style="font-style: italic; color:red;font-size:12px;">*pilih jumlah bunga jika
                                    ingin merubah</p>
                            </div>

                            <div class="form-group">
                                <label>Bunga (%)</label>
                                <select class="form-control" name="interest_rate_selected" id="interest_rate">
                                    <option value="">--- Bunga ---</option>
                                    <option value="5">5%</option>
                                    <option value="6">6%</option>
                                    <option value="10">10%</option>
                                </select>
                                <x-input-error :messages="$errors->get('interest_rate')" style="color: red;" class="mt-2" />
                            </div>


                            <div class="form-group">
                                <label>Total Harga DP saat ini</label>
                                <input type="text" class="form-control" value="{{ $credit->total_down_payment }}"
                                    id="show_down_payment" autocomplete="off" readonly>
                            </div>
                            <hr>

                            <div class="form-group">
                                <label>Tenor 12 Month</label>
                                <input type="text" class="form-control" name="tenor_12_month" id="tenor_12_month"
                                    value="{{ $credit->tenor_12_month }}" readonly autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>Tenor 24 Bulan</label>
                                <input type="text" class="form-control" name="tenor_24_month" id="tenor_24_month"
                                    value="{{ $credit->tenor_24_month }}" readonly autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>Tenor 36 Bulan</label>
                                <input type="text" class="form-control" name="tenor_36_month" id="tenor_36_month"
                                    value="{{ $credit->tenor_36_month }}" readonly autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>Tenor 48 Bulan</label>
                                <input type="text" class="form-control" name="tenor_48_month" id="tenor_48_month"
                                    value="{{ $credit->tenor_48_month }}" readonly autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>Tenor 60 Bulan</label>
                                <input type="text" class="form-control" name="tenor_60_month" id="tenor_60_month"
                                    value="{{ $credit->tenor_60_month }}" readonly autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>Tenor 72 Bulan</label>
                                <input type="text" class="form-control" name="tenor_72_month" id="tenor_72_month"
                                    value="{{ $credit->tenor_72_month }}" readonly autocomplete="off">
                            </div>

                            <div style="display: flex; gap:20px;" class="btn-credit-calculation">

                                <button type="button" class="btn btn-info" id="btn_calculate">
                                    <i class="fas fa-calculator"></i> Hitung Simulasi</button>

                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>

                        </form>
                    @endforeach

                </div>
            </div>

            @include('layouts.admin_views.footer')

        </div>


    </div>

    {{-- spinner --}}
    <div id="loadingSpinnerWrapper">
        <div class="spinner-border" role="status">
        </div>
    </div>
</body>

<style>
    #loadingSpinnerWrapper {
        position: fixed;
        /* Fix posisi spinner */
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: none;
        /* Spinner disembunyikan saat halaman dimuat */
        justify-content: center;
        /* Horizontal center */
        align-items: center;
        /* Vertical center */
        background-color: rgba(0, 0, 0, 0.517);
        /* Background semi-transparan */
        z-index: 9999;
        /* Pastikan spinner berada di atas konten lainnya */
    }

    .spinner-border {
        color: yellow;
        width: 3rem;
        height: 3rem;
        /* Pastikan tinggi spinner diatur */
    }
</style>



<script>
    document.getElementById('insuranceSelect').addEventListener('change', function() {
        var selectValue = this.value;
        var inputInsurance = document.getElementById('input_insurance');
        var insuranceNameInput = document.getElementById('insuranceName');

        if (selectValue === "") {
            // Jika tidak ada pilihan, eksekusi data dari input teks
            inputInsurance.value = insuranceNameInput.value; // Ambil nilai dari input teks
        } else {
            // Jika ada pilihan, set input ke nilai select
            inputInsurance.value = selectValue;
        }
    });

    document.getElementById('down_payment').addEventListener('change', function() {
        var selectValue = this.value;
        var inputDownPayment = document.getElementById('input_dp');
        var DownPaymentNameInput = document.getElementById('downpaymentresult');

        if (selectValue === "") {
            // Jika tidak ada pilihan, eksekusi data dari input teks
            inputDownPayment.value = DownPaymentNameInput.value; // Ambil nilai dari input teks
        } else {
            // Jika ada pilihan, set input ke nilai select
            inputDownPayment.value = selectValue;
        }
    });


    document.getElementById('interest_rate').addEventListener('change', function() {
        var selectValue = this.value;
        var inputInterestRate = document.getElementById('input_interestrate');
        var interestRateResult = document.getElementById('interestrateresult');

        if (selectValue === "") {
            // Jika tidak ada pilihan, eksekusi data dari input teks
            inputInterestRate.value = interestRateResult.value; // Ambil nilai dari input teks
        } else {
            // Jika ada pilihan, set input ke nilai select
            inputInterestRate.value = selectValue;
        }
    });

    window.addEventListener('load', function() {
        var loadingSpinnerWrapper = document.getElementById('loadingSpinnerWrapper');

        // Log elemen untuk memastikan spinner ditemukan
        console.log(loadingSpinnerWrapper); // Cek apakah elemen ditemukan

        if (loadingSpinnerWrapper) {
            // Menampilkan spinner saat halaman dimuat
            loadingSpinnerWrapper.style.display = 'flex';


            // Menyembunyikan spinner setelah 2 detik (2000ms)
            setTimeout(function() {

                loadingSpinnerWrapper.style.display = 'none'; // Sembunyikan spinner setelah 2 detik
            }, 1000); // 2000ms = 2 detik
        } else {
            console.log("Elemen spinner tidak ditemukan!");
        }
    });


    // FUNCTION CALCULATION CREDIT
    document.getElementById('btn_calculate').addEventListener('click', function(e) {
        e.preventDefault();

        const creditPriceText = document.getElementById('credit_price').value;
        const downPaymentPercent = document.getElementById('down_payment').value;
        const interestRate = document.getElementById('interest_rate').value;

        // Parsing nilai harga kredit
        const creditPrice = parseInt(creditPriceText.replace(/[^\d]/g, ''), 10);
        const downPaymentPercentage = parseFloat(downPaymentPercent);
        const interestRateValue = parseFloat(interestRate);

        // Validasi dasar
        if (isNaN(creditPrice) || isNaN(downPaymentPercentage) || isNaN(interestRateValue)) {
            alert('Mohon isi semua kolom dengan benar.');
            return;
        }

        // Hitung uang muka (dalam rupiah)
        const downPayment = creditPrice * (downPaymentPercentage / 100);

        // Kirim request ke backend
        fetch('{{ route('credit_calculations') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    credit_price: creditPrice,
                    down_payment: downPayment,
                    interest_rate: interestRateValue // <- sekarang dikirim
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Respon dari server tidak valid');
                }
                return response.json();
            })
            .then(data => {
                if (!data.status || !data.data) {
                    throw new Error('Data tidak ditemukan di response');
                }

                const result = data.data;

                document.getElementById('show_down_payment').value = Math.round(downPayment);

                document.getElementById('tenor_12_month').value = Math.round(result.tenor_12_month);
                document.getElementById('tenor_24_month').value = Math.round(result.tenor_24_month);
                document.getElementById('tenor_36_month').value = Math.round(result.tenor_36_month);
                document.getElementById('tenor_48_month').value = Math.round(result.tenor_48_month);
                document.getElementById('tenor_60_month').value = Math.round(result.tenor_60_month);
                document.getElementById('tenor_72_month').value = Math.round(result.tenor_72_month);
            })
            .catch(error => {
                console.error('Terjadi kesalahan:', error);
                alert('Terjadi kesalahan saat menghitung simulasi. Silakan periksa kembali input Anda.');
            });
    });
</script>

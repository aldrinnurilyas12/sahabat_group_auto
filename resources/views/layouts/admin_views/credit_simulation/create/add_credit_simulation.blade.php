<link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
<link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Inter:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
<!-- Custom styles for this template-->
<link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<title>Tambah data Kredit Simulasi - SAHABAT GROUP AUTO ADMINISTRATOR</title>

<body>
    <div id="wrapper">

        @include('layouts.admin_views.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                @include('layouts.admin_views.header')
                <h4 style="text-align:center;color:black;font-weight:bold;">Tambah Data Simulasi Kredit</h4>
                <div class="form-group-content">
                    <form id="credit_form" class="form_input" method="POST"
                        action="{{ route('master_credit_simulation.store') }}">
                        @csrf
                        <div class="form-group">
                            @foreach ($vehicle as $car)
                                <div class="form-group">
                                    <label>Unit</label>
                                    <input type="text" class="form-control" name="vehicle_id"
                                        value="{{ $car->id }}" hidden autocomplete="off">
                                    <input type="text" class="form-control"
                                        value="{{ $car->brand . ' ' . $car->vehicle_type . ' ' . $car->manufacture_year }}"
                                        readonly autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Harga Kredit Unit</label>
                                    @if ($vehicle->first()->credit_price)
                                        <input type="text" class="form-control" name="credit_price" id="credit_price"
                                            value="{{ 'Rp ' . number_format($car->credit_price) }}" autocomplete="off"
                                            readonly>
                                    @else
                                        <input type="text" class="form-control"
                                            placeholder="TIDAK ADA HARGA KREDIT, MASUKAN HARGA KREDIT DAHULU..."
                                            readonly>
                                    @endif
                                    <small>*Harga yang digunakan dalam perhitungan simulasi kredit</small>
                                </div>
                            @endforeach
                        </div>

                        <div class="form-group">
                            <label for="">Jenis Asuransi</label>

                            <select class="form-control" name="insurance_id" id="">
                                <option value="">--- Pilih Asuransi ---</option>
                                @foreach ($insurance as $insurances)
                                    <option value="{{ $insurances->id }}">{{ $insurances->insurance_name }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="form-group">
                            <label>Harga DP (%)</label>
                            <select class="form-control" name="down_payment" id="down_payment">
                                <option value="">--- Pilih Total DP ---</option>
                                <option value="20">20%</option>
                                <option value="30">30%</option>
                                <option value="40">40%</option>
                                <option value="50">50%</option>
                                <option value="60">60%</option>
                                <option value="70">70%</option>
                                <option value="80">80%</option>
                            </select>
                            <x-input-error :messages="$errors->get('down_payment')" style="color: red;" class="mt-2" />
                        </div>

                        <div class="form-group">
                            <label>Bunga (%)</label>
                            <select class="form-control" name="interest_rate" id="interest_rate">
                                <option value="">--- Bunga ---</option>
                                <option value="5">5%</option>
                                <option value="6">6%</option>
                                <option value="10">10%</option>
                            </select>
                            <x-input-error :messages="$errors->get('interest_rate')" style="color: red;" class="mt-2" />
                        </div>

                        <div class="form-group">
                            <label>Total Harga DP</label>
                            <input type="text" class="form-control" id="show_down_payment" autocomplete="off"
                                readonly>
                        </div>
                        <hr>
                        <h5 style="color: black;font-weight:bold;" for="">Rincian Tenor Kredit</h5>
                        <hr>

                        <div class="form-group">
                            <label>Tenor 12 Bulan (1 Tahun)</label>
                            <input type="text" class="form-control" name="tenor_12_month" id="tenor_12_month"
                                autocomplete="off" readonly>
                            <x-input-error :messages="$errors->get('tenor_12_month')" style="color: red;" class="mt-2" />
                        </div>
                        <div class="form-group">
                            <label>Tenor 24 Bulan (2 Tahun)</label>
                            <input type="text" class="form-control" name="tenor_24_month" id="tenor_24_month"
                                autocomplete="off" readonly>
                            <x-input-error :messages="$errors->get('tenor_24_month')" style="color: red;" class="mt-2" />
                        </div>
                        <div class="form-group">
                            <label>Tenor 36 Bulan (3 Tahun)</label>
                            <input type="text" class="form-control" name="tenor_36_month" id="tenor_36_month"
                                autocomplete="off" readonly>
                            <x-input-error :messages="$errors->get('tenor_36_month')" style="color: red;" class="mt-2" />
                        </div>
                        <div class="form-group">
                            <label>Tenor 48 Bulan (4 Tahun)</label>
                            <input type="text" class="form-control" name="tenor_48_month" id="tenor_48_month"
                                autocomplete="off" readonly>
                            <x-input-error :messages="$errors->get('tenor_48_month')" style="color: red;" class="mt-2" />
                        </div>
                        <div class="form-group">
                            <label>Tenor 60 Bulan (5 Tahun)</label>
                            <input type="text" class="form-control" name="tenor_60_month" id="tenor_60_month"
                                autocomplete="off" readonly>
                            <x-input-error :messages="$errors->get('tenor_60_month')" style="color: red;" class="mt-2" />
                        </div>
                        <div class="form-group">
                            <label>Tenor 72 Bulan (6 Tahun)</label>
                            <input type="text" class="form-control" name="tenor_72_month" id="tenor_72_month"
                                autocomplete="off" readonly>
                            <x-input-error :messages="$errors->get('tenor_72_month')" style="color: red;" class="mt-2" />
                        </div>

                        @if ($vehicle->first()->credit_price)
                            <div style="display: flex; gap:20px;" class="btn-credit-calculation">

                                <button type="button" class="btn btn-info" id="btn_calculate">
                                    <i class="fas fa-calculator"></i> Hitung Simulasi</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        @else
                            <button type="button" class="btn btn-dark">Simpan</button>
                        @endif
                    </form>
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



@if (session('alert'))
    <script type="text/javascript">
        alert('{{ session('alert') }}');
    </script>
@endif

<script>
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


    // SCRIPT UNTUK MELAKUKAN PERHITUNGAN SIMULASI | DATE : 28/07/2025 | AUTHOR : ALDRIN
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

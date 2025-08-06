<link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
<link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Inter:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
<!-- Custom styles for this template-->
<link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<title>Tambah data Kendaraan - SAHABAT GROUP AUTO ADMINISTRATOR</title>

<body>
    <div id="wrapper">

        @include('layouts.admin_views.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                @include('layouts.admin_views.header')
                <h4 style="text-align:center;color:black;font-weight:bold;">Tambah Data Kendaraan</h4>
                <div style="display: flex; gap:50px;flex-wrap:wrap;" class="form-group-content">

                    <form class="form_input_new" method="POST" action="{{ route('master_vehicle_data.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>VIN/NO.POL Kendaraan <span style="color: red">*</span></label>
                            <input type="text" class="form-control" value="{{ old('vehicle_registration_number') }}"
                                name="vehicle_registration_number" placeholder="Masukan NO.POL Kendaraan"
                                autocomplete="off">
                            <x-input-error :messages="$errors->get('vehicle_registration_number')" class="mt-2" style="color: red;" />
                        </div>
                        <div class="form-group">
                            <label for="">Brand/Merk</label>
                            <select class="form-control" name="brand">
                                <option value="">--- pilih brand---</option>
                                @foreach ($brand as $merk)
                                    <option value="{{ $merk->id }}">{{ $merk->brand_name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('brand')" class="mt-2" style="color: red;" />
                        </div>
                        <div class="form-group">
                            <label>Tipe Kendaraan</label>
                            <input type="text" class="form-control" value="{{ old('vehicle_type') }}"
                                name="vehicle_type" placeholder="Masukan tipe merk kendaraan, cth:avanza veloz"
                                autocomplete="off">
                            <x-input-error :messages="$errors->get('vehicle_type')" class="mt-2" style="color: red;" />
                        </div>
                        <div class="form-group">
                            <label>Model</label>
                            <select class="form-control" name="vehicle_category">
                                <option value="">--- Pilih jenis kendaraan ---</option>
                                @foreach ($vehicle_type as $type)
                                    <option value="{{ $type->id }}">{{ $type->vehicle_type }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('vehicle_category')" class="mt-2" style="color: red;" />
                        </div>
                        <div class="form-group">
                            <label>Jenis Kendaraan</label>
                            <select class="form-control" name="model">
                                <option value="">--- Pilih jenis kendaraan ---</option>
                                <option value="Mobil Penumpang">Mobil Penumpang</option>
                                <option value="Mobil Barang">Mobil Barang</option>
                                <option value="Mobil Sport">Mobil Sport</option>
                                <option value="Mobil Listrik">Mobil Listrik</option>
                                <option value="Kendaraan Modifikasi">Kendaraan Modifikasi</option>
                            </select>
                            <x-input-error :messages="$errors->get('model')" class="mt-2" style="color: red;" />
                        </div>
                        <div class="form-group">
                            <label>KM saat ini</label>
                            <input type="text" class="form-control" value="{{ old('current_km') }}"
                                name="current_km" placeholder="Masukan Kilometer saat ini" autocomplete="off">
                            <x-input-error :messages="$errors->get('current_km')" class="mt-2" style="color: red;" />
                        </div>
                        <div class="form-group">
                            <label>Warna</label>
                            <input type="text" class="form-control" value="{{ old('color') }}" name="color"
                                placeholder="Masukan warna kendaraan" autocomplete="off">
                            <x-input-error :messages="$errors->get('color')" class="mt-2" style="color: red;" />
                        </div>
                        <div class="form-group">
                            <label>Tahun Pembuatan</label>
                            <input type="number" class="form-control" step="1"
                                value="{{ old('manufacture_year') }}" name="manufacture_year">
                            <x-input-error :messages="$errors->get('manufacture_year')" class="mt-2" style="color: red;" />
                        </div>
                        <div class="form-group">
                            <label>Tahun Registrasi</label>
                            <input type="number" class="form-control" step="1"
                                value="{{ old('registration_year') }}" name="registration_year">
                            <x-input-error :messages="$errors->get('registration_year')" class="mt-2" style="color: red;" />
                        </div>
                        <div class="form-group">
                            <label>Tanggal Pajak</label>
                            <input type="date" class="form-control" value="{{ old('tax_date') }}"
                                name="tax_date">
                            <x-input-error :messages="$errors->get('tax_date')" class="mt-2" style="color: red;" />
                        </div>
                        <div class="form-group">
                            <label>Nomor BPKB</label>
                            <input type="number" class="form-control" value="{{ old('bpkb_number') }}"
                                name="bpkb_number" placeholder="Masukan No.BPKB">
                            <x-input-error :messages="$errors->get('bpkb_number')" class="mt-2" style="color: red;" />
                        </div>
                        <div class="form-group">
                            <label>Kode Lokasi</label>
                            <input type="text" class="form-control" value="{{ old('location_code') }}"
                                name="location_code" placeholder="Masukan kode lokasi">
                        </div>
                        <div class="form-group">
                            <label>No Urut Pendaftaran</label>
                            <input type="text" class="form-control"
                                value="{{ old('registration_queue_number') }}" name="registration_queue_number"
                                placeholder="Nomor urut pendaftaran">
                        </div>

                        <div class="form-group">
                            <label>No.Pol Kendaraan lama (jika ada)</label>
                            <input type="text" class="form-control" value="{{ old('old_vin') }}" name="old_vin"
                                placeholder="No.Pol kendaraan lama (optional)">
                        </div>

                        <div class="form-group">
                            <label for="">Lokasi cabang kendaraan</label>

                            <select class="form-control" name="location_branch_vehicle">
                                <option value="">--- pilih cabang ---</option>
                                @foreach ($branch as $cabang)
                                    <option value="{{ $cabang->id }}">
                                        {{ $cabang->location_code . ' - ' . $cabang->location_name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('location_branch_vehicle')" class="mt-2" style="color: red;" />
                        </div>
                        <br>
                        <h5 style="color: black;font-weight:bold;">Spesifikasi Mesin</h5>
                        <hr>
                        <div class="form-group">
                            <label>Jenis Bahan Bakar</label>
                            <select id="fuel_type" name="fuel_type" class="form-control">
                                <option value="">--- Pilih jenis bahan bakar ---</option>
                                <option value="bensin">Bensin</option>
                                <option value="solar">Solar</option>
                                <option value="lpg">Gas LPG</option>
                                <option value="biodiesel">Biodiesel</option>
                                <option value="e85">E85</option>
                                <option value="bioetanol">Bioetanol</option>
                                <option value="listrik">Bahan Bakar Listrik (EV)</option>
                                <option value="hidrogen">Hidrogen</option>
                                <option value="cng">Gas Alam (CNG)</option>
                            </select>
                            <x-input-error :messages="$errors->get('fuel_type')" class="mt-2" style="color: red;" />
                        </div>

                        <div class="form-group">
                            <label>Isi Silinder/Daya Listrik</label>
                            <input type="number" class="form-control"value="{{ old('cylinder_capacity') }}"
                                name="cylinder_capacity" placeholder="Isi silinder" autocomplete="off">
                            <x-input-error :messages="$errors->get('cylinder_capacity')" class="mt-2" style="color: red;" />
                        </div>
                        <div class="form-group">
                            <label>Transmisi Kendaraan</label>
                            <select class="form-control" name="transmission">
                                <option value="">--- Pilih Transmisi ---</option>
                                <option value="Manual">Manual Transmission (MT)</option>
                                <option value="Automatic">Automatic Transmission (AT)</option>
                            </select>
                            <x-input-error :messages="$errors->get('transmission')" class="mt-2" style="color: red;" />
                        </div>

                        <div class="form-group">
                            <label>Kunci Cadangan</label>
                            <select class="form-control" name="backup_vehicle_key">
                                <option value="">--- Kunci Serep/Kunci Cadangan ---</option>
                                <option value="Ada">Ada</option>
                                <option value="Tidak Ada">Tidak Ada</option>
                            </select>
                            <x-input-error :messages="$errors->get('backup_vehicle_key')" class="mt-2" style="color: red;" />
                        </div>

                        <div class="form-group">
                            <label>Buku Servis</label>
                            <select class="form-control" name="services_book">
                                <option value="">--- Buku Servis ---</option>
                                <option value="Ada">Ada</option>
                                <option value="Tidak Ada">Tidak Ada</option>
                            </select>
                            <x-input-error :messages="$errors->get('services_book')" class="mt-2" style="color: red;" />
                        </div>

                        <div class="form-group">
                            <label>Nomor Mesin</label>
                            <input type="text" class="form-control" value="{{ old('engine_number') }}"
                                name="engine_number" placeholder="Nomor Mesin" autocomplete="off">
                            <x-input-error :messages="$errors->get('engine_number')" class="mt-2" style="color: red;" />
                        </div>
                        <div class="form-group">
                            <label>Nomor Rangka</label>
                            <input type="text" class="form-control" value="{{ old('vehicle_identity_number') }}"
                                name="vehicle_identity_number" placeholder="Nomor Rangka Kendaraan"
                                autocomplete="off">
                            <x-input-error :messages="$errors->get('vehicle_identity_number')" class="mt-2" style="color: red;" />
                        </div>
                        <div class="form-group">
                            <label>Nomor Coding</label>
                            <input type="text" class="form-control" value="{{ old('coding_number') }}"
                                name="coding_number" placeholder="Nomor Coding" autocomplete="off">
                            <x-input-error :messages="$errors->get('coding_number')" class="mt-2" style="color: red;" />
                        </div>
                        <div class="form-group">
                            <label>Warna Plat Nomor Kendaraan (TNKB)</label>
                            <select class="form-control" name="licence_plate_color" id="">
                                <option value="">--- Pilih Warna Plat Nomor ---</option>
                                <option value="Hitam">Hitam</option>
                                <option value="Putih">Putih</option>
                            </select>

                            <x-input-error :messages="$errors->get('licence_plate_color')" class="mt-2" style="color: red;" />
                        </div>

                        <br>
                        <h5 style="color: black;font-weight:bold;">Informasi lainnya</h5>
                        <hr>
                        <div class="form-group">
                            <label for="">Status Unit Kendaraan</label>

                            <select class="form-control" name="status_vehicle_id">
                                <option value="">--- pilih status ---</option>
                                @foreach ($status_category as $status)
                                    <option value="{{ $status->id }}">{{ $status->category_name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('status_vehicle_id')" class="mt-2" style="color: red;" />
                        </div>
                        <div class="form-group">
                            <label>Harga Unit Kendaraan</label>
                            <input type="text" class="form-control" value="{{ old('price') }}" name="price"
                                placeholder="Masukan harga unit kendaraan" autocomplete="off">
                            <x-input-error :messages="$errors->get('price')" class="mt-2" style="color: red;" />
                        </div>
                        <div class="form-group">
                            <label>Harga Kredit Unit Kendaraan</label>
                            <input type="text" class="form-control"
                                placeholder="Masukan harga kredit unit kendaraan" value="{{ old('credit_price') }}"
                                name="credit_price" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Nama Pemilik</label>
                            <input type="text" class="form-control" value="{{ old('name_of_owner') }}"
                                name="name_of_owner" placeholder="Masukan nama pemilik" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Alamat Pemilik</label>
                            <input type="text" class="form-control" value="{{ old('address') }}" name="address"
                                placeholder="Masukan alamat pemilik" autocomplete="off">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Data</button>

                    </form>

                    <div style="width: 400px; height:max-content; padding:8px;" class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Informasi tambah data kendaraan</h6>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li>Penambahan master data kendaraan diharapkan benar</li>
                                <br>
                                <li>User bisa melakukan upload foto, media file, dan dokumen kendaraan pada menu master
                                    "Unit
                                    Kendaraan" jika sudah menambahkan data kendaraan pada form ini</li>
                            </ul>

                        </div>
                    </div>

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
</script>

<link rel="stylesheet" href="{{asset('assets/css/form.css')}}">
<link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
<link
    href="https://fonts.googleapis.com/css?family=Inter:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/css/form.css')}}">
<!-- Custom styles for this template-->
<link href="{{ asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">
<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<title>Tambah data Kendaraan - SAHABAT GROUP AUTO ADMINISTRATOR</title>

<body>
<div id="wrapper">

    @include('layouts.admin_views.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div  id="content">
            @include('layouts.admin_views.header')
            <h4 style="text-align:center;color:black;font-weight:bold;">Tambah Data Kendaraan</h4>
            <div style="display: flex; gap:50px;flex-wrap:wrap;" class="form-group-content">
                
            <form style="width: 60%;" class="form_input" method="POST" action="{{ route('master_vehicle_data.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                <label >VIN/NO.POL Kendaraan <span style="color: red">*</span></label>
                <input type="text" class="form-control" name="vehicle_registration_number" placeholder="Masukan NO.POL Kendaraan" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="">Brand/Merk</label>
                        <select class="form-control" name="brand">
                            <option value="">--- pilih brand---</option>
                            @foreach($brand as $merk)
                            <option value="{{$merk->id}}">{{$merk->brand_name}}</option>
                            @endforeach
                        </select>
                </div>
                <div class="form-group">
                    <label >Tipe Kendaraan</label>
                    <input type="text" class="form-control" name="vehicle_type" placeholder="Masukan tipe merk kendaraan, cth:avanza veloz" autocomplete="off">
                    </div>
                <div class="form-group">
                    <label>Model</label>
                    <select class="form-control" name="vehicle_category">
                        <option value="">--- Pilih jenis kendaraan ---</option>
                        @foreach ($vehicle_type as $type)
                        <option value="{{$type->id}}">{{$type->vehicle_type}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label >Jenis Kendaraan</label>
                    <select class="form-control" name="model" >
                        <option value="">--- Pilih jenis kendaraan ---</option>
                        <option value="Mobil Penumpang">Mobil Penumpang</option>
                        <option value="Mobil Barang">Mobil Barang</option>
                        <option value="Mobil Sport">Mobil Sport</option>
                        <option value="Mobil Listrik">Mobil Listrik</option>
                        <option value="Kendaraan Modifikasi">Kendaraan Modifikasi</option>
                    </select>
                </div>
                <div class="form-group">
                    <label >KM saat ini</label>
                    <input type="text" class="form-control" name="current_km"  placeholder="Masukan Kilometer saat ini" autocomplete="off">
                </div>
                <div class="form-group">
                    <label >Warna</label>
                    <input type="text" class="form-control" name="color"  placeholder="Masukan warna kendaraan" autocomplete="off">
                </div>
                <div class="form-group">
                    <label >Tahun Pembuatan</label>
                    <input type="number" class="form-control" step="1"  name="manufacture_year">
                </div>
                <div class="form-group">
                    <label >Tahun Registrasi</label>
                    <input type="number" class="form-control" step="1"  name="registration_year">
                </div>
                <div class="form-group">
                    <label >Tanggal Pajak</label>
                    <input type="date" class="form-control" name="tax_date">
                </div>
                <div class="form-group">
                    <label >Nomor BPKB</label>
                    <input type="number" class="form-control" name="bpkb_number" placeholder="Masukan No.BPKB">
                </div>
                <div class="form-group">
                    <label >Kode Lokasi</label>
                    <input type="text" class="form-control" name="location_code" placeholder="Masukan kode lokasi">
                </div>
                <div class="form-group">
                    <label >No Urut Pendaftaran</label>
                    <input type="text" class="form-control"  name="registration_queue_number" placeholder="Nomor urut pendaftaran">
                </div>

                <div class="form-group">
                    <label >No.Pol Kendaraan lama (jika ada)</label>
                    <input type="text" class="form-control"  name="old_vin" placeholder="No.Pol kendaraan lama (optional)">
                </div>
        
                <div class="form-group">
                    <label for="">Lokasi cabang kendaraan</label>
                   
                        <select class="form-control" name="location_branch_vehicle">
                            <option value="">--- pilih cabang ---</option>
                            @foreach($branch as $cabang)
                            <option value="{{$cabang->id}}">{{$cabang->location_code . " - " .$cabang->location_name}}</option>
                            @endforeach
                        </select>
                    
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
                </div>
               
                <div class="form-group">
                    <label >Isi Silinder/Daya Listrik</label>
                    <input type="number" class="form-control" name="cylinder_capacity" placeholder="Isi silinder"  autocomplete="off">
                </div>
                <div class="form-group">
                    <label >Transmisi Kendaraan</label>
                    <select class="form-control" name="transmission">
                        <option value="">--- Pilih Transmisi ---</option>
                        <option value="MT">Manual Transmission (MT)</option>
                        <option value="AT">Automatic Transmission (AT)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label >Nomor Mesin</label>
                    <input type="text" class="form-control" name="engine_number" placeholder="Nomor Mesin"  autocomplete="off">
                </div>
                <div class="form-group">
                    <label >Nomor Rangka</label>
                    <input type="text" class="form-control" name="vehicle_identity_number"  placeholder="Nomor Rangka Kendaraan" autocomplete="off">
                </div>
                <div class="form-group">
                    <label >Nomor Coding</label>
                    <input type="text" class="form-control" name="coding_number"  placeholder="Nomor Coding" autocomplete="off">
                </div>
                <div class="form-group">
                    <label >Warna TNKB</label>
                    <input type="text" class="form-control" name="licence_plate_color"  placeholder="Warna TNKB" autocomplete="off">
                </div>

                <br>
                <h5 style="color: black;font-weight:bold;">Informasi lainnya</h5>
                <hr>
                <div class="form-group">
                    <label for="">Status Unit Kendaraan</label>
                   
                        <select class="form-control" name="status_vehicle_id">
                            <option value="">--- pilih status ---</option>
                            @foreach($status_category as $status)
                            <option value="{{$status->id}}">{{$status->category_name}}</option>
                            @endforeach
                        </select>
                </div>
                <div class="form-group">
                    <label >Harga Unit Kendaraan</label>
                    <input type="text" class="form-control" name="price"  placeholder="Masukan harga unit kendaraan" autocomplete="off">
                </div>
                <div class="form-group">
                    <label >Harga Kredit Unit Kendaraan</label>
                    <input type="text" class="form-control" placeholder="Masukan harga kredit unit kendaraan" name="credit_price" autocomplete="off">
                </div>
                <div class="form-group">
                    <label >Nama Pemilik</label>
                    <input type="text" class="form-control" name="name_of_owner"  placeholder="Masukan nama pemilik" autocomplete="off">
                </div>
                <div class="form-group">
                    <label >Alamat Pemilik</label>
                    <input type="text" class="form-control" name="address"  placeholder="Masukan alamat pemilik" autocomplete="off">
                </div>
                
                {{-- <h5 style="color: black;font-weight:bold;">Upload Foto Mobil</h5>
                <hr>
                <div class="form-group">
                    <label for="">Upload foto mobil (Maks 15 Foto)</label>
                <input type="file" name="images[]" multiple required>  
                </div>
                <br>
                <h5 style="color: black;font-weight:bold;">Upload Dokumen/File</h5>
                <hr>
                <div class="form-group">
                    <label for="">Upload dokumen (STNK & BPKB)</label>
                    <input type="file" multiple name="document_files[]">  
                </div> --}}
                
                <button type="submit" class="btn btn-primary">Simpan</button>
            
            </form> 

            <div style="width: 400px; height:max-content; padding:8px;" class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi tambah data kendaraan</h6>
                </div>
                <div class="card-body">
                    <ul>
                        <li>Penambahan master data kendaraan diharapkan benar</li>
                        <br>
                        <li>User bisa melakukan upload foto dan dokumen kendaraan</li>
                        <br>
                        <li>Upload Foto kendaraan hanya bisa setelah upload master data kendataan dan Ketentuan upload gambar dengan format : JPEG, JPG, PNG, jpeg,jpg</li>
                        <br>
                        <li>Ketentuan upload dokumen seperti dokumen STNK & BPKB serta dokumen lainnya</li>
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
    position: fixed; /* Fix posisi spinner */
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: none; /* Spinner disembunyikan saat halaman dimuat */
    justify-content: center; /* Horizontal center */
    align-items: center; /* Vertical center */
    background-color: rgba(0, 0, 0, 0.517); /* Background semi-transparan */
    z-index: 9999; /* Pastikan spinner berada di atas konten lainnya */
  }
  
  .spinner-border {
    color: yellow;
    width: 3rem;
    height: 3rem; /* Pastikan tinggi spinner diatur */
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
       console.log(loadingSpinnerWrapper);  // Cek apakah elemen ditemukan
   
       if (loadingSpinnerWrapper) {
           // Menampilkan spinner saat halaman dimuat
           loadingSpinnerWrapper.style.display = 'flex';
           console.log("Spinner muncul, timer akan dimulai.");
   
           // Menyembunyikan spinner setelah 2 detik (2000ms)
           setTimeout(function() {
               console.log("2 detik berlalu, menyembunyikan spinner.");
               loadingSpinnerWrapper.style.display = 'none';  // Sembunyikan spinner setelah 2 detik
           }, 1000);  // 2000ms = 2 detik
       } else {
           console.log("Elemen spinner tidak ditemukan!");
       }
   });
   </script>




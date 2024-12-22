<link rel="stylesheet" href="{{asset('assets/css/form.css')}}">
<link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
<link
    href="https://fonts.googleapis.com/css?family=Inter:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/css/form.css')}}">
<!-- Custom styles for this template-->
<link href="{{ asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">
<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<title>Edit data Kendaraan - SAHABAT GROUP AUTO ADMINISTRATOR</title>

<body>

<div id="wrapper">

    @include('layouts.admin_views.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div  id="content">
            @include('layouts.admin_views.header')
            <h4 style="text-align:center;color:black;font-weight:bold;">Edit Data Kendaraan</h4>
            <div class="form-group-content">
            
            @foreach ($vehicle as $vehicles)
            <form class="form_input" method="POST" action="{{ route('update_vehicle.update',  $vehicles->id)}}">
                @csrf
                @method('PUT')
                <div class="form-group">
                <label >VIN/NO.POL Kendaraan <span style="color: red">*</span></label>
                <input type="text" class="form-control" value="{{$vehicles->vehicle_registration_number}}" name="vehicle_registration_number" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="">Brand/Merk</label>
                        <select class="form-control" name="brand" id="">
                            @foreach($brand as $merk)
                            <option value="{{$merk->id}}" {{$merk->brand_name == $vehicles->brand ? 'selected' : '' }}>{{$merk->brand_name}}</option>
                            @endforeach
                        </select>
                </div>
                <div class="form-group">
                    <label >Tipe Kendaraan</label>
                    <input type="text" class="form-control" name="vehicle_type" value="{{$vehicles->vehicle_type}}" autocomplete="off">
                    </div>
                <div class="form-group">
                    <label>Model</label>
                    <select class="form-control" name="vehicle_category" id="">
                        @foreach ($vehicle_type as $type)
                        <option value="{{$type->id}}" {{$type->id == $vehicles->vehicle_category ? 'selected' : '' }}>{{$type->vehicle_type}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label >Jenis Kendaraan</label>
                    <select class="form-control" name="model" >
                      @foreach($vehicle_model as $model)
                      <option value="{{$model->model_name}}" {{$model->model_name == $vehicles->model ? 'selected' : '' }}>{{$model->model_name}}</option>
                      @endforeach

                    </select>
                </div>
                <div class="form-group">
                    <label >KM saat ini</label>
                    <input type="text" class="form-control" name="current_km" value="{{$vehicles->current_km}}" autocomplete="off">
                </div>
                <div class="form-group">
                    <label >Warna</label>
                    <input type="text" class="form-control" name="color"  value="{{$vehicles->color}}" autocomplete="off">
                </div>
                <div class="form-group">
                    <label >Tahun Pembuatan</label>
                    <input type="number" class="form-control" step="1" value="{{$vehicles->manufacture_year}}"  name="manufacture_year">
                </div>
                <div class="form-group">
                    <label >Tahun Registrasi</label>
                    <input type="number" class="form-control" step="1" value="{{$vehicles->registration_year}}"  name="registration_year">
                </div>
                <div class="form-group">
                    <label >Tanggal Pajak</label>
                    <input value="{{ \Carbon\Carbon::parse($vehicles->tax_date)->format('Y-m-d') }}" type="date" class="form-control" name="tax_date">
                </div>
                <div class="form-group">
                    <label >Nomor BPKB</label>
                    <input type="text" class="form-control" value="{{$vehicles->bpkb_number}}" name="bpkb_number" placeholder="Masukan No.BPKB">
                </div>
                <div class="form-group">
                    <label >Kode Lokasi</label>
                    <input type="text" class="form-control" value="{{$vehicles->location_code}}" name="location_code">
                </div>
                <div class="form-group">
                    <label >No Urut Pendaftaran</label>
                    <input type="text" class="form-control" value="{{$vehicles->registration_queue_number}}" name="registration_queue_number">
                </div>

                <div class="form-group">
                    <label >No.Pol Kendaraan lama (jika ada)</label>
                    <input type="text" class="form-control" value="{{$vehicles->old_vin}}" name="old_vin">
                </div>
        
                <div class="form-group">

                    <label for="branch_id">Lokasi cabang kendaraan</label>
                
                    <select class="form-control" name="location_branch_vehicle" id="branch_id">
                        @foreach($branch as $cabang)
                            <option value="{{$cabang->id}}" {{$cabang->location_name == $vehicles->location_unit ? 'selected' : '' }}>{{$cabang->location_name}}</option>
                
                        @endforeach
                
                    </select>
                
                </div>
                <br>
                <h5 style="color: black;font-weight:bold;">Spesifikasi Mesin</h5>
                <hr>
                <div class="form-group">
                    <label >Tipe Bahan Bakar</label>
                    <input type="text" class="form-control" value="{{$vehicles->fuel_type}}" name="fuel_type" autocomplete="off">
                </div>
                <div class="form-group">
                    <label >Isi Silinder/Daya Listrik</label>
                    <input type="text" class="form-control" value="{{$vehicles->cylinder_capacity}}" name="cylinder_capacity" autocomplete="off">
                </div>
                <div class="form-group">
                    <label >Transmisi Kendaraan</label>
                    <select class="form-control" name="transmission" id="">
                        @foreach($transmission as $transmisi_vehicle)
                        <option value="{{$transmisi_vehicle->transmission}}" {{$transmisi_vehicle->transmission == $vehicles->transmission ? 'selected' : '' }}>{{$transmisi_vehicle->transmission}}</option>
                        @endforeach
                        {{-- <option value="MT">Manual Transmission (MT)</option>
                        <option value="AT">Automatic Transmission (AT)</option> --}}
                    </select>
                </div>
                <div class="form-group">
                    <label >Nomor Mesin</label>
                    <input type="text" class="form-control" value="{{$vehicles->engine_number}}" name="engine_number" autocomplete="off">
                </div>
                <div class="form-group">
                    <label >Nomor Rangka</label>
                    <input type="text" class="form-control" value="{{$vehicles->vehicle_identity_number}}" name="vehicle_identity_number" value="{{$vehicles->vehicle_identity_number}}" autocomplete="off">
                </div>
                <div class="form-group">
                    <label >Nomor Coding</label>
                    <input type="text" class="form-control" value="{{$vehicles->coding_number}}" name="coding_number"  autocomplete="off">
                </div>
                <div class="form-group">
                    <label >Warna TNKB</label>
                    <input type="text" class="form-control" value="{{$vehicles->licence_plate_color}}" name="licence_plate_color" autocomplete="off">
                </div>
                <br>
                <h5 style="color: black;font-weight:bold;">Informasi lainnya</h5>
                <hr>
                <div class="form-group">
                    <label for="">Status Unit Kendaraan</label>
                        <select class="form-control" name="status_vehicle_id" id="">
                          
                            @foreach($status_category as $status)
                            <option value="{{$status->id}}" {{$status->category_name == $vehicles->category_name ? 'selected' : '' }}>{{$status->category_name}}</option>
                            @endforeach
                        </select>
                </div>
                <div class="form-group">
                    <label >Harga Unit Kendaraan</label>
                    <input type="text" class="form-control" value="{{$vehicles->price}}" name="price" autocomplete="off">
                </div>
                <div class="form-group">
                    <label >Harga Kredit Unit Kendaraan</label>
                    <input type="text" class="form-control" value="{{$vehicles->credit_price}}" name="credit_price" autocomplete="off">
                </div>
                <div class="form-group">
                    <label >Nama Pemilik</label>
                    <input type="text" class="form-control" value="{{$vehicles->name_of_owner}}" name="name_of_owner" autocomplete="off">
                </div>
                <div class="form-group">
                    <label >Alamat Pemilik</label>
                    <input type="text" class="form-control" value="{{$vehicles->address}}" name="address"  placeholder="Masukan alamat pemilik" autocomplete="off">
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
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
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Buat SPK Kendaraan - SAHABAT GROUP AUTO ADMINISTRATOR</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Inter:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/form.css')}}">
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Inter:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('layouts.admin_views.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                @include('layouts.admin_views.header')
    
                <div id="content">
                    
                    <h4 style="text-align:center;color:black;font-weight:bold;">Tambah SPK Unit Kendaraan</h4>
                    
                    <div style="display: flex; gap:50px;flex-wrap:wrap;" class="form-group-content">
                        <form style="width: 60%;" class="form_input" method="POST" action="{{ route('transaksi_spk_unit.store')}}">
                            @csrf   

                            <div class="form-group">
                                <label>Unit Kendaraan</label>
                                <select class="form-control" name="vehicle_id" id="vehicleId">
                                    <option value="">==== Pilih Unit Kendaraan ====</option>
                                    @foreach ($vehicle_data as $vehicle)
                                    <option value="{{$vehicle->id}}">[{{$vehicle->vehicle_registration_number}}] - {{$vehicle->unit}}</option>        
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Warna Kendaraan</label>
                                <input id="showColor" class="form-control" value="{{old('color')}}" type="text" readonly>
                            </div>


                            <div class="form-group">
                                <label for="">Tahun Kendaraan</label>
                                <input id="showYear" class="form-control" value="{{old('manufacture_year')}}" type="text" readonly>
                            </div>

                            <div class="form-group">
                                <label>Metode Pembayaran</label>
                                <select class="form-control" name="payment_method" id="">
                                    <option value="">=== Pilih Metode Pembayaran ===</option>
                                    <option value="cash">Cash/Tunai</option>
                                    <option value="credit">Kredit</option>
                                </select>
                            </div>


                            <div style="display: flex;flex-wrap:wrap;justify-content:start; gap:10px;" class="form-group">
                                <div class="cash-price">
                                    <label for="">Harga Cash</label>
                                    <div style="display: flex; gap:10px;" class="input-price">
                                        <input style="font-size: 15px;" id="showPrice" value="{{old('price')}}" class="form-control" type="radio" name="price">
                                        <input style="border: none;width:100px;" type="text" value="{{old('price')}}" id="showPriceNew" readonly>
                                    </div>
                                </div>
                                 <br>
                                 <div class="credit-price">
                                    <label for="">Harga Kredit</label>
                                    <div style="display: flex; gap:10px;" class="input-price">
                                        <input style="font-size: 15px;" id="showCreditPrice" value="{{old('credit_price')}}" class="form-control" type="radio" name="price"> 
                                        <input style="border: none;width:100px;" type="text" value="{{old('credit_price')}}" id="showCreditPriceNew" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">Terbilang</label>
                                <input class="form-control" type="text" placeholder="Nominal terbilang" name="price_nominal">
                            </div>

                            <div class="form-group">
                                <label for="">DP Unit</label>
                                <input class="form-control" type="text" placeholder="Pembayaran DP" name="down_payment">
                                <p style="font-style: italic;font-size:13px;" class="text-secondary"> *Jika pembayaran metode kredit </p>
                            </div>

                            
                            
                            <div class="form-group">
                                <label for="">Lokasi Unit</label>
                                <input id="showLocation" class="form-control" type="text" name="location_unit" value="{{old('location_name')}}" readonly>
                            </div>

                            <hr>

                            <div class="form-group">
                                <label>Nama Customer</label>
                                <input type="text" class="form-control" name="customer" autocomplete="off" placeholder="Masukan Nama Customer">
                            </div>

                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" class="form-control" name="address" autocomplete="off" placeholder="Masukan Alamat Customer">
                            </div>

                            <div class="form-group">
                                <label>No.Telepon/WA</label>
                                <input type="text" class="form-control" name="phone_number" autocomplete="off" placeholder="Masukan No Telepon">
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" autocomplete="off" placeholder="Masukan Email">
                            </div>
                            

                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>  


                        <div style="width: 400px; height:max-content; padding:8px;" class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Informasi pembuatan akun admin</h6>
                            </div>
                            <div class="card-body">
                                <ul>
                                    <li>Pembuatan SPK Unit Kendaraan dilakukan oleh Sales/Marketing</li>
                                    <br>
                                    <li>Konfirmasi hanya dilakukan oleh Kepala Cabang dan Sales Manager</li>
                                    <br>
                                    <li>Pembuatan SPK Unit Kendaraan pastikan data yang dinput benar</li>
                                </ul>
                                
                            </div>
                        </div>
                    </div>

                    
                </div>

                
    
            </div>
           
            @include('layouts.admin_views.footer')

        </div>
        <!-- End of Content Wrapper -->
        @yield('content')

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    {{-- spinner --}}
    <div id="loadingSpinnerWrapper">
        <div class="spinner-border" role="status">
        </div>
      </div>
      
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
  

</body>

<script>
    window.addEventListener('load', function() {
       var loadingSpinnerWrapper = document.getElementById('loadingSpinnerWrapper');
   
       // Log elemen untuk memastikan spinner ditemukan
         // Cek apakah elemen ditemukan
   
       if (loadingSpinnerWrapper) {
           // Menampilkan spinner saat halaman dimuat
           loadingSpinnerWrapper.style.display = 'flex';
          
   
           // Menyembunyikan spinner setelah 2 detik (2000ms)
           setTimeout(function() {
               
               loadingSpinnerWrapper.style.display = 'none';  // Sembunyikan spinner setelah 2 detik
           }, 1000);  // 2000ms = 2 detik
       } else {
           console.log("Elemen spinner tidak ditemukan!");
       }
   });
   </script>

   <script>
    document.getElementById('vehicleId').addEventListener('change', function(){
        var vehicleId = this.value;

        if(!vehicleId) {
            document.getElementById('showYear').value = '';
            document.getElementById('showColor').value = '';
            document.getElementById('showLocation').value = '';
            document.getElementById('showPrice').value ='';
            document.getElementById('showPriceNew').value ='';
            document.getElementById('showCreditPrice') = '';
            document.getElementById('showCreditPriceNew') = '';
            return;
        }
        
        fetch('/get_unit/' + vehicleId).then(response =>{
            if(!response.ok){
                throw new Error('Not have data');
            }
            return response.json();
        }).then(data => {
            if(data.color){
                document.getElementById('showColor').value = data.color;
            }
            if(data.manufacture_year){
                document.getElementById('showYear').value = data.manufacture_year;
            }

            if(data.location_name){
                document.getElementById('showLocation').value = data.location_name;
            }

            if(data.price){
                document.getElementById('showPrice').value = data.price;
            }

            if(data.price){
                document.getElementById('showPriceNew').value = data.price;
            }

            if(data.credit_price){
                document.getElementById('showCreditPrice').value = data.credit_price;
            }

            if(data.credit_price){
                document.getElementById('showCreditPriceNew').value = data.credit_price;
            }
        })
    })
   </script>

</html>
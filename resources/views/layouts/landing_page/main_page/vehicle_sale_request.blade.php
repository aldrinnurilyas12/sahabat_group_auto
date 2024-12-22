<!DOCTYPE html>
 <html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sahabat Group Auto - Jual Beli Mobil Bekas Murah & Terpecaya</title>

    <!-- Meta SEO -->
    <meta name="title" content="Landwind - Tailwind CSS Landing Page">
    <meta name="description" content="Get started with a free and open-source landing page built with Tailwind CSS and the Flowbite component library.">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    <meta name="author" content="Themesberg">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link href="{{asset('assets/css/output.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link href="{{asset('bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
     <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{url('bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
</head>
<body>
    @include('layouts.landing_page.navbar.header_new')

    <!-- Start block -->
    <section style="height: 500px; background-color:black; position: relative;">
        <!-- Container for text and content -->
        <div class="max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28" style="position: relative; z-index: 2;">
            <div class="btn-contact" style="opacity: 1;">
                <h1 class="max-w-2xl mb-4 text-4xl font-extrabold leading-none tracking-tight md:text-5xl xl:text-6xl dark:text-white" style="color: rgb(255, 255, 255);">
                    Ingin menjual mobil anda? Kami siap memberikan penawaran terbaik.
                </h1>
                <p class="max-w-2xl mb-6" style="color: white;">
                   Jual mobil anda di PT Sahabat Group Auto, Dapatkan penawaran terbaik dari kami.
                </p>

                <a style="background:yellow; color:black;" class="btn btn-dark" href="#appointment-create">Jual Mobil Anda <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    
        <!-- Image with opacity -->
        <img src="{{asset('assets/images/deals.jpg')}}" alt="" style="position: absolute; top: 0; left: 0; height: 100%; width: 100%; object-fit: cover; opacity: 0.6; z-index: 1;">
    </section>
    

    <section id="appointment-create" style="background-image: linear-gradient(to right, #fffffc 10%, #fffff6f7 80%);">
        <div class="max-w-screen-xl px-4 py-8 mx-auto space-y-12 lg:space-y-20 lg:py-24 lg:px-6">
            <!-- Row -->
            <div class="items-center gap-8 lg:grid lg:grid-cols-2 xl:gap-16">
                <div style="width:100%;" class="text-gray-500 sm:text-lg ">
                    <h3 style="color: black;" class="mb-4 text-3xl font-extrabold dark:text-white">Form Jual Unit Kendaraan</h3>
                </div>
            </div>
            <!-- Row -->

            <div style="margin: 0; padding:0;" id="content">
                      
                <div style="display: flex; gap:50px;flex-wrap:wrap;" class="form-group-content">
                    <form style="width: 60%;" class="form_input" method="POST" action="{{ route('vehicle_request_save')}}">
                        @csrf 
                        
                        <div class="form-group">
                            <label>Pilih Unit</label>
                            <select class="form-control" name="brand_id">
                                <option value="">=== Pilih Merk/Brand ===</option>
                                @foreach($brand as $merk)
                                <option value="{{$merk->id}}">{{$merk->brand_name}}</option>
                                @endforeach
                            </select>
                            @error('brand_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                           
                        </div>

                        <div class="form-group">
                            <label>Tipe Unit Kendaraan</label>
                            <input type="vehicle_type" class="form-control"  name="vehicle_type" placeholder="Masukan tipe unit kendaraan, cth: Veloz Sport" autocomplete="off">
                            @error('vehicle_type')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Tahun Kendaraan</label>
                            <input type="text" class="form-control"  name="vehicle_year" placeholder="Masukan tahun kendaraan" autocomplete="off">
                            @error('vehicle_year')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Kilometer saat ini</label>
                            <input type="text" class="form-control"  name="current_km" placeholder="Masukan kilometer saat ini" autocomplete="off">
                            @error('current_km')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Warna Kendaraan</label>
                            <input type="text" class="form-control"  name="vehicle_color" placeholder="Masukan warna kendaraan" autocomplete="off">
                            @error('vehicle_color')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control"  name="name" placeholder="Masukan nama anda" autocomplete="off">
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control"  name="email" placeholder="Masukan email anda" autocomplete="off">
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="text" name="status" value="pending" hidden>
                        </div>

                        <div class="form-group">
                            <label>Nomor Telepon</label>
                            <input type="text" class="form-control"  name="phone_number" placeholder="Masukan nomor telepon" autocomplete="off">
                            @error('phone_number')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                       <br>
                       <div style="display: flex;flex-wrap:wrap; gap:10px;" class="btn-component">
                            <button type="submit" class="btn btn-dark">Dapatkan Penawaran <i class="fa fa-paper-plane"></i></button>
                            <button class="btn btn-primary" id="btn-check" type="button">Lihat Status</button>
                        </div>
                    </form>  

                    

                    <div style="width: 400px; height:max-content; padding:8px;" class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Informasi Penawaran Jual Unit Kendaraan</h6>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li>Silahkan isi form penawaran Jual Unit Kendaraan</li>
                                <br>
                                <li>Maka tim kami akan meninjau permintaan Jual Unit Kendaraan Anda</li>
                                <br>
                                <li>Tim kami akan menghubungi anda setelah H-2 untuk melakukan konfirmasi permintaan penawaran Jual Unit Kendaraan</li>
                            </ul>
                            
                        </div>
                    </div>
                </div>

                
            </div>
           
        </div>
    </section>


    <section id="check-status" style="background-image: linear-gradient(to right, #9c95ff 10%, #e0dbfff7 80%);">
        <div class="max-w-screen-xl px-4 py-8 mx-auto text-center lg:py-24 lg:px-6">
            <div style="width:100%;height:max-content; border-radius:10px;border:1.5px solid gray;background:white;padding:15px;" class="card-help-services">
             <div class="max-w-screen-md mx-auto mb-3 text-center lg:mb-12">
                 <h2 class="mb-4 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">Cek Status Informasi Permintaan Penawaran Jual Unit Kendaraan</h2>
                 <p class="font-light text-gray-500 sm:text-xl dark:text-gray-400">Silahkan masukan token anda yang sudah kami kirimkan melalui email.</p>
             </div>
             <form id="form-submit">
                 @csrf
                 <label for="">Masukan Token Anda</label>
                 <br>
                 <input style="margin-bottom: 30px;" type="text" class="input-form-submit" name="unique_tokens" placeholder="Masukan token disini..." id="">
                 <br>
                
                 <div class="btn-submit">
                     <button style="background-color: #212529;" class="btn btn-dark" type="submit">Cek Hasil
                     </button>
                 </div>
             </form>
             <br>
             <br>

             <div id="responseMessage" class="result-check-status" >
                <div class="max-w-screen-md mx-auto mb-3 text-center lg:mb-12">
                    <h2 class="mb-4 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">Hasil Informasi Status Anda</h2>
                     </div>
                     @if($vehicle_sale_request->isEmpty())
                     <p class="text-secondary">Hasil informasi status akan muncul ketika token dimasukan.</p>
                     @endif
                
                </div>


                <div id="info-status" style="display: flex;flex-wrap:wrap;gap:80px;text-align:start;justify-content:center;">
                   
                    <div style="width:300px;" class="info-first">
                     
                     
                    </div>
    
                    <div style="width:300px;" class="second-info">
                        
                    </div>
                 </div>
            </div>
            </div>
        </div>

           
        
    </section>

    @include('layouts.landing_page.footer.footer')
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

  .fixed-column {
            position: -webkit-sticky; /* Untuk kompatibilitas browser */
            position: sticky;
            left: 0;
            background-color: #fff;
            z-index: 1; /* Pastikan kolom waktu berada di atas konten lainnya */
            box-shadow: 1px 0 5px rgba(0, 0, 0, 0.1); /* Memberikan sedikit bayangan agar kolom terlihat lebih jelas */
        }
        .schedule-time {
            overflow-x: auto;
            max-width: 100%;
        }

        #check-status {
            display: none;
        }

        table {
            width: 100%;
            border-collapse: collapse; /* Menghilangkan gap antar kolom */
        }

        th, td {
            padding: 10px;
            text-align: left;
            font-size: 14px;
        }

        th {
            width:50px;
            position: relative;
            background-color: #f4f4f4; /* Menandai header */
        }
        

  
  </style>
    
</body>
@if (Session::has('message_success'))
<script>
    Swal.fire({
        title: 'Berhasil',
        text: "{{ Session::get('message_success') }}",
        icon: 'success',
        timer:2000,
        confirmButtonText: 'OK'
    });
</script>
    
@endif


@if (Session::has('failed_insert'))
<script>
    Swal.fire({
        title: 'Gagal',
        text: "{{ Session::get('failed_insert') }}",
        icon: 'error',
        timer:2000,
        confirmButtonText: 'OK'
    });
</script>
    
@endif

<script>
    window.onload = function() {
        var element = document.getElementById("filterBranch");
        if (element) {
            element.scrollIntoView({ behavior: "smooth" });
        }
    }
</script>

<script>

var btnSubmit = document.getElementById('btn-check');
var showDialog = document.getElementById('check-status');
var btnRequest = document.getElementById('btn-submit-check');

btnSubmit.addEventListener('click', function(event) {
    event.preventDefault();  // Mencegah form dari submit
   
    // Toggle display status
    if (showDialog.style.display === 'block') {
        showDialog.style.display = 'none';  // Menyembunyikan
    } else {
        showDialog.style.display = 'block'; // Menampilkan
    }
});



$(document).ready(function () {
    // Meng-handle form submit
    $('#form-submit').submit(function (e) {
        e.preventDefault(); // Mencegah halaman reload

        // Mengambil data form
        var formData = $(this).serialize();

        // Mengirim data menggunakan AJAX
        $.ajax({
            url: '/get_status', // URL untuk mengirim data
            type: 'GET',
            data: formData,
            success: function (response) {
             

                // Pastikan response.data ada dan valid
                if (response.status === 'success' && response.data) {
                   
                    // Tampilkan div info-status
                    $('#info-status').show();
                    

                    $('#info-status .info-first').empty();
                    $('#info-status .second-info').empty();
                   
                    // Loop data dan masukkan ke dalam HTML
                    $.each(response.data, function (index, item) {
                        // Menambahkan informasi kendaraan
                        $('#info-status .info-first').append(
                            '<ul>' +
                                '<p><strong>Unit :</strong><br>' + item.brand_name + ' ' + item.vehicle_type + ' ' + item.vehicle_color + ' ' + item.vehicle_year + '</p>' +
                                '<p><strong>Pemilik/Pemohon:</strong><br>' + item.name + '</p>' +
                                '<p><strong>Status:</strong><br>' + item.status + '</p>' +
                                '<p><strong>Tanggal konfirmasi:</strong><br>' + item.updated_at + '</p>' +
                            '</ul>'
                        );

                        // Menambahkan deskripsi
                        var description = item.description ? item.description : 'Informasi: -';
                        $('#info-status .second-info').append(
                            '<p><strong>Informasi: </strong><br>' + description + '</p>'
                        );
                    });
                } else {
                   
                  
                }
            },
            error: function (xhr, status, error) {
                // Menangani error
                $('#responseMessage').html('<p>Error: ' + error + '</p>');
            }
        });
    });
    });




</script>
  


<style>
@import url('https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap');

    .card {
        width: 14rem;
        height: max-content
    }

    body {
        font-family: "Noto Serif", serif;
    }

    input.input-form-submit {
        border-radius:6px;
    }


    #map { height: 400px; }
    @media only screen and (max-width:360px){
        .form-group-content{
            width:100%;
        },
        .card {
            width:100px;
        }
    }
</style>




<script>
    // Inisialisasi peta dan set view ke koordinat tengah
    var map = L.map('map').setView([51.505, -0.09], 13);  // Ini koordinat default

    // Menambahkan tile layer peta (OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Daftar koordinat (tiga titik)
    var coordinates = [
        [51.505, -0.09],   // Titik 1
        [51.515, -0.1],    // Titik 2
        [51.525, -0.11]    // Titik 3
    ];

    // Menambahkan marker untuk setiap titik koordinat
    coordinates.forEach(function(coord, index) {
        var marker = L.marker(coord).addTo(map);
        marker.bindPopup("Titik " + (index + 1) + ": " + coord[0] + ", " + coord[1]);
    });

    // Mengatur peta untuk menampilkan seluruh koordinat
    var bounds = L.latLngBounds(coordinates);
    map.fitBounds(bounds);  // Menyesuaikan peta untuk menampilkan semua titik
</script>


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
      document.getElementById('vehicle_id').addEventListener('change', function(){
    var vehicle_id = this.value

    if(!vehicle_id) {
        document.getElementById('showLocation').value='';
        return;
    }

    fetch('/get_location/' + vehicle_id).then(response => {
        if(!response.ok) {
            throw new Error('Location not found');
        }
        return response.json();
    }).then(data => {
        if(data.branch_id) {
            document.getElementById('showLocation').value = data.branch_id;
        }
    })
   })
   </script>


</html>
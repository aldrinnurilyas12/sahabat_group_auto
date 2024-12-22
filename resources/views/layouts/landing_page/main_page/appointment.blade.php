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
    
</head>
<body>
    @include('layouts.landing_page.navbar.header_new')

    <!-- Start block -->
    <section style="height: 500px; background-color:black; position: relative;">
        <!-- Container for text and content -->
        <div class="max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28" style="position: relative; z-index: 2;">
            <div class="btn-contact" style="opacity: 1;">
                <h1 class="max-w-2xl mb-4 text-4xl font-extrabold leading-none tracking-tight md:text-5xl xl:text-6xl dark:text-white" style="color: rgb(255, 255, 255);">
                    Jadwalkan Kunjungan Anda ke Showroom Kami!
                </h1>
                <p class="max-w-2xl mb-6" style="color: white;">
                    Ingin merasakan langsung produk pilihan Anda? Kami mengundang Anda untuk mengunjungi showroom kami! Dapatkan pengalaman berbelanja yang lebih personal dengan melakukan appointment terlebih dahulu.
                </p>

                <a style="background:yellow; color:black;" class="btn btn-dark" href="#appointment-create">Buat Appointment <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    
        <!-- Image with opacity -->
        <img src="{{asset('assets/images/csss.jpg')}}" alt="" style="position: absolute; top: 0; left: 0; height: 100%; width: 100%; object-fit: cover; opacity: 0.6; z-index: 1;">
    </section>
    


    <section style="background-image: linear-gradient(to right, #fffffc 10%, #fffff6f7 80%);">
        <div style="padding-bottom: 2rem;" class="max-w-screen-xl px-4 py-8 mx-auto space-y-12 lg:space-y-20 lg:py-24 lg:px-6">
            <!-- Row -->
            <div class="items-center gap-8 lg:grid lg:grid-cols-2 xl:gap-16">
                <div class="text-gray-500 sm:text-lg ">
                    <h3 style="color: black;" class="mb-4 text-3xl font-extrabold dark:text-white">Kenapa harus membuat janji?</h3>
                   
                    <ul style="color: black; padding-left:0;" role="list" class="pt-8 space-y-5 border-t border-gray-200 my-7 dark:border-gray-700">
                        <li class="flex space-x-3">
                            <!-- Icon -->
                            <svg class="flex-shrink-0 w-5 h-5 text-purple-500 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-base font-medium leading-tight text-gray-900 dark:text-white"> Pelayanan Eksklusif: Anda akan dilayani secara langsung oleh tenaga ahli kami yang siap memberikan informasi detail dan rekomendasi terbaik.</span>
                        </li>
                        <li class="flex space-x-3">
                            <!-- Icon -->
                            <svg class="flex-shrink-0 w-5 h-5 text-purple-500 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-base font-medium leading-tight text-gray-900 dark:text-white"> Kenyamanan Maksimal: Hindari antrean dan nikmati waktu yang lebih fokus untuk memilih produk sesuai keinginan.</span>
                        </li>
                        <li class="flex space-x-3">
                            <!-- Icon -->
                            <svg class="flex-shrink-0 w-5 h-5 text-purple-500 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-base font-medium leading-tight text-gray-900 dark:text-white">Kunjungan Terjadwal: Kami akan mempersiapkan segala sesuatu sebelum kedatangan Anda, memastikan Anda mendapatkan pengalaman yang menyenangkan.</span>
                        </li>
        
                    </ul>

                </div>
                <img class="hidden w-full mb-4 rounded-lg lg:mb-0 lg:flex" src="{{asset('assets/images/cs.jpg')}}" alt="dashboard feature image">
            </div>
            <!-- Row -->
           
        </div>
    </section>


      <section id="filterBranch" style="background-image: linear-gradient(to bottom, #003fd2 10%, #4498fff7 80%);">
        <div style="padding-top:30px;padding-bottom:3rem;" class="max-w-screen-xl px-4 py-8 mx-auto space-y-12 lg:space-y-20 lg:py-24 lg:px-6">
            <!-- Row -->
            <div style="display: block;color:white;" >
                <h3 class="mb-2 text-3xl font-extrabold dark:text-white">Lihat Jadwal Kunjungan & Test Drive</h3>
                <p>Anda dapat melihat jadwal kunjungan dan dapat melakukan appointment</p>

                <div style="display: flex; gap:20px;justify-content:space-between;font-size:14px;" class="filter-location">
                   <h5>Tanggal : <?php echo date('d F Y') ?></h5>

                   <div class="filter-content">
                    <form method="GET" action="{{route('filter_branch')}}">
                        <select style="height: max-content;text-align:center;border-radius:5px;color:black;" name="location_unit" id="">
                                <option value="#">=== Pilih Lokasi ===</option>
                                @foreach($location as $loc)
                                <option value="{{$loc->location_name}}">{{$loc->location_name}}</option>
                                @endforeach
                        </select>
                        <button class="btn btn-dark">Filter</button>
                    </form>
                   </div>
                </div>
            </div>
            <!-- Row -->


            <div style="background-color:rgb(255, 255, 255); width:100%; height:300px; padding:0; overflow-x:scroll;" class="schedule-time">
                <table style="width: 100%; overflow-x:auto;" border="1">
                    <thead>
                        <tr style="gap:20px;">
                            <th class="fixed-column">Waktu</th>
                            @foreach($vehicle_new as $ads)
                                <th style="width:300px;">{{$ads->unit}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @if($schedule_times->isNotEmpty())
                            @foreach($schedule_times as $time)
                                <tr>
                                    <td class="fixed-column">{{$time->schedule_time}}</td>
                                   @if(!$selectlocation)
                                   <td>Data tidak ada silahkan filter lokasi</td>
                                   @else
                                    @foreach($vehicle_new as $ads)
                                        <td>
                                            @php
                                                // Mencari apakah ada data yang cocok untuk ads_id dan schedule_time ini
                                                $matchedAd = $vehicle_ads->firstWhere(function($vehicle_ad) use ($ads, $time) {
                                                    return $vehicle_ad->ads_id == $ads->ads_id && $vehicle_ad->schedule_time == $time->schedule_time;
                                                });
                                            @endphp
                
                                            @if($matchedAd) <!-- Jika ada kendaraan yang sudah terdaftar pada waktu tersebut -->
                                                <span style="background:rgba(255, 54, 138, 0.445); color:rgb(128, 0, 0); padding:5px; border-radius:5px;">Booked</span>
                                            @else <!-- Jika tidak ada kendaraan yang terdaftar pada waktu tersebut -->
                                                <span style="background:rgba(54, 255, 54, 0.445); color:green; padding:5px; border-radius:5px;">Available</span>
                                            @endif
                                        </td>
                                    @endforeach
                                    @endif
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="{{ count($vehicle_new) + 1 }}" style="text-align: center;">Tidak ada data jadwal</td>
                            </tr>
                        @endif
                        
                        
                    </tbody>
                </table>
                
            </div>
            
            
            
           
        </div>
      </section>
    

      <section id="appointment-create" style="background-image: linear-gradient(to right, #fffffc 10%, #fffff6f7 80%);">
        <div class="max-w-screen-xl px-4 py-8 mx-auto space-y-12 lg:space-y-20 lg:py-24 lg:px-6">
            <!-- Row -->
            <div class="items-center gap-8 lg:grid lg:grid-cols-2 xl:gap-16">
                <div style="width:100%;" class="text-gray-500 sm:text-lg ">
                    <h3 style="color: black;" class="mb-4 text-3xl font-extrabold dark:text-white">Pilih Jadwal Kunjungan Anda</h3>
                </div>
            </div>
            <!-- Row -->

            <div style="margin: 0; padding:0;" id="content">
                      
                <div style="display: flex; gap:50px;flex-wrap:wrap;" class="form-group-content">
                    <form style="width: 60%;" class="form_input" method="POST" action="{{ route('appointment_save')}}">
                        @csrf 
                        
                        <div class="form-group">
                            <label>Pilih Unit</label>
                            <select id="vehicle_id" class="form-control" name="ads_id">
                                <option value="">=== Pilih Unit Dahulu ===</option>
                                @foreach($vehicle_data as $ads)
                                <option value="{{$ads->ads_id}}">{{$ads->unit}}</option>
                                @endforeach
                            </select>
                            @error('ads_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                           
                        </div>

                        <div class="form-group">
                            <input hidden id="showLocation" type="text" name="branch_id" value="{{old('branch_id')}}" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label>Tanggal Kunjungan/Test Drive</label>
                            <input type="date" class="form-control"  name="date" autocomplete="off">
                            @error('date')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Jam</label>
                            <select class="form-control" name="schedule_time" id="">
                                <option value="#">=== Pilih Jam Kunjungan ===</option>
                                @foreach($schedule_times as $time)
                                <option value="{{$time->id}}">{{$time->schedule_time}}</option>
                                @endforeach
                            </select>
                            @error('schedule_time')
                            <div class="alert alert-danger">{{ $message }}</div>
                             @enderror
                        </div>

                        <div class="form-group">
                            <label>Nama Lengkap Anda</label>
                            <input type="text" class="form-control"  name="name" autocomplete="off">
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control"  name="email" autocomplete="off">
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>No.Telepon</label>
                            <input type="text" class="form-control"  name="phone_number" autocomplete="off">
                            @error('phone_number')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                       <br>
                        <button type="submit" class="btn btn-dark">Kirim Appointment <i class="fa fa-paper-plane"></i></button>
                    </form>  

                    

                    <div style="width: 400px; height:max-content; padding:8px;" class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Informasi Appointment</h6>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li>Silahkan lihat dahulu jadwal kunjungan dan lokasi yang ingin dikunjungi</li>
                                <br>
                                <li>Pilih Unit Kendaraan yang ingin melakukan kunjungan/test drive</li>
                                <br>
                                <li>Lalu isi form data kunjungan untuk melakukan appointment</li>
                                <br>
                                <li>Tim kami akan menghubungi anda setelah H-2 untuk melakukan konfirmasi kunjungan</li>
                            </ul>
                            
                        </div>
                    </div>
                </div>

                
            </div>
           
        </div>
    </section>
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
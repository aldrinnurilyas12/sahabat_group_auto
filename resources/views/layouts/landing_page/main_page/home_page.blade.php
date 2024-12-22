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

    {{-- section awal --}}
    <section style="background-image: linear-gradient(to bottom, #f8f000 10%, #fff30984 80%);">
        <div class="max-w-screen-xl px-4 py-8 mx-auto space-y-12 lg:space-y-20 lg:py-24 lg:px-6">
            <!-- Row -->
            <div style="display: flex; justify-content:center;" class="items-center gap-8 lg:grid lg:grid-cols-2 xl:gap-16">
                <div style="text-align: center;" class="btn-contact">
                    <h1 style="color: black;font-weight:bold;font-size:50px;">Cari Mobil Bekas<br>Murah & Terpercaya.</h1>
                    <p style="color:rgb(0, 0, 0);">Sahabat Group Auto menyediakan kemudahan pelanggan dalam mencari mobil bekas murah & terpercaya <a href="https://tailwindcss.com" class="hover:underline"></p>
                    
                        <div style="padding: 10px; display:flex;gap:20px;justify-content:center;" class="btn-grouped">
                        <a style="padding: 10px;color:white;border-radius:6px;border:none;background-color:#212529;" href="https://wa.me/+6289679994949" class="btn btn-dark"><i class="fa fa-whatsapp"></i>&nbsp;Hubungi Kami</a>
                        <a style="border: 2px solid #212529;text-align:center;align-content:center;" href="{{route('vehicle_appointment')}}" class="btn">Jadwalkan Kunjungan Anda</a>    
                    </div>
                    </div>
            </div>
            <!-- Row -->
           
        </div>
    </section>
 
     {{-- section why us --}}
    <section  id="whyUs">
        <div class="max-w-screen-xl px-4 py-8 mx-auto space-y-12 lg:space-y-20 lg:py-24 lg:px-6">
            <!-- Row -->
            <div class="items-center gap-8 lg:grid lg:grid-cols-2 xl:gap-16">
                <div class="text-gray-500 sm:text-lg ">
                    <h2 style="color: black;" class="mb-4 text-3xl font-extrabold tracking-tight dark:text-white">Mengapa harus kami?</h2>
                    <p style="color: rgba(0, 0, 0, 0.874)" class="mb-8 font-light lg:text-xl">Kami selalu mengupayakan yang terbaik bagi para pelanggan kami dan memberikan pelayanan yang berkualitas</p>
                    <!-- List -->
                    <ul style="color: black" role="list" class="pt-8 space-y-5 border-t border-gray-200 my-7 dark:border-gray-700">
                        <li class="flex space-x-3">
                            <!-- Icon -->
                            <svg class="flex-shrink-0 w-5 h-5 text-purple-500 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-base font-medium leading-tight text-gray-900 dark:text-white">Mobil Bekas yang berkualitas dan harga yang terjangkau</span>
                        </li>
                        <li class="flex space-x-3">
                            <!-- Icon -->
                            <svg class="flex-shrink-0 w-5 h-5 text-purple-500 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-base font-medium leading-tight text-gray-900 dark:text-white">Bekerja sama dengan Multifinance terkemuka</span>
                        </li>
                        <li class="flex space-x-3">
                            <!-- Icon -->
                            <svg class="flex-shrink-0 w-5 h-5 text-purple-500 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-base font-medium leading-tight text-gray-900 dark:text-white">Pelayanan yang terbaik</span>
                        </li>
                    </ul>

                </div>
                <img class="hidden w-full mb-4 rounded-lg lg:mb-0 lg:flex" src="{{asset('assets/images/showroom-bg.jpg')}}" alt="dashboard feature image">
            </div>
            <!-- Row -->
           
        </div>
    </section>
    
     {{-- section mobil bekas--}}
    <section id="mobil-bekas" style="padding:20px;">
        <div class="max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 ">
        <h2 style="text-align: center;margin" class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">Pilihan Unit Kami</h2>
        <br>
        <br> 
            <div style="display: flex; gap:10px;flex-wrap:wrap;justify-content:center;margin-bottom:5rem;" class="form-group-content">
        
                @foreach($vehicle_ads as $ads)
                    @if($ads->category_name == 'Unit Booked')
                        <div class="card">
                           
                                <div style="background-image:linear-gradient(to bottom, rgba(27, 64, 134, 0.316), rgba(15, 15, 15, 0.947));color:rgb(0, 0, 0);width:100%; height:100%;padding:5px;border-radius:5px;font-size:12px;position: absolute;" class="info-date">
                                    <p style="background-color: rgba(255, 255, 255, 0.596);color:rgb(0, 0, 0);width:max-content;padding:5px;border-radius:5px;font-size:12px;position: absolute;">
                                        {{\Carbon\Carbon::parse($ads->created_at)->diffForHumans()}}
                                    </p>
                                    
                                </div>
                                <img style="width: 100%;height:150px;"  src="{{ asset('storage/' . $ads->foto) }}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 style="margin-bottom: 0;font-size:16px;" class="card-title">{{$ads->unit}}</h5>
                                    <div style="color:gray;margin-bottom:10px;" class="small-text">
                                        <small>{{$ads->color}}</small> &bullet; <small>{{$ads->manufacture_year}}</small>
                                    </div>
                                    
                                    <p style="font-weight: bold;" class="card-text">{{"Rp." . number_format($ads->price)}}</p>
                                    
                                    <div style="font-size: 12px;display:flex;padding:0;align-items:center;gap:10px;justify-content:center;" class="btn">
                                        <a href="#" class="btn btn-danger">Sudah Booked</a>
                                    
                                    </div>
                                </div>
                            </div>
                        
                    @else

                    <div class="card">
                        <div class="info-date">
                            <p style="background-color: rgba(255, 255, 255, 0.596);color:rgb(0, 0, 0);width:max-content;padding:5px;border-radius:5px;font-size:12px;position: absolute;">
                                {{\Carbon\Carbon::parse($ads->created_at)->diffForHumans()}}
                            </p>
                        </div>
                        <img style="width: 100%;height:150px;"  src="{{ asset('storage/' . $ads->foto) }}" class="card-img-top" alt="...">
                        <div class="card-body">
                        <h5 style="margin-bottom: 0;font-size:16px;" class="card-title">{{$ads->unit}}</h5>
                        <div style="color:gray;margin-bottom:10px;" class="small-text">
                            <small>{{$ads->color}}</small> &bullet; <small>{{$ads->manufacture_year}}</small>
                        </div>
                        
                        <p style="font-weight: bold;" class="card-text">{{"Rp." . number_format($ads->price)}}</p>
                        
                        <div style="font-size: 12px;display:flex;padding:0;align-items:center;gap:10px;justify-content:space-between;border:none;" class="btn">
                            <form action="{{route('ads_clicked', $ads->slug)}}" method="POST">
                                @method('PUT')
                                @csrf
                                <input type="text" name="id" value="{{$ads->ads_id}}" hidden>
                                <input type="text" value="{{$ads->clicked}}" name="clicked" hidden>
                                 <button class="btn btn-dark" type="submit">Detail</button>
                            </form>
                            <a style="color: #212529;text-decoration:underline;font-size:14px;" href="https://wa.me/+6289674050680">Hubungi Kami</a>
                        </div>
                        </div>
                    </div>   
                    @endif
                @endforeach
               
            </div>


        <div style="text-align: center" class="button-more-vehicle">
            <a style="background-color:#212529;" class="btn btn-dark" href="{{route('all_vehicle')}}">Lihat semua <i class="fas fa-arrow-right"></i></a>
        </div>
        </div>
    </section>
    
     {{-- section customer request --}}
    <section id="customerRequest" class="bg-gray-50 dark:bg-gray-800">
        <div class="max-w-screen-xl px-4 py-8 mx-auto text-center lg:py-24 lg:px-6">
           <div style="width:100%;height:max-content; border-radius:10px;border:1.5px solid gray;background:white;padding:15px;" class="card-help-services">
            <div class="max-w-screen-md mx-auto mb-3 text-center lg:mb-12">
                <h2 class="mb-4 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">Bantuan pencarian mobil</h2>
                <p class="font-light text-gray-500 sm:text-xl dark:text-gray-400">Tidak ada unit kendaraan yang dicari? silahkan masukan email dan nomor telepon anda, Kami akan menghubungi anda.</p>
            </div>
            <form action="{{route('request_vehicle')}}" method="POST">
                @csrf
                <div class="input-form">
                    <Label style="color: black; font-size:15px;font-weight:bold;">Merek Mobil</Label>
                    <br>
                    <select style="width:60%;text-align:center;border-radius:6px;" name="brand" id="">
                        <option value="">=== Pilih Brand/Merek ===</option>
                        @foreach($brand as $merk)
                        <option  value="{{$merk->id}}">{{$merk->brand_name}}</option>
                        @endforeach

                    </select>
                    @error('brand')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <br>
                <div class="input-form">
                    <Label style="color: black; font-size:15px;font-weight:bold;" >Tipe Mobil</Label>
                    <br>
                    <input class="input-form-submit" style="width:60%;" type="text" name="vehicle_type" autocomplete="off" placeholder="Masukan tipe mobil : avanza veloz sport">
                    @error('vehicle_type')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <br>
                <div class="input-form">
                    <Label style="color: black; font-size:15px;font-weight:bold;">Tahun Kendaraan</Label>
                    <br>
                    <input class="input-form-submit" style="width:60%;" name="year" type="number" autocomplete="off" placeholder="Masukan tahun kendaraan">
                    @error('year')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <br>
                <br>
                <div class="input-form">
                    <Label style="color: black; font-size:15px;font-weight:bold;">Warna Kendaraan</Label>
                    <br>
                    <input class="input-form-submit" style="width:60%;" name="vehicle_color" type="text" autocomplete="off" placeholder="Masukan warna kendaraan">
                    @error('vehicle_color')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <br>
                <div class="input-form">
                    <Label style="color: black; font-size:15px;font-weight:bold;">Nama Anda</Label>
                    <br>
                    <input class="input-form-submit" style="width:60%;" name="name" type="text" autocomplete="off" placeholder="Masukan nama anda...">
                    @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <br>
                <div class="input-form">
                    <Label style="color: black; font-size:15px;font-weight:bold;">Email</Label>
                    <br>
                    <input class="input-form-submit" style="width:60%;" name="email" type="text" autocomplete="off" placeholder="Masukan Email anda...">
                    @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <br>
                <div class="input-form">
                    <Label  style="color: black; font-size:15px;font-weight:bold;">No.Telp/WA</Label>
                    <br>
                    <input class="input-form-submit" style="width:60%;" name="phone_number" type="text" autocomplete="off" placeholder="Masukan nomor telepon anda...">
                    @error('phone_number')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <br>
                <div style="display: flex;flex-wrap:wrap; gap:20px;justify-content:center;" class="btn-submit">
                    <button style="background-color: #212529;" class="btn btn-dark" type="submit">Kirim Permintaan &nbsp;<i class="fa fa-paper-plane" aria-hidden="true"></i>
                    </button>

                    <button id="btn-submit-check" type="button" class="btn btn-primary">Cek Status</button>
                </div>
            </form>
           </div>
        </div>
    </section>

    <section id="result-check">
        <div class="max-w-screen-xl px-4 py-8 mx-auto text-center lg:py-12 lg:px-6">
            <div style="width:100%;height:max-content; border-radius:10px;border:1.5px solid gray;background:white;padding:15px;" class="card-help-services">
             <div class="max-w-screen-md mx-auto mb-3 text-center lg:mb-12">
                 <h2 class="mb-4 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">Hasil Informasi Status Permintaan Unit Kendaraan</h2>
                 <p class="font-light text-gray-500 sm:text-xl dark:text-gray-400">Silahkan Masukan Token yang sudah kami kirimkan melalui email anda</p>
             </div>

             <form id="resultForm">
                @csrf
                <label for="">Masukan Token Anda</label>
                <br>
                <input style="margin-bottom: 30px;" type="text" class="input-form-submit" name="unique_tokens" placeholder="Masukan token disini..." id="">
                <br>
               
                <div class="btn-submit">
                    <button id="btn-submit-check-result" style="background-color: #212529;" class="btn btn-dark" type="submit">Cek Hasil
                    </button>
                </div>
            </form>

            <br>
            <br>
            {{-- @if($vehicle_request->isNotEmpty()) --}}
            <div id="responseMessage" class="result-check-status">
                <div class="max-w-screen-md mx-auto mb-3 text-center lg:mb-12">
                    <h2 class="mb-4 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">Hasil Informasi Status Anda</h2>
                     </div>
                     @if($vehicle_request->isEmpty())
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

            
            {{-- @else

            @endif --}}
            
            </div>
         </div>
    </section>
    
     {{-- section gallery--}}
    <section id="gallery" class="bg-white dark:bg-gray-900">
        <div class="max-w-screen-xl px-4 py-8 mx-auto lg:py-24 lg:px-6">
            <div class="max-w-screen-md mx-auto mb-8 text-center lg:mb-12">
                <h2 class="mb-4 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">Gallery Kami</h2>
                <p class="mb-5 font-light text-gray-500 sm:text-xl dark:text-gray-400">Tidak ada unit kendaraan yang dicari? silahkan masukan email dan nomor telepon anda.</p>
            </div>
           
        </div>
      </section>

      <section id="contactus" style="background-image: linear-gradient(to right, #fffff7 10%, #e8e8e828 80%);">
        <div class="max-w-screen-xl px-4 py-8 mx-auto space-y-12 lg:space-y-20 lg:py-24 lg:px-6">
            <!-- Row -->
            <div class="items-center gap-8 lg:grid lg:grid-cols-2 xl:gap-16">
                <div class="text-gray-500 sm:text-lg ">
                    <h2 style="color: black;" class="mb-4 text-3xl font-extrabold tracking-tight dark:text-white">Alamat Showroom Kami</h2>
                    <p style="color: rgba(0, 0, 0, 0.874)" class="mb-8 font-light lg:text-xl">Saat ini PT Sahabat Group Auto memiliki beberapa cabang yang dapat anda kunjungi.</p>
                    <!-- List -->
                    <ul style="color: black; padding-left:0;" role="list" class="pt-8 space-y-5 border-t border-gray-200 my-7 dark:border-gray-700">
                        @foreach($branch as $office)
                        @if($office->location_name == 'PLAZA AUTO')
                        <li class="flex space-x-3">
                           
                            <div style="display: block; background:rgba(6, 0, 0, 0.812);padding:12px; border-radius:6px;" class="information">
                                <div style="display: flex; gap:10px;color:white;" class="flex-info">
                                    <i class="fa fa-building" aria-hidden="true"></i>
                                    <span style="color: white;" class="text-base font-bold">{{$office->location_name . " (Kantor Pusat)"}}</span>
                                </div>
                               
                            <div style="display: flex;flex-wrap:wrap; gap:10px;" class="more-info">
                                <small style="font-size: 12px;color:rgb(255, 255, 255);"><i class="fa fa-phone" aria-hidden="true"></i>
                                    {{$office->phone_number}}</small>

                                    <small style="font-size: 12px;color:rgb(255, 255, 255);"><i class="fa fa-map-pin" aria-hidden="true"></i>
                                        {{$office->address}}</small>
                            </div>
                            </div>
                            
                        </li>
                        @else
                        <li class="flex space-x-3">
                            
                            <div style="display: block; background:rgba(6, 0, 0, 0.812);padding:12px; border-radius:6px;" class="information">
                                <div style="display: flex; gap:10px;color:white;" class="flex-info">
                                    <i class="fa fa-building" aria-hidden="true"></i>
                                    <span style="color: white;" class="text-base font-bold">{{$office->location_name}}</span>
                                </div>
                                <div style="display: flex;flex-wrap:wrap; gap:10px;" class="more-info">
                                    <small style="font-size: 12px;color:rgb(255, 255, 255);"><i class="fa fa-phone" aria-hidden="true"></i>
                                        {{$office->phone_number}}</small>

                                        <small style="font-size: 12px;color:rgb(255, 255, 255);"><i class="fa fa-map-pin" aria-hidden="true"></i>
                                            {{$office->address}}</small>
                                </div>
                            </div>
                        </li>
                        @endif
                        @endforeach
                       
                    </ul>

                </div>
                <div id="map"></div>
            </div>
            <!-- Row -->
           
        </div>
      </section>
   
      @include('layouts.landing_page.footer.footer')
    <!-- End block -->
   
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

  #result-check {
    display: none;
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

    var btnSubmit = document.getElementById('btn-submit-check');
    var showDialog = document.getElementById('result-check');
    var btnCheckResult = document.getElementById('btn-submit-check-result');

    var showResult = document.getElementById('info-status');


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
    $('#resultForm').submit(function (e) {
        e.preventDefault(); // Mencegah halaman reload

        // Mengambil data form
        var formData = $(this).serialize();

        // Mengirim data menggunakan AJAX
        $.ajax({
            url: '/get_status_request', // URL untuk mengirim data
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
                                '<p><strong>Unit :</strong><br>' + item.brand_name + ' ' + item.vehicle_type + ' ' + item.vehicle_color + ' ' + item.year + '</p>' +
                                '<p><strong>Pemilik/Pemohon:</strong><br>' + item.name + '</p>' +
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


</html>
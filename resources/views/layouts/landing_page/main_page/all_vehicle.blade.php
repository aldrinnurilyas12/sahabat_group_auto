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
    <link href="{{ asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link href="{{asset('bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{url('bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    
</head>
<body>
    <div id="wrapper">

        @include('layouts.landing_page.sidebar.sidebar_landingpage')
    
        <!-- Content Wrapper -->
        <div id="content-wrapper">
            
            <!-- Main Content -->
            {{-- @include('layouts.landing_page.navbar.header_new') --}}

            <div id="content">
                @include('layouts.landing_page.navbar.header_new')
                <div id="content"> 
                    <br>
                    <div id="resultContent" style="display: flex; gap:10px;flex-wrap:wrap;justify-content:center;" class="form-group-content">
                        @if ($vehicle_ads->isEmpty())
                        
                        <h3>Data tidak ditemukan</h3>
                        @else
                        @foreach($vehicle_ads as $ads)
                        
                        @if($ads->category_name == 'Unit Booked')
                        <div class="card" style="width: 14rem; height:max-content;">
                            <div style="background-image:linear-gradient(to bottom, rgba(27, 64, 134, 0.316), rgba(15, 15, 15, 0.947));color:rgb(0, 0, 0);width:100%; height:100%;padding:5px;border-radius:5px;font-size:12px;position: absolute;" class="info-date">
                                <p style="background-color: rgba(255, 255, 255, 0.596);color:rgb(0, 0, 0);width:max-content;padding:5px;border-radius:5px;font-size:12px;position: absolute;">
                                    {{\Carbon\Carbon::parse($ads->created_at)->diffForHumans()}}
                                </p>
                                
                            </div>
                            <img style="width: 100%;height:150px;"  src="{{ asset('storage/' . $ads->foto) }}" class="card-img-top" alt="...">
                            <div class="card-body">
                              <h5 style="margin-bottom: 0;font-size:16px;" class="card-title">{{$ads->unit . ' ' . $ads->manufacture_year}}</h5>
                              <div style="color:gray;margin-bottom:10px;" class="small-text">
                                <small>{{$ads->color}}</small> &bullet; <small>{{$ads->manufacture_year}}</small>
                              </div>
                             
                              <p style="font-weight: bold;" class="card-text">{{"Rp." . number_format($ads->price)}}</p>
                              
                              <div style="font-size: 14px;display:flex;padding:0;align-items:center;gap:10px;justify-content:center;" class="btn">
                                <a href="{{route('vehicle_detail', $ads->ads_id)}}" class="btn btn-danger">Sudah Booked</a>
                                
                              </div>
                            </div>
                          </div> 
                        
                        @else
                        <div class="card" style="width: 14rem; height:max-content;">
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
                              
                              <div style="font-size: 14px;display:flex;padding:0;align-items:center;gap:10px;justify-content:space-between;border:none;" class="btn">
                                <form action="{{route('ads_clicked', $ads->slug)}}" method="POST">
                                  @method('PUT')
                                  @csrf
                                  <input type="text" name="id" value="{{$ads->ads_id}}" hidden>
                                  <input type="text" value="{{$ads->clicked}}" name="clicked" hidden>
                                   <button class="btn btn-dark" type="submit">Detail</button>
                              </form>
                                <a style="color: #212529;text-decoration:underline;" href="https://wa.me/+6289674050680">Hubungi Kami</a>
                              </div>
                            </div>
                          </div> 
                          @endif  
                          @endforeach
                          @endif

                     </div>    
                     <div style="display: flex; justify-content:center;" class="btn">
                        @if ($lowerprice && $highprice)
                        <form action="{{route('all_vehicle')}}" action="GET">
                        <button  class="btn btn-secondary" style="">
                          Reset Filter
                        </button>
                        </form>
                        @else
                            
                        @endif
                    </div>    
                            
                </div> 
            </div>
            <div style="display: flex; justify-content:center;" class="pagination">
              {{$vehicle_ads->links()}}
            </div>
           
            <br>
            
        @include('layouts.landing_page.footer.footer')
        </div>
    </div>

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


<style>
  @import url('https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap');
  
body {
  font-family: "Noto Serif", serif;
},  


</style>

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
  // Mendapatkan semua checkbox filter
  const checkboxes = document.querySelectorAll('[id^="filterBrand"]');

  checkboxes.forEach(checkbox => {
      checkbox.addEventListener('change', function() {
          const selectedBrands = [];
          // Menyusun array brand yang dipilih
          checkboxes.forEach(cb => {
              if (cb.checked) {
                  selectedBrands.push(cb.value);
              }
          });

          // Kirim request AJAX ke server
          fetch('/filter_brand/', {
              method: 'GET',
              headers: {
                  'Content-Type': 'application/json'
              },
              body: JSON.stringify({ brand_name: selectedBrands })
          })
          .then(response => response.json())
          .then(data => {
              // Lakukan update pada konten yang sesuai dengan hasil dari server
              document.getElementById('resultContent').innerHTML = data;
          })
          .catch(error => {
              console.error('Error:', error);
          });
      });
  });
</script>


 </html>
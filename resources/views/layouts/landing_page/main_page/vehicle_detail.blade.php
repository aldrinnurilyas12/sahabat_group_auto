<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$vehicle_data->first()->unit}}</title>
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link href="{{asset('assets/css/output.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset('bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="{{url('bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
  </head>
<body>

@include('layouts.landing_page.navbar.header_new')

<section style="padding:0 30px 0 30px;"  class="bg-white dark:bg-gray-900">
    <div class="container">
      <div class="card">
          <div class="container-fliud">
              @foreach ($vehicle_data as $vehicle)
              <div class="wrapper row">
                  <div style="height: max-content;" class="preview col-md-6">
                      
                      <div class="preview-pic tab-content">
                        
                      <img style="height: 300px;"  src="{{ asset('storage/' . $vehicle_fotos->first()->images) }}" class="card-img-top" alt="...">
                      
                      @foreach($vehicle_fotos as $vehicles)
                        <div class="tab-pane" id="pic">
                        
                          <img src="{{ asset('storage/' . $vehicles->images) }}" />
                        
                      </div>
                      @endforeach
                      </div>    
                      <ul style="margin-bottom: 30px;" class="preview-thumbnail nav nav-tabs">
                          @foreach($vehicle_fotos as $vehicles)
                        <li class="active"><a data-target="#pic-1" data-toggle="tab"><img src="{{ asset('storage/' . $vehicles->images) }}" /></a></li>
                      
                          @endforeach
                      </ul>

                      <div style="display: flex; gap:10px;" class="media-player">
                        <div class="video-player">
                          <a href="#" data-toggle="modal" data-target="#videoPlayer{{$vehicle->ads_id}}"
                          style="background:whitesmoke;color:black;border:none;" class="btn btn-dark"><i class="fa fa-play-circle" aria-hidden="true"></i> Putar Video
                          </a>
                        </div>

                        <div class="engine-sound">
                          <a href="#" data-toggle="modal" data-target="#soundPlayer{{$vehicle->ads_id}}" style="background:whitesmoke;color:black;border:none;" class="btn btn-dark"><i class="fa fa-car" aria-hidden="true"></i>
                            Suara Mesin
                          </a>
                        </div>
                      </div>
                    
                      
                  </div>

                  
                  <div style="padding-top:10px; margin-bottom:10px;" class="details col-md-6">
                      
                    <h5>{{$vehicle->unit}}</h5>
                    <p style="background:#fffff4; padding:4px; border-radius:4px;width:max-content;height:max-content;font-size:12px;" class="location-unit">
                      <i class="fa fa-map-pin" aria-hidden="true"></i>  {{$vehicle->location_unit}}
                    </p>

                    <div style="display: flex; gap:20px; flex-wrap:wrap;margin-bottom:0;" class="price-info">
                      <div style="margin: 0;" class="price">
                        <label style="font-weight: normal;font-size: 12px; color:gray;" for="">Harga Cash</label>
                        <h4 style="font-weight: bold;">{{"Rp " .number_format($vehicle->price)}}</h4>
                      </div>

                      <div class="credit-price">
                        <label style="font-weight: normal;font-size: 12px; color:gray;" for="">Harga Kredit</label>
                      <h4 style="font-weight: bold;">{{"Rp " .number_format($vehicle->credit_price)}}</h4>
                      </div>
                    </div>

                    <div class="views">
                      @if($vehicle->clicked)
                      <i style="color: gray;" class="fa fa-eye" aria-hidden="true"> <span style="color: black;">{{$vehicle->clicked}}x dilihat</span></i>
                      @else
                      <i style="color: gray;" class="fa fa-eye" aria-hidden="true"> <span style="color: black;">belum dilihat</span></i>
                      @endif
                    </div>

                    <br>
                    <div style="width: 100%; height:max-content:20px;border-radius:10px;padding-left:0;" class="container">
                      <div class="title">
                        <h6>Informasi Detail</h6>
                      </div>
                    <div style="width: 100%; height:max-content;background:#ffffff;padding:20px;border:1.5px solid rgb(241, 241, 241);border-radius:10px;display:flex;flex-wrap:wrap;gap:40px;" class="detail-information">

                      <div style="display: block; gap:5px;align-items:center;" class="detail-sub-info">
                        <p style="font-size: 12px; color:gray;margin-bottom:0;">Warna</p>
                        <p style="margin-bottom: 0;font-weight:bold;">{{$vehicle->color}}</p>
                      </div>

                      <div style="display: block; gap:5px;align-items:center;" class="detail-sub-info">
                        <p style="font-size: 12px; color:gray;margin-bottom:0;">Kategori</p>
                        <p style="margin-bottom: 0;font-weight:bold;">{{$vehicle->vehicle_category}}</p>
                      </div>

                      <div style="display: block; gap:5px;align-items:center;" class="detail-sub-info">
                        <p style="font-size: 12px; color:gray;margin-bottom:0;">Tahun</p>
                        <p style="margin-bottom: 0;font-weight:bold;">{{$vehicle->manufacture_year}}</p>
                      </div>

                      <div style="display: block; gap:5px;align-items:center;" class="detail-sub-info">
                        <p style="font-size: 12px; color:gray;margin-bottom:0;">Bahan Bakar</p>
                        <p style="margin-bottom: 0;font-weight:bold;">{{$vehicle->fuel_type}}</p>
                      </div>

                      <div style="display: block; gap:5px;align-items:center;" class="detail-sub-info">
                        <p style="font-size: 12px; color:gray;margin-bottom:0;">CC Mesin</p>
                        <p style="margin-bottom: 0;font-weight:bold;">{{number_format($vehicle->cylinder_capacity) . " cc"}}</p>
                      </div>

                      <div style="display: block; gap:5px;align-items:center;" class="detail-sub-info">
                        <p style="font-size: 12px; color:gray;margin-bottom:0;">Kilometer</p>
                        <p style="margin-bottom: 0;font-weight:bold;">{{number_format($vehicle->current_km) . " km"}}</p>
                      </div>

                      <div style="display: block; gap:5px;align-items:center;" class="detail-sub-info">
                        <p style="font-size: 12px; color:gray;margin-bottom:0;">Transmisi</p>
                        <p style="margin-bottom: 0;font-weight:bold;">
                            @if($vehicle->transmission == 'AT - Automatic Transmission')
                            Otomatis
                            @else
                            Manual
                            @endif
                        </p>
                      </div>

                      <div style="display: block; gap:5px;align-items:center;" class="detail-sub-info">
                        <p style="font-size: 12px; color:gray;margin-bottom:0;">Pajak</p>
                        <p style="margin-bottom: 0;font-weight:bold;">
                          @if($vehicle->tax_date)
                          {{date("M-Y",strtotime($vehicle->tax_date))}}
                          @elseif($vehicle->tax_date == null)
                          {{"Belum"}}
                          @else
                          @endif
                        </p>
                      </div>

                      <div style="display: block; gap:5px;align-items:center;" class="detail-sub-info">
                        <p style="font-size: 12px; color:gray;margin-bottom:0;">BPKB</p>
                        <p style="margin-bottom: 0;font-weight:bold;">
                          @if($vehicle->bpkb_number)
                          Ada
                          @elseif($vehicle->bpkb_number == null)
                          Tidak
                          @else
                          @endif
                        </p>
                      </div>

                      
                      

                    </div>
                    </div>
                    <div style="display: flex; flex-wrap:wrap; gap:10px;align-items:center;" class="contact-info">
                      <a href="/vehicle_appointment/#appointment-create" style="width:max-content;margin-top:20px;background-color: #212529;" class="btn btn-dark">
                        Jadwalkan Test Drive
                       </a>

                       <a href="https://wa.me/{{$contact->first()->phone_number}}" style="width:max-content;margin-top:20px;color:black;">
                        Hubungi Sales
                       </a>
                    </div>
                    
                      
                  </div>
              </div>
              @endforeach
              
          </div>

      </div>
  </div>
</section>
<br>
<br>
<section style="padding: 10px;" class="more-information">
  <div  class="card-body">

    {{-- tab --}}
    <!-- Tabs navs -->
    <ul style="display: flex;justify-content:center;gap:20px;" class="nav nav-tabs mb-3" id="ex1" role="tablist">
        <li class="nav-item" role="presentation">
            <a
                data-mdb-tab-init
                class="nav-link active"
                id="ex1-tab-1"
                href="#ex1-tabs-1"
                role="tab"
                aria-controls="ex1-tabs-1"
                aria-selected="true"
            >Deskripsi Kendaraan</a>
        </li>
        <li class="nav-item" role="presentation">
            <a
                data-mdb-tab-init
                class="nav-link"
                id="ex1-tab-2"
                href="#ex1-tabs-2"
                role="tab"
                aria-controls="ex1-tabs-2"
                aria-selected="false"
            >Rincian Kredit</a>
        </li>
      </ul>
     

      <div class="tab-content" id="ex1-content">
       
        <div style="padding: 40px;"
        class="tab-pane fade show active"
        id="ex1-tabs-1"
        role="tabpanel"
        aria-labelledby="ex1-tab-1">

        <div style="display: block;margin-bottom:50px;" class="description-vehicle">
          <h4>Deskripsi</h4>
          <hr>
          <p style="font-size: 14px; color:gray;">
            @if($vehicle_data->first()->description == null)
              <p>Maaf tidak ada deskripsi untuk unit {{$vehicle_data->first()->unit}} </p>
            @else
            {{$vehicle_data->first()->description}}
            @endif
            </p>


        </div>


        <div style="display: block;" class="description-vehicle">
          <h4>Kontak Kami</h4>
          <hr>

          <div style="display: block;" class="contact-person">
            @foreach($contact as $cp)
            <div style="display: flex; gap:12px;" class="dflex-contact">
              <p>{{$cp->name }}</p>
              <a href="https://wa.me/{{$cp->phone_number}}">{{$cp->phone_number}}</a>
            </div>
            @endforeach
            
          </div>
         

          
        </div>
        
        </div>
       
       
       
        <div class="tab-pane fade" id="ex1-tabs-2" role="tabpanel" aria-labelledby="ex1-tab-2">
         
          <div class="card-body">
          <div id="table-detail" class="table-responsive">
              
              <table style="font-size: 14px; color:black;" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>Unit</th>
                          <th>Harga Unit</th>
                          <th>Biaya DP Unit</th>
                          <th>Asuransi</th>
                          <th>Tenor 12 Bulan</th>
                          <th>Tenor 24 Bulan</th>
                          <th>Tenor 36 Bulan</th>
                          <th>Tenor 48 Bulan</th>
                          <th>Tenor 60 Bulan</th>
                          <th>Tenor 72 Bulan</th>
                      </tr>
                  </thead>
              
                  <tbody>
                      <?php $no = 1;  ?>
                      @foreach($credit_simulation as $credit)
                      <tr>
                          <td><?php echo $no++ ?></td>
                          <td>{{$credit->unit}}</td>
                          <td>{{"IDR " . number_format($credit->price)}}</td>
                          <td>{{"IDR " . number_format($credit->down_payment)}}</td>
                          <td>{{$credit->insurance_name}}</td>
                          <td>{{"IDR " . number_format($credit->tenor_12_month)}}</td>
                          <td>{{"IDR " . number_format($credit->tenor_24_month)}}</td>
                          <td>{{"IDR " . number_format($credit->tenor_36_month)}}</td>
                          <td>{{"IDR " . number_format($credit->tenor_48_month)}}</td>
                          <td>{{"IDR " . number_format($credit->tenor_60_month)}}</td>
                          <td>{{"IDR " . number_format($credit->tenor_72_month)}}</td>

                      </tr>

                      @endforeach
                  
                  </tbody>
              </table>
          </div>
          </div>
      </div>
      </div>
  </div>


</section>

{{-- modal video player --}}
@foreach($vehicle_data as $vehicle) 
<div class="modal fade" id="videoPlayer{{$vehicle->ads_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$vehicle->ads_id}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div style="display: flex; justify-content:space-between;" class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel{{$vehicle->ads_id}}">Video : {{$vehicle->unit}}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            @if($media_video->isNotEmpty())
            <video controls>
              <source src="{{ asset('storage/' . $media_video->first()->media_files) }}"> 
            </video>
            @else
            <div class="alert alert-warning">
            <p>Tidak ada video untuk unit ini</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endforeach
{{-- end modal --}}


{{-- modal sound player --}}
@foreach($vehicle_data as $vehicle) 
<div class="modal fade" id="soundPlayer{{$vehicle->ads_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$vehicle->ads_id}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div style="display: flex; justify-content:space-between;" class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel{{$vehicle->ads_id}}">Suara Mesin : {{$vehicle->unit}}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            @if($engine_sound->isNotEmpty())
            <audio controls>
              <source src="{{ asset('storage/' . $engine_sound->first()->media_files) }}"> 
              </audio>
            @else
            <div class="alert alert-warning">
              <p>Tidak ada suara mesin untuk unit ini</p>
              </div>
            @endif
        </div>
    </div>
</div>
@endforeach
{{-- end modal --}}


<br>
<br>

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

</style>

 <script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
 <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
 <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.js')}}"></script>
 <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
</body>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap');
  
body {
  font-family: "Noto Serif", serif;

}

h4 {
  color: black;
  font-size: 16px;
  font-weight: bold;
}


  
img {
  max-width: 100%; }

.preview {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -webkit-flex-direction: column;
      -ms-flex-direction: column;
          flex-direction: column; }
  @media screen and (max-width: 996px) {
    .preview {
      margin-bottom: 20px; } }

.preview-pic {
  -webkit-box-flex: 1;
  -webkit-flex-grow: 1;
      -ms-flex-positive: 1;
          flex-grow: 1; }

.preview-thumbnail.nav-tabs {
  border: none;
  margin-top: 15px; }
  .preview-thumbnail.nav-tabs li {
    width: 18%;
    margin-right: 2.5%; }
    .preview-thumbnail.nav-tabs li img {
      max-width: 100%;
      display: block; }
    .preview-thumbnail.nav-tabs li a {
      padding: 0;
      margin: 0; }
    .preview-thumbnail.nav-tabs li:last-of-type {
      margin-right: 0; }

.tab-content {
  overflow: hidden; }
  .tab-content img {
    width: 100%;
    -webkit-animation-name: opacity;
            animation-name: opacity;
    -webkit-animation-duration: .3s;
            animation-duration: .3s; }

.card {
  margin-top: 50px;
  background: #ffffff;
  padding: 3em;
  line-height: 1.5em; }

@media screen and (min-width: 997px) {
  .wrapper {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex; } }

.details {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -webkit-flex-direction: column;
      -ms-flex-direction: column;
          flex-direction: column; }

.colors {
  -webkit-box-flex: 1;
  -webkit-flex-grow: 1;
      -ms-flex-positive: 1;
          flex-grow: 1; }

.product-title, .price, .sizes, .colors {
  text-transform: UPPERCASE;
  font-weight: bold; }

.checked, .price span {
  color: #ff9f1a; }

.product-title, .rating, .product-description, .price, .vote, .sizes {
  margin-bottom: 15px; }

.product-title {
  margin-top: 0; }

.size {
  margin-right: 10px; }
  .size:first-of-type {
    margin-left: 40px; }

.color {
  display: inline-block;
  vertical-align: middle;
  margin-right: 10px;
  height: 2em;
  width: 2em;
  border-radius: 2px; }
  .color:first-of-type {
    margin-left: 20px; }

.add-to-cart, .like {
  background: #ff9f1a;
  padding: 1.2em 1.5em;
  border: none;
  text-transform: UPPERCASE;
  font-weight: bold;
  color: #fff;
  -webkit-transition: background .3s ease;
          transition: background .3s ease; }
  .add-to-cart:hover, .like:hover {
    background: #b36800;
    color: #fff; }

.not-available {
  text-align: center;
  line-height: 2em; }
  .not-available:before {
    font-family: fontawesome;
    content: "\f00d";
    color: #fff; }

.orange {
  background: #ff9f1a; }

.green {
  background: #85ad00; }

.blue {
  background: #0076ad; }

.tooltip-inner {
  padding: 1.3em; }

@-webkit-keyframes opacity {
  0% {
    opacity: 0;
    -webkit-transform: scale(3);
            transform: scale(3); }
  100% {
    opacity: 1;
    -webkit-transform: scale(1);
            transform: scale(1); } }

@keyframes opacity {
  0% {
    opacity: 0;
    -webkit-transform: scale(3);
            transform: scale(3); }
  100% {
    opacity: 1;
    -webkit-transform: scale(1);
            transform: scale(1); } }

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
         }, 2000);  // 2000ms = 2 detik
     } else {
         console.log("Elemen spinner tidak ditemukan!");
     }
 });

  document.addEventListener('DOMContentLoaded', function () {
      // Select all tab links
      const tabLinks = document.querySelectorAll('.nav-link');

      // Add click event to each tab link
      tabLinks.forEach(link => {
          link.addEventListener('click', function (e) {
              e.preventDefault(); // Prevent default anchor behavior

              // Remove active class from all links and hide all tab content
              tabLinks.forEach(item => {
                  item.classList.remove('active');
                  item.setAttribute('aria-selected', 'false');
              });
              document.querySelectorAll('.tab-pane').forEach(content => {
                  content.classList.remove('show', 'active');
              });

              // Add active class to the clicked link and show corresponding tab content
              this.classList.add('active');
              this.setAttribute('aria-selected', 'true');
              const target = this.getAttribute('href');
              document.querySelector(target).classList.add('show', 'active');
          });
      });
  });


</script>






</html>
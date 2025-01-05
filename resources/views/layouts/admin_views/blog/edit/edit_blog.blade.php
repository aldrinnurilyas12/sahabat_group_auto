<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Edit data Blog - SAHABAT GROUP AUTO ADMINISTRATOR</title>

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
                
                {{-- content --}}


                <div id="content">
                    
                    <h4 style="text-align:center;color:black;font-weight:bold;">Edit Blog</h4>
                    @foreach($blog_data as $blog)
                    <div class="form-group-content">
                  
                        <form class="form_input" method="POST" action="{{ route('blog_edit',$blog->id)}}" enctype="multipart/form-data">
                            @csrf   
                            @method('PUT')
                            
                            <div class="form-group">
                                <label>Judul Blog</label>
                                <input type="text" class="form-control" value="{{$blog->title}}" name="title" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label>Subtitle Blog</label>
                                <textarea class="form-control" name="subtitle"  id="" cols="40" rows="10">{{$blog->subtitle}}</textarea>
                            </div>
                            <hr>

                            <div class="form-group">
                                <label for="">Foto</label>
                                <div style="display: flex; flex-wrap:wrap; gap:10px;" class="img-content">
                                    <img width="180" height="180" src="{{asset('storage/' . $blog->blog_foto)}}" alt="">
                                </div>
                            </div>
                            <input type="file" name="blog_foto[]" multiple>
                            <br>
                            <small style="color: red;">*hanya 1 foto saja</small>
                            <hr>
                            <div class="form-group">
                                <label>Author</label>
                                <input type="text" class="form-control" value="{{$blog->created_by}}" autocomplete="off" readonly>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Posting</label>
                                <input type="text" class="form-control" value="{{$blog->post_date}}" autocomplete="off" readonly>
                            </div>

                            <div class="form-group">
                                <label>Terakhir diperbarui</label>
                                <input type="text" class="form-control" value="{{$blog->updated_at}}" autocomplete="off" readonly>
                            </div>

                            <br>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>  
                        @endforeach
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
</html>
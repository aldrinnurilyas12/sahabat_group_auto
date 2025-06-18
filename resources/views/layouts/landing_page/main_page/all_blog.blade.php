<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sahabat Group Auto - Jual Beli Mobil Bekas Murah & Terpecaya</title>

    <!-- Meta SEO -->
    <meta name="title" content="Landwind - Tailwind CSS Landing Page">
    <meta name="description"
        content="Get started with a free and open-source landing page built with Tailwind CSS and the Flowbite component library.">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    <meta name="author" content="Themesberg">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link href="{{ asset('assets/css/output.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ url('bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

</head>

<body>
    <div id="wrapper">
        {{-- 
        @include('layouts.landing_page.sidebar.sidebar_landingpage') --}}

        <!-- Content Wrapper -->
        <div id="content-wrapper">

            <!-- Main Content -->
            {{-- @include('layouts.landing_page.navbar.header_new') --}}

            <div id="content">

                @include('layouts.landing_page.navbar.header_new')
                <div id="content">
                    <br>
                    <h3 style="text-align: center;">Blog dan Gallery Kami</h3>
                    <br>
                    <div id="resultContent" style="display: flex; gap:10px;flex-wrap:wrap;justify-content:center;"
                        class="form-group-content">
                        @if ($all_blog->isEmpty())
                            <h3>Data tidak ditemukan</h3>
                        @else
                            @foreach ($all_blog as $blog)
                                <div class="card">
                                    <div class="info-date">
                                        <p
                                            style="background-color: rgba(255, 255, 255, 0.596);color:rgb(0, 0, 0);width:max-content;padding:5px;border-radius:5px;font-size:12px;position: absolute;">
                                            {{ \Carbon\Carbon::parse($blog->created_at)->diffForHumans() }}
                                        </p>
                                    </div>
                                    <img style="width: 100%;height:150px;"
                                        src="{{ asset('storage/' . $blog->blog_foto) }}" class="card-img-top"
                                        alt="...">
                                    <div class="card-body">
                                        <h5 style="margin-bottom: 0;font-size:16px;" class="card-title">
                                            <a style="color:black;font-weight:bold;"
                                                href="{{ route('show_blog', $blog->id) }}">{{ $blog->title }}</a>
                                        </h5>
                                        <div style="color:gray;margin-bottom:10px;" class="small-text">
                                            <small>{{ $blog->post_date }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        @endif


                    </div>


                </div>
            </div>
            <div style="display: flex; justify-content:center;" class="pagination">

                {{ $all_blog->links() }}

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

        .card {
            width: 16rem;
            height: max-content
        }

        @media only screen and (max-width: 390px) {
            .card {
                width: 85%;
                color: rgb(0, 0, 0);
            }
        }
    </style>

    @if (Session::has('failed_insert'))
        <script>
            Swal.fire({
                title: 'Data tidak ada',
                text: "{{ Session::get('failed_insert') }}",
                icon: "error",
                timer: 3000
            });
        </script>
    @endif
</body>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap');

    body {
        font-family: "Noto Serif", serif;
    }

    ,
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

                loadingSpinnerWrapper.style.display = 'none'; // Sembunyikan spinner setelah 2 detik
            }, 1000); // 2000ms = 2 detik
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
                    body: JSON.stringify({
                        brand_name: selectedBrands
                    })
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Testimonial Customer</title>
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link href="{{ asset('assets/css/output.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="{{ url('bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</head>

<body>

    @include('layouts.landing_page.navbar.header_new')
    <section class="bg-white dark:bg-gray-900">
        <div class="container">


            <div id="content">
                <br>
                <h3 style="text-align: center;">Testimonial Customer</h3>
                <div id="resultContent" style="display: flex; gap:10px;flex-wrap:wrap;justify-content:center;"
                    class="form-group-content">
                    @if ($all_testimonial->isEmpty())
                        <h3>Data tidak ditemukan</h3>
                    @else
                        <span style="display:flex; justify-content:center;" class="total-rating">An
                            average rating of {{ (float) $avg_rating }} from {{ $rating_total }} reviews</span>
                        <div style="display: flex; gap:10px;flex-wrap:wrap;justify-content:center;margin-bottom:2rem;"
                            class="form-group-content">
                            @foreach ($all_testimonial as $testi)
                                <div style="width:300px; height:max-content;background:#fff; border:1px solid rgb(235, 235, 235);padding:1em;border-radius:10px;"
                                    class="card-testimonial">
                                    <div class="card-body">

                                        @if ($testi->hidden_name == 'y')
                                            <h5 class="card-title">{{ $testi->customer_name }}</h5>
                                        @else
                                            <h5 style="color: gray;" class="card-title">anonymous</h5>
                                        @endif
                                        <p style="font-style: italic; color:black; font-weight:400;" class="card-text">
                                            <span style="font-size: 15px; font-family:cambria;">"</span>
                                            {{ $testi->testimonial }}.<span
                                                style="font-size: 15px; font-family:cambria;">"</span>
                                        </p>

                                        <div style="display: flex; flex-wrap:wrap; gap:4px; font-size:14px;"
                                            class="rating-date">

                                            <span style="display:flex; gap:3px;align-items:center;color:black;"><img
                                                    style="width:16px; height:16px;"
                                                    src="{{ asset('assets/img/star-icon.svg') }}" alt="">
                                                {{ $testi->rating }}</span>
                                            <span style="color: black;"> | </span>
                                            <span>{{ date('d F Y'), strtotime($testi->created_at) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

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
        .scroll-images ul {
            display: flex;
            flex-wrap: nowrap;
            margin-bottom: 18px;
            padding-left: 0;
            list-style: none;
            min-width: 100%;
        }

        .scroll-images li {
            margin-right: 10px;
        }

        .scroll-images img {
            width: 150px;
            height: 80px;
        }


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
    </style>

    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
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
        max-width: 100%;
    }

    .preview {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -webkit-flex-direction: column;
        -ms-flex-direction: column;
        flex-direction: column;
    }

    @media screen and (max-width: 996px) {
        .preview {
            margin-bottom: 20px;
        }
    }

    .preview-pic {
        -webkit-box-flex: 1;
        -webkit-flex-grow: 1;
        -ms-flex-positive: 1;
        flex-grow: 1;
    }

    .preview-thumbnail.nav-tabs {
        border: none;
        margin-top: 15px;
    }

    .preview-thumbnail.nav-tabs li {
        width: 18%;
        margin-right: 2.5%;
    }

    .preview-thumbnail.nav-tabs li img {
        max-width: 100%;
        display: block;
    }

    .preview-thumbnail.nav-tabs li a {
        padding: 0;
        margin: 0;
    }

    .preview-thumbnail.nav-tabs li:last-of-type {
        margin-right: 0;
    }

    .tab-content {
        overflow: hidden;
    }

    .tab-content img {
        width: 100%;
        -webkit-animation-name: opacity;
        animation-name: opacity;
        -webkit-animation-duration: .3s;
        animation-duration: .3s;
    }

    .card {
        margin-top: 50px;
        background: #ffffff;
        padding: 1em;
        line-height: 1.5em;
    }

    @media only screen and (max-width: 390px) {
        .card {
            padding: 10px;
            color: rgb(0, 0, 0);
        }
    }


    @media screen and (min-width: 997px) {
        .wrapper {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
        }
    }

    .details {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -webkit-flex-direction: column;
        -ms-flex-direction: column;
        flex-direction: column;
    }

    .colors {
        -webkit-box-flex: 1;
        -webkit-flex-grow: 1;
        -ms-flex-positive: 1;
        flex-grow: 1;
    }

    .product-title,
    .price,
    .sizes,
    .colors {
        text-transform: UPPERCASE;
        font-weight: bold;
    }

    .checked,
    .price span {
        color: #ff9f1a;
    }

    .product-title,
    .rating,
    .product-description,
    .price,
    .vote,
    .sizes {
        margin-bottom: 15px;
    }

    .product-title {
        margin-top: 0;
    }

    .size {
        margin-right: 10px;
    }

    .size:first-of-type {
        margin-left: 40px;
    }

    .color {
        display: inline-block;
        vertical-align: middle;
        margin-right: 10px;
        height: 2em;
        width: 2em;
        border-radius: 2px;
    }

    .color:first-of-type {
        margin-left: 20px;
    }

    .add-to-cart,
    .like {
        background: #ff9f1a;
        padding: 1.2em 1.5em;
        border: none;
        text-transform: UPPERCASE;
        font-weight: bold;
        color: #fff;
        -webkit-transition: background .3s ease;
        transition: background .3s ease;
    }

    .add-to-cart:hover,
    .like:hover {
        background: #b36800;
        color: #fff;
    }

    .not-available {
        text-align: center;
        line-height: 2em;
    }

    .not-available:before {
        font-family: fontawesome;
        content: "\f00d";
        color: #fff;
    }

    .orange {
        background: #ff9f1a;
    }

    .green {
        background: #85ad00;
    }

    .blue {
        background: #0076ad;
    }

    .tooltip-inner {
        padding: 1.3em;
    }

    @-webkit-keyframes opacity {
        0% {
            opacity: 0;
            -webkit-transform: scale(3);
            transform: scale(3);
        }

        100% {
            opacity: 1;
            -webkit-transform: scale(1);
            transform: scale(1);
        }
    }

    @keyframes opacity {
        0% {
            opacity: 0;
            -webkit-transform: scale(3);
            transform: scale(3);
        }

        100% {
            opacity: 1;
            -webkit-transform: scale(1);
            transform: scale(1);
        }
    }
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
            }, 2000); // 2000ms = 2 detik
        } else {
            console.log("Elemen spinner tidak ditemukan!");
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Select all tab links
        const tabLinks = document.querySelectorAll('.nav-link');

        // Add click event to each tab link
        tabLinks.forEach(link => {
            link.addEventListener('click', function(e) {
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

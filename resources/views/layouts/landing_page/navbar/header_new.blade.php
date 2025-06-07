<nav style="padding: 30px;background-color:white;box-shadow: rgba(95, 95, 95, 0.3) 0px 1px 2px 0px, rgba(64, 64, 65, 0.15) 0px 2px 6px 2px; "
    class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a style="font-weight: bold;" class="navbar-brand" href="#">PT Sahabat Group Auto</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div style="justify-content: center" class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul style="padding-left:20px;" class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a style="padding: 10px; color:black;text-decoration:none;" class="nav-link-header active"
                        aria-current="page" href="{{ route('sahabatmotor') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a style="padding: 10px; color:black;text-decoration:none;" class="nav-link-header"
                        href="{{ route('sahabatmotor') }}#gallery">Galeri</a>
                </li>
                <li class="nav-item">
                    <a style="padding: 10px; color:black;text-decoration:none;" class="nav-link-header"
                        href="{{ route('vehicle_appointment') }}">Appointment</a>
                </li>
                <li class="nav-item">
                    <a style="padding: 10px; color:black;text-decoration:none;" class="nav-link-header" id="contact-us"
                        href="{{ route('vehicle_sale_request') }}">Jual Mobil</a>
                </li>
                <li class="nav-item">
                    <a style="padding: 10px; color:black;text-decoration:none;" class="nav-link-header" id="contact-us"
                        href="{{ route('sahabatmotor') }}#contactus">Contact Us</a>
                </li>

                <li class="nav-item">
                    <a style="padding: 10px; color:black;text-decoration:none;" class="nav-link-header" id="contact-us"
                        href="{{ route('sahabatmotor') }}#testimonial-customers">Testimonial</a>
                </li>
                {{-- <li class="nav-item dropdown">
            <a style="padding: 10px; color:black;text-decoration:none;" class="nav-link-header dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Lainnya
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="#">Jual & Beli Mobil</a></li>
              <li><a class="dropdown-item" href="#">Tukar Tambah Mobil</a></li>
              
            </ul>
          </li> --}}

            </ul>
            <div class="search-bar">
                <div class="form-search">
                    <form style="display: flex;gap:6px;" action="{{ route('search/') }}" method="GET"
                        class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" name="search" type="search"
                            placeholder="Cari mobil disini...." value="{{ old('search') }}" aria-label="Search">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </form>
                </div>

                {{-- <div style="display: block;" class="btn-appointment">
            <p style="color:gray;margin-bottom:4px;font-size:13px;">Hubungi kami</p>
            <p style="font-weight: bold;">021-4664355223</p>
           </div> --}}
            </div>

        </div>
    </div>
</nav>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap');

    nav {
        font-family: "Noto Serif", serif;
    }

    ,
    li.nav-item {
        padding: 10px;
        background: red;
    }

    ,
</style>

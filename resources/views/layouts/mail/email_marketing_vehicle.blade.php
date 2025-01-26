<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>
</head>
<body>

    <div class="container">

        <p>{{$data['title']}}</p>
        <br>
        @if ($data['images'])
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                @foreach ($data['images'] as $key => $img)
                    <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key }}" class="{{ $key === 0 ? 'active' : '' }}"></li>
                @endforeach
            </ol>
            <div style="margin-bottom: 20px;" class="carousel-inner">
                @foreach ($data['images'] as $key => $img)
                    <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                        <img style="width:300px; height:300px;" class="d-block w-100" src="{{ asset('storage/' . $img->images) }}" alt="Slide {{ $key + 1 }}">
                    </div>
                @endforeach
            </div>
        
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        @else
        @endif
        <br>
        <p>Informasi Unit</p>
            <ul>
                <li>Brand : {{$data['brand']}}</li>
                <li>Tipe Mobil : {{$data['vehicle_type']}}</li>
                <li>Tahun : {{$data['manufacture_year']}}</li>
                <li>Warna : {{$data['color']}}</li>
            </ul>
        <br>
        <p>{{$data['description']}}</p> 

        @if($data['link'])
        <a href="{{$data['link']}}">{{$data['link']}}</a>
        @else
        @endif

        <p>Terima kasih telah memilih kami. Kami tidak sabar untuk menyambut Anda!</p>

        

        <div class="footer">

            <p>Jika Anda memiliki pertanyaan, silakan hubungi kami di <a href="mailto:support@example.com">sahabatgroupauto.helpdesk.com</a>.</p>

            <p>&copy; {{ date('Y') }} PT Sahabat Group Auto. Semua hak dilindungi.</p>

        </div>

    </div>
</body>

<style>

    body {

        font-family: Arial, sans-serif;

        background-color: #f4f4f4;

        margin: 0;

        padding: 20px;

    }

    .container {

        max-width: 600px;

        margin: auto;

        background: #ffffff;

        padding: 20px;

        border-radius: 8px;

        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);

    }

    h4 {

        color: #333333;

    }

    p {

        color: #555555;

        line-height: 1.6;

    }

    .footer {

        margin-top: 20px;

        text-align: center;

        font-size: 12px;

        color: #888888;

    }

    .highlight {

        font-weight: bold;

        color: #007BFF;

    }

</style>
</html>
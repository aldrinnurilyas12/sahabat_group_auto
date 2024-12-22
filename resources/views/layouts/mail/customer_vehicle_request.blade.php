<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <div class="container">

        <h4>Yth.{{$data['name']}}</h4>

        <p>Permohonan permintaan pencarian unit kendaraan {{ $data['brand_name'] . ' ' . $data['vehicle_type'] . ' ' . $data['year']  }} berhasil dikirim untuk ditinjau.</p>

        <ul>
            <li><strong>Unit Kendaraan :</strong> {{$data['vehicle_type']}}</li>
            <li><strong>Merk Kendaraan :</strong> {{$data['brand_name']}}</li>
            <li><strong>Tahun Kendaraan :</strong> {{$data['year']}}</li>
            <li><strong>Warna Kendaraan :</strong> {{$data['vehicle_color']}}</li>
        </ul>
       
        <ul>
            <h4>Gunakan token ini untuk melihat informasi status Permintaan pencarian Unit Kendaraan.</h4>
            <li><strong>Token anda :</strong>{{$data['unique_tokens']}}</li>
        </ul>

        <p>Jika anda ingin melihat informasi status tinjauan permintaan pencarian Unit Kendaraan, silahkan kunjungi link :
            <a href="{{route('sahabatmotor')}}#customerRequest">Lihat Status Permintaan Jual Unit</a>
        </p>



        <p>Terima kasih atas permintaan pencarian unit kendaraan, Tim kami akan menghubungi anda 6 Hari masa kerja</p>

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
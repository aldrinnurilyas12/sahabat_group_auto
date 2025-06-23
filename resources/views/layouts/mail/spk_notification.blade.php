<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notifikasi SPK</title>
</head>

<body>

    <div class="container">

        {{-- <h4>Yth. {{ $data['employee_name'] }}</h4> --}}

        <p>Pemberitahuan!
            <br>
            SPK untuk unit kendaraan {{ $data['unit'] }} telah berhasil terjual
        </p>

        <ul>
            <li><strong>Unit Kendaraan:</strong> {{ $data['unit'] }}</li>
            <li><strong>Lokasi Unit : {{ $data['location_unit'] }}</strong></li>
            <li><strong>Status : {{ $data['spk_status'] }}</strong></li>
            <li><strong>Tanggal SPK : {{ $data['created_at'] }} </strong></li>
            <li><strong>Tanggal Konfirmasi SPK : {{ $data['spk_confirmation_date'] }} </strong></li>
            <hr>
            <br>
            <span>Detail Customer</span>
            <li>Nama Customer : {{ $data['name'] }}</li>
            <li>Alamat : {{ $data['address'] }}</li>
        </ul>

        <div class="footer">

            <p>Jika Anda memiliki pertanyaan, silakan hubungi kami di <a
                    href="mailto:support@example.com">sahabatgroupauto.helpdesk.com</a>.</p>

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

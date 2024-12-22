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

        <h4>Yth. {{$data['name']}}</h4>

        <p>Selamat! Appointment Anda untuk menghadiri <span class="highlight">test drive/kunjungan di Showroom {{$data['location_unit']}}</span> telah berhasil dijadwalkan.</p>

        <ul>
            <li><strong>Unit Kendaraan :</strong> {{$data['unit']}}</li>

            <li><strong>Tanggal :</strong> {{date('d F Y', strtotime($data['date']))}}</li>

            <li><strong>Jam :</strong> {{$data['schedule_time']}}</li>

            <li><strong>Showroom :</strong> {{$data['location_unit']}}</li>

            <li><strong>Alamat :</strong> {{$data['address']}}</li>

            <li><strong>No.Telepon :</strong> {{$data['no_telepon']}}</li>
        </ul>
        

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
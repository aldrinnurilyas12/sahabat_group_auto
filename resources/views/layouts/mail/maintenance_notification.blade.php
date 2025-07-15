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

        <h4>Yth. Pengguna web admin PT Sahabat Group Auto </h4>

        <p>Maaf Saat ini kami sedang melakukan maintenance dan pengembangan website admin oleh tim IT, tidak dapat
            digunakan pada :
        </p>

        <ul>

            <li><strong>Tanggal :</strong>
                {{ $data['start_date_maintenance'] . '   |   ' . 'Jam : ' . $data['time_start_date_maintenance'] . ' Wib' }}
            </li>

            <li><strong>Hingga :</strong>
                {{ $data['end_date_maintenance'] . '   |   ' . 'Jam : ' . $data['time_end_date_maintenance'] . ' Wib' }}
            </li>

            <li><strong>Keterangan :</strong> {{ $data['description'] }}</li>

        </ul>

        <p>Selama periode ini, Anda mungkin mengalami keterbatasan akses atau fungsionalitas pada website admin kami.
            Kami mohon maaf atas ketidaknyamanan yang mungkin ditimbulkan.</p>


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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verifikasi Akun Pengguna </title>
</head>

<body>

    <div class="container">
        <h4> PT Sahabat Group Auto </h4>
        <hr>
        <br>
        <h5>Silahkan Verifikasi Email anda untuk login pengguna</h5>
        <ul>
            <li>NIK : {{ $data['nik'] }}</li>
            <li>Nama Karyawan : {{ $data['name'] }}</li>
            <li>Password default: Gunakan Tanggal Lahir anda dengan contoh format (dmy => 12012001)</li>
        </ul>
        <span style="font-style: italic;">*Harap segera mengubah password anda setelah melakukan verifikasi akun</span>

        <br>
        <br>

        <div style="display: flex; justify-content:center;" class="btn">
            <a href="{{ route('users_verification_page', $data['nik']) }}"
                style="width: max-content;padding:8px; background:rgb(0, 0, 0); color:white;border:none; border-radius:4px;text-decoration:none;"
                type="button" class="btn btn-primary">Verifikasi Email</a>
        </div>

        <div class="footer">

            <p>Jika Anda memiliki pertanyaan, silakan hubungi kami di <a
                    href="mailto:support@example.com">sahabatgroupauto.helpdesk.com</a>.</p>

            <p>&copy; {{ date('Y') }} PT Sahabat Group Auto. Semua hak dilindungi.</p>

        </div>
    </div>


</body>

<style>
    .container {

        max-width: 600px;

        margin: auto;

        background: #ffffff;

        padding: 20px;

        border-radius: 8px;

        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);

    }
</style>

</html>

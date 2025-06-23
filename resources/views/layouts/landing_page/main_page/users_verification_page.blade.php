<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verifikasi Akun Pengguna </title>
</head>

<body>
    <div class="card-container">
        <div class="container">
            <h4> PT Sahabat Group Auto </h4>
            <hr>
            <br>
            <h5>Silahkan Verifikasi Email anda untuk login pengguna</h5>


            <form action="{{ route('user_verification', $nik) }}" method="POST">
                @csrf
                @method('PUT')
                <div style="display: flex; justify-content:center;" class="btn">
                    <button
                        style="width: max-content;padding:8px; background:rgb(0, 0, 0); color:white;border:none; border-radius:4px;cursor:pointer;"
                        type="submit" class="btn btn-primary">Verifikasi Email</a>
                </div>

            </form>

            <div class="footer">

                <p>Jika Anda memiliki pertanyaan, silakan hubungi kami di <a
                        href="mailto:support@example.com">sahabatgroupauto.helpdesk.com</a>.</p>

                <p>&copy; {{ date('Y') }} PT Sahabat Group Auto. Semua hak dilindungi.</p>

            </div>
        </div>
    </div>


</body>

<style>
    .card-container {

        width: 100%;
        display: flex;
        margin-top: 10%;
        justify-content: center;
        background: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);

    }
</style>

</html>

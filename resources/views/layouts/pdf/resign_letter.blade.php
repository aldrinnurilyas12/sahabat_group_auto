<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Resign Letter</title>
</head>

<body>

    <div style="text-align:center;" class="title-center">
        <h5><strong>PT SAHABAT GROUP AUTO</strong></h5>
        <h6>Surat Resign Karyawan</h6>
    </div>


    <div class="spk-information">
        @foreach ($employee_resign as $emp)
            <div class="container-name">
                <p>Tanggal Resign</p>
                <p>{{ $emp->created_at }}</p>
            </div>

            <div class="container-name">
                <p>NIK</p>
                <p>{{ $emp->nik }}</p>
            </div>

            <div class="container-name">
                <p>Nama</p>
                <p>{{ $emp->name }}</p>
            </div>

            <div class="container-name">
                <p>Posisi Pekerjaan</p>
                <p>{{ $emp->position_name }}</p>
            </div>

            <div class="container-name">
                <p>Department</p>
                <p>{{ $emp->department_name }}</p>
            </div>

            <div class="container-name">
                <p>Alasan Resign</p>
                <p>{{ $emp->resign_reasons }}</p>
            </div>

            <div class="container-name">
                <p>Hari terakhir kerja</p>
                <p>{{ $emp->last_day_of_work }}</p>
            </div>

            <div class="container-name">
                <p>Properti perusahaan yang dikembalikan</p>
                <p>{{ $emp->return_company_property }}</p>
            </div>

            <br>

            <div style="margin-bottom: 70px;" class="signature-approval">

                <div style="float: left;margin-right: 5rem;" class="hr-sign">
                    <p style="font-size: 13px;"><strong>Kepala Sumber Daya Manusia</strong></p>
                    <img width="80" height="80"
                        src="{{ public_path('storage/' . $head_hr_signature->first()->signature) }}" alt="">
                    <br>
                    <p style="font-size: 13px;">{{ $head_hr_signature->first()->name }}</p>
                </div>


                <div style="float: left;margin-left: -2rem;" class="hr-sign">
                    <p style="font-size: 13px;"><strong>Kepala Cabang</strong></p>
                    <img width="80" height="80"
                        src="{{ public_path('storage/' . $head_branch_signature->first()->signature) }}"
                        alt="">
                    <br>
                    <p style="font-size: 13px;">{{ $head_branch_signature->first()->name }}</p>
                </div>

                <div style="float: right;margin-left: 10rem;" class="hr-sign">
                    <p style="font-size: 13px;"><strong>Karyawan</strong></p>
                    <img width="80" height="80"
                        src="{{ public_path('storage/' . $employee_signature->first()->signature) }}" alt="">
                    <br>
                    <p style="font-size: 13px;">{{ $employee_signature->first()->name }}</p>
                </div>
            </div>
        @endforeach


    </div>

    <br>
    <br>
    <br>
    <br>
    <footer>
        <div style="margin-top: 12rem;" class="body-footer">
            <h5>PT Sahabat Group Auto</h5>
            <p>Bursa Mobil Summarecon Serpong, Jl. Gading Serpong Boulevard, Curug Sangereng, Kec. Klp. Dua, Kabupaten
                Tangerang, Banten 15810</p>
        </div>

    </footer>

</body>

<style>
    body {
        font-family: Arial, sans-serif;
        padding: 20px;

    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
        font-size: 12px;
    }

    th {
        background-color: #f2f2f2;
    }

    .body-footer {
        width: 100%;
        text-align: center;
        color: black;
        font-size: 14px;
        padding: 6px;
        background: rgb(247, 247, 247);
    }

    .body-footer h5 {
        font-size: 16px;
        margin-bottom: 5px;
    }

    .title-center {
        text-align: center;
        margin-bottom: 20px;
    }

    .title-center h5 {
        margin: 0;
        font-size: 24px;
    }

    .title-center h6 {
        margin: 5px 0;
        font-size: 18px;
        font-weight: normal;
    }

    .spk-information {
        background-color: #ffffff;
        padding: 20px;
        margin-bottom: 30px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .container-name {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .container-name p {
        margin: 0;
        font-size: 14px;
    }

    .container-name p:first-child {
        font-weight: bold;
    }

    hr {
        border: 1px solid #eee;
        margin: 20px 0;
    }
</style>

</html>

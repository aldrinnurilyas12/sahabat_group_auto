<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SPK PDF</title>
</head>
<body>

    <div style="text-align:center;" class="title-center">
        <h5><strong>PT SAHABAT GROUP AUTO</strong></h5>
        <h6>Payroll Karyawan</h6>
    </div>

    
    <div class="spk-information">
        @foreach($payroll_data as $payroll)
        <div class="container-name">
            <p>Tanggal Payroll</p>
            <p>{{$payroll->created_at}}</p>
        </div>

        <div class="container-name">
            <p>Nama</p>
            <p>{{$payroll->name}}</p>
        </div>

        <div class="container-name">
            <p>Total gaji yang dibayarkan</p>
            <p>Rp.{{number_format($payroll->salary_total)}}</p>
        </div>
        
        <div class="container-name">
            <p>Bank asal</p>
            <p>{{$payroll->bank}}</p>
        </div>

        <div class="container-name">
            <p>Nomor Rekening Bank</p>
            <p>{{$payroll->bank_account}}</p>
        </div>

        <br>

        <div class="container-name">
            <div class="table-payroll">
                <label for="">Rincian Gaji</label>
                <table>
                    <thead>
                        <tr>
                            <th>Gaji Pokok</th>
                            <th>Tunj.Transport</th>
                            <th>Tunj.Kesehatan</th>
                            <th>Tunj.Lainnya</th>
                            <th>Total Gaji yang dibayarkan</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $no = 1;  ?>
                        @foreach($payroll_data as $payroll)
                        <tr style="width: 200px;">
                            <td>Rp.{{number_format($payroll->salary)}}</td>
                            <td>Rp.{{number_format($payroll->tunjangan_transport)}}</td>
                            <td>Rp.{{number_format($payroll->tunjangan_kesehatan)}}</td>
                            <td>Rp.{{number_format($payroll->tunjangan_lainnya)}}</td>
                            <td><strong>Rp.{{number_format($payroll->salary_total)}}</strong></td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
            <br>
            <br>
            <div class="table-presensi">
                <label for="">Rincian Presensi</label>
                <table>
                    <thead>
                        <tr>
                            <th>Kehadiran</th>
                            <th>Sakit</th>
                            <th>Izin</th>
                            <th>Alpha</th>
                            <th>Presensi Rate</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($payroll_data as $payroll)
                        <tr style="width: 200px;">
                            <td>{{$payroll->total_hadir}}</td>
                            <td>{{$payroll->total_sakit}}</td>
                            <td>{{$payroll->total_izin}}</td>
                            <td>{{$payroll->total_alpha}}</td>
                            <td>{{sprintf("%.0f",$payroll->attendance_rate_permonth)}} %</td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
        
        <br>
        
        <div style="margin-bottom: 70px;"  class="signature-approval">
            <div style="float: left; margin-right: 5rem;" class="head-finance-sign">
               <p style="font-size: 13px;"><strong>Kepala Keuangan</strong></p> 
                <img width="80" height="80" src="{{ public_path('storage/' . $head_of_finance_sign->first()->signature) }}" alt="">
                <br>
                <p style="font-size: 13px;">{{$head_of_finance_sign->first()->name}}</p> 
            </div>

            <div style="float: left;margin-right: 9rem;" class="hr-sign">
                <p style="font-size: 13px;"><strong>Kepala Sumber Daya Manusia</strong></p> 
                <img width="80" height="80" src="{{ public_path('storage/' . $head_of_hr_sign->first()->signature) }}" alt="">
                <br>
               <p style="font-size: 13px;">{{$head_of_hr_sign->first()->name}}</p>  
            </div>    
        </div>
        @endforeach


    </div>

    <br>
    <br>
    <br>
    <br>
   <footer>
        <div class="body-footer">
        <h5>PT Sahabat Group Auto</h5>
        <p>Bursa Mobil Summarecon Serpong, Jl. Gading Serpong Boulevard, Curug Sangereng, Kec. Klp. Dua, Kabupaten Tangerang, Banten 15810</p>
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
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }
        th {
            background-color: #f2f2f2;
        }
    .body-footer {
        width:100%;
        text-align: center;
        color: black;
        font-size: 14px;
        padding: 6px;
        background: rgb(247, 247, 247);
    }

    .body-footer h5{
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
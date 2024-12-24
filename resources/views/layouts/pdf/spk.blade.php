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
        <h6>SPK UNIT KENDARAAN</h6>
    </div>

    
    <div class="spk-information">
        @foreach($spk_data as $spk)
        <div class="container-name">
            <p>Tanggal SPK</p>
            <p>{{$spk->created_at}}</p>
        </div>

        <div class="container-name">
            <p>Unit</p>
            <p>{{$spk->unit}}</p>
        </div>

        <div class="container-name">
            <p>Harga</p>
            <p>Rp.{{number_format($spk->price)}}</p>
        </div>

        <div class="container-name">
            <p>Terbilang</p>
            <p style="font-style: italic;">{{$spk->price_nominal}}</p>
        </div>
        <div class="container-name">
            <p>Metode Pembayaran</p>
            <p>{{$spk->payment_method}}</p>
        </div>

        <hr>

        <div class="container-name">
            <p>Nama Pelanggan</p>
            <p>{{$spk->customer}}</p>
        </div>

        <div class="container-name">
            <p>Alamat</p>
            <p>{{$spk->address}}</p>
        </div>

        <div class="container-name">
            <p>No.Telepon</p>
            <p>{{$spk->phone_number}}</p>
        </div>

        <div class="container-name">
            <p>Email</p>
            <p>{{$spk->email}}</p>
        </div>
        

        <hr>
        <div style="margin-bottom: 70px;"  class="signature-approval">
            <div style="float: left; margin-right: 5rem;" class="head-branch">
               <p style="font-size: 13px;"><strong>Kepala Cabang</strong></p> 
                <img width="80" height="80" src="{{ public_path('storage/' . $head_branch_signature->first()->signature) }}" alt="">
                <br>
                <p style="font-size: 13px;">{{$head_branch_signature->first()->name}}</p> 
            </div>

            <div style="float: left;margin-right: 9rem;" class="sales-manager">
                <p style="font-size: 13px;"><strong>Sales Manager</strong></p> 
                <img width="80" height="80" src="{{ public_path('storage/' . $sales_manager_signature->first()->signature) }}" alt="">
                <br>
               <p style="font-size: 13px;">{{$sales_manager_signature->first()->name}}</p>  
            </div>

             <div style="margin-top: 10px;"  class="customer-signature">
                <br>
                <br>
                <p style="margin-bottom: 5px;font-size:12px;" class="text-secondary">Materai</p>
                <br>
                 <p style="font-size: 13px;">{{$spk->customer}}</p>
             </div>
    
        </div>
        @endforeach


    </div>

  
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
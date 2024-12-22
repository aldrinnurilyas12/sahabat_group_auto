<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{$vehicle->first()->brand . " " . $vehicle->first()->vehicle_type . " " . $vehicle->first()->manufacture_year}} - SAHABAT GROUP AUTO ADMINISTRATOR</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Inter:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('layouts.admin_views.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                @include('layouts.admin_views.header')
                
                {{-- content --}}
                <div class="container-fluid">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div style="display: flex;flex-wrap:wrap; justify-content:space-between;align-items:center;"  class="card-header py-3">
                            <a href="{{route('master_vehicle_data.index')}}" class="btn btn-info"><i class="fas fa-chevron-left"></i> &nbsp;Kembali</a>
                            <a href="#" data-toggle="modal" data-target="#infoModal"><i style="font-size: 20px;" class="fa fa-info-circle" aria-hidden="true"></i>
                            </a>
                        </div>

                        {{-- Image content --}}
                        
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                @foreach ($images as $key => $img)
                                    <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key }}" class="{{ $key === 0 ? 'active' : '' }}"></li>
                                @endforeach
                            </ol>
                            <div style="margin-bottom: 20px;" class="carousel-inner">
                                @foreach ($images as $key => $img)
                                    <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                        <img style="width:400px; height:400px;" class="d-block w-100" src="{{ asset('storage/' . $img->images) }}" alt="Slide {{ $key + 1 }}">
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
                        
                      
                        

                        {{-- end --}}

                        <div class="title-container">
                            @if($vehicle->isNotEmpty())
                                <div class="title-content">
                                    <h4>{{$vehicle->first()->unit}}</h4>
                                </div>

                                <h5 style="color: black;margin-bottom:30px;">{{"IDR " . number_format($vehicle->first()->price)}}</h5>
                                

                                <div style="display: block; gap:10px; justify-content:center;margin-top:10p" class="content-status">

                                    <div class="active-status-vehicle">
                                        <p>Lokasi Unit: </p><h5 class="btn-location">{{$vehicle->first()->location_unit}}</h5>
                                    </div>
                                    <div class="active-status-vehicle">
                                        <div style="display: flex;flex-wrap:wrap; gap:10px;width:100%;justify-content:center;" class="status">
                                            <p>Status Unit:</p>
                                            @if ($vehicle->first()->category_name == 'Unit Terjual')
                                            <h5 class="btn-active-status-sold">{{$vehicle->first()->category_name}}</h5>
                                            @else
                                            <h5 class="btn-active-status">{{$vehicle->first()->category_name}}</h5>
                                            <a style="font-size:12px; text-decoration:underline;" href="#" data-toggle="modal" data-target="#changeStatusModal">Ubah Status <i class="fas fa-share-square"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                
                                    <div style="display: flex;flex-wrap:wrap; gap:10px;width:100%;justify-content:center;" class="payment-method">
                                        @if ($vehicle->first()->category_name == 'Unit Terjual')
                                        <p>Metode Pembayaran : </p>
                                        @if($vehicle->first()->payment_method == null)
                                        <p class="text-danger">Belum ada</p>
                                        @else
                                        <h5 class="btn-active-status-sold">{{$vehicle->first()->payment_method}}</h5>
                                        @endif
                                        <a style="font-size:12px; text-decoration:underline;" href="{{route('payment_method', $vehicle->first()->id)}}">Atur Pembayaran <i class="fas fa-share-square"></i></a>
                                        @endif
                                    </div>
                                 
                                    <div style="display: flex;flex-wrap:wrap;" class="active-status-vehicle">
                                        <p>Status iklan :</p>
                                        @if($check_ads == null)
                                        <p class="text-danger">Belum terpasang<p>
                                            <a style="font-size:12px; text-decoration:underline;" href="{{route('add_vehicle_advertisement', $vehicle->first()->id)}}" >Pasang Iklan <i class="fas fa-share-square"></i></a>
                                           
                                        @else
                                        <p class="text-success"><i style="color: green;" class="fa fa-check-circle"></i> Sudah terpasang</p>
                                        @endif
                                    
                                    </div>
       
                                       
                                </div>
                             @endif
                        </div>
                  
                        <div class="card-body">

                            {{-- tab --}}
                            <!-- Tabs navs -->
                            <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a
                                        data-mdb-tab-init
                                        class="nav-link active"
                                        id="ex1-tab-1"
                                        href="#ex1-tabs-1"
                                        role="tab"
                                        aria-controls="ex1-tabs-1"
                                        aria-selected="true"
                                    >Detail Kendaraan</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a
                                        data-mdb-tab-init
                                        class="nav-link"
                                        id="ex1-tab-2"
                                        href="#ex1-tabs-2"
                                        role="tab"
                                        aria-controls="ex1-tabs-2"
                                        aria-selected="false"
                                    >Simulasi Kredit</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a
                                        data-mdb-tab-init
                                        class="nav-link"
                                        id="ex1-tab-3"
                                        href="#ex1-tabs-3"
                                        role="tab"
                                        aria-controls="ex1-tabs-3"
                                        aria-selected="false"
                                    >Dokumen Lainnya</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a
                                        data-mdb-tab-init
                                        class="nav-link"
                                        id="ex1-tab-4"
                                        href="#ex1-tabs-4"
                                        role="tab"
                                        aria-controls="ex1-tabs-4"
                                        aria-selected="false"
                                    >Foto Unit</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a
                                        data-mdb-tab-init
                                        class="nav-link"
                                        id="ex1-tab-5"
                                        href="#ex1-tabs-5"
                                        role="tab"
                                        aria-controls="ex1-tabs-5"
                                        aria-selected="false"
                                    >Media Player Unit</a>
                                </li>
                            </ul>

                            <div class="tab-content" id="ex1-content">
                                <div
                                    class="tab-pane fade show active"
                                    id="ex1-tabs-1"
                                    role="tabpanel"
                                    aria-labelledby="ex1-tab-1">
                                    <div id="table-detail" class="table-responsive">
                                        <table style="color: black;" class="table table-bordered"> 
                                        </thead> 
                                        @foreach($vehicle as $cars)
                                            <tbody> 
                                                <tr> 
                                                    <td class="title">VIN/NO.POL</td> 
                                                    <td>{{$cars->vehicle_registration_number}}</td> 
                                                </tr> 
                                                <tr> 
                                                    <td class="title">Tipe</td>
                                                    <td>{{$cars->vehicle_type}}</td>
                                                </tr> 
                                                <tr> 
                                                    <td class="title">Merk/Brand</td>
                                                    <td>{{$cars->brand}}</td> </tr> 
                                                <tr>
                                                    <td class="title">Tahun</td>
                                                    <td>{{$cars->manufacture_year}}</td>
                                                </tr>   
                                                <tr>
                                                    <td class="title">Harga</td>
                                                    <td>{{"Rp" . number_format($cars->price)}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="title">Kategori/Jenis</td>
                                                    <td>{{$cars->vehicle_category}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="title">Model</td>
                                                    <td>{{$cars->model}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="title">Warna</td>
                                                    <td>{{$cars->color}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="title">Jenis Bahan Bakar</td>
                                                    <td>{{$cars->fuel_type}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="title">Kapasitas Silinder</td>
                                                    <td>{{$cars->cylinder_capacity}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="title">Transmisi</td>
                                                    <td>{{$cars->transmission}}</td>
                                                <tr>
                                                    <td class="title">Nomor Rangka</td>
                                                    <td>{{$cars->vehicle_identity_number}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="title">Nomor Mesin</td>
                                                    <td>{{$cars->engine_number}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="title">Warna TNKB</td>
                                                    <td>{{$cars->licence_plate_color}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="title">Tahun Pendaftaran</td>
                                                    <td>{{$cars->registration_year}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="title">Tanggal Pajak</td>
                                                    <td>{{$cars->tax_date}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="title">Nomor BPKB</td>
                                                    <td>{{$cars->bpkb_number}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="title">Kode Lokasi</td>
                                                    <td>{{$cars->location_code}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="title">Nomor antrian Pendaftaran</td>
                                                    <td>{{$cars->registration_queue_number}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="title">Lokasi Unit</td>
                                                    <td>{{$cars->location_unit}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="title">Nama Pemilik</td>
                                                    <td>{{$cars->name_of_owner}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="title">Alamat Pemilik</td>
                                                    <td>{{$cars->address}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="title">Tanggal Buat</td>
                                                    <td>{{$cars->created_at}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="title">Dibuat oleh</td>
                                                    <td>{{$cars->created_by}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="title">Tanggal update</td>
                                                    <td>{{$cars->updated_at}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="title">Diperbarui oleh</td>
                                                    <td>{{$cars->updated_by}}</td>
                                                </tr>
                                            </tbody>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                                {{-- credit simulation --}}
                                <div class="tab-pane fade" id="ex1-tabs-2" role="tabpanel" aria-labelledby="ex1-tab-2">
                                    <div  class="card-header py-3">
                                        @if($vehicle->isNotEmpty())
                                        <a href="{{ route('add_credit_simulation', $vehicle->first()->id) }}" class="btn btn-primary">
                                            <i class="fas fa-plus-circle"></i>&nbsp;Buat Simulasi Kredit
                                        </a>
                                        @else
                                        <a href="{{ route('add_credit_simulation', $vehicle->first()->id) }}" class="btn btn-primary">
                                            <i class="fas fa-plus-circle"></i>&nbsp;Buat Simulasi Kredit
                                        </a>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                    <div id="table-detail" class="table-responsive">
                                        
                                        <table style="font-size: 14px; color:black;" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Aksi</th>
                                                    <th>Unit</th>
                                                    <th>Harga Unit</th>
                                                    <th>Biaya DP Unit</th>
                                                    <th>Asuransi</th>
                                                    <th>Tenor 12 Bulan</th>
                                                    <th>Tenor 24 Bulan</th>
                                                    <th>Tenor 36 Bulan</th>
                                                    <th>Tenor 48 Bulan</th>
                                                    <th>Tenor 60 Bulan</th>
                                                    <th>Tenor 72 Bulan</th>
                                                </tr>
                                            </thead>
                                        
                                            <tbody>
                                                <?php $no = 1;  ?>
                                                @foreach($credit_simulation as $credit)
                                                <tr>
                                                    <td><?php echo $no++ ?></td>
                                                    <td><div style="display:flex; justify-content:center;gap:8px; " class="action">
                                                        <a href="{{route('edit_credit_simulation', $credit->id)}}"><i class="fas fa-edit"></i></a>
                                                        <form action="{{route('master_credit_simulation.destroy', $credit->id)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button style="width:25px;justify-content:center;display:flex;" class="btn btn-primary" type="submit"><i  class="fas fa-trash"></i></button>
                                                        </form>
                                                    </td>
                                                    <td>{{$credit->unit}}</td>
                                                    <td>{{"IDR " . number_format($credit->price)}}</td>
                                                    <td>{{"IDR " . number_format($credit->down_payment)}}</td>
                                                    <td>{{$credit->insurance_name}}</td>
                                                    <td>{{"IDR " . number_format($credit->tenor_12_month)}}</td>
                                                    <td>{{"IDR " . number_format($credit->tenor_24_month)}}</td>
                                                    <td>{{"IDR " . number_format($credit->tenor_36_month)}}</td>
                                                    <td>{{"IDR " . number_format($credit->tenor_48_month)}}</td>
                                                    <td>{{"IDR " . number_format($credit->tenor_60_month)}}</td>
                                                    <td>{{"IDR " . number_format($credit->tenor_72_month)}}</td>
        
                                                </tr>
        
                                                @endforeach
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                    </div>
                                </div>
                                {{-- document --}}
                                <div class="tab-pane fade" id="ex1-tabs-3" role="tabpanel" aria-labelledby="ex1-tab-3">
                                    <div style="font-size: 13px;" class="alert alert-warning">
                                        <ul>
                                            <li>Maksimal upload 10 File Dokumen</li>
                                            <li>Foto harus berektensi : jpg,png,jpeg,pdf,excel,dan word.</li>
                                        </ul>
                                    </div>
                                    <h5 style="color: black;">Dokumen Kendaraan : {{$vehicle->first()->brand . " " . $vehicle->first()->vehicle_type . " " . $vehicle->first()->manufacture_year}}</h5>
                                    <br>

                                    <div style="display: flex; gap:15px; justify-content:space-between;flex-wrap:wrap;" class="btn-content">
                                        <div style="display: flex;gap:10px;" class="btn-container-doc">
                                            <form action="{{route('download.document', $vehicle->first()->id)}}"  method="GET">
                                                <button style="margin-bottom: 20px;" class="btn btn-primary" type="submit"><i class="fas fa-download"></i> &nbsp; Download Dokumen</button>
                                            </form>

                                            {{-- BUTTON FOR DELETE ALL DOCUMENTS --}}
                                            {{-- <div class="form-delete-doc">
                                                <form action="{{route('delete_document',['vehicle_id'=>$vehicle->first()->id])}}"  method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" style="margin-bottom: 20px;" class="btn btn-danger"><i class="fas fa-trash"></i> &nbsp; Hapus Semua Dokumen</button>
                                                </form>
                                            </div> --}}
                                        </div>

                                        <div style="display: flex;" class="form-doc-upload">
                                            <form style="display: flex;" action="{{route('document_upload')}}"  method="POST" enctype="multipart/form-data">
                                            @csrf
                                                <div class="form-group">
                                                    <input type="text" name="vehicle_id" value="{{$vehicle->first()->id}}" hidden>
                                                    <input type="file" name="document_files[]" multiple required>
                                                </div>
                                                <button style="margin-bottom: 20px;" class="btn btn-info" type="submit"><i class="fas fa-upload"></i> &nbsp; Upload Dokumen</button>
                                            </form>
                                        </div>
                                    </div>

                                    <div style="display: flex; flex-wrap:wrap;gap:5px;" class="container-image">
                                    @foreach ($documents as $item)
                                    <div class="doc-display">
                                        <img height="200" width="200" src="{{ asset('storage/' . $item->document_files) }}">
                                        <div class="form-delete-doc">
                                            <form action="{{route('delete_onlychoose_document',['id' =>  $item->id])}}"  method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button style="margin-top:5px;" type="submit"  style="margin-bottom: 20px;" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                    @endforeach
                                    </div>
                                </div>
                                
                                {{-- images content --}}
                                <div class="tab-pane fade" id="ex1-tabs-4" role="tabpanel" aria-labelledby="ex1-tab-4">
                                    <div style="font-size: 13px;" class="alert alert-warning">
                                        <ul>
                                            <li>Maksimal upload 15 Foto</li>
                                            <li>Foto harus berektensi : jpg,png,jpeg.</li>
                                        </ul>
                                    </div>
                                    <h5 style="color: black;">Foto Unit : {{$vehicle->first()->brand . " " . $vehicle->first()->vehicle_type . " " . $vehicle->first()->manufacture_year}}</h5>
                                    <br>
                                    
                                    <div style="display: flex; gap:15px; justify-content:space-between;flex-wrap:wrap;" class="btn-content">
                                    @if ($vehicle->isNotEmpty())
                                        @foreach ($vehicle as $item)
                                        <div style="display: flex;gap:10px;" class="btn-container-img">
                                            <div class="form-download">
                                                <form action="{{route('download.images', $item->id)}}"  method="GET">
                                                    <button style="margin-bottom: 20px;" class="btn btn-primary" type="submit"><i class="fas fa-download"></i> &nbsp; Download Foto Unit</button>
                                                </form>
                                            </div>

                                            {{-- BUTTON FOR ALL FOTOS --}}
                                            {{-- <div class="form-delete-img">
                                                <form action="{{route('delete_images', ['vehicle_id' => $item->id])}}"  method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"  style="margin-bottom: 20px;" class="btn btn-danger"><i class="fas fa-trash"></i> &nbsp; Hapus Semua Foto</button>
                                                </form>
                                            </div> --}}
                                        </div>
                                        
                                        @endforeach
                                        <div style="display: flex;" class="form-doc-upload">
                                            <form style="display: flex;" action="{{route('image_upload')}}"  method="POST" enctype="multipart/form-data">
                                            @csrf
                                                <div class="form-group">
                                                    <input type="text" name="vehicle_id" value="{{$vehicle->first()->id}}" hidden>
                                                    <input type="file" name="images[]" multiple required>
                                                </div>
                                                <button style="margin-bottom: 20px;" class="btn btn-info" type="submit"><i class="fas fa-upload"></i> &nbsp; Upload Foto</button>
                                            </form>
                                        </div>
                                    @else           
                                    @endif
                                    </div>

                                    <div style="display: flex; flex-wrap:wrap;gap:5px;" class="container-image">
                                    @foreach ($images as $galery)
                                        <div class="img-display">
                                            <img height="200" width="200" src="{{ asset('storage/' . $galery->images) }}">
                                            <div class="form-delete-img">
                                                <form action="{{route('delete_onlychoose_images',['id' =>  $galery->id])}}"  method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button style="margin-top:5px;" type="submit"  style="margin-bottom: 20px;" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </div>
                                        </div>

                                    @endforeach
                                    </div>
                                </div>

                                {{-- media player --}}
                                <div class="tab-pane fade" id="ex1-tabs-5" role="tabpanel" aria-labelledby="ex1-tab-5">
                                    <div style="font-size: 13px;" class="alert alert-warning">
                                        <ul>
                                            <li>Maksimal upload 5 File Media</li>
                                            <li>Media bisa berupa Video dan Suara : MP4 & MP3</li>
                                            <li>Durasi Video maks : 5 menit dan size :100 MB</li>
                                        </ul>
                                    </div>
                                    <h5 style="color: black;">Media Player : {{$vehicle->first()->brand . " " . $vehicle->first()->vehicle_type . " " . $vehicle->first()->manufacture_year}}</h5>
                                    <br>
                                    
                                    {{-- <div style="display: flex; gap:15px; justify-content:space-between;flex-wrap:wrap;" class="btn-content">
                                    @if ($vehicle->isNotEmpty())
                                        @foreach ($vehicle as $item)
                                        <div style="display: flex;gap:10px;" class="btn-container-img">
                                            <div class="form-download">
                                                <form action="{{route('download.images', $item->id)}}"  method="GET">
                                                    <button style="margin-bottom: 20px;" class="btn btn-primary" type="submit"><i class="fas fa-download"></i> &nbsp; Download Foto Unit</button>
                                                </form>
                                            </div>

                                            {{-- BUTTON FOR ALL FOTOS --}}
                                            {{-- <div class="form-delete-img">
                                                <form action="{{route('delete_images', ['vehicle_id' => $item->id])}}"  method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"  style="margin-bottom: 20px;" class="btn btn-danger"><i class="fas fa-trash"></i> &nbsp; Hapus Semua Foto</button>
                                                </form>
                                            </div> --}}
                                        {{-- </div> --}}
                                        
                                       
                                    {{-- </div> --}} 

                                    <div style="display: flex;" class="form-video-upload">
                                        <form action="{{route('vehicle_media_upload')}}"  method="POST" enctype="multipart/form-data">
                                        @csrf
                                            <div class="form-group">
                                                <input type="text" name="vehicle_id" value="{{$vehicle->first()->id}}" hidden>
                                                <select class="form-control" name="media_type" id="">
                                                    <option value="">=== Pilih Tipe Media ===</option>
                                                    <option value="video">Video</option>
                                                    <option value="engine sound">Suara Mesin</option>
                                                </select>
                                                <br>
                                                <input type="file" name="media_files">
                                            </div>
                                            <br>
                                            <button style="margin-bottom: 20px;" class="btn btn-info" type="submit"><i class="fas fa-upload"></i> &nbsp; Upload Media</button>
                                        </form>
                                    </div>

                                    <div style="display: flex; flex-wrap:wrap;gap:15px;" class="container-image">
                                    @foreach ($media_video as $video)
                                        <div style="border:1.5px solid gray;" class="img-display">
                                            <video width="200" height="200" controls>
                                            <source src="{{ asset('storage/' . $video->media_files) }}" type="video/mp4">
                                            </video>
                                            {{-- <div class="form-delete-img">
                                                <form action="{{route('delete_onlychoose_images',['id' =>  $galery->id])}}"  method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button style="margin-top:5px;" type="submit"  style="margin-bottom: 20px;" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </div> --}}
                                        </div>

                                    @endforeach

                                    @foreach($media_sound as $sound)
                                        <div style="align-content: end; border:1.5px solid gray;" class="sound-display">
                                            <audio controls>
                                                <source src="{{ asset('storage/' . $sound->media_files) }}" type="audio/mpeg" >
                                            </audio>
                                        </div>
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- end content --}}
            

                {{-- modal change status --}}
                <div class="modal fade" id="changeStatusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ubah status unit : {{$vehicle->first()->brand . ' ' . $vehicle->first()->vehicle_type . ' ' . $vehicle->first()->manufacture_year;}}</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form method="POST" action="{{route('update_status', $vehicle->first()->id)}}">
                            @csrf
                            @method('PUT')
                            <div style="color: black;" class="modal-body">
                                <p>Pilih status :</p>
                                @foreach ($status_category as $status)
                                <div style="display: block;" class="listed-option">
                                    <input type="radio" name="status_vehicle_id" value="{{$status->id}}" id="">
                                    {{$status->category_name}}
                                </div>
                                @endforeach      
                            </div>
                            <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </form>
                        </div>
                    </div>
                </div>
                {{-- end --}}


                {{-- modal info --}}


            </div>
                

            </div>
           
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            

        </div>
        <!-- End of Content Wrapper -->
        @yield('content')

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    {{-- spinner --}}
    <div id="loadingSpinnerWrapper">
        <div class="spinner-border" role="status">
        </div>
      </div>
      
      <style>
        #loadingSpinnerWrapper {
        position: fixed; /* Fix posisi spinner */
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: none; /* Spinner disembunyikan saat halaman dimuat */
        justify-content: center; /* Horizontal center */
        align-items: center; /* Vertical center */
        background-color: rgba(0, 0, 0, 0.517); /* Background semi-transparan */
        z-index: 9999; /* Pastikan spinner berada di atas konten lainnya */
      }
      
      .spinner-border {
        color: yellow;
        width: 3rem;
        height: 3rem; /* Pastikan tinggi spinner diatur */
      }
      
      </style>
</body>
  

    @if (Session::has('message_success'))
    <script>
        Swal.fire({
            title: 'Berhasil',
            text: "{{ Session::get('message_success') }}",
            icon: 'success',
            toast: true,
            position: 'bottom-end',
            showConfirmButton: false,
            timer:2000
        });
    </script>
    @endif

    @if (Session::has('success_images'))
    <script>
        Swal.fire({
            title: 'Berhasil',
            text: "{{ Session::get('success_images') }}",
            icon: 'success',
            timer:2000,
            confirmButtonText: 'OK'
        });
    </script>
    @endif

    @if (Session::has('success_document'))
    <script>
        Swal.fire({
            title: 'Berhasil',
            text: "{{ Session::get('success_document') }}",
            icon: 'success',
            timer:2000,
            confirmButtonText: 'OK'
        });
    </script>
    @endif

    @if (Session::has('delete_document'))
    <script>
        Swal.fire({
            title: 'Berhasil',
            text: "{{ Session::get('delete_document') }}",
            icon: 'success',
            timer:2000,
            confirmButtonText: 'OK'
        });
    </script>
    @endif

    @if (Session::has('delete_images'))
    <script>
        Swal.fire({
            title: 'Berhasil',
            text: "{{ Session::get('delete_images') }}",
            icon: 'success',
            timer:2000,
            confirmButtonText: 'OK'
        });
    </script>
    @endif

    @if (Session::has('failed_delete_images'))
    <script>
        Swal.fire({
            title: 'Gagal',
            text: "{{ Session::get('failed_delete_images') }}",
            icon: 'error',
            timer:2000,
            confirmButtonText: 'OK'
        });
    </script>
    @endif

    @if (Session::has('failed_insert'))
    <script>
        Swal.fire({
            title: 'Gagal',
            text: "{{ Session::get('failed_insert') }}",
            icon: "error",
            timer:6000,
            confirmButtonText: 'OK'
        });
    </script>
        
    @endif
    
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Page level plugins -->
    <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('assets/js/demo/datatables-demo.js')}}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Select all tab links
        const tabLinks = document.querySelectorAll('.nav-link');

        // Add click event to each tab link
        tabLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault(); // Prevent default anchor behavior

                // Remove active class from all links and hide all tab content
                tabLinks.forEach(item => {
                    item.classList.remove('active');
                    item.setAttribute('aria-selected', 'false');
                });
                document.querySelectorAll('.tab-pane').forEach(content => {
                    content.classList.remove('show', 'active');
                });

                // Add active class to the clicked link and show corresponding tab content
                this.classList.add('active');
                this.setAttribute('aria-selected', 'true');
                const target = this.getAttribute('href');
                document.querySelector(target).classList.add('show', 'active');
            });
        });
    });


</script>

<style>
    .title {
        font-weight: bold;
    }

    .title-container  {
        display: block;
        text-align: center;
        gap: 6px;
    }

    .title-content{
        font-family:Inter, sans-serif;
        color: black;
        font-weight:bold;
        padding: 10px;
        gap: 8px;
        display: flex;
        justify-content: center;
    }

    .active-status-vehicle{
        display: flex;
        justify-content: center;
        align-content: center;
        gap: 10px;
    }
    .btn-active-status {
        width:max-content;
        padding: 3px;
        height: max-content;
        font-size: 14px;
        border-radius: 6px;
        background:rgba(0, 255, 128, 0.429) ;
        color: rgb(0, 150, 60);
    }

    .btn-active-status-sold {
        width:max-content;
        padding: 3px;
        height: max-content;
        font-size: 14px;
        border-radius: 6px;
        background:rgba(255, 13, 0, 0.429) ;
        color: rgb(206, 1, 1);
    }

    .btn-location {
        width:max-content;
        padding: 3px;
        height: max-content;
        font-size: 14px;
        border-radius: 6px;
       color:black;

    }
</style>


<script>
    window.addEventListener('load', function() {
       var loadingSpinnerWrapper = document.getElementById('loadingSpinnerWrapper');
   
       // Log elemen untuk memastikan spinner ditemukan
       console.log(loadingSpinnerWrapper);  // Cek apakah elemen ditemukan
   
       if (loadingSpinnerWrapper) {
           // Menampilkan spinner saat halaman dimuat
           loadingSpinnerWrapper.style.display = 'flex';
           console.log("Spinner muncul, timer akan dimulai.");
   
           // Menyembunyikan spinner setelah 2 detik (2000ms)
           setTimeout(function() {
               console.log("2 detik berlalu, menyembunyikan spinner.");
               loadingSpinnerWrapper.style.display = 'none';  // Sembunyikan spinner setelah 2 detik
           }, 1000);  // 2000ms = 2 detik
       } else {
           console.log("Elemen spinner tidak ditemukan!");
       }
   });
   </script>

</html>
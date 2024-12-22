<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Data Unit Kendaraan - SAHABAT GROUP AUTO ADMINISTRATOR</title>

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
                        <div  class="card-header py-3">
                            <div  class="card-header py-3">
                                <h5 style="color: black;"><strong>Data Master Unit Kendaraan Admin PT Sahabat Group Auto</strong></h5>
                                <br>
                                <div style="display: flex;flex-wrap:wrap;gap:10px;" class="component">
                                    <a style="height: 40px;" href="{{ route('add_vehicle') }}" class="btn btn-primary">
                                        <i class="fas fa-plus-circle"></i>&nbsp;Tambah Data Kendaraan
                                    </a>

                                    @if($vehicle->isNotEmpty())
                                    <form action="{{route('vehicle_export')}}" method="POST">
                                        @csrf
                                        <input type="text" name="location_unit" value="{{$selectedLocation}}" hidden>
                                        <input type="text" name="category_name" value="{{$selectedStatus}}" hidden>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-file-excel"></i>
                                                &nbsp; Download
                                        </button> 
                                    </form>
                                    @else
                                    <button class="btn btn-dark">
                                        <i class="fas fa-file-excel"></i>
                                        &nbsp; Download Excel
                                    </button> 
                                    @endif
        
                                </div>
                            </div>
                            
                            <br>
                            <div style="display: flex;flex-wrap:wrap;gap:10px;justify-content:space-between;align-items:center;" class="container-btn">
                                <div style="color: black;" class="form-group">
                                    <form  action="{{route('filter_status')}}" method="GET">

                                    <div style="display: flex;gap:10px;" class="grouped-container">
                                        <div style="display: block" class="select-group">
                                            <label for="">Lokasi unit</label>
                                            <select class="form-control" name="location_unit" id="branch">
                                                <option value="">--- Pilih Lokasi Unit ---</option>
                                                <option value="alldata">Semua Lokasi</option>
                                                  @foreach ($branch as $item)
                                                      <option value="{{$item->location_code.' - '. $item->location_name }}">{{$item->location_code .' - '. $item->location_name }}</option>
                                                  @endforeach
                                            </select>
                                        </div>
                                       
                                        <div style="display: block" class="select-group">
                                        <label for="">Status unit</label>
                                        <select class="form-control" name="status" id="status">
                                        <option value="">--- Pilih Status Unit ---</option>
                                        <option value="alldata">Semua Data</option>
                                          @foreach ($status_category as $item)
                                              <option value="{{ $item->category_name }}">{{ $item->category_name }}</option>
                                          @endforeach
                                        </select>
                                        </div>

                                        <button style="height: 40px; align-self:end;" type="submit" class="btn btn-secondary">Pilih</button>
                                    </div>
                                      &nbsp;
                                     
                                    </form>

                                    <div style="font-size:14px;" class="alert alert-warning">
                                        @if ($selectedStatus || $selectedLocation)
                                            <strong>
                                                Data terpilih:
                                            </strong>
                                            <br>
                                            @if ($selectedStatus)
                                                Status Unit : {{$selectedStatus}} <br>    
                                            @endif

                                            @if ($selectedStatus && $selectedLocation !== 'alldata')
                                                Lokasi Unit : {{$selectedLocation}}
                                                
                                            @endif
                                        @else
                                            <div class="alert alert-warning">
                                                Terapkan filter untuk mendapatkan data.
                                            </div>
                                        @endif  
                                    </div>
                                </div>
                                

                            </div>
                        </div>
                        <div class="card-body">

                            {{-- unit ready --}}
                            <div class="tab-content" id="ex1-content">
                                <div class="tab-pane fade show active"
                                    id="ex1-tabs-1"
                                    role="tabpanel"
                                    aria-labelledby="ex1-tab-1">
                                    <div style="overflow: hidden;" class="table-responsive">
                                        <table style="font-size: 14px; color:black;" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Detail</th>
                                                    <th>Aksi</th>
                                                    <th>Kendaraan</th>
                                                    <th>VIN/NO.POL</th>
                                                    <th>Status Unit</th>
                                                    <th>Tipe</th>
                                                    <th>Merk</th>
                                                    <th>Tahun</th>
                                                    <th>Harga</th>
                                                    <th>Harga Kredit</th>
                                                    <th>Kategori/Jenis</th>
                                                    <th>Model</th>
                                                    <th>Warna</th>
                                                    <th>Jenis Bahan Bakar</th>
                                                    <th>Kapasitas Silinder</th>
                                                    <th>Transmisi</th>
                                                    <th>Nomor Rangka</th>
                                                    <th>Nomor Mesin</th>
                                                    <th>Nomor Coding</th>
                                                    <th>Warna TNKB</th>
                                                    <th>Tahun Pendaftaran</th>
                                                    <th>Tanggal Pajak</th>
                                                    <th>Nomor BPKB</th>
                                                    <th>Kode Lokasi</th>
                                                    <th>registration queue number</th>
                                                    <th>Lokasi Unit</th>
                                                    <th>Nama Pemilik</th>
                                                    <th>Alamat Pemilik</th>
                                                    <th>created_at</th>
                                                    <th>created_by</th>
                                                    <th>updated_at</th>
                                                    <th>updated_by</th>              
                                                </tr>
                                            </thead>
                                           
                                            <tbody>
                                                <?php $no = 1;  ?>
                                                @foreach($vehicle as $cars)
                                                <tr>
                                                    <td><?php echo $no++ ?></td>
                                                    <td> <a class="btn btn-info" href="{{route('detail_vehicle', $cars->id)}}">Detail</a></td>
                                                    <td><div style="display:flex; justify-content:center;gap:8px; " class="action">
                                                        <a href="{{route('edit_vehicle', $cars->id)}}"><i class="fas fa-edit"></i></a>
                                                        <a style="size: 12px;" href="#" data-toggle="modal" data-target="#deleteUnit{{$cars->id}}"><i class="fas fa-trash"></i></a>
                                                        
                                                    </td>
                                                    <td>{{$cars->brand ." " . $cars->vehicle_type ." " . $cars->manufacture_year}}</td>
                                                    <td>{{$cars->vehicle_registration_number}}</td>
                                                    <td>
                                                        @if($cars->category_name == 'Unit Terjual')
                                                        <p class="text-danger">
                                                            {{$cars->category_name}}
                                                        </p>
                                                        @else
                                                        <p class="text-success">
                                                            {{$cars->category_name}}
                                                        </p>
                                                        @endif
                                                        </td>
                                                    <td>{{$cars->vehicle_type}}</td>
                                                    <td>{{$cars->brand}}</td>
                                                    <td>{{$cars->manufacture_year}}</td>
                                                    <td>{{"Rp" . number_format($cars->price)}}</td>
                                                    <td>{{"Rp" . number_format($cars->credit_price)}}</td>
                                                    <td>{{$cars->vehicle_category}}</td>
                                                    <td>{{$cars->model}}</td>
                                                    <td>{{$cars->color}}</td>
                                                    <td>{{$cars->fuel_type}}</td>
                                                    <td>{{$cars->cylinder_capacity ."cc"}}</td>
                                                    <td>{{$cars->transmission}}</td>
                                                    <td>{{$cars->vehicle_identity_number}}</td>
                                                    <td>{{$cars->engine_number}}</td>
                                                    <td>{{$cars->coding_number}}</td>
                                                    <td>{{$cars->licence_plate_color}}</td>
                                                    <td>{{$cars->registration_year}}</td>
                                                    <td>{{ date('Y-m', strtotime($cars->tax_date)) }}</td>
                                                    <td>{{$cars->bpkb_number}}</td>
                                                    <td>{{$cars->location_code}}</td>
                                                    <td>{{$cars->registration_queue_number}}</td>
                                                    <td>{{$cars->location_unit}}</td>
                                                    <td>{{$cars->name_of_owner}}</td>
                                                    <td>{{$cars->address}}</td>
                                                    <td>{{$cars->created_at}}</td>
                                                    <td>{{$cars->created_by}}</td>
                                                    <td>{{$cars->updated_at}}</td>
                                                    <td>{{$cars->updated_by}}</td>
                                             </tr>
        
                                                @endforeach
                                             
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{-- unit sold --}}
                           
                        </div>
                    </div>

                </div>

                {{-- modal change status --}}

                @foreach($vehicle as $cars) 
                <div class="modal fade" id="deleteUnit{{$cars->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$cars->id}}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel{{$cars->id}}">Hapus data unit: {{$cars->brand . ' ' . $cars->vehicle_type . ' ' . $cars->manufacture_year}}</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                
                            <form method="POST" action="{{ route('master_vehicle_data.destroy', $cars->id) }}">
                                @csrf
                                @method('DELETE')
                                <div style="color: black;" class="modal-body">
                                    Apakah Anda ingin menghapus data unit kendaraan:
                                    {{$cars->brand . ' ' . $cars->vehicle_type . ' ' . $cars->manufacture_year}} ?
                                    <br>
                                    <br>
                                    <strong>Data yang akan terhapus :</strong>
                                    <ul>
                                        <li>Foto Kendaraan</li>
                                        <li>File Dokumen (STNK & BPKB)</li>
                                        <li>Data Iklan</li>
                                        <li>Appointment</li>
                                        <li>Simulasi Kredit</li>
                                    </ul>
                                    <span style="font-style: italic;color:gray;font-size:12px;">*Data akan terhapus permanen.</span>    
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                    <button class="btn btn-danger" type="submit">Hapus</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                @endforeach

                {{-- end modal --}}

            </div>

           
           
            @include('layouts.admin_views.footer')
        
        </div>
        <!-- End of Content Wrapper -->
        @yield('content')

    </div>

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
            timer:2000,
            confirmButtonText: 'OK'
        });
    </script>
        
    @endif

    @if (Session::has('message_success'))
    <script>
        Swal.fire({
            title: 'Berhasil',
            text: "{{ Session::get('message_success') }}",
            icon: 'success',
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
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Page level plugins -->
    <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('assets/js/demo/datatables-demo.js')}}"></script>

    <style>
        .col-sm-12{
            overflow-x: scroll;
        }

    </style>
    <script>
        window.addEventListener('load', function() {
           var loadingSpinnerWrapper = document.getElementById('loadingSpinnerWrapper');

           if (loadingSpinnerWrapper) {
               // Menampilkan spinner saat halaman dimuat
               loadingSpinnerWrapper.style.display = 'flex';
               // Menyembunyikan spinner setelah 2 detik (2000ms)
               setTimeout(function() {
                   loadingSpinnerWrapper.style.display = 'none';  // Sembunyikan spinner setelah 2 detik
               }, 1000);  // 2000ms = 2 detik
           } else {
               console.log("Elemen spinner tidak ditemukan!");
           }
       });
       </script>

</html>
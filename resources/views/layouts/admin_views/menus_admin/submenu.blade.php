<link rel="stylesheet" href="{{asset('assets/css/form.css')}}">
<link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
<link
    href="https://fonts.googleapis.com/css?family=Inter:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

<!-- Custom styles for this template-->
<link href="{{ asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">
<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<body>
    <div id="wrapper">

        @include('layouts.admin_views.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
        
            @include('layouts.admin_views.header')
            <div class="container-fluid">
        <div class="card shadow mb-4">
            <div  class="card-header py-3">
                <h5 style="color: black;"><strong>Data Submenu Web Admin PT Sahabat Group Auto</strong></h5>
                <br>
                <div style="display: flex; gap:10px;" class="component-btn">

                    @if($submenu->isNotEmpty())
                    <a href="{{ route('submenu_create', ['id' => $submenu->first()->parent_id]) }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i>&nbsp;Tambah Submenu
                    </a>
                    @else
                    <a href="{{ route('submenu_create', ['id' => $sub_menus->first()->id]) }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i>&nbsp;Tambah Submenu
                    </a>
                    @endif

                    <a href="{{route('submenu_export', $submenu->first()->parent_id)}}" class="btn btn-success">
                        <i class="fas fa-file-excel"></i>
                        &nbsp; Download
                    </a>
                </div>
                
            </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table style="font-size: 14px; color:black;" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Aksi</th>
                                    <th>Menu Utama</th>
                                    <th>Submenu</th>
                                    <th>Icon</th>
                                    <th>Link</th>
                                    <th>Super Admin Role</th>
                                    <th>Admin Role</th>
                                    <th>Branch Head Role</th>
                                    <th>Aktif?</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                    <th>Updated At</th>
                                    <th>Updated By</th>
                                </tr>
                            </thead>
                        
                            <tbody>
                                <?php $no = 1;  ?>

                            
                                @foreach($submenu as $sub)
                                <tr style="width: 200px;">
                                    <td><?php echo $no++ ?></td>
                                    <td><div style="display:flex; justify-content:center;gap:8px; " class="action">
                                        <a href="{{route('submenu_edit',['id' => $sub->id])}}"><i class="fas fa-edit"></i></a>
                                        <a style="size: 12px;" href="#" data-toggle="modal" data-target="#deleteSubMenu{{$sub->id}}"><i class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                    <td>{{$sub->menu_name}}</td>
                                    <td>{{$sub->submenu_name}}</td>
                                    <td>{{$sub->submenu_icons}}</td>
                                    <td>{{$sub->submenu_link}}</td>
                                    <td>{{$sub->superadmin_role}}</td>
                                    <td>{{$sub->admin_role}}</td>
                                    <td>{{$sub->branch_head_role}}</td>
                                    <td>{{$sub->submenu_aktif}}</td>
                                    <td>{{$sub->created_at}}</td>
                                    <td>{{$sub->created_by}}</td>
                                    <td>{{$sub->updated_at}}</td>
                                    <td>{{$sub->updated_by}}</td>
                                
                                </tr>
                                
            
                                @endforeach
                        
                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </div>
            @include('layouts.admin_views.footer')
        </div>
    </div>

    {{-- modal change status --}}

    @foreach($submenu as $sub) 
    <div class="modal fade" id="deleteSubMenu{{$sub->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$sub->id}}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel{{$sub->id}}">Hapus Data Menu Utama: {{$sub->menu_name}}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
    
                <form method="POST" action="{{route('submenu_delete', ['id' => $sub->id])}}">
                    @csrf
                    @method('DELETE')
                    <div style="color: black;" class="modal-body">
                        Apakah Anda ingin menghapus data menu:
                        <br>
                        {{$sub->submenu_name}} ?
                        <br>
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

    {{-- spinner --}}
    <div id="loadingSpinnerWrapper">
        <div class="spinner-border" role="status">
        </div>
    </div>
</body>
  
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

@if (Session::has('delete_success'))
<script>
    Swal.fire({
        title: 'Gagal',
        text: "{{ Session::get('delete_success') }}",
        icon: "error",
        toast:true,
        position : bottom-end,
        timer:6000,
        confirmButtonText: 'OK'
    });
</script>
    
@endif

 <!-- Page level plugins -->
 <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js')}}"></script>
 <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

 <!-- Page level custom scripts -->
 <script src="{{ asset('assets/js/demo/datatables-demo.js')}}"></script>
 

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
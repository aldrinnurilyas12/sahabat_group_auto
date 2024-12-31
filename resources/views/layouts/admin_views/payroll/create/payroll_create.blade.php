<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Tambah Data Kantor Cabang - SAHABAT GROUP AUTO ADMINISTRATOR</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Inter:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/form.css')}}">
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Inter:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
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
    
                <section id="info">
                    <div id="content">
                        
                        <h4 style="text-align:center;color:black;font-weight:bold;">Payroll Detail Karyawan</h4>
                        
                        <div style="display: flex; gap:50px;flex-wrap:wrap;" class="form-group-content">
                            
                            @foreach($payroll_detail as $payroll)
                        
                                <div style="display: flex; justify-content:center; gap:3rem;width:100%;" class="dflex-container">
                                    <div class="form_input">
                                        <div class="form-group">
                                            <label>NIK</label>
                                            <input type="text" class="form-control"  value="{{$payroll->nik}}" autocomplete="off" readonly placeholder="Masukan Nama Cabang">
                                        </div>
                                
                                        <div class="form-group">
                                            <label>Nama Karyawan</label>
                                            <input type="text" class="form-control" name="" value="{{$payroll->name}}" autocomplete="off" readonly placeholder="Masukan Nama Cabang">
                                        </div>

                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" class="form-control" name="" value="{{$payroll->email}}" autocomplete="off" readonly placeholder="Masukan Nama Cabang">
                                        </div>

                                        <div class="form-group">
                                            <label>Posisi Pekerjaan</label>
                                            <input type="text" class="form-control" name="address" value="{{$payroll->position_name}}" autocomplete="off" readonly placeholder="Masukan Alamat Cabang">
                                        </div>

                                        <div class="form-group">
                                            <label>Kantor</label>
                                            <input type="text" class="form-control" name="" value="{{$payroll->location_name}}" autocomplete="off" readonly placeholder="Masukan Nama Cabang">
                                        </div>

                                    </div>

                                    <div class="form_input">
                                        <div class="form-group">
                                            <label>Gaji Pokok</label>
                                            <input type="text" class="form-control"  value="{{"Rp.".number_format($payroll->salary)}}" autocomplete="off" readonly placeholder="Masukan Nama Cabang">
                                        </div>
                                
                                        <div class="form-group">
                                            <label>Tunjangan Transport</label>
                                            <input type="text" class="form-control" name="" value="{{"Rp.".number_format($payroll->tunjangan_transport)}}" autocomplete="off" readonly placeholder="Masukan Nama Cabang">
                                        </div>

                                        <div class="form-group">
                                            <label>Tunjangan Kesehatan</label>
                                            <input type="text" class="form-control" name="" value="{{"Rp.".number_format($payroll->tunjangan_kesehatan)}}" autocomplete="off" readonly placeholder="Masukan Nama Cabang">
                                        </div>

                                        <div class="form-group">
                                            <label>Tunjangan Lainnya</label>
                                            <input type="text" class="form-control" name="address" value="{{"Rp.".number_format($payroll->tunjangan_lainnya)}}" autocomplete="off" readonly placeholder="Masukan Alamat Cabang">
                                        </div>

                                        <div class="form-group">
                                            <label>Total Gaji</label>
                                            <input type="text" class="form-control" name="" value="{{"Rp.".number_format($payroll->salary_total)}}" autocomplete="off" readonly placeholder="Masukan Nama Cabang">
                                        </div>

                                    </div>
                                </div>

                        
                            
                            @endforeach


                        
                        </div>

                        
                    </div>
                </section>

                <section id="cart">
                    <div class="col-xl-12 col-lg-7">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Statistik Presensi Karyawan</h6>
                              
                                <div class="dropdown no-arrow">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                        aria-labelledby="dropdownMenuLink">
                                        <div class="dropdown-header">Dropdown Header:</div>
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                              <div id="revenueChart"></div>
                            </div>
                        </div>
                      </div>
                </section>

                
    
            </div>
           
            @include('layouts.admin_views.footer')

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

<script>
    window.addEventListener('load', function() {
       var loadingSpinnerWrapper = document.getElementById('loadingSpinnerWrapper');
   
       // Log elemen untuk memastikan spinner ditemukan
         // Cek apakah elemen ditemukan
   
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


//  analytics


fetch('/get_attendance/{id}')
    .then(response => response.json())
    .then(data => {
        var options = {
            series: [{
                name: "Statistik Presensi Karyawan",
                data: [
                    data.total_hadir[0] ?. total_hadir ||0,
                    data.total_izin[0] ?. total_izin ||0,
                    data.total_sakit[0] ?. total_sakit ||0

                ]
            }],
            chart: {
                height: 350,
                type: 'line',
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'straight' // Mengubah menjadi 'smooth' untuk tampilan yang lebih baik
            },
            title: {
                text: 'Statistik Presensi Karyawan',
                align: 'center'
            },
            grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'], // Mengatur warna baris
                    opacity: 0.5
                },
            },
            xaxis: {
                categories: data.attendance_type // Menggunakan daftar bulan dari server
            }
        };

        var chart = new ApexCharts(document.querySelector("#revenueChart"), options);
        chart.render();
    })
    .catch(error => console.error('Error fetching revenue data:', error)); // Menangani error


   </script>

</html>
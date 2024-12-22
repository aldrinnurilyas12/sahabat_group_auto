<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Analytics - SAHABAT GROUP AUTO ADMINISTRATOR</title>
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

                <div class="container-fluid">
                  <div class="row">
                    <div class="col-xl-2 col-md-6 mb-4">
                        <div style="background-image: linear-gradient(to right, #2da3e2, #4A00E0);color:white;" class="card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div style="color: white;" class="text-xs font-weight-bold text-uppercase mb-1">
                                            Total Unit Kendaraan</div>
                                        <div style="color: white;" class="h5 mb-0 font-weight-bold">{{$vehicle_total}}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="col-xl-2 col-md-6 mb-4">
                        <div style="background-image: linear-gradient(to right, #2da3e2, #4A00E0);color:white;" class="card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div style="color: white;" class="text-xs font-weight-bold text-uppercase mb-1">
                                            Total Brand/Merk</div>
                                        <div style="color: white;" class="h5 mb-0 font-weight-bold">{{$vehicle_brand}}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-xl-2 col-md-6 mb-4">
                        <div style="background-image: linear-gradient(to right, #2da3e2, #4A00E0);color:white;" class="card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div style="color: white;" class="text-xs font-weight-bold text-uppercase mb-1">
                                            Iklan Kendaraan</div>
                                        <div style="color: white;" class="h5 mb-0 font-weight-bold">{{$vehicle_ads}}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-md-6 mb-4">
                        <div style="background-image: linear-gradient(to right, #2da3e2, #4A00E0);color:white;" class="card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div style="color: white;" class="text-xs font-weight-bold text-uppercase mb-1">
                                            Appointment</div>
                                        <div style="color: white;" class="h5 mb-0 font-weight-bold">{{$appointment_total}}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-md-6 mb-4">
                        <div style="background-image: linear-gradient(to right, #2da3e2, #4A00E0);color:white;" class="card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div style="color: white;" class="text-xs font-weight-bold text-uppercase mb-1">
                                           Permintaan Pencarian Unit</div>
                                        <div style="color: white;" class="h5 mb-0 font-weight-bold">{{$unit_request}}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-md-6 mb-4">
                        <div style="background-image: linear-gradient(to right, #2da3e2, #4A00E0);color:white;" class="card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div style="color: white;" class="text-xs font-weight-bold text-uppercase mb-1">
                                            Permintaan Jual Unit</div>
                                        <div style="color: white;" class="h5 mb-0 font-weight-bold">{{$sale_unit_request}}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                    {{-- area charts --}}
                    <div class="row">
                        <div class="col-xl-12 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Revenue</h6>
                                  
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

                        <div class="col-xl-8 col-lg-7">
                          <div class="card shadow mb-4">
                              <!-- Card Header - Dropdown -->
                              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                  <h6 class="m-0 font-weight-bold text-primary">Unit Kendaraan Paling Banyak dilihat</h6>
                                
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
                                <div id="chart"></div>
                              </div>
                          </div>
                        </div>

                        <div class="col-xl-4 col-lg-5">
                          <div class="card shadow mb-4">
                              <!-- Card Header - Dropdown -->
                              <div
                                  class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                  <h6 class="m-0 font-weight-bold text-primary">Total unit By Brand/Merk</h6>
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
                                  <div class="chart-pie pt-4 pb-2">
                                      <div id="piechart"></div>
                                  </div>
                                  
                              </div>
                          </div>
                      </div>
                    </div>
                    {{-- end content --}}
                </div>
            </div>
           
            @include('layouts.admin_views.footer')
            

        </div>
        <!-- End of Content Wrapper -->
        @yield('content')

    </div>


    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <style>
        .col-sm-12{
            overflow-x: scroll;
        }

    </style>
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
    
    fetch('/get_clicked_data').then(response => response.json())
    .then(data => {
      var options = {
        chart : {
          type: 'bar'
        },
        series : [{
          name : 'Total Clicked Unit',
          data : data.total_vehicle_clicked
        }],
        xaxis :{
          categories: data.unit
        },
        theme : {
          mode: 'light',
          palette : 'palette6',
          monochrome : {
            enabled : false,
          }
        }
      };

      var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
    });



    fetch('/get_brand_total').then(response => response.json())
    .then(data => {
      var options = {
        chart : {
          type: 'pie',
          height : 500
        },
        series: data.brand_total,
        labels : data.brand_name,

        title: {
          text : 'Total Brand',
          align: 'center'
        },
        theme: {
          mode : 'light',
          palette : 'palette1',
          monochrome : {
            enabled:false,
          }
        }
        

      };

      var piechart = new ApexCharts(document.querySelector("#piechart"), options);
      piechart.render();
    });
    

</script>


    
</html>
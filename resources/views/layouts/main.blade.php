<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> 1Bonus - Dashboard</title>

    <!-- Custom fonts for this template-->
{{--    <link href="{{ asset("front/vendor/fontawesome-free/css/all.min.css")}}" rel="stylesheet" type="text/css">--}}
{{--    <link href="{{ asset("front/vendor/fontawesome-free/css/brands.min.css")}}" rel="stylesheet" type="text/css">--}}
{{--    <link href="{{ asset("front/vendor/fontawesome-free/css/fontawesome.min.css")}}" rel="stylesheet" type="text/css">--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/brands.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/fontawesome.min.css">
    <link href="{{ asset('front/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('front/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <script src="https://unpkg.com/imask"></script>
    @vite('resources/js/app.js')

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">


    @if(auth()->user())

        @if(auth()->user()->type == 'admin')
            <!-- Sidebar -->
            @include('layouts.navbars.sidebar')
             <!-- End of Sidebar -->
        @elseif(auth()->user()->type == 'partner')
            @include('layouts.navbars.sidebarPartner')
        @endif
    @endif
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            @if(auth()->user())
                <!-- Topbar -->
                @include('layouts.navbars.navbar')
                <!-- End of Topbar -->
            @endif
            <!-- Begin Page Content -->
            <div class="container-fluid">

                @yield('content')

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        @if(auth()->user())
        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; wash-car.kz {{ now()->year }}</span>
                </div>
            </div>
        </footer>
        @endif
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

{{--<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>--}}


<!-- Bootstrap core JavaScript-->
<script src="{{ asset('front/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{ asset('front/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('front/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('front/js/sb-admin-2.min.js')}}"></script>


@if ((request()->route()->getName() == 'admin.index'))
    <!-- DASHBOARD ONLY -->
    <script src="{{ asset('front/vendor/chart.js/Chart.min.js')}}"></script>

    <script src="{{ asset('front/js/demo/chart-area-demo.js')}}"></script>
    <script src="{{ asset('front/js/demo/chart-pie-demo.js')}}"></script>
@endif
@if(request()->route()->getName() == 'partner.index')

    <!-- DASHBOARD ONLY -->
    <script src="{{ asset('front/vendor/chart.js/Chart.min.js')}}"></script>

    <script src="{{ asset('front/js/demo/chart-area-demo.js')}}"></script>
    <script src="{{ asset('front/js/demo/chart-pie-demo.js')}}"></script>
    <!-- END DASHBOARD -->
@endif

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

{{--<script src="https://unpkg.com/imask"></script>--}}
<script src="https://api-maps.yandex.ru/2.1/?apikey=7bce743f-5a51-4f12-b3bb-bd104982f84c&lang=ru_RU" type="text/javascript"></script>
<!-- DATATABLES -->
<script src="{{ asset("front/vendor/datatables/jquery.dataTables.min.js")}}"></script>
<script src="{{ asset('front/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

<script src="{{ asset('front/js/demo/datatables-demo.js')}}"></script>
<!-- END DATATABLES -->

@yield('js')
<script>

    // let phoneMask = IMask(
    //     document.getElementById('register=phone'), {
    //         mask: '{7}0000000000'
    //     });

</script>
</body>

</html>

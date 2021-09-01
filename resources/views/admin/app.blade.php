<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cymatrax | Admin</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('/assets/admin/')}}/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
          href="{{asset('/assets/admin/')}}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('/assets/admin/')}}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{asset('/assets/admin/')}}/plugins/jqvmap/jqvmap.min.css">

    <link rel="stylesheet" href="{{asset('/assets/admin/')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('/assets/admin/')}}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

    <link rel="stylesheet"
          href="{{asset('/assets/admin/')}}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('/assets/admin/')}}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->

    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('/assets/admin/')}}/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('/assets/admin/')}}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('/assets/admin/')}}/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('/assets/admin/')}}/plugins/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" href="{{asset('/assets/admin/')}}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet"
          href="{{asset('/assets/admin/')}}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <script>
        var APP_URL = '{{URL::to("/")}}';
        var CSRF_TOKEN = '{{csrf_token()}}'
    </script>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{URL::to('/')}}/admin/dashboard" class="nav-link">Home</a>
            </li>

        </ul>


        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Messages Dropdown Menu -->
            <li class="nav-item">
                <a class="nav-link" href="{{URL::to('/')}}/admin/logout" role="button">
                    Logout
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{URL::to('/')}}/admin/dashboard" class="brand-link">
            <img src="{{asset('/assets/')}}/images/logo.png" alt="Cymatrax Admin Logo"
                 class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Cymatrax Admin</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{asset('/assets/admin/')}}/dist/img/default.png" class="img-circle elevation-2"
                         alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{Auth::guard('admin')->user()->name}}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item menu-open">
                        <a href="{{URL::to('/admin/')}}/dashboard"
                           class="nav-link @if(Request::segment(2) == "dashboard") active @endif">
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    @if(checkRoleFeature('free-subscription'))
                        <li class="nav-item menu-open">
                            <a href="{{URL::to('/admin/')}}/free-subscription"
                               class="nav-link  @if(Request::segment(2) == "free-subscription") active @endif">
                                <p>
                                    Free Subscription
                                </p>
                            </a>
                        </li>
                    @endif
                    @if(checkRoleFeature('file-delete-setting'))
                        <li class="nav-item menu-open">
                            <a href="{{URL::to('/admin/')}}/file-delete-setting"
                               class="nav-link  @if(Request::segment(2) == "file-delete-setting") active @endif">
                                <p>
                                    File Setting
                                </p>
                            </a>
                        </li>
                    @endif
                    @if(checkRoleFeature('users'))
                        <li class="nav-item menu-open">
                            <a href="{{URL::to('/admin/')}}/users"
                               class="nav-link  @if(Request::segment(2) == "users" || Request::segment(2) == "user-files") active @endif">
                                <p>
                                    Users
                                </p>
                            </a>
                        </li>
                    @endif
                    @if(checkRoleFeature('admins'))
                        <li class="nav-item menu-open">
                            <a href="{{URL::to('/admin/')}}/admins"
                               class="nav-link  @if(Request::segment(2) == "admins") active @endif">
                                <p>
                                    Admins
                                </p>
                            </a>
                        </li>
                    @endif
                    @if(checkRoleFeature('roles'))
                        <li class="nav-item menu-open">
                            <a href="{{URL::to('/admin/')}}/roles"
                               class="nav-link  @if(Request::segment(2) == "roles") active @endif">
                                <p>
                                    Roles
                                </p>
                            </a>
                        </li>
                    @endif
                   @if(checkRoleFeature('reports'))
                        <li class="nav-item menu-open">
                            <a href="{{URL::to('/admin/')}}/reports"
                               class="nav-link  @if(Request::segment(2) == "reports") active @endif">
                                <p>
                                    Reports
                                </p>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
@yield('content')
<!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2021 <a href="javascript:void(0)">Cymatrax Admin</a>.</strong>
        All rights reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('/assets/admin/')}}/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('/assets/admin/')}}/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('/assets/admin/')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="{{asset('/assets/admin/')}}/plugins/select2/js/select2.full.min.js"></script>

<!-- ChartJS -->
{{--<script src="{{asset('/assets/admin/')}}/plugins/chart.js/Chart.min.js"></script>--}}
<!-- Sparkline -->
{{--<script src="{{asset('/assets/admin/')}}/plugins/sparklines/sparkline.js"></script>--}}
<!-- JQVMap -->
{{--<script src="{{asset('/assets/admin/')}}/plugins/jqvmap/jquery.vmap.min.js"></script>--}}
{{--<script src="{{asset('/assets/admin/')}}/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>--}}
<!-- jQuery Knob Chart -->
{{--<script src="{{asset('/assets/admin/')}}/plugins/jquery-knob/jquery.knob.min.js"></script>--}}
<!-- daterangepicker -->
<script src="{{asset('/assets/admin/')}}/plugins/moment/moment.min.js"></script>
<script src="{{asset('/assets/admin/')}}/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script
    src="{{asset('/assets/admin/')}}/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="{{asset('/assets/admin/')}}/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="{{asset('/assets/admin/')}}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="{{asset('/assets/admin/')}}/plugins/sweetalert2/sweetalert2.min.js"></script>

<script src="{{asset('/assets/admin/')}}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{asset('/assets/admin/')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{asset('/assets/admin/')}}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{asset('/assets/admin/')}}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{asset('/assets/admin/')}}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{asset('/assets/admin/')}}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>

<script src="{{asset('/assets/admin/')}}/plugins/jszip/jszip.min.js"></script>
<script src="{{asset('/assets/admin/')}}/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{asset('/assets/admin/')}}/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{asset('/assets/admin/')}}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{asset('/assets/admin/')}}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{asset('/assets/admin/')}}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>


<!-- AdminLTE App -->
<script src="{{asset('/assets/admin/')}}/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('/assets/admin/')}}/dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{--<script src="{{asset('/assets/admin/')}}/dist/js/pages/dashboard.js"></script>--}}
<script src="{{asset('/assets/admin/')}}/dist/js/custom.js"></script>

<script>
    @if(session()->has('error'))
    Swal.fire({
        title: 'Error',
        text: '{{session('error')}}',
        icon: 'error',
        showCancelButton: false,
    });
    @endif

    @if(session()->has('success'))
    Swal.fire({
        title: 'Success',
        text: '{{session('success')}}',
        icon: 'success',
        showCancelButton: false,
    });
    @endif

    $("#example1").DataTable({

         // "responsive": true,
        "lengthChange": false,
        "autoWidth": true,
        "scrollX": true,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    $(document).ready(function () {
        $('.select2').select2({
            dropdownParent: $('#update-role-modal')
        });
        $('.select2bs4').select2({
            theme: 'bootstrap4',
            dropdownParent: $('#update-role-modal')

        })
    });

</script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cymatrax | Admin</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('/assets/admin/')}}/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{asset('/assets/admin/')}}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('/assets/admin/')}}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{asset('/assets/admin/')}}/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('/assets/admin/')}}/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('/assets/admin/')}}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('/assets/admin/')}}/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('/assets/admin/')}}/plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <div class="col-md-4 offset-4">
    <img class="mr-auto ml-auto d-block" src="{{URL::to('/')}}/assets/images/logo.banner.png" class="logo-banner"/>
    </div>
      <div class="card card-info col-md-4 offset-4 pl-0 pr-0">
          <div class="card-header">
              <h3 class="card-title">Admin Login</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form class="form-horizontal" method="post" action="{{URL::to('/')}}/admin/login">
              @csrf
              <div class="card-body">
                  <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-3 col-form-label">Email</label>
                      <div class="col-sm-9">
                          <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label for="inputPassword3" class="col-sm-3 col-form-label">Password</label>
                      <div class="col-sm-9">
                          <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                      </div>
                  </div>
{{--                  <div class="form-group row">--}}
{{--                      <div class="offset-sm-3 col-sm-9">--}}
{{--                          <div class="form-check">--}}
{{--                              <input type="checkbox" class="form-check-input" id="exampleCheck2">--}}
{{--                              <label class="form-check-label" for="exampleCheck2">Remember me</label>--}}
{{--                          </div>--}}
{{--                      </div>--}}
{{--                  </div>--}}
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <button type="submit" class="btn btn-info">Sign in</button>
              </div>
              <!-- /.card-footer -->
          </form>
      </div>

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
<!-- ChartJS -->
<script src="{{asset('/assets/admin/')}}/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="{{asset('/assets/admin/')}}/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="{{asset('/assets/admin/')}}/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="{{asset('/assets/admin/')}}/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('/assets/admin/')}}/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="{{asset('/assets/admin/')}}/plugins/moment/moment.min.js"></script>
<script src="{{asset('/assets/admin/')}}/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('/assets/admin/')}}/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="{{asset('/assets/admin/')}}/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="{{asset('/assets/admin/')}}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<!-- AdminLTE App -->
<script src="{{asset('/assets/admin/')}}/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('/assets/admin/')}}/dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('/assets/admin/')}}/dist/js/pages/dashboard.js"></script>

<script>
    @if(session()->has('error'))
    Swal.fire({
        title: 'Error',
        text: 'Invalid Credentials',
        icon: 'error',
        showCancelButton: false,
    });
    @endif
    @if(session()->has('success'))
    Swal.fire({
        title: 'Success',
        text: '{{session()->has('success')}}',
        icon: 'success',
        showCancelButton: false,
    });
    @endif
</script>
</body>
</html>

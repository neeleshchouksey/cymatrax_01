@extends('admin.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        {{--                        <h1 class="m-0">Users</h1>--}}
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{URL::to('/')}}/admin/dashboard">Home</a></li>
                            <li class="breadcrumb-item active">Admins</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <h3>You don't have rights to access this page</h3>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>

@endsection

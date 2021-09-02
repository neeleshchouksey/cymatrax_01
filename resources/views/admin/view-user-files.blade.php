@extends('admin.app')
<style>
    #user-files-dt_filter{
        margin-top:1.5rem;!important;
    }
</style>
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
                            <li class="breadcrumb-item active">User Files</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">User Files</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="float-right">
                                    <tbody>
                                    <tr>
                                        <td>Filter by created at:</td>
                                        <td><input class="form-control" type="text" id="fromDate" name="fromDate"></td>
                                        <td><button class="btn btn-primary" onclick="clear_filter()">Clear</button></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table id="user-files-dt" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Name</th>
                                        <th>File Name</th>
                                        <th>Created</th>
                                        <th>Cleaned</th>
                                        <th>Duration</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>S. No.</th>
                                        <th>Name</th>
                                        <th>File Name</th>
                                        <th>Created</th>
                                        <th>Cleaned</th>
                                        <th>Duration</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
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

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
                            <li class="breadcrumb-item active">Users</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Files List</h3>
                                <table class="float-right w-50">
                                    <tbody>
                                    <tr>
                                        <td class="w-25" class="float-left">Delete Files:</td>
                                        <td class="" class="float-left"><input class="form-control w-90" type="text" id="deleteUserFromDate" name="deleteUserFromDate"></td>
                                        <td class="float-right"><button class="btn btn-primary" onclick="deleteFileByDate()">Delete</button></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="file-datatable" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>S. No.</th>
                                        <th>Name</th>
                                        <th>File Name</th>
                                        <th>Created At</th>
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
                                        <th>Created At</th>
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

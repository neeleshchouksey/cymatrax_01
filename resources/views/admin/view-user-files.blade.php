@extends('admin.app')
<style>
    #user-files-dt_filter{
        margin-top:1.5rem;!important;
    }
    .dataTables_empty{
        display: none!important;
    }
    .w-90{
        width: 90%!important;
    }
    .w-10{
        width: 10%!important;
    }
    .w-15{
        width: 15%!important;
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
{{--                                <div class="float-left"><button class="btn btn-secondary" onclick="htmlToCSV()">Export</button></div>--}}

                                <table class="float-right w-75">
                                    <tbody>
                                    <tr>
                                        <td class="w-25"><input type="text" class="form-control w-90" onkeyup="view_user_files()" id="keyword" placeholder="Search"></td>
                                        <td class="w-25"><select class="form-control w-90" id="filter-by" onchange="view_user_files()"><option value="">All</option><option value="1">Cleaned</option><option value="0">Uncleaned</option></select> </td>
                                        <td class="w-10">Created at:</td>
                                        <td class="w-25" class="float-left"><input class="form-control w-90" type="text" id="fromDate" name="fromDate"></td>
                                        <td class="float-right"><button class="btn btn-primary" onclick="clear_filter()">Clear</button></td>
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
                                    <tbody id="files-body">

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
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

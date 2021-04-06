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
                                <h3 class="card-title">Users List</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>S. No.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Country</th>
                                        <th>Zip Code</th>
                                        <th>Trial Expiry</th>
                                        <th>Total Uploaded File(s)</th>
                                        <th>Total Cleaned File(s)</th>
                                        <th>Total Paid File(s)</th>
                                        <th>Last Login</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $k=>$v)
                                        <tr>
                                            <td>{{$k+1}}</td>
                                            <td>{{$v->name}}</td>
                                            <td>{{$v->email}}</td>
                                            <td>{{$v->address}}</td>
                                            <td>{{$v->city}}</td>
                                            <td>{{$v->state}}</td>
                                            <td>{{$v->country}}</td>
                                            <td>{{$v->zip_code}}</td>
                                            <td>@if($v->trial_expiry_date){{date("d-m-Y",$v->trial_expiry_date)}}@else Trial Not Started @endif</td>
                                            <td>{{$v->uploaded_files_count}}</td>
                                            <td>{{$v->cleaned_files_count}}</td>
                                            <td>{{$v->paid_files_count}}</td>
                                            <td>@if($v->last_login_at){{date("d-m-Y h:i A",$v->last_login_at)}} @else Not login yet @endif</td>
                                            <td>
                                                @if(!$v->deleted_at)
                                                    <button class="btn-sm btn-danger mb-1" onclick="activateDeactivateUser({{$v->id}},0)"><i class="fa fa-trash"></i>
                                                        Deactivate
                                                    </button><br>
                                                @else
                                                    <button class="btn-sm btn-success mb-1" onclick="activateDeactivateUser({{$v->id}},1)"><i class="fa fa-check"></i>
                                                        Activate
                                                    </button><br>
                                                @endif
                                                <button class="btn-sm btn-primary" onclick="resetTrial({{$v->id}})"><i class="fa fa-sync"></i> Reset
                                                    Trial
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>S. No.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Country</th>
                                        <th>Zip Code</th>
                                        <th>Trial Expiry</th>
                                        <th>Total Uploaded File(s)</th>
                                        <th>Total Cleaned File(s)</th>
                                        <th>Total Paid File(s)</th>
                                        <th>Last Login</th>
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

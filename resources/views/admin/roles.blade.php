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
                            <li class="breadcrumb-item active">Roles</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Role List</h3>

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>S. No.</th>
                                        <th>Role</th>
                                        <th>Action </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($roles as $k=>$v)
                                        <tr>
                                            <td>{{$k+1}}</td>
                                            <td>{{$v->role}}</td>
                                            <td>
                                                @if(!$v->deleted_at)
                                                    <button class="btn-sm btn-primary"
                                                            onclick="getSingleRole({{$v->id}})"><i
                                                            class="fa fa-user-edit"></i> Edit
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>S. No.</th>
                                        <th>Name</th>
                                        <th>Email</th>
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

    <div class="modal fade" id="update-role-modal" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <input type="hidden" id="edit_id" name="edit_id"/>
                        <label for="edit_name" class="col-sm-3 col-form-label">Role</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_role" name="edit_role"
                                   placeholder="Role">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="edit_role" class="col-sm-3 col-form-label">Features</label>
                        <div class="col-sm-9">
                            <select name="edit_feature" id="edit_features" class="form-control select2bs4" multiple>

                            </select>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateRole()">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection

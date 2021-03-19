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
                            <div class="card-header">
                                <h3 class="card-title">Admins List</h3>
                                <button class="btn btn-primary float-right" data-toggle="modal"
                                        data-target="#add-admin-modal">Add New
                                </button>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>S. No.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($admins as $k=>$v)
                                        <tr>
                                            <td>{{$k+1}}</td>
                                            <td>{{$v->name}}</td>
                                            <td>{{$v->email}}</td>
                                            <td>
                                                @if(!$v->deleted_at)
                                                    <button class="btn-sm btn-danger mb-1"
                                                            onclick="activateDeactivateAdmin({{$v->id}},0)"><i
                                                            class="fa fa-trash"></i>
                                                        Deactivate
                                                    </button>
                                                @else
                                                    <button class="btn-sm btn-success mb-1"
                                                            onclick="activateDeactivateAdmin({{$v->id}},1)"><i
                                                            class="fa fa-check"></i>
                                                        Activate
                                                    </button>
                                                @endif
                                                @if(!$v->deleted_at)
                                                    <button class="btn-sm btn-primary"
                                                            onclick="getSingleAdmin({{$v->id}})"><i
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

    <div class="modal fade" id="add-admin-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Admin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="email" name="email"
                                   placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="role" class="col-sm-3 col-form-label">Role</label>
                        <div class="col-sm-9">
                            <select name="role" id="role" class="form-control">
                                @foreach($roles as $r)
                                    <option value="{{$r->id}}">{{$r->role}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addAdmin()">Save</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="update-admin-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Admin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <input type="hidden" id="edit_id" name="edit_id"/>
                        <label for="edit_name" class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_name" name="edit_name"
                                   placeholder="Name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="edit_email" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_email" name="edit_email"
                                   placeholder="Email" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="edit_password" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="edit_password" name="edit_password"
                                   placeholder="Enter to Change Password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="edit_role" class="col-sm-3 col-form-label">Role</label>
                        <div class="col-sm-9">
                            <select name="edit_role" id="edit_role" class="form-control">
                                @foreach($roles as $r)
                                    <option value="{{$r->id}}">{{$r->role}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateAdmin()">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection

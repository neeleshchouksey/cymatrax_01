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
                            <li class="breadcrumb-item active">Plan & Subscription</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Plan List</h3>

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="plan-datatable" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>S. No.</th>
                                        <th>Plan </th>
                                        <th>Charges</th>
                                        <th>Files</th>
                                        <th>Text 1</th>
                                        <th>Text 2</th>
                                        <th>Text 3</th>
                                        <th>Action </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>S. No.</th>
                                        <th>Plan Name</th>
                                        <th>Charges</th>
                                        <th>No of clean files</th>
                                        <th>Text 1</th>
                                        <th>Text 2</th>
                                        <th>Text 3</th>
                                        <th>Action </th>
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

    <div class="modal fade" id="update-plan-modal" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Plan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <input type="hidden" id="edit_id" name="edit_id"/>
                        <label for="edit_name" class="col-sm-3 col-form-label">Plan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_name" name="edit_name"
                                   placeholder="Plan">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="edit_charges" class="col-sm-3 col-form-label">Charges</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_charges" name="edit_charges"
                                   placeholder="Charges">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="edit_no_of_clean_file" class="col-sm-3 col-form-label">No of clean files</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_no_of_clean_file" name="edit_no_of_clean_file"
                                   placeholder="No of clean files">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="text_1" class="col-sm-3 col-form-label">Text 1</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_text_1" name="edit_text_1"
                                   placeholder="Text 1">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="text_2" class="col-sm-3 col-form-label">Text 2</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_text_2" name="edit_text_2"
                                   placeholder="Text 2">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="text_3" class="col-sm-3 col-form-label">Text 3</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_text_3" name="edit_text_3"
                                   placeholder="Text 3">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updatePlan()">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection

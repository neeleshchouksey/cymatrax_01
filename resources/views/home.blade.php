@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Upload files from here</div>
                    <div class="card-body">
                        <div class="card-title text-center text-white card-style">
                            Audio Conversion Tool
                        </div>
                        <form id="dropzoneForm" enctype="multipart/form-data" class="dropzone"
                              action="{{ route('file.upload') }}">
                            @csrf

                        </form>

                        <div align="center">
                            <br>
                            <button type="button" class="btn btn-info" id="submit-all">Upload</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


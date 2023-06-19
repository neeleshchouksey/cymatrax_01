@extends('layouts.app')
<style>
    table, td, th {
        border: 1px solid rgba(0, 0, 0, 0.3);
        padding: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        border-bottom: 1.5px solid rgba(0, 0, 0, 0.3);
    }
</style>
@section('content')
    <section class="contained">
        <h1 class="myaccount">{{$title}}</h1>
        <div class="tool">
            <h3>Audio Conversion Tool</h3>
            <p>$<?php echo "1" ?> per minute</p>
            <form id="dropzoneForm" enctype="multipart/form-data" class="dropzone"
                  action="{{ route('file.upload') }}">
                @csrf
                <div class="dz-default dz-message">
{{--                    <img src="{{URL::to('/')}}/assets/images/upload.png" class="logo-banner"/>--}}
                    <img width="50px" height="50px" src="{{URL::to('/')}}/assets/images/upload-icon.png" class="logo-banner"/>
                    <br>
                    Drag and Drop files here
                    <br><br>
                            or
                    <button class="drop-btn" type="button">Browse Files</button>
                    <button class="dz-button" type="button"></button>
                </div>
            </form>
            <div style="display: inline-flex">
                
            <button type="button" class="c-btn" style="margin-right: 2rem" id="submit-all">Upload</button>
                
                <p> *Only mp3 and wav files can be processed, up to 15 files no larger than 600MB may be uploaded at once. For more info
                <a href="javascript:void(0)" id="myBtn">Click Here</a>, page</p>
              
            </div>
            <div> <p> * All files will be kept for {{ $val}} days  </p>  </div>
        </div>
    </section>

    <!-- The Modal -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Guidance on max allowed to upload at once</p>
            <table>
                <tr style="text-align: left"><th>Files to upload</th><th>File Size</th></tr>
                <tr><td><15</td><td>< 40MB</td></tr>
                <tr><td><10</td><td>< 60MB</td></tr>
            </table>
        </div>

    </div>
@endsection


@extends('layouts.app')
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
            <button type="button" class="c-btn" id="submit-all">Upload</button>
        </div>
    </section>
@endsection


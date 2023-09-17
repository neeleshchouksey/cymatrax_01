@extends('layouts.app')

@section('content')

    <section class="contained">
        <h1 class="myaccount">{{$title}}</h1>

        <div class="wave-div">
            <h5>Input Audio Analysis</h5>
            <h6>File Name: <span class="font-weight-normal">{{$file->file_name}}</span></h6>
{{--            <h6>File Size: <span class="font-weight-normal">{{convertToReadableSize(filesize(public_path().'/upload/'.$file->file_name))}}</span></h6>--}}
            <h6>File Size: <span class="font-weight-normal">{{$size}}</span></h6>
            <div id="input-waveform"></div>
            <button id="play-btn" class="wave-btn">
                Play
            </button>
            <button id="pause-btn" class="wave-btn">
                Pause
            </button>
            <button class="wave-btn"
                    onclick="window.location='{{URL::to('/')}}/download-file/{{$file->file_name}}'">Download File
            </button>

            <h5>Output Audio Analysis</h5>
            <h6>File Name: <span class="font-weight-normal">{{$file->processed_file}}</span></h6>
{{--            <h6>File Size: <span class="font-weight-normal">{{convertToReadableSize(filesize(public_path().'/upload/'.$file->processed_file))}}</span></h6>--}}
            <h6>File Size: <span class="font-weight-normal">{{$psize}}</span></h6>

            <div id="output-waveform"></div>
            <button id="play-btn1" class="wave-btn">
                Play
            </button>
            <button id="pause-btn1" class="wave-btn">
                Pause
            </button>
            <button class="wave-btn"
                    onclick="window.location='{{URL::to('/')}}/download-file/{{$file->processed_file}}'">Download
                File
            </button>
        </div>

    </section>



@endsection



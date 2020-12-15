@extends('layouts.app')

@section('content')

    <section class="contained">
        @include('layouts/menu')

        <div class="wave-div">
            <h5>Input Audio Analysis</h5>
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



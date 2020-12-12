@extends('layouts.app')

@section('content')

    <section>
        @include('layouts/menu')
        <div class="relative">
            <h4>Thank you for your purchase {{Auth::user()->name}}</h4>
            <a class="btn" href="{{ asset('public/upload/'.$file->processed_file) }}"
               download>Download File</a>
        </div>

        <div class="wave-div">
        <h5>Input Audio Analysis</h5>
        <div id="input-waveform"></div>
            <button id="play-btn" class="wave-btn">
                Play
            </button>
            <button id="pause-btn" class="wave-btn">
                Pause
            </button>
        <h5>Output Audio Analysis</h5>
        <div id="output-waveform"></div>
        <button id="play-btn1" class="wave-btn">
            Play
        </button>
        <button id="pause-btn1" class="wave-btn">
           Pause
        </button>
        </div>

    </section>



@endsection



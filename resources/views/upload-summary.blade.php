@extends('layouts.app')

@section('content')

    <section class="contained">
        <h1 class="myaccount">{{$title}}</h1>
        <div class="checkouttotal">
                @foreach($getData as $key=>$item)
                <div class="tr-border">
                    <div class="row">
                        <div>
                            <b>Upload Date:</b>
                            <span>{{ Carbon\Carbon::parse($item->created_at)->format('d-M-Y, H: i A') }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div>
                            <b>File Name:</b>
                            @if(!$item->cleaned)
                                <span>{{$item->file_name}}</span>
                            @else
                                <span>{{$item->processed_file}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div>
                            <b> File duration :</b>
                            <span id="duration{{$key}}"></span>
                            <button style="visibility:hidden;" type="button" onclick="getDuration({{$key}})"
                                    class="getdur">Get Duration
                            </button>
                            <span id="ids{{$key}}"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div>
                            <input type="hidden" id="duration_in_sec{{$key}}" class="durValue"/>
                            <audio id="audio{{$key}}" controls="" style="vertical-align: middle"
                                   src="{{ asset('public/upload/'.$item->file_name) }}" type="audio/mp3"
                                   controlslist="nodownload">
                                Your browser does not support the audio element.
                            </audio>
                        </div>
                    </div>
                </div>

                @endforeach

            <div class="row">
            <b>Total duration = <span id="total-duration"></span></b> <br>
            <b>Total Cost =  <span id="total-cost"></span>($1 per minute)  </b>
            </div>
            <button class="c-btn"  onclick="document.location = '{{URL::to('/')}}/checkout/{{$id}}'" style="margin-top: 1rem">Proceed to Checkout</button>

        </div>
    </section>



@endsection




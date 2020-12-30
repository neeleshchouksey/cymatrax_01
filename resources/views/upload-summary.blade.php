@extends('layouts.app')

@section('content')

    <section class="contained">
        <h1 class="myaccount">{{$title}}</h1>
        <div class="checkouttotal">
            <table class="tr-table">
                <tbody>
                @foreach($getData as $key=>$item)
                    <tr>
                        <td>
                            <p>
                                <b> Upload Date:</b>
                                <span> {{ Carbon\Carbon::parse($item->created_at)->format('d-M-Y, H: i A') }}</span>
                            </p>
                            <p>
                                @if(!$item->cleaned)
                                    <b>File Name:</b>
                                    <span>{{$item->file_name}}</span>
                                @else
                                    <b>File Name: </b>
                                    <span>{{$item->processed_file}}</span>
                                @endif
                            </p>
                            <p>
                                <b> File duration :</b>
                                <span id="duration{{$key}}" ></span>
                                <button style="visibility:hidden;" type="button" onclick="getDuration({{$key}})" class="getdur">Get Duration</button>
                                <span id="ids{{$key}}" ></span>
                            </p>
                            <p>
                                <input type="hidden" id="duration_in_sec{{$key}}" class="durValue"/>
                                <audio id="audio{{$key}}" controls="" style="vertical-align: middle; width: 40%!important;"
                                       src="{{ asset('public/upload/'.$item->file_name) }}" type="audio/mp3"
                                       controlslist="nodownload">
                                    Your browser does not support the audio element.
                                </audio>
                            </p>
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>

            <b>Total duration = <span id="total-duration"></span></b> <br>
            <b>Total Cost =  <span id="total-cost"></span> </b>
            <b>($1 per minute) </b><br><br><br>

            <button class="c-btn"  onclick="document.location = '{{URL::to('/')}}/checkout/{{$id}}'" style="margin-top: 1rem">Proceed to Checkout</button>

        </div>
    </section>



@endsection




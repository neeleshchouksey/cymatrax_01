@extends('layouts.app')

@section('content')

    <section class="contained">
        @include('layouts/menu')
        <div class="checkouttotal">
            <table class="tr-table">
                <tbody>
                @foreach($getData as $key=>$item)
                    <tr>
                        <td>
                            <audio  id="audio{{$key}}" controls="" style="vertical-align: middle" src="{{ asset('public/upload/'.$item->file_name) }}" type="audio/mp3" controlslist="nodownload">
                                Your browser does not support the audio element.
                            </audio>
                            <input type="hidden" id="duration_in_sec{{$key}}" class="durValue"/>
                        </td>

                        <td>
                            <b> File Duration : <span id="duration{{$key}}" ></span> </b>
                            <button style="visibility:hidden;" type="button" onclick="getDuration({{$key}})" class="getdur">Get Duration</button>
                            <span id="ids{{$key}}" ></span>
                        </td>
                        <td>
                            <b> File Name : <span>{{$item->file_name}}</span> </b>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <b>Total duration = <span id="total-duration"></span></b> <br>
            <b>Total Cost =  <span id="total-cost"></span> </b>
            <b>($1 per minute) </b><br><br><br>

            <a href="{{URL::to('/')}}/checkout/{{$id}}" style="margin-top: 1rem">Proceed to Checkout</a>

        </div>
    </section>



@endsection




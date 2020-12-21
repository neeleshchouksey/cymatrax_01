@extends('layouts.app')

@section('content')

    <div class="content">
        @include('layouts/menu')

        <section class="contained">
            <div class="relative">
                <h3>Transaction Details</h3>

                <table class="tr-table">
                    <tbody>
                    @foreach($getData as $key=>$item)
                        <tr>
                            <td>
                                <audio  id="audio{{$key}}" controls="" style="vertical-align: middle" src="{{ asset('public/upload/'.$item->processed_file) }}" type="audio/mp3" controlslist="nodownload">
                                    Your browser does not support the audio element.
                                </audio>
                                <input type="hidden" id="duration_in_sec{{$key}}" class="durValue"/>
                                <b> File duration : <span id="duration{{$key}}" ></span> </b>
                                <button style="visibility:hidden;" type="button" onclick="getDuration({{$key}})" class="getdur">Get Duration</button>
                                <span id="ids{{$key}}" ></span>
                            </td>
                            <td>
                                <b> File Name : <span>{{$item->processed_file}}</span> </b>

                            </td>
                            <td>
                                <button class="wave-btn" onclick="window.location='{{URL::to('/')}}/download-file/{{$item->processed_file}}'">Download File</button>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <b>Total duration = <span id="total-duration"></span></b> <br>
                <b>Total Cost = <span id="total-cost"></span> </b><br>
                <b>($1 per minute) </b>

            </div>
        </section>
    </div>




@endsection




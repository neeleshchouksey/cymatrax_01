@extends('layouts.app')

@section('content')

    <section class="contained">
        <h1 class="myaccount">{{$title}}</h1>
        <div class="checkouttotal">
            @if(count($getData))
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
                                <audio id="audio{{$key}}" controls="" style="vertical-align: middle"
                                       src="{{ asset('public/upload/'.$item->file_name) }}" type="audio/mp3"
                                       controlslist="nodownload">
                                    Your browser does not support the audio element.
                                </audio>
                            </p>
                        </td>

                        <td colspan="2">
                            @if(!$item->cleaned)

                                <a class="btn btn-success" href="{{URL::to('/')}}/download-file/{{$item->file_name}}"
                                   download>Download</a>
                            @else
                                <a class="btn btn-success"
                                   href="{{URL::to('/')}}/download-file/{{$item->processed_file}}"
                                   download>Download</a>
                            @endif

                            @if(!$item->cleaned)
                                <a href="{{URL::to('/')}}/checkout-single/{{$item->id}}" class="btn btn-sucess">Pay &
                                    Checkout</a>
                            @else
                                <a href="{{URL::to('/')}}/audio-analysis/{{$item->id}}" class="btn btn-sucess">Audio
                                    Analysis</a>
                            @endif
                        </td>

                    </tr>

                @endforeach
                </tbody>
            </table>
            @else
            <h4>No Data Found</h4>
            @endif
        </div>
    </section>

@endsection


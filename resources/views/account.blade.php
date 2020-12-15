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
                            <b> Upload Date:</b>
                            <p> {{ Carbon\Carbon::parse($item->created_at)->format('d-M-Y, H: i A') }}</p>
                        </td>
                        <td>
                            <audio id="audio{{$key}}" controls="" style="vertical-align: middle"
                                   src="{{ asset('public/upload/'.$item->file_name) }}" type="audio/mp3"
                                   controlslist="nodownload">
                                Your browser does not support the audio element.
                            </audio>
                        </td>
                        <td>
                            @if(!$item->cleaned)
                                <b>File Name:</b>
                                <p>{{$item->file_name}}</p>
                            @else
                                <b>File Name: </b>
                                <p>{{$item->processed_file}}</p>
                            @endif
                        </td>
                        <td>
                            @if(!$item->cleaned)

                            <a class="btn btn-success" href="{{URL::to('/')}}/download-file/{{$item->file_name}}"
                               download>Download</a>
                            @else
                                <a class="btn btn-success" href="{{URL::to('/')}}/download-file/{{$item->processed_file}}"
                                   download>Download</a>
                            @endif
                        </td>
                        <td>
                            @if(!$item->cleaned)
                                <a href="{{URL::to('/')}}/checkout-single/{{$item->id}}" class="btn btn-sucess">Pay &
                                    Checkout</a>
                            @else
                                <a href="{{URL::to('/')}}/audio-analysis/{{$item->id}}" class="btn btn-sucess">Audio Analysis</a>
                            @endif
                        </td>

                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>
    </section>

@endsection


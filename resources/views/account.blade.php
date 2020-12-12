@extends('layouts.app')

@section('content')

    <section>
        @include('layouts/menu')
        <div class="checkouttotal">
            <table>
                <tbody>
                @foreach($getData as $key=>$item)
                    <tr>
                        <td>
                            <b> Upload Time:</b>
                            <p> {{ Carbon\Carbon::parse($item->created_at)->format('d-M-Y, H: i A') }}</p>
                        </td>
                        <td>
                            <audio id="audio{{$key}}" controls="" style="vertical-align: middle"
                                   src="{{ asset('public/upload/'.$item->file_name) }}" type="audio/mp3"
                                   controlslist="nodownload">
                                Your browser does not support the audio element.
                            </audio>
                        </td>
{{--                        <td>--}}

{{--                            <input type="hidden" id="duration_in_sec{{$key}}" class="durValue"/>--}}
{{--                            <b> File duration = <span id="duration{{$key}}"></span> </b>--}}
{{--                            <button style="visibility:hidden;" type="button" onclick="getDuration({{$key}})"--}}
{{--                                    class="getdur">Get--}}
{{--                                Duration--}}
{{--                            </button>--}}
{{--                            <span id="ids{{$key}}"></span>--}}

{{--                        </td>--}}
                        <td>
                            @if(!$item->cleaned)
                            <a class="btn btn-success" href="{{ asset('public/upload/'.$item->file_name) }}"
                               download>Download</a>
                            @else
                                <a class="btn btn-success" href="{{ asset('public/upload/'.$item->processed_file) }}"
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


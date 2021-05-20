@extends('layouts.app')

@section('content')

    <section class="contained">
        <h1 class="myaccount">{{$title}}</h1>
        <div class="checkouttotal">
            @include('common-uploaded-files')
            <div id="file_count" class="row">
                <b>Total duration = <span id="total-duration"></span></b> <br>
                <b>Total Cost = <span id="total-cost"></span>($1 per minute) </b>
            </div>
            @if(Auth::user()->is_admin)
                <button id="clean-btn" class="c-btn" onclick="clean_files({{$id}})"
                        style="margin-top: 1rem; margin-bottom: 20px;">Clean File(s)
                </button>
            @else
                @if(!Auth::user()->trial_expiry_date)
                    <button id="clean-btn" class="c-btn" onclick="clean_files_with_free_trial({{$id}})"
                            style="width: 275px !important;"
                            style="margin-top: 1rem">Clean File(s) With free trial
                    </button>
                    <p><b>OR</b></p>
                    <button class="c-btn" onclick="document.location = '{{URL::to('/')}}/checkout/{{$id}}'"
                            style="margin-top: 1rem; margin-bottom: 20px;">Proceed to Checkout
                    </button>
                @elseif(Auth::user()->trial_expiry_date<time())
                    <button class="c-btn" onclick="document.location = '{{URL::to('/')}}/checkout/{{$id}}'"
                            style="margin-top: 1rem; margin-bottom: 20px;">Proceed to Checkout
                    </button>
                @else
                    <button id="clean-btn" class="c-btn" onclick="clean_files({{$id}})"
                            style="margin-top: 1rem; margin-bottom: 20px;">Clean File(s)
                    </button>
                @endif
            @endif
        </div>
    </section>
@endsection




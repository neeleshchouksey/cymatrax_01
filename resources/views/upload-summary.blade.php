@extends('layouts.app')

@section('content')

    <section class="contained">
        <h1 class="myaccount">{{$title}}</h1>
        <div class="checkouttotal">
            @include('common-uploaded-files')
            <div class="row">
                <b>Total duration = <span id="total-duration"></span></b> <br>
                <b>Total Cost = <span id="total-cost"></span>($1 per minute) </b>
            </div>
            @if(!Auth::user()->trial_expiry_date || Auth::user()->trial_expiry_date<time())
                <button class="c-btn" onclick="document.location = '{{URL::to('/')}}/checkout/{{$id}}'"
                        style="margin-top: 1rem">Proceed to Checkout
                </button>
            @else
                <button id="clean-btn" class="c-btn" onclick="clean_files({{$id}})"
                        style="margin-top: 1rem">Clean File(s)
                </button>
            @endif
        </div>
    </section>
@endsection




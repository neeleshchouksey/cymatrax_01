@extends('layouts.app')

@section('content')

    <section class="contained">
        <h1 class="myaccount">{{$title}}</h1>

        <div class="checkouttotal">
            @include('common-uploaded-files')

            <div class="row">
                <b>Total duration = <span id="total-duration"></span></b> <br>
                <b>Total Cost =  <span id="total-cost"></span>($1 per minute)  </b>
            </div>

        </div>
    </section>





@endsection




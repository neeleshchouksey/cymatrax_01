@extends('layouts.app')

@section('content')

    <section class="contained">
        <h1 class="myaccount">{{$title}}</h1>

        <div class="checkouttotal">
            <table id="example" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                <thead>
                <tr style="text-align: left">

                    <th data-priority="1">Name</th>
                    <th data-priority="2">Duration</th>
                    <th data-priority="3">Upload Date</th>
                    <th data-priority="4">Audio</th>
                </tr>
                </thead>
                <tbody id="audio-list-datatable">

                </tbody>

            </table>
            <div id="file_count" class="row">
                <b>Total duration = <span id="total-duration"></span></b> <br>
                <b>Total Cost =
                    @if(Auth::user()->trial_expiry_date>time())
                        <span>($0 per minute)</span>
                    @else
                        <span id="total-cost"></span>($1 per minute) </b>
                @endif
            </div>
        </div>
    </section>





@endsection




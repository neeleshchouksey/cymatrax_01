@extends('layouts.app')

@section('content')

    <section class="contained">
        <h1 class="">{{$title}}
        <span class="free-trial" style="margin-top: 8px;">
             @if(!Auth::user()->trial_expiry_date)
                <a href="{{URL::to('/')}}/free-subscription">Start <b><?php echo get_free_trial_days(); ?> Days</b> free
                    trial</a>
            @elseif(Auth::user()->trial_expiry_date<time())
                Your trial period is expired
            @else
                Your trial period expire on {{ date("m/d/Y",Auth::user()->trial_expiry_date) }}
            @endif

        </span>
            <div class="">
                <button style="float: right;margin-bottom: 16px;
    margin-top: 34px;" type="button" class="c-btn">Checkout</button>
                <button style="float: right; margin-right: 10px;
    margin-top: 35px;" type="button" class="c-btn">Download</button>
            </div>
        </h1>

        {{--<div class="relative">
        <select style="margin-bottom: 15px;" class="input" name="file_filter" id="file_filter" onchange="fileFilter(this.value);">
            <option value="2">Filter By</option>
            <option value="0">Cleaned</option>
            <option value="1">Uncleaned</option>
            <option value="2">All</option>

        </select>
        </div>--}}

        <div class="checkouttotal">
          {{--@include('common-uploaded-files')--}}
            <table id="example" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                <thead>
                <tr style="text-align: left">

                    <th data-priority="1">Name</th>
                    <th data-priority="2">Duration</th>
                    <th data-priority="3">Upload Date</th>
                    <th data-priority="4">Audio</th>
                    <th data-priority="5">Status</th>
                    <th>Select All <input type="checkbox" id="selectAll"></th>
                </tr>
                </thead>
                <tbody id="audio-list-datatable">

                </tbody>

            </table>
        </div>
    </section>

@endsection


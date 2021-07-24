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
            <div class="mb-3">
{{--                <form id="multiple-checkout-frm" action="{{ url('multiple-checkout') }}" method="post">--}}
{{--                    {{ csrf_field() }}--}}
{{--                    <input type="hidden" value="" name="ids" id="allCheckoutIds">--}}
{{--                    <button onclick="allCheckout();" id="btnCheckout" disabled style="float: right;margin-bottom: 16px;--}}
{{--    margin-top: 34px;" type="button" class="c-btn">Checkout</button>--}}
{{--                </form>--}}

                @if(Auth::user()->is_admin)
                    <button id="clean-btn" class="c-btn  float-right" onclick="clean_multiple_files()">Clean File(s)
                    </button>
                @else
                    @if(!Auth::user()->trial_expiry_date)
                        <button id="clean-btn" class="c-btn float-right ml-2" style="width: 275px !important;" disabled onclick="clean_multiple_files_with_free_trial()">Clean File(s) With free trial
                        </button>

                        <form id="multiple-checkout-frm" action="{{ url('multiple-checkout') }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" value="" name="ids" id="allCheckoutIds">
                            <button onclick="allCheckout();" id="btnCheckout" disabled type="button" class="c-btn float-right">Checkout</button>
                        </form>
                    @elseif(Auth::user()->trial_expiry_date<time())
                        <form id="multiple-checkout-frm" action="{{ url('multiple-checkout') }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" value="" name="ids" id="allCheckoutIds">
                            <button onclick="allCheckout();" id="btnCheckout" disabled type="button" class="c-btn  float-right mr-2">Checkout</button>
                        </form>
                    @else
                        <button id="clean-btn" class="c-btn float-right" disabled onclick="clean_multiple_files()">Clean File(s)
                        </button>
                    @endif
                @endif

                <button onclick="allDownload();" id="btnDownload" disabled type="button" class="c-btn float-right mr-2">Download</button>
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
            <div id="alert-info">

            </div>
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


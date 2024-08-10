@extends('layouts.app')

@section('content')

    <section class="contained">
        <h1 class="myaccount">{{ $title }}</h1>
        <div class="checkouttotal">
            {{--            include('common-uploaded-files') --}}

            <input type="hidden" id="du_arr">

            <table id="example" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                <thead>
                    <tr style="text-align: left">

                        <th data-priority="1">Name</th>
                        <th data-priority="2">Duration</th>
                        <th data-priority="3">Upload Date</th>
                        <th data-priority="4">Audio</th>
                        <th data-priority="5">Status</th>
                    </tr>
                </thead>
                <tbody id="audio-list-datatable">

                </tbody>

            </table>

            <div id="file_count" class="row">
                <b>Total duration = <span id="total-duration"></span></b> <br>
                <b>

                    @if ($remaining_file_limits !== 'Unlimited' && $remaining_file_limits <= $total_uploded_file)
                        Total Cost =

                        @if (Auth::user()->trial_expiry_date > time())
                            <span>($0 per minute)</span>
                        @else
                            @php
        $plan_id = currentPlan()->plan_id ?? '0';

        $price_per_minute = currentPlan()->price_per_minute ?? '';
                            @endphp

                          
                            <span id="total-cost"></span>

                            (${{ $price_per_minute ?? '0' }} per minute)
                </b>
                <input type="hidden" name="value" id="charge-value" value="">
                @endif
                @endif
                <input type="hidden" name="dollerValue" id="dollerValue" value="{{ $price_per_minute ?? '' }}">
            </div>
            <input type="hidden" name="remaining_file_limits" id="remaining_file_limits"
                value="{{ $remaining_file_limits }}">
            <input type="hidden" name="total_uploded_file" id="total_uploded_file" value="{{ $total_uploded_file }}">


            @if (Auth::user()->is_admin || currentPlan()->subscription || Auth::user()->enterprise_user)
            <input type="hidden" name="value" value="{{ $remaining_file_limits }}">
            
            @if (
        ($remaining_file_limits <= 0 || $remaining_file_limits <= $total_uploded_file) &&
        $remaining_file_limits != 'Unlimited'
    )
                    <div style="margin-top: 1rem; margin-bottom: 20px;">
                        <button style="font-size: 12px !important; display: inline-block !important;" id="clean-btn"
                        class="c-btn" onclick="clean_files({{ $id }},{{ $remaining_file_limits }})">
                        Proceed to checkout
                        </button>
                        <span style="display: inline-block; margin-left: 10px;" id="file_count">Plan Limit is
                            exceeded</span>
                    </div>
                @else
                    <button id="clean-btn" class="c-btn"
                        onclick="clean_files({{ $id }}, '{{ $remaining_file_limits }}' )"
                        style="margin-top: 1rem; margin-bottom: 20px;">Clean File(s)
                    </button>
                @endif
            @else

            <input type="hidden" name="value" value="{{ $remaining_file_limits }}">
            
            @if (
        ($remaining_file_limits <= 0 || $remaining_file_limits <= $total_uploded_file) &&
        $remaining_file_limits != 'Unlimited'
    )
                    <div style="margin-top: 1rem; margin-bottom: 20px;">
                        <button style="font-size: 12px !important; display: inline-block !important;" id="clean-btn"
                        class="c-btn" onclick="clean_files({{ $id }},{{ $remaining_file_limits }})">
                        Proceed to checkout
                        </button>
                        <span style="display: inline-block; margin-left: 10px;" id="file_count">Plan Limit is
                            exceeded</span>
                    </div>
                @else
                    <button id="clean-btn" class="c-btn"
                        onclick="clean_files({{ $id }}, '{{ $remaining_file_limits }}' )"
                        style="margin-top: 1rem; margin-bottom: 20px;">Clean File(s)
                    </button>
                @endif
             
            @endif
        </div>

        <div id="alert-info">

        </div>

    </section>
@endsection

@extends('layouts.app')

@section('content')

    <section class="contained">
        <h1 class="myaccount">{{$title}}</h1>
        <div class="checkouttotal">
{{--            @include('common-uploaded-files')--}}

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
                <b>Total Cost =
                    @if(Auth::user()->trial_expiry_date>time())
                        <span>($0 per minute)</span>
                    @else
                        <input type="hidden" name="dollerValue" id="dollerValue" value="{{$dollerValue->value}}">
                        <span id="total-cost"></span>(${{$dollerValue->value}} per minute) </b>
                        <input type="hidden" name="value" id="charge-value" value="">
                @endif
            </div>
             <?php //dd($remaining_file_limits); ?>
            @if(Auth::user()->is_admin || Auth::user()->subscription || Auth::user()->enterprise_user)
               
                
               
                @if($remaining_file_limits ==0 )
                    <button id="clean-btn" class="c-btn" onclick="clean_files({{$id. ','.$remaining_file_limits}})"
                            style="margin-top: 1rem; margin-bottom: 20px;">Clean File(s)
                    </button>

                <div id="file_count" class="row">
                    <span> Plan Limit is exceeded </span> </div>
                @else
                    <button id="clean-btn" class="c-btn" onclick="clean_files({{$id. ','.$remaining_file_limits}})"
                            style="margin-top: 1rem; margin-bottom: 20px;">Clean File(s)
                    </button>
                @endif
                
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
                    <button id="clean-btn" class="c-btn" onclick="clean_files({{$id. ','.$remaining_file_limits}})"
                            style="margin-top: 1rem; margin-bottom: 20px;">Clean File(s)
                    </button> 
                    <label> Plan Limit is exceeded </label>
                @endif
            @endif
        </div>

        <div id="alert-info">

        </div>

    </section>
@endsection




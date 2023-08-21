@extends('layouts.app')

@section('content')

    <section class="contained">
        <h1 class="">{{ $title }}
            <span class="free-trial" style="margin-top: 8px;">
                @if (Auth::user()->subscription || Auth::user()->enterprise_user)
                    {{ Auth::user()->plan_name }} Subscription Enabled
                @else
                    @if (!Auth::user()->trial_expiry_date)
                        <!-- <a href="{{ URL::to('/') }}/free-subscription">Start <b><?php echo get_free_trial_days(); ?> Days</b> free
                            trial</a> -->
                    @elseif(Auth::user()->trial_expiry_date < time())
                        Your trial period is expired
                    @else
                        Your trial period will expire on {{ date('m/d/Y', Auth::user()->trial_expiry_date) }}
                    @endif
                @endif
            </span>
            <div class="mb-3">
                {{--                <form id="multiple-checkout-frm" action="{{ url('multiple-checkout') }}" method="post"> --}}
                {{--                    {{ csrf_field() }} --}}
                {{--                    <input type="hidden" value="" name="ids" id="allCheckoutIds"> --}}
                {{--                    <button onclick="allCheckout();" id="btnCheckout" disabled style="float: right;margin-bottom: 16px; --}}
                {{--    margin-top: 34px;" type="button" class="c-btn">Checkout</button> --}}
                {{--                </form> --}}
                <form method="post" action="{{ URL::to('/') }}/download-file" id="download-form">
                    @csrf
                    <input type="hidden" name="download_files" id="download_files">
                    <button onclick="allDownload(event);" id="btnDownload" disabled type="submit"
                        class="c-btn float-right ml-2">
                        Download
                    </button>
                </form>
                @if (Auth::user()->is_admin || Auth::user()->subscription || Auth::user()->enterprise_user)
                    <button id="clean-btn" class="c-btn  float-right"
                        onclick="clean_multiple_files({{ $remaining_file_limits }})">Clean File(s)
                    </button>
                @else
                    @if (!Auth::user()->trial_expiry_date)
                        <button id="clean-btn" class="c-btn float-right ml-2" style="width: 275px !important;" disabled
                            onclick="clean_multiple_files_with_free_trial()">Clean File(s) With free trial
                        </button>

                        <form id="multiple-checkout-frm" action="{{ url('multiple-checkout') }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" value="" name="ids" id="allCheckoutIds">
                            <button onclick="allCheckout();" id="btnCheckout" disabled type="button"
                                class="c-btn float-right">Checkout
                            </button>
                        </form>
                    @elseif(Auth::user()->trial_expiry_date < time())
                        <form id="multiple-checkout-frm" action="{{ url('multiple-checkout') }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" value="" name="ids" id="allCheckoutIds">
                            <button onclick="allCheckout();" id="btnCheckout" disabled type="button"
                                class="c-btn float-right mr-2">Checkout
                            </button>
                        </form>
                    @else
                        <button id="clean-btn" class="c-btn float-right" disabled
                            onclick="clean_multiple_files({{ $remaining_file_limits }})">Clean
                            File(s)
                        </button>
                    @endif
                @endif



                <button type="button" class="c-btn float-right mr-2"><a style="text-decoration: none; color:#ffffff"
                        href="{{ route('uploadAudio') }}">Upload</a></button>
                {{--                <button onclick="allDownload(event);" id="btnDownload" disabled type="button" --}}
                {{--                        class="c-btn float-right mr-2"> --}}
                {{--                    Download --}}
                {{--                </button> --}}
            </div>
        </h1>

        <div class="relative">
            <select style="margin-bottom: 15px;" class="input" name="file_filter" id="file_filter"
                onchange="fileFilter(this.value);">
                <option value="2">Filter By</option>
                <option value="0">Cleaned</option>
                <option value="1">Uncleaned</option>
                <option value="2">All</option>

            </select>
        </div>

        <div class="checkouttotal">
            <div id="alert-info">

            </div>
            {{-- @include('common-uploaded-files') --}}
            <table id="example" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                <thead>
                    <tr style="text-align: left">

                        <th data-priority="1">Name</th>
                        <th data-priority="2">Duration in minutes</th>
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
    {{-- model  --}}
    <div class="modal fade" id="file-limits-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Now you don't have limit more than {{ $remaining_file_limits }}
                        files, please select a new plan or upgrade your current plan</h3>
                    <br><br>
                </div>
                <div class="modal-footer" style="text-align:center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        onclick="closelimitsModal()">Close</button>
                    <button type="button" class="btn btn-primary"><a href="{{ route('subscription') }}">Select or Upgrade
                            Plan</a></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        // $(document).ready(function() {
        // $('.swal2-confirm swal2-styled').click(function(e) {
        //     window.location = env(APP_URL) + '/subscription'
        // });
        // });

        var elements = document.getElementsByClassName("swal2-confirm swal2-styled");
        for (var i = 0; i < elements.length; i++) {
            elements[i].addEventListener("click", function() {
                console.log(12312313)
                window.location = 'http://localhost/cymatrax_dev/subscription';
            });
        }
    </script>

@endsection

@extends('layouts.app')



@section('content')
    <style type="text/css">
        .paginate_button {

            background-color: #44908d !important;

            color: #fff !important;

        }



        div#example_paginate {

            width: 50%;

            display: flex;

        }



        a#example_next {

            display: block !important;

            width: 200px !important;

            padding: 0px !important;

            border: none !important;

            line-height: 50px !important;

            background-color: #44908d !important;

            color: #fff !important;

            letter-spacing: 3px !important;

            cursor: pointer !important;

            transition: all 0.4s !important;

            margin-top: 15px;

            border-radius: 5px;

        }



        a#example_previous {

            display: block !important;

            width: 200px !important;

            padding: 0px !important;

            border: none !important;

            line-height: 50px !important;

            background-color: #44908d !important;

            color: #fff !important;

            letter-spacing: 3px !important;

            cursor: pointer !important;

            transition: all 0.4s !important;

            margin-top: 15px;

            border-radius: 5px;

        }



        .disable-btn {

            background-color: #b4b4b4 !important
        }
    </style>



    <section class="contained">

        <h1 class="">{{ $title }}

            <span class="free-trial" style="margin-top: 8px;">



            </span>

            <div class="mb-3">

                <form method="post" action="{{ URL::to('/') }}/delete-file" id="delete-form">
                    @csrf
                    <input type="hidden" name="delete_files" id="delete_files">
                    <button onclick="deleteFiles(event);" id="btnDelete" disabled type="submit"
                        class="c-btn float-right ml-2 disable-btn">
                        Delete
                    </button>

                </form>

                <form method="post" action="{{ URL::to('/') }}/download-file" id="download-form">
                    @csrf
                    <input type="hidden" name="download_files" id="download_files">
                    <button onclick="allDownload(event);" id="btnDownload" disabled type="submit"
                        class="c-btn float-right ml-2 disable-btn">
                        Download
                    </button>

                </form>





                @if (Auth::user()->is_admin || currentPlan()->subscription || Auth::user()->enterprise_user)
                    <button id="clean-btn" class="c-btn  float-right disable-btn"
                        onclick="clean_multiple_files({{ $remaining_file_limits }},{{ currentPlan()->price_per_minute ?? '' }})">Clean

                        File(s)

                    </button>
                @else
                    <button id="clean-btn" class="c-btn  float-right disable-btn"
                        onclick="clean_multiple_files({{ $remaining_file_limits }},{{ currentPlan()->price_per_minute ?? '' }})">Clean
                        File(s)
                    </button>
                @endif

                <a style="text-decoration: none; color:#ffffff" href="{{ route('uploadAudio') }}">
                    <button type="button" class="c-btn float-right mr-2">Upload</button>
                </a>


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



                    <a href="{{ route('subscription') }}"> <button type="button" class="btn btn-primary">Select or Upgrade

                            Plan</button></a>

                </div>

            </div>

        </div>

    </div>

    <script>
        var elements = document.getElementsByClassName("swal2-confirm swal2-styled");

        for (var i = 0; i < elements.length; i++) {

            elements[i].addEventListener("click", function() {

                console.log(12312313)

                window.location = 'http://localhost/cymatrax_dev/subscription';

            });

        }
    </script>
@endsection

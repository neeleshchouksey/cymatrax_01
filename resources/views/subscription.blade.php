@extends('layouts.app')
@section('content')
    <style>
        .dashboard-main {
            color: green;
        }

        .dashboard-main h2,
        .dashboard-main .dashboard-buttons {
            text-align: center;
        }

        .dashboard-buttons button {
            font-size: 20px;
            padding: 10px;
            width: 150px;
            margin: 10px 0;
            border-radius: 5px;
        }

        .dashboard-buttons button a {
            color: #000000;
            font-weight: 600;
            text-decoration: none;
        }

        .high-text {
            color: #187fde !important;
        }

        /* subscription style start */
        .subscription-buttons button {
            font-size: 20px;
            padding: 10px;
            width: auto;
            margin: 10px 0;
            border-radius: 5px;
        }

        .subscription-buttons button a {
            color: #000000;
            font-weight: 600;
            text-decoration: none;
        }

        .subs-header {
            display: flex;
            border-bottom: 1px solid #ccc;
            align-items: center;
            justify-content: space-between;
        }

        .subs-header button {
            margin-left: 100px;
    height: 44px;
    font-size: 16px;
    padding: 0 35px;
    border-radius: 8px;
    font-weight: 600;
    color: #fff;
    background: #44908d;
    border: #fff;
        }

        .subs-content {
            width: 100%;
            display: flex;
            justify-content: center;
            background-color: #ffffff;
            padding: 30px 0;
            border-bottom: 1px solid #cccccc;
            box-shadow: 0 3px 10px rgb(0 0 0 / 0.2);
            margin-top: 30px;
        }

        .subs-content .single-subs {
            width: 30%;
            max-width: 250px;
            margin: 1.5%;
            border-radius: 8px;
            border: 2px solid #cccccc;
            padding: 0 15px;
            height: auto;
            min-height: 350px;
            position: relative;
        }

        .subs-content .subs-1 {
            float: left;
            border-top: 8px solid #cccccc;
        }

        .subs-content .subs-2 {
            border-top: 8px solid green;
        }

        .subs-content .subs-3 {
            float: right;
            border-top: 8px solid blue;
        }

        .single-subs h3,
        .single-subs .first-p {
            text-align: center;
        }

        .first-p {
            font-weight: 600;
        }

        .bottom-btn-main {
            border-radius: 8px;
            position: absolute;
            width: auto;
            min-width: 200px;
            left: 50%;
            justify-content: center;
            display: flex;
            bottom: 30px;
            transform: translateX(-50%);
            height: 30px;
        }

        .bottom-1 {
            border: 2px solid;
        }

        .bottom-2 {
            background-color: green;
            border: 2px solid green;
        }

        .bottom-3 {
            border: 2px solid;
           
        }

        .bottom-btn {
            position: absolute;
            bottom: 6%;
            padding: 16px;
            min-width: 150px;
            font-size: 15px;
            font-weight: 600;
            left: 50%;
            transform: translateX(-50%);
            background: #44908d;
          
            border-radius: 10px;

            color: #fff !important;
    letter-spacing: 2px !important;
    cursor: pointer !important;
    transition: all 0.4s !important;
    border:#fff !important;
        }

        .bottom-btn a {
            color: #fff;
            text-decoration: none;
            font-family: Futura, Trebuchet MS, Arial, sans-serif;
        }

        .mini-para {
            text-align: center;
            font-size: 10px;
            margin-top: -10px;
        }
    </style>
    <section class="contained">
        <div class="subs-header">
            <h1>{{ $title }}</h1>
            <button>{{ Auth::user()->subscription ? Auth::user()->plan_name : 'Community' }}</button>
            @if (Auth::user()->is_cancelled == 1 && !is_null(Auth::user()->plan_end_date)) 
                <div>
                    <p><b>Your {{Auth()->user()->plan_name}} plan is still active</b></p> 
                    <p style="color: #ea0d0d"><b>Expiry on {{Auth::user()->plan_end_date}}</b></p> 
                </div>
            @endif
        </div>
       
            
        <div class="subs-content">

            
            @foreach ($subscriptions as $key => $data)
                    
            <?php 
                $selectedClass = (Auth::user()->plan_name == $data->name) ? 'subs-2' : 'subs-1';
                $selectedButtonClass = (Auth::user()->plan_name == $data->name  || Auth::user()->plan_name == NULL ) ? '2' : '';
             ?>

        <div class="single-subs {{ $selectedClass }}">
               
            
            
                    <h3>{{ $data->name }}</h3>
                    <p class="first-p">{{ $data->charges == 'Free' ? 'Free' : '$' . $data->charges . ' per editor/month' }}
                    </p>
                    @if ($data->charges == 'Free')
                        <p class="mini-para">Always</p>
                    @endif
                    @if ($data->text_1)
                        <p>&#9989;{{ $data->text_1 }}</p>
                    @endif
                    @if ($data->text_2)
                        <p>&#9989;{{ $data->text_2 }}</p>
                    @endif
                    @if ($data->text_3)
                        <p>&#9989;{{ $data->text_3 }}</p>
                    @endif

                    @if(Auth::user()->plan_name == $data->name )
                    <div class="bottom-btn-main bottom-2">
                        {{-- <div> --}}

                        {{-- </div> --}}
                    </div>
                    @else
                    <div class="bottom-btn-main bottom-1">
                        {{-- <div> --}}

                        {{-- </div> --}}
                    </div>
                    @endif
                    <button class="bottom-btn">
                        @if (!Auth::user()->subscription && $data->name == 'Community')
                            Selected
                        @elseif(Auth::user()->subscription && Auth::user()->plan_name == $data->name)
                            Selected
                        @else
                            <a href="{{ route('paymentCreateView', $data->id) }}">{{$data->name }}</a>
                        @endif

                    </button>
                </div>
            @endforeach
            {{-- <div class="single-subs second-subs">
                <h3>Community</h3>
                <p>Free</p>
                <p>Forever</p>
                {{ $free_clean_files }}
            </div>
            <div class="single-subs third-subs">
                <h3>Community</h3>
                <p>Free</p>
                <p>Forever</p>
                {{ $free_clean_files }}
            </div> --}}
        </div>
       
    </section>
@endsection

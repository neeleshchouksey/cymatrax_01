{{-- @extends('layouts.app')
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
    </style>
    <section class="contained">
        <h1 class="myaccount">{{ $title }}</h1>
        <div class="dashboard-main">
            <h2>Welcome back {{ Auth::user()->name }}</h2><br>
            <h2>You have uploaded <span class="high-text">{{ $uploads[0]->count ?? 0 }}</span> files with <span
                    class="high-text">{{ intval($uploads[0]->duration) ?? 0 }}</span> minutes of content.</h2>
            <h2>Save money and sign up for a <span class="high-text">subscription</span> today!</h2><br>
            <div class="dashboard-buttons">
                @if (Auth::user()->subscription == 0)
                    <button><a href="{{ route('subscription') }}">Select Subscription</a></button><br>
                @endif
                <button><a href="{{ route('my_account') }}">Go to My Account</a></button>
            </div>
        </div>
    </section>
@endsection --}}

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
    </style>
    <section class="contained">
        @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
        <h1 class="myaccount">{{ $title }}</h1>
        <div class="dashboard-main">
            <h2>Welcome back {{ Auth::user()->name }}</h2><br>
            <?php  if(isset($uploads[0])) {  ?>
            <h2>You have uploaded <span class="high-text">{{ $uploads[0]->count ?? 0 }}</span> files with <span
                    class="high-text"><?php
                    
                    $seconds = $uploads[0]->duration;
                    $minutes = floor($seconds / 60);
                    $secondsleft = $seconds % 60;
                    if ($minutes < 10) {
                        $minutes = '0' . $minutes;
                    }
                    if ($secondsleft < 10) {
                        $secondsleft = '0' . $secondsleft;
                    }
                    echo "$minutes:$secondsleft";
                    ?>
                </span> minutes of content.</h2>

            <?php  } ?>
            <h2>Save money and sign up for a <span class="high-text">subscription</span> today!</h2><br>
            <div class="dashboard-buttons">

                @if (Auth::user()->subscription == 0)
                    <button><a href="{{ route('subscription') }}">Select Subscription</a></button><br>
                @endif
                <button><a href="{{ route('my_account') }}">Go to My Account</a></button>
            </div>
        </div>
    </section>
@endsection

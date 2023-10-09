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

h1.myaccount {
    display: flex;
    align-items: center;
    border-bottom: solid 1px #ccc;
    margin-right: 50px;
}

h1.myaccount .title {
    flex: 1;
    /* Add any additional styling for the title if needed */
}

h1.myaccount .current-plan {
    /* Add any additional styling for the current plan if needed */

}
</style>
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
    height: 45px;
    font-size: 18px;
    padding: 0 35px;
    border-radius: 8px;
    font-weight: 600;
    background: #a9fbe4;
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

.bottom-1 {}



.bottom-3 {
    border: 2px solid;

}

.bottom-btn {
    position: absolute;
    bottom: 6%;
    padding: 16px;
    min-width: 240px;
    font-size: 15px;
    font-weight: 500;
    left: 50%;
    transform: translateX(-50%);
    background: #44908d;
    border-radius: 10px;
    color: #fff !important;
    letter-spacing: 2px !important;
    cursor: pointer !important;
    transition: all 0.4s !important;
    border: #fff !important;
}

.bottom-btn a {
    color: #fff;
    text-decoration: none;
}

.mini-para {
    text-align: center;
    font-size: 10px;
    margin-top: -10px;
}
</style>

@if(Auth::user()->plan_name != "Community" )
<section class="contained">
    @if (session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
    @endif

    <h1 class="myaccount">
        <span class="title">{{ $title }}</span>
        <!-- <span class="current-plan">Current Plan: {{ Auth::user()->plan_name }}</span> -->
    </h1>


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
@else
<section class="contained">
    <div class="subs-header">
        <h1>{{ $title }}</h1>
        <!-- <h1 class="myaccount">
    <span class="title">{{ $title }}</span>
    <span class="current-plan">Current Plan: {{ Auth::user()->plan_name }}</span>
</h1> -->
        <!-- <span><b>Current Plan: {{ Auth::user()->plan_name }} </b></span> -->
        @if (Auth::user()->is_cancelled == 1 && !is_null(Auth::user()->plan_end_date))
        <div>
            <p><b>Your {{Auth()->user()->plan_name}} plan is still active</b></p>
            <p style="color: #ea0d0d"><b>Expiry on {{Auth::user()->plan_end_date}}</b></p>
        </div>
        @endif
    </div>
    <p>Upgrade Today and unlock more Cymatrax features</p>


    <div class="subs-content">


        @foreach ($subscriptions as $key => $data)

        <?php 
                    $selectedClass = (Auth::user()->plan_name == $data->name) ? 'subs-2' : 'subs-1';
                    $selectedButtonClass = (Auth::user()->plan_name == $data->name  || Auth::user()->plan_name == NULL ) ? '2' : '';
                ?>

        <div class="single-subs {{ $selectedClass }}">



            <h3>{{ $data->name }}</h3>
            <p class="first-p">{{ $data->charges == 'Free' ? 'Free' : $data->display_text_price_per_month }}
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
              
                </div>
            @else
                <div class="bottom-btn-main bottom-1">
                  
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

@endif



@endsection
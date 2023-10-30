{{-- <html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @if ($status == 1)
        <h1>You have successfully purchase {{$plan_name}} subscription please click below button to go My Account and start clean files</h1>
        <div>
            <a href="{{route('my_account')}}">Go to My Account</a>
        </div> 
    @elseif ($status == 0)
        <h1>Something went wrong while your subscription please select subscription using below button and try again</h1>
        <div>
            <a href="{{route('subscription')}}">Go to Subscription page</a>
        </div>
    @elseif ($status == 'cancelled')
        <h1>You have successfully cancelled your subscription please click below button to go My Account</h1>
        <div>
            <a href="{{route('my_account')}}">Go to My Account</a>
        </div>  
    @endif
    
</body>
</html> --}}

@extends('layouts.app')
@section('content')
    <style>
        .dashboard-main {
            color: green;
            max-width: 600px;
            padding-top: 30px;
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
        <h1 class="myaccount">
            {{ $status == 1 ? 'Payment Success' : ($status == 'cancelled' ? 'Cancel Plan' : 'Something went wrong') }}</h1>
        <div class="dashboard-main">
            @if ($status == 1)
                <h1>You have successfully purchase {{ $plan_name }} subscription please click below button to go My
                    Account and start clean files</h1>
                <div>
                    <a href="{{ route('my_account') }}">Go to My Account</a>
                </div>
            @elseif ($status == 0)
                <h1>Something went wrong while your subscription please select subscription using below button and try again
                </h1>
                <div>
                    <a href="{{ route('subscription') }}">Go to Subscription page</a>
                </div>
            @elseif ($status == 'cancelled')
                <h1>You have successfully cancelled your subscription please click below button to go My Account</h1>
                <div>
                    <a href="{{ route('my_account') }}">Go to My Account</a>
                </div>
            @elseif ($status == 'free')
                <h1>You have successfully added {{ $plan_name }} subscription please click below button to go My Account</h1>
                <div>
                    <a href="{{ route('my_account') }}">Go to My Account</a>
                </div>
            @endif
        </div>
        </div>
    </section>
@endsection

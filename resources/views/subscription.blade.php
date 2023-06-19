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

        .bottom-1 {
            border: 2px solid;
        }

        .bottom-2 {
            background-color: green;
            border: 2px solid green;
        }

        .bottom-3 {
            border: 2px solid blue;
            background-color: blue;
        }

        .bottom-btn {
            position: absolute;
            bottom: 6%;
            padding: 12px;
            min-width: 150px;
            font-size: 19px;
            font-weight: 600;
            left: 50%;
            transform: translateX(-50%);
            background: #a9fbe4;
            color: #000000;
            border-radius: 10px;
        }

        .bottom-btn a {
            color: #000000;
            text-decoration: none;
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
            <button>Starter {{ Auth::user()->subscription ? Auth::user()->plan_name : 'Community' }}</button>
        </div>
        <div class="subs-content">
            @foreach ($subscriptions as $key => $data)
                <div class="single-subs subs-{{ $key + 1 }}">
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

                    <div class="bottom-btn-main bottom-{{ $key + 1 }}">
                        {{-- <div> --}}

                        {{-- </div> --}}
                    </div>
                    <button class="bottom-btn">
                        @if (!Auth::user()->subscription && $data->name == 'Community')
                            Selected
                        @elseif(Auth::user()->subscription && Auth::user()->plan_name == $data->name)
                            Selected
                        @else
                            <a href="{{ route('paymentCreateView', $data->id) }}">{{ 'Choose ' . $data->name }}</a>
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
        {{-- <div class="dashboard-main">
            <div class="subscription-buttons">
                @foreach ($subscriptions as $subscription)
                    <button><a disabled
                            href="{{ Auth::user()->plan_id == $subscription->plan_id ? '#' : route('paymentCreateView', $subscription->id) }}"><span>{{ $subscription->name }}
                                Subscription - ${{ $subscription->charges }}/month</span><br><span style="font-size: 16px">
                                @if ($subscription->name != 'Unlimited')
                                    (upload and clean up to {{ $subscription->no_of_clean_file }} files a month)
                                @endif
                            </span></a></button><br>
                @endforeach
            </div>
        </div> --}}
    </section>
@endsection

@extends('layouts.app')
@section('content')
    <style>
        .subscription-main {
            color: green;
            text-align: center;
        }

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
    </style>

    <section class="contained">
        <h1 class="myaccount">{{ $title }}</h1>

        <div class="subscription-main">
            <h2>Great let's get started</h2><br>
            <h2>Select Plan that works for you,</h2>
            <div class="subscription-buttons">
                @foreach ($subscriptions as $subscription)
               

               
                                
                                <?php  if(Auth::user()->plan_id == $subscription->plan_id){ ?>
                                    <button style="border-color: red">
                                    <a disabled class="border border-success"
                            href="{{ Auth::user()->plan_id == $subscription->plan_id ? '#' : route('paymentCreateView', $subscription->id) }}">
                                <span class="border border-success" >
                                    {{ $subscription->name }}
                                    Subscription - ${{ $subscription->charges }}/month
                                </span  >
                                <br>
                                <span class="subscription-main" style="font-size: 16px">
                                @if ($subscription->name != 'Unlimited')
                                    (upload and clean up to {{ $subscription->no_of_clean_file }} files a month)
                                @endif
                                </span>

                                </a></button>
                                <?php }else{ ?>
                                    <button>
                                    <a
                                    href="{{ route('paymentCreateView', $subscription->id) }}">
                                    <span >
                                    {{ $subscription->name }}
                                    Subscription - ${{ $subscription->charges }}/month
                                </span  >
                                <br>
                                <span class="subscription-main" style="font-size: 16px">
                                @if ($subscription->name != 'Unlimited')
                                    (upload and clean up to {{ $subscription->no_of_clean_file }} files a month)
                                @endif
                                </span>
                                </a>
                                </button>
                                    <?php } ?>

                               
                               
                                <br>
                @endforeach
            </div>
        </div>
    </section>
@endsection

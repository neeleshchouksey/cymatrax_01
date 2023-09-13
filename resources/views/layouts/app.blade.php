<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Cymatrax</title>
    <meta name="description" content="Cymatrax offers audio processing...">
    <meta name="keywords" content="Audio Processing, Audio Equalization">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{URL::to('/')}}/assets/images/favicon.png">
    <link rel="stylesheet" href="{{asset('public/dropzone/dist/dropzone.css')}}" />
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="{{ captcha_layout_stylesheet_url() }}" type="text/css" rel="stylesheet">

    <link href="{{URL::to('/')}}/assets/css/index.css" rel="stylesheet" />

    <script>
    var APP_URL = '{{URL::to("/")}}';
    var CSRF_TOKEN = '{{csrf_token()}}'
    </script>

    <style>
    /* #overlay{
        position:fixed;
        z-index:99999;
        top:0;
        left:0;
        bottom:0;
        right:0;
        background:rgba(0,0,0,0.9);
        transition: 1s 0.4s;
    }
    #overlay > img{
        position: absolute;
        top: 50%;
        left: 50%;
    } */
    /* CSS for the button */
    .signup-button {
        background-color: #475862;
        /* Background color (you can change this) */
        color: white;
        /* Font color */
        border: none;
        /* Remove button border */
        padding: 10px 10px;
        /* Add padding for better appearance */
        font-size: 16px;
        /* Font size (you can adjust this) */
        cursor: pointer;
        /* Add a pointer cursor on hover */
        border-radius: 5px;
        /* Rounded corners for a modern look */
    }

    /* Hover effect (optional) */
    .signup-button:hover {
        background-color: #44908D;
        /* Change the background color on hover */
    }

    .plan-container {
        display: flex;
        /* Use flexbox to align items */
        justify-content: flex-end;
        /* Push elements to the right */
        align-items: center;
        /* Vertically center items */
    }

    /* CSS for the label */
    .plan-label {
        margin-right: 20px;
        /* Add space between the label and buttons */
    }

    /* CSS for the buttons */
    .c-btn {
        background-color: #3498db;
        /* Background color (you can change this) */
        color: white;
        /* Font color */
        border: none;
        /* Remove button border */
        padding: 10px 20px;
        /* Add padding for better appearance */
        font-size: 16px;
        /* Font size (you can adjust this) */
        cursor: pointer;
        /* Add a pointer cursor on hover */
        border-radius: 5px;
        /* Rounded corners for a modern look */
        text-decoration: none;
        /* Remove underline for links (optional) */
    }

    /* Hover effect (optional) */
    .c-btn:hover {
        background-color: #2980b9;
        /* Change the background color on hover */
    }
    </style>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-QGRTB9YSNS"></script>
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'G-QGRTB9YSNS');
    </script>
</head>

<body>
    <header>
        <div class="inner-header">
            <img src="{{URL::to('/')}}/assets/images/logo.banner.png" class="logo-banner" />
            <img src="{{URL::to('/')}}/assets/images/logo.png" class="logo-icon" />
            <a class="mobile-toggle" onclick="$('header ul').toggleClass('open');">&#9776;</a>
            <ul>
                @if(Auth::user())
                <li><a href="{{URL::to('/')}}/dashboard">Dashboard</a></li>
                <li><a href="{{URL::to('/')}}/upload-audio/">Upload Audio</a></li>
                <li><a href="{{URL::to('/')}}/account">My Account</a></li>
                <li><a href="{{URL::to('/')}}/transactions/">Transactions</a></li>
                <li><a href="{{URL::to('/')}}/services/">Services</a></li>
                <li>
                    <button class="profileButton" onclick="$('.profileMenu').toggleClass('open');"></button>
                    <ul class="profileMenu">

                        <li><a href="{{URL::to('/')}}/profile/">Edit Profile</a></li>
                        <li><a href="{{URL::to('/')}}/password/reset">Reset Password</a></li>
                        <li>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
                @else
                <li><a href="{{URL::to('/')}}">Home</a></li>
                <li><a href="{{URL::to('/')}}/services/">Services</a></li>
                <li><a href="{{URL::to('/')}}/login">Login</a></li>
                <li><a href="{{URL::to('/')}}/register"><button class="signup-button">Sign Up Free </button> </a>
                </li>
                @endif
            </ul>
        </div>
        <div class="inner-header">
            <?php  if(Auth::user()) { ?>
            <div class="plan-container">
                <div class="plan-label">Current Plan:</div>
                <button class="c-btn  mr-2" disabled>{{ Auth::user()->plan_name ?? '' }}</button>
                <span></span>
                <button class="c-btn" disabled><a href="{{ route('subscription') }}">Upgrade Plan</a></button>
            </div>
            <?php } ?>
        </div>
        <br>
    </header>

    <div id="app">
        <!-- /* loader is temp display:none  -->
        <!-- <div id="overlay" class="d-none">
        <img src="{{asset('assets/images/loader.gif')}}" alt="Loading" style="height:30px;width:30px" />
    </div> -->
        @yield('content')
    </div>
    <footer>
        <div class="inner-footer">
            <p class="copyright">&copy; 2020, All Rights Reserved, cymatrax.com</p>
            <nav>
                <a href="{{URL::to('/')}}/privacy/">Privacy Policy</a> | <a href="{{URL::to('/')}}/terms/">Terms
                    of Use</a>
            </nav>
        </div>
    </footer>
</body>


<script src="{{asset('public/dropzone/dist/dropzone.js')}}"></script>
{{--<script src="{{ asset('public/js/app.js') }}" defer></script>--}}
{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>--}}
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>

<script src="{{ asset('public/js/component.js') }}"></script>
<!-- sweet aleart -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Include a polyfill for ES6 Promises (optional) for IE11 -->
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
<!-- paypal pro scripts -->
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>--}}
<script src="https://unpkg.com/wavesurfer.js"></script>
{{--<script src="{{ asset('public/js/jquery.card.js') }}"></script>--}}
{{--<script src="{{ asset('public/js/card.js') }}"></script>--}}
<!-- paypal pro scripts end-->

@if(session()->has('message'))

<script>
Swal.fire({
    title: 'Success!',
    text: "{{ session()->get('message') }}",
    icon: 'success',
    showCancelButton: false,
});
</script>
@endif

<script>
var msg = '{{Session::get('
alert ')}}';
var exist = '{{Session::has('
alert ')}}';
if (exist) {

    Swal.fire({
        title: 'Thank You',
        text: msg,
        icon: 'success',
        showCancelButton: false,
    });
}
var msg1 = '{{Session::get('
error ')}}';
var exist1 = '{{Session::has('
error ')}}';
if (exist1) {
    Swal.fire({
        title: 'Error!',
        text: msg1,
        icon: 'error',
        showCancelButton: false,
    });
}
</script>


<script>
@if(isset($file))
$(document).ready(function() {
    var wavesurfer = WaveSurfer.create({
        container: '#input-waveform',
        waveColor: '#384a50',
        progressColor: '#71b3b0',
        barWidth: 3
    });

    var wavesurfer1 = WaveSurfer.create({
        container: '#output-waveform',
        waveColor: '#71b3b0',
        progressColor: '#384a50',
        barWidth: 3
    });

    wavesurfer.load(APP_URL + '/public/upload/{{$file->file_name}}');
    wavesurfer1.load(APP_URL + '/public/upload/{{$file->processed_file}}');

    $("#play-btn").click(function() {
        wavesurfer.play();
    });
    $("#pause-btn").click(function() {
        wavesurfer.pause();
    });
    $("#play-btn1").click(function() {
        wavesurfer1.play();
    });
    $("#pause-btn1").click(function() {
        wavesurfer1.pause();
    });
    // $("#output-btn").click(function (){
    //     wavesurfer1.playPause();
    // });
});
@endif

$(document).ready(function() {
    // PAGE IS FULLY LOADED
    // FADE OUT YOUR OVERLAYING DIV
    setTimeout(function() {
        // $('#overlay').fadeOut();
    }, 500);
});
</script>

</html>
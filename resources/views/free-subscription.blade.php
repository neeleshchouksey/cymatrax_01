@extends('layouts.app')
@section('content')


    <section class="contained">
        <h1 class="myaccount">{{$title}}</h1>
        <div>
            Are you sure? You want to confirm free subscription ?
            <button class="wave-btn"  onclick="window.location.href = '{{URL::to('/')}}/confirm-subscription'">OK</button>
            <button class="wave-btn" onclick="window.location.href = '{{URL::to('/')}}/dashboard'">Cancel</button>
        </div>
    </section>
@endsection


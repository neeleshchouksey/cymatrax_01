@extends('layouts.app')
@section('content')


    <section class="contained">
        <h1 class="myaccount">{{$title}}</h1>
        <div>
            Are you sure? You want to confirm free subscription ?
            <a href="{{URL::to('/')}}/confirm-subscription">Click Here</a>
        </div>
    </section>
@endsection


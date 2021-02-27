@extends('layouts.app')

@section('content')

    <section class="contained">
        <h1 class="myaccount">{{$title}}</h1>
        <div class="checkouttotal">
          @include('common-uploaded-files')
        </div>
    </section>

@endsection


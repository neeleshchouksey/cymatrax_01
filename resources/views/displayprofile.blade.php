@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="card-header">My Account</div>
        @foreach($getData as $item)  
        @if($item->cleaned == 0)
        <div class="card" style="margin-bottom:1%;">
        <div class="card-body">
       
          
           <b> File Name:</b><p>{{$item->file_name}}</p>
           <b> Upload Time:</b>
           <p> {{ Carbon\Carbon::parse($item->created_at)->format('d-m-Y, H: i: s') }}</p>
          
  
            <audio controls="" style="vertical-align: middle" src="{{ asset('public/images/'.$item->file_name) }}" type="audio/mp3" controlslist="nodownload">
                Your browser does not support the audio element.
            </audio>
        
        
            <a class="btn btn-success" href="{{ asset('public/images/'.$item->file_name) }}" download>Download</a>
          
            <a class="btn btn-warning" download style="margin-left:2%;">Pay & Clean</a>

          <!-- paypal code -->
           
         <!-- end paypal code -->


           
            </div>
            </div>

            @else

            <div class="card" style="margin-bottom:1%;">
            <div class="card-body">
            <b> File Name:</b><p>{{$item->processed_file}}</p>
            <b> Upload Time:</b>
            <p> {{ Carbon\Carbon::parse($item->created_at)->format('d-m-Y, H: i: s') }}</p>
            <audio controls="" style="vertical-align: middle" src="{{ asset('public/images/'.$item->processed_file) }}" type="audio/mp3" controlslist="nodownload">
                Your browser does not support the audio element.
            </audio>
            <a class="btn btn-success" href="{{ asset('public/images/'.$item->processed_file) }}" download>Download</a>
            </div>
            </div>
            @endif
        @endforeach


       
        
        </div>    
        </div>
        </div>




      



@endsection


@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <h3><b>Upload Summary</b></h3>
      <div class="outer-box">

        @foreach($getData as $item)  

        <div class="card" style="margin-bottom:1%;">
        <div class="card-body">
       
          
           <b> File Name:</b><p>{{$item->file_name}}</p>
         
           
            <audio controls="" style="vertical-align: middle" src="{{ asset('public/images/'.$item->file_name) }}" type="audio/mp3" controlslist="nodownload">
                Your browser does not support the audio element.
            </audio>
             <b> File duration =  </b> 
        

        
            </div>



            </div>
        @endforeach


       <b>Total duration = </b> <br>
       <b>Total Cost = </b><br>
       <b>($1 per minute) </b>

<!-- paypal code -->
<div class="flex-center position-ref full-height">
  <div class="content" >
      <a href="{{ route('payment') }}" class="btn btn-success" style="margin:1%;">Pay & Checkout</a>
      <a href="{{ url('file/fetch')}}" class="btn btn-success" style="margin:1%;">Cancel</a>

  </div>
</div>
<!-- end paypal code -->
        </div>
        </div>    
        </div>
        </div>






@endsection


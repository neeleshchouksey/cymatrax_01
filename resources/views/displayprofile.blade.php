@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="card-header">My Account</div>
        @foreach($getData as $key=>$item)  
        @if($item->cleaned == 0)
        <div class="card" style="margin-bottom:1%;">
        <div class="card-body">
       
          
           <b> File Name:</b><p>{{$item->file_name}}</p>
           <b> Upload Time:</b>
           <p> {{ Carbon\Carbon::parse($item->created_at)->format('d-m-Y, H: i: s') }}</p>
          
  
            <audio controls="" style="vertical-align: middle" src="{{ asset('public/upload/'.$item->file_name) }}" type="audio/mp3" controlslist="nodownload">
                Your browser does not support the audio element.
            </audio>
        
        
            <a class="btn btn-success" href="{{ asset('public/upload/'.$item->file_name) }}" download>Download</a>
          
            <!-- <a class="btn btn-warning" download style="margin-left:2%;">Pay & Clean</a> -->

          <!-- paypal code -->




                      
<!-- get duration end -->

            <div class="card" style="display:none;">
            <div class="card-body">
            <p id="demo"></p>
                <audio style="display:none;" id="audio{{$key}}" controls="" style="vertical-align: middle" src="{{ asset('public/upload/'.$item->file_name) }}" type="audio/mp3" controlslist="nodownload">
                    Your browser does not support the audio element.
                </audio>
                <!-- <b> File duration = <span id="duration{{$key}}" ></span> </b> -->
                <button style="visibility:hidden;" type="button" onclick="getDuration({{$key}})" class="getdur">Get Duration</button>
                <span id="ids{{$key}}" ></span>
                </div>

                </div>
           

<!-- get duration end -->
             

   

            <div class="content" style="display:inline-flex;">

                  <form  method="post" action="{{ route('payment') }}">
                    @csrf
                  <input type="hidden"  name="totalduration" value=""  id="duration_in_sec{{$key}}" class="durValue"/>
                  

                  <input type="hidden" name="totalcost" value="singlefile" >
                  <input type="hidden" name="fileids" value="{{$item->id}}" id="paypal_audio_ids"/>
                  <input type="submit" value="Pay & Checkout" class="btn btn-warning" name="submit"/>
                  </form>
  
              </div>
           
              <a href="{{URL::to('/')}}/propaypalsingle/{{$item->id}}" class="btn btn-warning">Propaypal</a>     

         <!-- end paypal code -->


           
            </div>
            </div>

            @else

            <div class="card" style="margin-bottom:1%;">
            <div class="card-body">
            <b> File Name:</b><p>{{$item->processed_file}}</p>
            <b> Upload Time:</b>
            <p> {{ Carbon\Carbon::parse($item->created_at)->format('d-m-Y, H: i: s') }}</p>
            <audio controls="" style="vertical-align: middle" src="{{ asset('public/upload/'.$item->processed_file) }}" type="audio/mp3" controlslist="nodownload">
                Your browser does not support the audio element.
            </audio>
            <a class="btn btn-success" href="{{ asset('public/upload/'.$item->processed_file) }}" download>Download</a>
            </div>
            </div>

            @endif
        @endforeach


       
        
        </div>    
        </div>
        </div>




      



@endsection


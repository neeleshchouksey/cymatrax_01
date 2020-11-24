@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="card-header">My Account</div>
        @foreach($getData as $item)  

        <div class="card" style="margin-bottom:1%;">
        <div class="card-body">
       
          
           <b> File Name:</b><p>{{$item->file_name}}</p>
           <b> Upload Time:</b>
           <p> {{ Carbon\Carbon::parse($item->created_at)->format('d-m-Y, H: i: s') }}</p>
           <!-- <b> File duration:</b>
           <p>--</p> -->
           
            <audio controls="" style="vertical-align: middle" src="{{ asset('public/images/'.$item->file_name) }}" type="audio/mp3" controlslist="nodownload">
                Your browser does not support the audio element.
            </audio>
          <!-- <b>  Conversion price per minutes: </b>
          $1.00  -->
        
            <a class="btn btn-success" href="{{ asset('public/images/'.$item->file_name) }}" download>Download</a>
            @if($item->cleaned == 0)
            <a class="btn btn-warning" download style="margin-left:2%;">Pay & Clean</a>
            @endif
        
        
            </div>

<!-- paypal code -->
<!-- <div class="flex-center position-ref full-height">
  
  <div class="content">

      <a href="{{ route('payment') }}" class="btn btn-success" style="margin:1%;">Pay $100 from Paypal</a>

  </div>
</div> -->
<!-- end paypal code -->

            </div>
        @endforeach


       
        
        </div>    
        </div>
        </div>




        <!-- <table class="table table-bordered">
       
        @foreach($getData as $item)
        <tr>
            <td>
           <b> File Name:</b><p>{{$item->file_name}}</p>
           <b> Upload Time:</b>
           <p> {{ Carbon\Carbon::parse($item->created_at)->format('d-m-Y, H: i: s') }}</p>
          
            <audio controls="" style="vertical-align: middle" src="{{ asset('public/images/'.$item->file_name) }}" type="audio/mp3" controlslist="nodownload">
                Your browser does not support the audio element.
            </audio>
          <b>  Conversion price per minutes: </b>
          $1.00 
            <a class="btn btn-success" href="{{ asset('public/images/'.$item->file_name) }}" download>Download</a>

            </td>
           
        </tr>
        @endforeach
     
       </table>  -->



@endsection


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
           <b> File duration:</b>
           <p>--</p>
           
            <audio controls="" style="vertical-align: middle" src="{{ asset('public/images/'.$item->file_name) }}" type="audio/mp3" controlslist="nodownload">
                Your browser does not support the audio element.
            </audio>
          <!-- <b>  Conversion price per minutes: </b>
          $1.00  -->
            <a class="btn btn-success" href="{{ asset('public/images/'.$item->file_name) }}" download>Download</a>

        
            </div>

<!-- paypal code -->
<div class="flex-center position-ref full-height">
  
  <div class="content">
      <h1>Laravel 6 PayPal Integration Tutorial - ItSolutionStuff.com</h1>
        
      <table border="0" cellpadding="10" cellspacing="0" align="center"><tr><td align="center"></td></tr><tr><td align="center"><a href="https://www.paypal.com/in/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="javascript:window.open('https://www.paypal.com/in/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;"><img src="https://www.paypalobjects.com/webstatic/mktg/Logo/pp-logo-200px.png" border="0" alt="PayPal Logo"></a></td></tr></table>

      <a href="{{ route('payment') }}" class="btn btn-success">Pay $100 from Paypal</a>

  </div>
</div>
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


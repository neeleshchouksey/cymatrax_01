@extends('layouts.app')

@section('content')

<link href="{{ asset('public/css/card.css') }}" rel="stylesheet">

<div class="container">
@if(session()->has('error'))
    <div class="alert alert-danger">
        {{ session()->get('error') }}
    </div>
@endif
    <div class="row justify-content-center">
        <div class="col-md-8">

@foreach($getData as $key=>$item)


<div class="card" style="display:none;">
   <div class="card-body">
    <audio  id="audio{{$key}}" controls=""  src="{{ asset('public/upload/'.$item->file_name) }}" type="audio/mp3" controlslist="nodownload">
       hello
    </audio>
    <input type="hidden" id="duration_in_sec{{$key}}" class="durValue"/>
      <button style="visibility:hidden;" type="button" onclick="getDuration({{$key}})" class="getdur">Get Duration</button>
    </div>
    </div>


@endforeach

<form method="POST" action="{{ URL::to('/')}}/payment/store"  id="form_id">
    {{ csrf_field() }}
    <div class="form-container">
          
        <input id="column-left" type="text" name="first-name" placeholder="First Name" required="required" />
        <input id="column-right" type="text" name="last-name" placeholder="Surname" required="required" />
        <input id="input-field" type="text" name="number" placeholder="Card Number"  />
        <input id="column-left" type="text" name="expiry" placeholder="MM / YY" required="required" />
        <input id="column-right" type="text" name="cvc" placeholder="CCV" required="required" />
 
        <div class="card-wrapper"></div>

       

        <input id="input-field" type="text" name="streetaddress" required="required" autocomplete="on" maxlength="45" placeholder="Streed Address"/>
        <input id="column-left" type="text" name="city" required="required" autocomplete="on" maxlength="20" placeholder="City"/>
        <input id="column-right" type="text" name="zipcode" required="required" autocomplete="on" pattern="[0-9]*" maxlength="5" placeholder="ZIP code"/>
        <input id="input-field" type="email" name="email" required="required" autocomplete="on" maxlength="40" placeholder="Email"/>
        <!-- <input id="input-field" type="text" name="amount" required="required" autocomplete="on" maxlength="40" placeholder="Amount" id="paypal_total_cost"/> -->
       
       <!-- file data pass -->
        <input type="text" name="amount" value="" id="paypal_total_cost"/>
        <input type="text" name="fileids" value="{{$audioids}}" id="paypal_audio_ids"/>
        <input type="text" name="totalduration" value="" id="paypal_total_duration"/>
       <!-- file data pass -->
        <input id="input-button" name="submit" type="submit" value="Submit"/>
       
       
      </div>
</form>


<div class="content" style="display:inline-flex;margin-left: 58%;">
                  

                  <!-- <form  method="Post" action="{{ route('payment') }}">
                    @csrf
                  <input type="text" name="totalcost" value="" id="paypal_total_cost"/>
                  <input type="text" name="fileids" value="{{$audioids}}" id="paypal_audio_ids"/>
                  <input type="text" name="totalduration" value="" id="paypal_total_duration"/>
                  <input type="submit" value="Pay & Checkout" class="btn btn-success" name="submit"/>
                  </form> -->
                  <span style="margin-left:1%;"><a href="{{URL::to('/file/fetch')}}" class="btn btn-success">Cancel</a></span>
  
              </div>

</div>
</div>
</div>






@endsection
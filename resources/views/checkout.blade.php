@extends('layouts.app')

@section('content')

    <div class="content">
        <section class="contained">
            <h1 class="myaccount">{{$title}}</h1>

            <div class="relative">
                @if(session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                @endif

                @foreach($getData as $key=>$item)


                    <div class="card" style="display:none;">
                        <div class="card-body">
                            <audio id="audio{{$key}}" controls=""
                                   src="{{ asset('public/upload/'.$item->file_name) }}" type="audio/mp3"
                                   controlslist="nodownload">
                                hello
                            </audio>
                            <input type="hidden" id="duration_in_sec{{$key}}" class="durValue"/>
                            <button style="visibility:hidden;" type="button" onclick="getDuration({{$key}})"
                                    class="getdur">Get Duration
                            </button>
                        </div>
                    </div>


                @endforeach


                <form class="checkoutform" method="POST" class="register"
                      id="checkout-form">
                    {{ csrf_field() }}
                    <h4>Payment Information</h4>

                    <table>
                        <tbody>
                        <tr>
                            <td>Cart Contents:</td>
                            <td>
                                Cymatrax Audio Processing
                            </td>
                        </tr>
                        <tr>
                            <td>Checkout Total:</td>
                            <td>
                                <span id="span_paypal_total_cost"></span>
                                <input type="hidden" name="amount" value="" id="paypal_total_cost"/>
                            </td>
                        </tr>
                        <tr>
                            <td>Credit Card Number:</td>
                            <td>
                                <input id="number" type="text" name="number"  pattern="[0-9]*" maxlength="16"
                                       placeholder="Card Number" onkeypress="return onlyNumberKey(event)" />
                            </td>
                        </tr>
                        <tr>
                            <td>Expiration Date:</td>
                            <td>
                                <input id="expiry" type="text" name="expiry" placeholder="MM / YY"
                                       required="required"/>
                            </td>
                        </tr>
                        <tr>
                            <td>CVV Code:</td>
                            <td>
                                <input id="cvc" type="text" name="cvc" placeholder="CVV"  pattern="[0-9]*" maxlength="4"
                                       required="required" onkeypress="return onlyNumberKey(event)" />

                            </td>
                        </tr>
                        <tr>
                            <td><h4>Billing Information</h4>
                            </td>
                        </tr>

                        <tr>
                            <td>Email</td>
                            <td>
                                <input id="email" type="email" name="email" required="required"
                                       autocomplete="on"
                                       maxlength="40" placeholder="Email" value="{{$user->email}}"/>
                            </td>
                        </tr>
                        <?php
                        $fname = "";
                        $lname = "";
                        $name = explode(" ", $user->name);
                        if (!empty($name) && isset($name[0])) {
                            $fname = $name[0];
                        }
                        if (!empty($name) && isset($name[1])) {
                            $lname = $name[1];
                        }
                        ?>
                        <tr>
                            <td>First Name:</td>
                            <td>
                                <input id="first-name" type="text" name="first-name"
                                       placeholder="First Name" value="{{$fname}}"
                                       required="required"/>
                            </td>
                        </tr>
                        <tr>
                            <td>Last Name:</td>
                            <td>
                                <input id="last-name" type="text" name="last-name"
                                       placeholder="Last Name" value="{{$lname}}"
                                       required="required"/>

                            </td>
                        </tr>
                        <tr>
                            <td>Address:</td>
                            <td>
                                <input id="streetaddress" type="text" name="streetaddress" required="required"
                                       autocomplete="on" maxlength="45" placeholder="Street Address" value="{{$user->address}}"/>

                            </td>
                        </tr>
                        <tr>
                            <td>City:</td>
                            <td>
                                <input id="city" type="text" name="city" required="required"
                                       autocomplete="on"
                                       maxlength="20" placeholder="City" value="{{$user->city}}"/>

                            </td>
                        </tr>
                        <tr>
                            <td>State:</td>
                            <td>
                                <input id="state" type="text" name="state" required="required"
                                       autocomplete="on"
                                       maxlength="20" placeholder="State" value="{{$user->state}}"/>

                            </td>
                        </tr>
                        <tr>
                            <td>Country:</td>
                            <td>
                                <select name="country" id="country" class="input" style="max-width:165px;" required >
                                    <option value="" selected="" >Select Country</option>
                                    @foreach($countries as $c)
                                        <option value="{{$c->code}}" {{$user->country==$c->code?'selected':''}}>{{$c->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Zip Code:</td>
                            <td>
                                <input id="zipcode" type="text" name="zipcode" required="required"
                                       autocomplete="on" pattern="[0-9]*" maxlength="6" value="{{$user->zip_code}}"
                                       placeholder="ZIP code" onkeypress="return onlyNumberKey(event)" />
                            </td>
                        </tr>
                        <tr></tr>
                        <tr>
                            <td>
                                <!-- file data pass -->
                                <input type="hidden" id="checkout_id" name="checkout_id" value="{{Request::segment(2)}}">
                                <input type="hidden" id="fileids" name="fileids" value="{{$audioids}}" id="paypal_audio_ids"/>
                                <input type="hidden" name="totalduration" value="" id="paypal_total_duration"/>
                                <!-- file data pass -->
                                <button id="input-button" name="submit" type="button"  onclick="window.location='{{URL::to('/')}}/account'" class="c-btn">Cancel</button>
                            </td>
                            <td><button id="process-button" name="submit" type="button" onclick="checkout();" class="c-btn">Process Payment
                                </button></td>
                        </tr>
                        </tbody>
                    </table>



                </form>


            </div>


        </section>
    </div>




@endsection

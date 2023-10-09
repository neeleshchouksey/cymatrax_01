@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <div class="content">
        <section>
            <style>
                table {
                    margin-top: 23px;
                }
                .google-logo {
                    background: linear-gradient(45deg, #DB4437 0%, #DB4437 33.33%, #4285F4 33.33%, #4285F4 66.66%, #F4B400 66.66%, #F4B400 100%);
                    color: #FFFFFF;
                    padding: 5px
                    }
                .google a {
                    padding: 10px 40px;
                    border: 3px solid;
                    /* color: #000000; */
                    border-radius: 7px;
                    text-decoration: none;
                    font-weight: 600;
                    font-size: 18px;
                }

                .google {
                    text-align: center;
                    padding-top: 30px;
                }
            </style>
            <style type="text/css">
                .register-button{
                        background-color: #44908d !important;
                    }
            </style>
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-success">
                    {{ session()->get('error') }}
                </div>
            @endif
            {{-- <div class="relative">
                @if (session('status'))
                    <div class="success">{{ session('status') }}</div>
                @endif

                @php $error = $errors->getMessages(); @endphp

                @if (isset($error['name']))
                    <div class="errors">{{ $error['name'][0] }}</div>
                @elseif(isset($error['email']))
                    <div class="errors">{{ $error['email'][0] }}</div>
                @elseif(isset($error['password']))
                    <div class="errors">{{ $error['password'][0] }}</div>
                @elseif(isset($error['streetaddress']))
                    <div class="errors">{{ $error['streetaddress'][0] }}</div>
                @elseif(isset($error['city']))
                    <div class="errors">{{ $error['city'][0] }}</div>
                @elseif(isset($error['state']))
                    <div class="errors">{{ $error['state'][0] }}</div>
                @elseif(isset($error['country']))
                    <div class="errors">{{ $error['country'][0] }}</div>
                @elseif(isset($error['zipcode']))
                    <div class="errors">{{ $error['zipcode'][0] }}</div>
                @elseif(isset($error['CaptchaCode']))
                    <div class="errors">{{ $error['CaptchaCode'][0] }}</div>
                @endif

                <br>
                <form method="POST" action="{{ route('register') }}" class="register" id="register-form">
                    @csrf

                    <table>
                        <tbody>
                        <tr>
                            <td colspan="2"><h3>Registration</h3></td>
                        </tr>
                        <tr>
                            <td>Name<span class="req">*</span> :</td>
                            <td>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                       name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            </td>
                        </tr>
                        <tr>
                            <td>Email Address<span class="req">*</span> :</td>
                            <td>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            </td>
                        </tr>
                        <tr>
                            <td>Password<span class="req">*</span> :</td>
                            <td>
                                <input id="password" type="password"
                                       class="form-control @error('password') is-invalid @enderror" name="password"
                                       required
                                       autocomplete="new-password">
                            </td>
                        </tr>
                        <tr>
                            <td>Confirm <br>Password<span class="req">*</span> :</td>
                            <td>
                                <input id="password-confirm" type="password" class="form-control"
                                       name="password_confirmation" required autocomplete="new-password">
                            </td>
                        </tr>
                        <tr>
                            <input type="hidden" name="user" value="1">
                        </tr>
                        <tr>
                            <td>Address<span class="req">*</span> :</td>
                            <td>
                                <input id="streetaddress" type="text" name="streetaddress" required="required"
                                       value="{{ old('streetaddress') }}" autocomplete="on" maxlength="45" placeholder="Street Address"/>

                            </td>
                        </tr>
                        <tr>
                            <td>City<span class="req">*</span> :</td>
                            <td>
                                <input id="city" type="text" name="city" required="required"
                                       autocomplete="on" value="{{ old('city') }}"
                                       maxlength="20" placeholder="City"/>

                            </td>
                        </tr>
                        <tr>
                            <td>State<span class="req">*</span> :</td>
                            <td>
                                <input id="state" type="text" name="state" required="required"
                                       autocomplete="on" value="{{ old('state') }}"
                                       maxlength="20" placeholder="State"/>

                            </td>
                        </tr>
                        <tr>
                            <td>Country<span class="req">*</span> :</td>
                            <td>
                                <select name="country" id="country" class="input" style="max-width:188px;">
                                    <option value="" selected="">Select Country</option>
                                    @foreach ($countries as $c)
                                        <option value="{{$c->code}}">{{$c->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Zip Code<span class="req">*</span> :</td>
                            <td>
                                <input id="zipcode" type="text" name="zipcode" required="required"
                                       value="{{ old('zipcode') }}" autocomplete="on" pattern="[0-9]*" maxlength="6"
                                       placeholder="ZIP code" onkeypress="return onlyNumberKey(event)"/>
                            </td>
                        </tr>
                        <tr>
                            <td>I am not a robot</td>
                            <td>
                                <input id="CaptchaCode" name="CaptchaCode" required placeholder="Enter captcha code"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">  {!! captcha_image_html('CymatraxCaptcha') !!}</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                            <input required type="checkbox" name="term_conditions" value="1" oninvalid="this.setCustomValidity('Please accept our legal agreements before continuing.')" onchange="this.setCustomValidity('')"/> <span style="font-size: 15px;">I understand and agree to</span> <a style="text-decoration:none; font-size: 15px;" download href="{{URL::to('/')}}/public/terms_and_conditions/Privacy Policy and Terms of Service.pdf">Privacy Policy and Terms of service</a>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <button class="register-button" type="submit" >Create Account</button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <p><a href="{{URL::to('/')}}/login">Back to login</a></p>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </form>
            </div> --}}










            <div class="relative">
                @if (session('status'))
                    <div class="success">{{ session('status') }}</div>
                @endif

                @php $error = $errors->getMessages(); @endphp

                @if (isset($error['email']))
                    <div class="errors">{{ $error['email'][0] }}</div>
                @elseif(isset($error['password']))
                    <div class="errors">{{ $error['password'][0] }}</div>
                @endif

                <br>
                <form method="POST" action="{{ route('do-register') }}" class="register" id="register-form">
                    @csrf
                    <div>
                        <h3>Registration</h3>
                        <div class="google">
                            <a href="{{ route('login-with-google') }}"><i class="google-logo fa fa-google"></i> Continue with Google</a>
                            <div style="margin-top: 33px">OR</div>
                        </div>
                    </div>
                    <table>
                        <tbody>
                            {{-- <tr>
                            <td colspan="2"></td>
                        </tr>
                        <tr><td><a href="{{route('login-with-google')}}">Continue with Google</a></td></tr>
                        <tr><td>OR</td></tr> --}}
                            <tr>
                                <td>Email Address<span class="req">*</span> :</td>
                                <td>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>
                                </td>
                            </tr>
                            <!-- <tr>
                                <td>Password<span class="req">*</span> :</td>
                                <td>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">
                                </td>
                            </tr> -->
                            <tr>
                                <td></td>
                                <td>
                                    <button class="register-button" type="submit">Create Account</button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    By clicking "Create account" or "Continue with Google" you agree to the 
                                    <span style="cursor: pointer; color: #6fb4b7" onclick="openPrivacyModel()">Cymatrax TOS and Privacy Policy</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <p><a href="{{ URL::to('/') }}/login">Back to login</a></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </form>
            </div>
        </section>


        <div class="modal fade" id="privacy-policy-modal" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div style="border-radius: 5px"  class="modal-content">
                    <div class="main-content">
                        <h2>Content of Privacy Policy</h2>
                        <p>Service Providers: We may engage with trusted service providers who assist us in operating our business and delivering our services, such as hosting providers, payment processors, customer support services, or data analysis providers. These service providers are authorized to use your personal information only as necessary to provide the requested services to us.</p>
                        <p>Service Providers: We may engage with trusted service providers who assist us in operating our business and delivering our services, such as hosting providers, payment processors, customer support services, or data analysis providers. These service providers are authorized to use your personal information only as necessary to provide the requested services to us.</p>
                        <p>Service Providers: We may engage with trusted service providers who assist us in operating our business and delivering our services, such as hosting providers, payment processors, customer support services, or data analysis providers. These service providers are authorized to use your personal information only as necessary to provide the requested services to us.</p>
                        <p>Service Providers: We may engage with trusted service providers who assist us in operating our business and delivering our services, such as hosting providers, payment processors, customer support services, or data analysis providers. These service providers are authorized to use your personal information only as necessary to provide the requested services to us.</p>
                        <p>Service Providers: We may engage with trusted service providers who assist us in operating our business and delivering our services, such as hosting providers, payment processors, customer support services, or data analysis providers. These service providers are authorized to use your personal information only as necessary to provide the requested services to us.</p>
                        <p>Service Providers: We may engage with trusted service providers who assist us in operating our business and delivering our services, such as hosting providers, payment processors, customer support services, or data analysis providers. These service providers are authorized to use your personal information only as necessary to provide the requested services to us.</p>
                        <p>Service Providers: We may engage with trusted service providers who assist us in operating our business and delivering our services, such as hosting providers, payment processors, customer support services, or data analysis providers. These service providers are authorized to use your personal information only as necessary to provide the requested services to us.</p>
                        <p>Service Providers: We may engage with trusted service providers who assist us in operating our business and delivering our services, such as hosting providers, payment processors, customer support services, or data analysis providers. These service providers are authorized to use your personal information only as necessary to provide the requested services to us.</p>
                        <p>Service Providers: We may engage with trusted service providers who assist us in operating our business and delivering our services, such as hosting providers, payment processors, customer support services, or data analysis providers. These service providers are authorized to use your personal information only as necessary to provide the requested services to us.</p>
                        <p>Service Providers: We may engage with trusted service providers who assist us in operating our business and delivering our services, such as hosting providers, payment processors, customer support services, or data analysis providers. These service providers are authorized to use your personal information only as necessary to provide the requested services to us.</p>
                        <p>Service Providers: We may engage with trusted service providers who assist us in operating our business and delivering our services, such as hosting providers, payment processors, customer support services, or data analysis providers. These service providers are authorized to use your personal information only as necessary to provide the requested services to us.</p>
                    </div>
                    <div style="text-align: center" class="privacy-footer">
                        <button style="padding: 8px 18px;background: #6fb4b7;border-radius: 5px;cursor: pointer;border: none;" onclick="closePrivacyPolicy()">Okay</button>
                    </div>
                </div>
            </div>
        </div>



    </div>
    <script>
        function openPrivacyModel() {
            $("#privacy-policy-modal").show();
        }

        function closePrivacyPolicy() {
            $("#privacy-policy-modal").hide();
        }

        function isValidEmail(email) {
          // Regular expression for validating an Email
          const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          return emailRegex.test(email);
        }

      
    </script>
@endsection

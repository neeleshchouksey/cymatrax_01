@extends('layouts.app')

@section('content')
    <div class="content">
        <section>
            <div class="relative">
                @if (session('status'))
                    <div class="success">{{ session('status') }}</div>
                @endif

                @php $error = $errors->getMessages(); @endphp

                @if(isset($error['name']))
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
                @endif

                <br>
                <form method="POST" action="{{ route('register') }}" class="register">
                    @csrf

                    <table>
                        <tbody>
                        <tr>
                            <td colspan="2"><h3>Registration</h3></td>
                        </tr>
                        <tr>
                            <td>Name:</td>
                            <td>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                       name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            </td>
                        </tr>
                        <tr>
                            <td>Email Address:</td>
                            <td>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            </td>
                        </tr>
                        <tr>
                            <td>Password:</td>
                            <td>
                                <input id="password" type="password"
                                       class="form-control @error('password') is-invalid @enderror" name="password"
                                       required
                                       autocomplete="new-password">
                            </td>
                        </tr>
                        <tr>
                            <td>Confirm Password:</td>
                            <td>
                                <input id="password-confirm" type="password" class="form-control"
                                       name="password_confirmation" required autocomplete="new-password">
                            </td>
                        </tr>
                        <tr>
                            <td>User Type</td>
                            <td>
                                <input type="radio" name="user" value="1" checked>
                                Single User


                                <input type="radio" name="user" value="2" style="margin-left: 22px;">
                                Company User
                            </td>
                        </tr>
                        <tr>
                            <td>Address:</td>
                            <td>
                                <input id="streetaddress" type="text" name="streetaddress" required="required"
                                       value="{{ old('streetaddress') }}" autocomplete="on" maxlength="45" placeholder="Street Address"/>

                            </td>
                        </tr>
                        <tr>
                            <td>City:</td>
                            <td>
                                <input id="city" type="text" name="city" required="required"
                                       autocomplete="on" value="{{ old('city') }}"
                                       maxlength="20" placeholder="City"/>

                            </td>
                        </tr>
                        <tr>
                            <td>State:</td>
                            <td>
                                <input id="state" type="text" name="state" required="required"
                                       autocomplete="on" value="{{ old('state') }}"
                                       maxlength="20" placeholder="State"/>

                            </td>
                        </tr>
                        <tr>
                            <td>Country:</td>
                            <td>
                                <select name="country" id="country" class="input" style="max-width:165px;">
                                    <option value="" selected="">Select Country</option>
                                    @foreach($countries as $c)
                                        <option value="{{$c->code}}">{{$c->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Zip Code:</td>
                            <td>
                                <input id="zipcode" type="text" name="zipcode" required="required"
                                       value="{{ old('zipcode') }}" autocomplete="on" pattern="[0-9]*" maxlength="6"
                                       placeholder="ZIP code" onkeypress="return onlyNumberKey(event)"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                            <input required="required" type="checkbox" name="term_conditions" value="1"/> <a style="font-size: 15px;" download href="{{URL::to('/')}}/public/terms_and_conditions/terms_and_conditions.pdf">Terms and Conditions</a>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <button type="submit">Create Account</button>
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
            </div>
        </section>
    </div>

@endsection

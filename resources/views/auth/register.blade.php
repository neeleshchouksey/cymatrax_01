@extends('layouts.app')

@section('content')
    <div class="content">
        <section>
            <div class="relative">
                @if (session('status'))
                    <div class="success">{{ session('status') }}</div>
                @endif
                @error('error')
                <div class="errors">{{ $message }}</div>
                @enderror
                @error('email')
                <div class="errors">{{ $message }}</div>
                @enderror
                @error('password')
                <div class="errors">{{ $message }}</div>
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
                                       autocomplete="on" maxlength="45" placeholder="Street Address"/>

                            </td>
                        </tr>
                        <tr>
                            <td>City:</td>
                            <td>
                                <input id="city" type="text" name="city" required="required"
                                       autocomplete="on"
                                       maxlength="20" placeholder="City"/>

                            </td>
                        </tr>
                        <tr>
                            <td>State:</td>
                            <td>
                                <input id="state" type="text" name="state" required="required"
                                       autocomplete="on"
                                       maxlength="20" placeholder="State"/>

                            </td>
                        </tr>
                        <tr>
                            <td>Country:</td>
                            <td>
                                <select name="country" id="country" class="input" style="max-width:165px;">
                                    <option value="" selected="" >Select Country</option>
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
                                       autocomplete="on" pattern="[0-9]*" maxlength="6"
                                       placeholder="ZIP code" onkeypress="return onlyNumberKey(event)" />
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

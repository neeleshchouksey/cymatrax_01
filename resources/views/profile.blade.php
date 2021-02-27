@extends('layouts.app')

@section('content')
    <div class="content" >
        <section class="contained" >
            <h1 class="myaccount" >{{$title}}</h1>

            <div class="relative" >
                @if (session('status'))
                    <div class="success" >{{ session('status') }}</div>
                @endif
                @error('name')
                <div class="errors" >{{ $message }}</div>
                @enderror
                @error('email')
                <div class="errors" >{{ $message }}</div>
                @enderror
                @error('password')
                <div class="errors" >{{ $message }}</div>
                @endif
                <br>
                <form method="POST" action="{{ route('update-profile') }}" class="register" >
                    @csrf

                    <table>
                        <tbody>
                        <tr>
                            <td colspan="2" ><h3>Profile</h3></td>
                        </tr>
                        <tr>
                            <td>Name:</td>
                            <td>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                       name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>
                            </td>
                        </tr>
                        <tr>
                            <td>Email Address:</td>
                            <td>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ $user->email }}" readonly autocomplete="email" autofocus>
                            </td>
                        </tr>
                        <tr>
                            <td>User Type</td>
                            <td>
                                <input type="radio" name="user" value="1" @if($user->user == 1) checked @endif>
                                Single User


                                <input type="radio" name="user" value="2" @if($user->user == 2) checked @endif>
                                Company User
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
                                <select name="country" id="country" class="input" style="max-width:165px;" >
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
                        <tr>
                            <td></td>
                            <td>
                                <button type="submit" >Update Profile</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </form>
            </div>
        </section>
    </div>

@endsection

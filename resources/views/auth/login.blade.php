@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <div class="content">
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
                    /* padding-top: 30px; */
                }
        </style>
        <section>
            @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                @endif
            <div class="relative">
                @error('email')
                <div class="errors">{{ $message }}</div>
                @enderror
                @error('password')
                <div class="errors">{{ $message }}</div>
                @endif
                <br>
                <form method="POST" action="{{ route('login') }}" class="login">
                    @csrf
                    <div class="google">
                        <h3>Customer Login</h3><br>
                        <a href="{{ route('login-with-google') }}"><i class="google-logo fa fa-google"></i> Continue with Google</a>
                        <div style="margin-top: 33px">OR</div>
                    </div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="6">
                        <tbody>
                        {{-- <tr>
                            <td colspan="2"><h3>Customer Login</h3></td>
                        </tr> --}}

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
                                       required autocomplete="current-password">
                            </td>
                        </tr>
                        <tr>
                            <td><input type="hidden" value="1" name="sent"/></td>
                            <td>
                                <button>Sign In</button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <p>Forgot your password? <a href="{{ route('password.request') }}">Click Here</a></p>
                                <p>Don't have an account? <a href="{{ route('register') }}">Create one</a></p>
                                @if (session('email__'))
                                <p>Verify your email? <a href="{{route('send-verify-email', session('email__'))}}">Click Here</a></p>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </section>
    </div>
@endsection

@extends('layouts.app')

@section('content')

    <div class="content">
        <section>

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
                    <table width="100%" border="0" cellspacing="0" cellpadding="6">
                        <tbody>
                        <tr>
                            <td colspan="2"><h3>Customer Login</h3></td>
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
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </section>
    </div>
@endsection

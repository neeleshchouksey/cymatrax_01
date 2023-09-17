@extends('layouts.app')

@section('content')
<style type="text/css">
    .reset-button{
            background-color: #44908d !important;
        }
</style>
    <div class="content">
        <section>
            <div class="relative">
                @if (session('status'))
                    <div class="success">{{ session('status') }}</div>
                @endif
                @error('email')
                <div class="errors">{{ $message }}</div>
                @enderror
                <br>
                <form method="POST" action="{{ route('password.email') }}" autocomplete="off" class="register">
                    @csrf
                    <table>
                        <tbody>
                        <tr>
                            <td colspan="2"><h3>Forget Password</h3></td>
                        </tr>
                        <tr>
                            <td>Email Address:</td>
                            <td>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <button class="reset-button" type="submit">Reset</button>
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

@extends('layouts.app')

@section('content')
<style type="text/css">
    .change-password-button{
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
                @error('password')
                <div class="errors">{{ $message }}</div>
                @endif
                <br>
                <form method="POST" action="{{ route('change-password') }}" class="register">
                    @csrf
                    <input type="hidden" name="id" value="{{ $id }}">
                    <table>
                        <tbody>
                        <tr>
                            <td colspan="2"><h3>Change Password</h3></td>
                        </tr>
                        <tr>
                            <td>Password</td>
                            <td>
                                <input id="password" type="password"
                                       class="form-control @error('password') is-invalid @enderror" name="password"
                                       required autocomplete="new-password">
                            </td>
                        </tr>
                        <tr>
                            <td>Confirm Password</td>
                            <td>
                                <input id="password-confirm" type="password" class="form-control"
                                       name="password_confirmation" required autocomplete="new-password">
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <button class="change-password-button" type="submit">Change Password</button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </section>
    </div>

@endsection

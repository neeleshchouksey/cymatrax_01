@extends('layouts.app')

@section('content')
    <div class="content">
        <section>
            @include('layouts/menu')

            <div class="relative">
                @if (session('status'))
                    <div class="success">{{ session('status') }}</div>
                @endif
                @error('name')
                <div class="errors">{{ $message }}</div>
                @enderror
                @error('email')
                <div class="errors">{{ $message }}</div>
                @enderror
                @error('password')
                <div class="errors">{{ $message }}</div>
                @endif
                <br>
                <form method="POST" action="{{ route('update-profile') }}" class="register">
                    @csrf

                    <table>
                        <tbody>
                        <tr>
                            <td colspan="2"><h3>Profile</h3></td>
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
                            <td></td>
                            <td>
                                <button type="submit">Update Profile</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </form>
            </div>
        </section>
    </div>

@endsection

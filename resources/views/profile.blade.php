@extends('layouts.app')

@section('content')
    <style>
        .buttons a {
            padding: 10px;
            border: 1px solid;
            border-radius: 5px;
            text-decoration: none;
            margin: 10px 0;
        }

        .buttons td {
            padding: 10px 20px 20px 0 !important;
        }
    </style>
    <div class="content">
        <div class="modal fade" id="cancel-plan-modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="updatePlan()">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <section class="contained">
            <h1 class="myaccount">{{ $title }}</h1>

            <div class="relative">
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
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
                                    <td colspan="2">
                                        <h3>Profile</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Name:</td>
                                    <td>
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ $user->name }}" required autocomplete="name" autofocus>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Email Address:</td>
                                    <td>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ $user->email }}" readonly autocomplete="email" autofocus>
                                    </td>
                                </tr>
                                {{-- <tr>
                            <td>User Type</td>
                            <td>
                                <input type="radio" name="user" value="1" @if ($user->user == 1) checked @endif>
                                Single User


                                <input type="radio" name="user" value="2" @if ($user->user == 2) checked @endif>
                                Company User
                            </td>
                        </tr> --}}
                                <tr>
                                    <td>Subscription :</td>
                                    <td>
                                        <input type="text" disabled name="plan_name"
                                            value="{{ $user->subscription == 1 ? $user->plan_name : "Your don't have it" }}">


                                    </td>
                                </tr>
                                <tr class="buttons">
                                    @if ($user->subscription == 1)

                                        <td>
                                            <a href="{{ route('subscription') }}">Upgrade Plan</a>
                                        </td>
                                        <td onclick="cancelPlannn()">
                                            <a href="#">Cancel Plan</a>
                                            {{-- Cancel Plan --}}
                                        </td>
                                    @else
                                        <td>
                                            <a href="{{ route('subscription') }}">Select Plan</a>
                                        </td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>Address:</td>
                                    <td>
                                        <input id="streetaddress" type="text" name="streetaddress" required="required"
                                            autocomplete="on" maxlength="45" placeholder="Street Address"
                                            value="{{ $user->address }}" />

                                    </td>
                                </tr>
                                <tr>
                                    <td>City:</td>
                                    <td>
                                        <input id="city" type="text" name="city" required="required"
                                            autocomplete="on" maxlength="20" placeholder="City" value="{{ $user->city }}" />

                                    </td>
                                </tr>
                                <tr>
                                    <td>State:</td>
                                    <td>
                                        <input id="state" type="text" name="state" required="required"
                                            autocomplete="on" maxlength="20" placeholder="State" value="{{ $user->state }}" />

                                    </td>
                                </tr>
                                <tr>
                                    <td>Country:</td>
                                    <td>
                                        <select name="country" id="country" class="input" style="max-width:165px;">
                                            <option value="" selected="">Select Country</option>
                                            @foreach ($countries as $c)
                                                <option value="{{ $c->code }}"
                                                    {{ $user->country == $c->code ? 'selected' : '' }}>{{ $c->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Zip Code:</td>
                                    <td>
                                        <input id="zipcode" type="text" name="zipcode" required="required"
                                            autocomplete="on" pattern="[0-9]*" maxlength="6" value="{{ $user->zip_code }}"
                                            placeholder="ZIP code" onkeypress="return onlyNumberKey(event)" />
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
        <script>
            function cancelPlannn() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to cancel your plan",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Cancel it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: "get",
                            url: APP_URL + "/cancel-plan",
                            success: function(response) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: response.msg,
                                    icon: 'success',
                                    showCancelButton: false,
                                }).then((result) => {
                                    location.reload();
                                })
                            },
                            error: function(error) {
                                Swal.fire({
                                    title: "Error",
                                    text: error.responseJSON.msg,
                                    icon: "error",
                                });
                            }
                        });
                    }
                });
            }
        </script>
    @endsection

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
                    <h2 style="color: green; text-align:center">That's great plan</h2><br>
                    <form method="POST" action="{{ route('paymentProcess') }}" class="payment">
                        @csrf
                        <table width="100%" border="0" cellspacing="0" cellpadding="6">
                            <tbody>

                                <tr>
                                    <td colspan="2"><b>Caymatrax "{{ $data[0]->name }}" Subscription</b></td>
                                </tr>
                                <tr>
                                    <td><h3 style="color: green">Monthly Cost :</h3></td>
                                    <td><h3 style="color: green">{{$data[0]->charges}}$ Plus tax</h3></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <h3>Billing Information</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <input type="hidden" value="{{ $data[0]->id }}" name="plan_id">
                                    <td>Email :</td>
                                    <td>
                                        <input id="name" type="text" disabled
                                            class="form-control @error('name') is-invalid @enderror" name="name" disabled
                                            value="{{ Auth::user()->email }}" required>
                                    </td>
                                </tr>
                                @php
                                    $name_parts = explode(' ', Auth::user()->name);
                                @endphp
                                <tr>
                                    <td>First Name :</td>
                                    <td>
                                        <input id="charge" disabled value="{{ $name_parts[0] ?? '' }}" type="text"
                                            disabled class="form-control  @error('text') is-invalid @enderror" name="charge"
                                            required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Last Name :</td>
                                    <td>
                                        <input id="charge" disabled value="{{ $name_parts[1] ?? '' }}" type="text"
                                            disabled class="form-control  @error('text') is-invalid @enderror" name="charge"
                                            required>
                                    </td>
                                </tr>
                                </tr>
                                <tr>
                                    <td>Address :</td>
                                    <td>
                                        <input id="charge" disabled value="{{ Auth::user()->address ?? '' }}" type="text"
                                            disabled class="form-control  @error('text') is-invalid @enderror" name="charge"
                                            required>
                                    </td>
                                </tr>
                                </tr>
                                <tr>
                                    <td>City :</td>
                                    <td>
                                        <input id="charge" disabled value="{{ Auth::user()->city ?? '' }}" type="text"
                                            disabled class="form-control  @error('text') is-invalid @enderror" name="charge"
                                            required>
                                    </td>
                                </tr>
                                </tr>
                                <tr>
                                    <td>State :</td>
                                    <td>
                                        <input id="charge" disabled value="{{ Auth::user()->state ?? '' }}" type="text"
                                            disabled class="form-control  @error('text') is-invalid @enderror" name="charge"
                                            required>
                                    </td>
                                </tr>
                                </tr>
                                <tr>
                                    <td>Country :</td>
                                    <td>
                                        <input id="charge" disabled value="{{ Auth::user()->country ?? '' }}" type="text"
                                            disabled class="form-control  @error('text') is-invalid @enderror" name="charge"
                                            required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Zip Code :</td>
                                    <td>
                                        <input id="charge" disabled value="{{ Auth::user()->zip_code ?? '' }}"
                                            type="text" disabled class="form-control  @error('text') is-invalid @enderror"
                                            name="charge" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <button type="submit">Process Payment</button>
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

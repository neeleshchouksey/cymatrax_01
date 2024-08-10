@extends('layouts.app')

@section('content')
    <div class="content">
        <section>
            <br><br><br>
            <center>
                <h3 style="color: green">Payment</h3>
            </center>

            <div class="relative">
                @error('email')
                    <div class="errors">{{ $message }}</div>
                @enderror
                @error('password')
                    <div class="errors">{{ $message }}</div>
                    @endif

                    <form method="POST" action="{{ route('onetimePaymentProcess') }}" class="payment">
                        @csrf
                        <table width="100%" border="0" cellspacing="0" cellpadding="6">
                            <tbody>
                                <input type="hidden" name="value" value={{ $postData['charge'] }}>

                                <tr>
                                    <td>
                                        <h3 style="color: green">Total Cost :</h3>
                                    </td>
                                    <td>
                                        <h3 style="color: green">${{ $postData['charge'] }}</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <h3>Billing Information</h3>
                                    </td>
                                </tr>
                                <tr>

                                    <td>Email :</td>
                                    <td>
                                        <input id="name" type="text" disabled
                                            class="form-control @error('name') is-invalid @enderror" name="name" disabled
                                            value="{{ Auth::user()->email ?? '' }}" required>
                                    </td>
                                </tr>

                                <td colspan="2">
                                    <div class="">
                                        <strong> <input type="checkbox" name="checkbox" id="checkb1"></strong>I understand
                                        that i am agreeing to a subscription.it will renew at the price and frequency listed
                                        until it ends or is cancelled. Discounts are applicable to the first subscription order
                                        only unless othewise stated.
                                    </div>
                                </td>
                                </tr>

                                <tr>
                                    <td>
                                        <button type="submit" id="processPaymentBtn">Complete Order</button>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            const $checkbox = $('#checkb1');
            const $processPaymentBtn = $('#processPaymentBtn');

            // Disable the button initially if the checkbox is not checked
            $processPaymentBtn.prop('disabled', !$checkbox.is(':checked'));

            $checkbox.on('change', function() {
                $processPaymentBtn.prop('disabled', !this.checked);
            });
        });
    </script>

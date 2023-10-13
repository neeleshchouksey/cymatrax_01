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
                    {{-- <h2 style="color: green; text-align:center">That's a great plan!</h2> --}}
                    <br>
                    <br>
                    <form method="POST" action="{{ route('paymentProcess') }}" class="payment">
                        @csrf
                        <table width="100%" border="0" cellspacing="0" cellpadding="6">
                            <tbody>
                                <input type="hidden" name="value" value={{$data[0]->charges}}>
                                <input type="hidden" name="plan_id" value={{$data[0]->plan_id}}>
                                <tr>
                                    <td colspan="2"><b>Cymatrax "{{ $data[0]->name }}" Subscription</b></td>
                                </tr>
                                <tr>
                                    <td><h3 style="color: green">Monthly Cost :</h3></td>
                                    <td><h3 style="color: green">${{$data[0]->charges}}</h3></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <h3>Billing Information</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <input type="hidden" value="{{ $data[0]->plan_id }}" name="plan_id">
                                    <td>Email :</td>
                                    <td>
                                        <input id="name" type="text" disabled
                                            class="form-control @error('name') is-invalid @enderror" name="name" disabled
                                            value="{{ Auth::user()->email ?? '' }}" required>
                                    </td>
                                </tr>
                                @php
                                    $name_parts = Auth::user()->name ? explode(' ', Auth::user()->name) : '';
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
                                <td colspan="2">
                                        <div class="alert alert-warning" style="background-color: pink;display: none;">
                                            <strong>!</strong> To Continue with your purchase, agree to deferred or recurring purchase terms
                                        </div>    
                                    </td>
                                
                                        </tr>
                                <tr>
                                <td colspan="2">
                                        <div class="" >
                                            <strong> <input type="checkbox" name="checkbox" id="checkb1" onclick="showmsg(event)"></strong>I understand that I am agreeing to a subscription.
                                            It will autorenew at the list price at renewal time and at the stated subscription interval until it is cancelled.
                                            A reminder will be sent X days before your credit card is charged.
                                            Discounts are applicable to the first subscription order only unless otherwise stated.
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

        $checkbox.on('change', function () {
            $processPaymentBtn.prop('disabled', !this.checked);
        });
    });
     function showmsg(e) {
                if ($("#checkb1").prop("checked")) {
                    $(".alert.alert-warning").show();
                } else {
                    $(".alert.alert-warning").hide();
                }
    }
</script>

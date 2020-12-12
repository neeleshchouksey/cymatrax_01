@extends('layouts.app')
@section('content')


    <div class="content">
        @include('layouts/menu')

        <section>
            <div class="relative">
                <h3>Transaction History</h3>
                <table class="transaction-table" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                        <th>S. No.</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th> Email</th>
                        <th>Total Duration</th>
                        <th>Total Price</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($paymentdetails as $key=>$item)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$item->firstname}}</td>
                            <td>{{$item->lastname}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->duration}}</td>
                            <td>${{$item->totalprice}}</td>
                            <td><a href="{{URL::to('/')}}/transaction-details/{{$item->id}}">View Details</a></td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </section>


@endsection

@extends('layouts.app')
@section('content')

    <section class="contained">
        <h1 class="myaccount">{{$title}}</h1>
        <div class="relative">
            @if(count($paymentdetails))
                <table id="example" class="stripe hover"  style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead>
                    <tr style="text-align: left">
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
            @else
                <h4>No transaction history found</h4>
            @endif
        </div>
    </section>



@endsection

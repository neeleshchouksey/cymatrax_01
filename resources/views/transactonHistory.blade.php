@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
          
            <table class="table">
            <thead>
                <tr>
                    <!-- <th>id </th> -->
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th> Email</th>
                    <th>Total Duration</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($paymentdetails as $item)
            <tr>
               <!-- <td>id{{$item->id}}</td> -->
                <td>{{$item->firstname}}</td>
                <td>{{$item->lastname}}</td>
                <td>{{$item->email}}</td>
                <td>{{$item->duration}}</td>
                <td>${{$item->totalprice}}</td>
                <td><a href="{{URL::to('/')}}/transactionfileinfo/{{$item->id}}">View Details</a></td>

            </tr>
            @endforeach
           </tbody>
           </table>
           
</div>
</div>
</div>
<script>
    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){

            Swal.fire({
                title: 'Thank You',
                text: 'Payment Completed Successfully',
                icon: 'success',
                showCancelButton: false,
            });
    }
  </script>

@endsection

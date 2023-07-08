<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @if ($status == 1)
        <h1>You have successfully purchase {{$plan_name}} subscription please click below button to go My Account and start clean files</h1>
        <div>
            <a href="{{route('my_account')}}">Go to My Account</a>
        </div> 
    @else
        <h1>Something went wrong while your subscription please select subscription using below button and try again</h1>
        <div>
            <a href="{{route('subscription')}}">Go to Subscription page</a>
        </div>
    @endif
    
</body>
</html>
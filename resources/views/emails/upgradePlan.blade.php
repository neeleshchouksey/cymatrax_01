<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>..</title>
</head>

<body>
    @if (!empty(Auth::user()->name))
        <p>Hello {{Auth::user()->name}},</p>
        <br>
    @endif
    <p>Congratulations! You have sucessfully upgraded with our {{$plan_name}} plan</p><br>
    <p>Thanks!</p>
    <p>Team Cymatrax</p>
    <br><br><br>
</body>

</html>

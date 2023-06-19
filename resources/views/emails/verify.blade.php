<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>..</title>
    <style>
        .btn a {
            padding: 10px 15px;
            border: 1px solid #000000;
            border-radius: 5px;
            background: #ffffff;
            color: #000000;
            text-decoration: none;
            font-size: 18px;
            font-weight: 600;
        }

        .btn {
            border: none;
            padding: 0;
        }
    </style>
</head>

<body>
    <h1>Verify your email address</h1>
    <br>
    <p>Please click below button for verify your email</p><br>
    <button class="btn"><a href="{{ route('verify-user', $id) }}">Verify Email</a></button>
    <br><br><br>
</body>

</html>

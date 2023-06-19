<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <style>
        .inbox-main {
            text-align: center;
            margin: 100px auto 0;
            background: #ffffff;
            width: auto;
            max-width: 430px;
            padding: 0 20px;
            font-family: sans-serif;
            box-shadow: 0 3px 10px rgb(0 0 0 / 0.2);
        }

        img {
            max-width: 200px;
            margin-top: 20px;
        }

        .google_btn {
            border: 3px solid;
            border-radius: 8px;
            padding: 10px 80px;
            text-decoration: none;
            font-size: 22px;
            font-weight: 600;
            color: #000000;
        }
    </style>
</head>

<body>
    <div class="inbox-main">
        <img src="{{ asset('/assets/images/inbox2.png') }}" alt="">
        <h1>Check your inbox</h1>
        <p>Click on the link we sent to <b>{{ session('email__sentt') }}</b> to finish your account setup.</p><br>
        <a class="google_btn" target="_blank" href="https://mail.google.com/mail/u/0/#inbox">Open Gmail</a>
        <br><br>
        <p>No email in your inbox or span folder? Let's <a
                href="{{ route('send-verify-email', session('email__sentt')) }}">resend it</a></p>
        <br><br>
    </div>
</body>

</html>

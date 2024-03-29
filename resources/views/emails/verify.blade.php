<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Verification</title>

</head>

<body>
    <div class="container" style="   background: #e9e9f5;">
        <div class="header" style=" background-color: #e9e9f5;">
            <div class="content" style="text-align: center;background: #e9e9f5;   margin: 0 auto;
            max-width: 600px;
            background: #ffffff;
            padding: 30px 40px;
            color: #000000;
            font-family: 'Lato', sans-serif;
            font-size: 16px;
            line-height: 1.5;
            text-align: left;">
                <img style="max-height: 148px; height: 148px; margin: 0 auto; display: block;" src="{{URL::to('/')}}/assets/images/logo.banner.png" class="CToWUd a6T" data-bit="iit" tabindex="0">
            </div>
        </div>

        <div class="content" style="  margin: 0 auto;
            max-width: 600px;
            background: #ffffff;
            padding: 30px 40px;
            color: #000000;
            font-family: 'Lato', sans-serif;
            font-size: 16px;
            line-height: 1.5;
            text-align: left;">
            <p style="font-size: 16px; margin: 0 0 10px 0;">Hello!</p>
            <p style="font-size: 16px; margin: 0 0 10px 0;">Verify your email address.</p>
            <p style="font-size: 16px; margin: 0 0 10px 0;">Please click the button below to verify your email.</p>
            <p style="margin: 0;">

                    <a href="{{ route('verify-user', $id) }}" style="padding: 10px 15px;border-radius: 5px;background: #44908d;color: white;text-decoration: none;font-size: 16px;font-weight: 600;cursor: pointer;">Verify Email</a>

            </p><br><br>
            <p style="margin: 0;"><span style="font-size: 16px;">Regards,</span></p>
            <p style="margin: 0;"><span style="font-size: 16px;">Cymatrax</span></p>
            <br>
            <hr>
            <br>
            <p style="font-size: 14px; margin: 0 0 10px 0;">If you're having trouble clicking the "Verify Email" button, copy and paste the URL below into your web browser: <a href="{{ route('verify-user', $id) }}">{{ route('verify-user', $id) }}</a></p>
        </div>

        <div class="footer" style=" background: #e2e6e9;
            font-family: 'Lato', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            text-align: center;
            padding: 10px;
            color: #333333;
            font-weight: 400;
            display: block;">
            <p style="margin: 0 auto; display: block;">© 2023 Cymatrax. All rights reserved.</p>
        </div>
    </div>
</body>

</html>

<div class="contained">
    <h1 class="myaccount">My Account</h1>
    <button class="profileButton" onclick="$('.profileMenu').toggleClass('open');"></button>
    <ul class="profileMenu">
        <li><a href="{{URL::to('/')}}/home/">Upload Audio</a></li>
        <li><a href="{{URL::to('/')}}/transactions/">Transactions</a></li>
        <li><a href="{{URL::to('/')}}/profile/">Edit Profile</a></li>
        <li><a href="{{URL::to('/')}}/password/reset">Reset Password</a></li>
    </ul>
</div>

<div class="contained">
    <h1 class="myaccount"><?php echo e($title); ?></h1>
    <button class="profileButton" onclick="$('.profileMenu').toggleClass('open');"></button>
    <ul class="profileMenu">
        <li><a href="<?php echo e(URL::to('/')); ?>/upload-audio/">Upload Audio</a></li>
        <li><a href="<?php echo e(URL::to('/')); ?>/transactions/">Transactions</a></li>
        <li><a href="<?php echo e(URL::to('/')); ?>/profile/">Edit Profile</a></li>
        <li><a href="<?php echo e(URL::to('/')); ?>/password/reset">Reset Password</a></li>
    </ul>
</div>
<?php /**PATH /opt/lampp/htdocs/cymatrax_waves/resources/views/layouts/menu.blade.php ENDPATH**/ ?>
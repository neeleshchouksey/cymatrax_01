<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Cymatrax</title>
    <meta name="description" content="Cymatrax offers audio processing...">
    <meta name="keywords" content="Audio Processing, Audio Equalization">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="icon" type="image/png" href="<?php echo e(URL::to('/')); ?>/assets/images/favicon.png">
    <link rel="stylesheet" href="<?php echo e(asset('public/dropzone/dist/dropzone.css')); ?>"/>
    <link href="<?php echo e(URL::to('/')); ?>/assets/css/index.css" rel="stylesheet"/>
    <script>
        var APP_URL = '<?php echo e(URL::to("/")); ?>';
        var CSRF_TOKEN = '<?php echo e(csrf_token()); ?>'
    </script>


</head>
<body>
<header>
    <div class="inner-header">
        <img src="<?php echo e(URL::to('/')); ?>/assets/images/logo.banner.png" class="logo-banner"/>
        <img src="<?php echo e(URL::to('/')); ?>/assets/images/logo.png" class="logo-icon"/>
        <a class="mobile-toggle" onclick="$('header ul').toggleClass('open');">&#9776;</a>
        <ul>
            <?php if(Auth::user()): ?>
                <li><a href="<?php echo e(URL::to('/')); ?>/dashboard">Dashboard</a></li>
                <li><a href="<?php echo e(URL::to('/')); ?>/services/">Services</a></li>
                <li><a href="<?php echo e(URL::to('/')); ?>/account">My Account</a></li>
                <li>
                    <a href="<?php echo e(route('logout')); ?>"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        Sign Out
                    </a>

                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                        <?php echo csrf_field(); ?>
                    </form>

                </li>
            <?php else: ?>
                <li><a href="<?php echo e(URL::to('/')); ?>">Home</a></li>
                <li><a href="<?php echo e(URL::to('/')); ?>/services/">Services</a></li>
                <li><a href="<?php echo e(URL::to('/')); ?>/login">Login</a></li>
            <?php endif; ?>
        </ul>
    </div>
</header>

<div id="app">
    <?php echo $__env->yieldContent('content'); ?>
</div>
<footer>
    <div class="inner-footer">
        <p class="copyright">&copy; 2020, All Rights Reserved, cymatrax.com</p>
        <nav>
            <a href="<?php echo e(URL::to('/')); ?>/privacy/">Privacy Policy</a> | <a href="<?php echo e(URL::to('/')); ?>/terms/">Terms
                of Use</a>
        </nav>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="<?php echo e(asset('public/dropzone/dist/dropzone.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/app.js')); ?>" defer></script>
    <script src="<?php echo e(asset('public/js/component.js')); ?>"></script>
    <!-- sweet aleart -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Include a polyfill for ES6 Promises (optional) for IE11 -->
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
    <!-- paypal pro scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://unpkg.com/wavesurfer.js"></script>
    <script src="<?php echo e(asset('public/js/jquery.card.js')); ?>"></script>
    <script src="<?php echo e(asset('public/js/card.js')); ?>"></script>
    <!-- paypal pro scripts end-->
    <script>
        $(document).ready(function () {


            var userSelection = document.getElementsByClassName('getdur');

            console.log(userSelection);


            for (var i = 0; i < userSelection.length; i++) {
                (userSelection[i]).click();
            }

            var total_duration = 0;

            setTimeout(() => {
                var total = 0;
                for (var i = 0; i < userSelection.length; i++) {
                    total = $("#duration_in_sec" + i).val();
                    total_duration = total_duration + parseFloat(total);
                }
                var minutes = Math.floor(total_duration / 60);
                var seconds = Math.floor(total_duration % 60);

                var per_sec_cost = 1 / 60;

                total_cost = per_sec_cost * total_duration;

                $("#total-duration").html(minutes + ' min ' + seconds + ' sec')
                $("#total-cost").html('$' + total_cost.toFixed(2))


                total_cost = total_cost.toFixed(2);
                $("#paypal_total_cost").val(total_cost)
                $("#span_paypal_total_cost").html("$ "+total_cost);
                $("#paypal_total_duration").val( minutes + '.' + seconds)
            }, 1500);

        });
    </script>
    <script>
        var msg = '<?php echo e(Session::get('alert')); ?>';
        var exist = '<?php echo e(Session::has('alert')); ?>';
        if (exist) {

            Swal.fire({
                title: 'Thank You',
                text: msg,
                icon: 'success',
                showCancelButton: false,
            });
        }
     var msg = '<?php echo e(Session::get('error')); ?>';
        var exist = '<?php echo e(Session::has('error')); ?>';
        if (exist) {
            Swal.fire({
                title: 'Error!',
                text: msg,
                icon: 'error',
                showCancelButton: false,
            });
        }
    </script>


    <script>
        <?php if(isset($file)): ?>
        $(document).ready(function(){
            var wavesurfer = WaveSurfer.create({
                container: '#input-waveform',
                waveColor: '#384a50',
                progressColor: '#71b3b0',
                barWidth: 3
            });

            var wavesurfer1 = WaveSurfer.create({
                container: '#output-waveform',
                waveColor: '#71b3b0',
                progressColor: '#384a50',
                barWidth: 3
            });

            wavesurfer.load(APP_URL+'/public/upload/<?php echo e($file->file_name); ?>');
            wavesurfer1.load(APP_URL+'/public/upload/<?php echo e($file->processed_file); ?>');

            $("#play-btn").click(function (){
                wavesurfer.play();
            });
            $("#pause-btn").click(function (){
                wavesurfer.pause();
            });
           $("#play-btn1").click(function (){
                wavesurfer1.play();
            });
            $("#pause-btn1").click(function (){
                wavesurfer1.pause();
            });
            // $("#output-btn").click(function (){
            //     wavesurfer1.playPause();
            // });
        });
        <?php endif; ?>
    </script>

</footer>
</body>
</html>
<?php /**PATH /opt/lampp/htdocs/cymatrax_waves/resources/views/layouts/app.blade.php ENDPATH**/ ?>
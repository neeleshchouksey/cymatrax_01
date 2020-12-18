<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Cymatrax')); ?></title>

    <!-- Scripts -->
<!-- for pro paypal -->
<!-- <link href="<?php echo e(asset('public/css/card.css')); ?>" rel="stylesheet"> -->


<!-- end pro paypal -->
    <script>
        var APP_URL = '<?php echo e(URL::to("/")); ?>';
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
                $("#total-cost").html( '$' + total_cost.toFixed(2))



                total_cost=total_cost.toFixed(2);
                document.getElementById("paypal_total_cost").setAttribute('value',total_cost);
                document.getElementById("paypal_total_duration").setAttribute('value',minutes+'.'+seconds);


            }, 1500);

        });
    </script>







    <script src="<?php echo e(asset('assets/dropzone/dist/dropzone.js')); ?>"></script>
    <link rel="stylesheet" href="<?php echo e(asset('assets/dropzone/dist/dropzone.css')); ?>"/>


    <script src="<?php echo e(asset('public/js/app.js')); ?>" defer></script>
    <script src="<?php echo e(asset('public/js/component.js')); ?>"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="<?php echo e(asset('public/css/app.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('public/css/style.css')); ?>" rel="stylesheet">


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
        $(document).ready(function(){
            var wavesurfer = WaveSurfer.create({
                container: '#waveform',
                waveColor: 'violet',
                progressColor: 'purple'
            });

            wavesurfer.load(APP_URL+'/public/upload/1607512830_3B.WAV');


        });


    </script>

</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                <?php echo e(config('app.name', 'Cymatrax')); ?>

            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="<?php echo e(__('Toggle navigation')); ?>">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    <?php if(auth()->guard()->guest()): ?>

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('/home')); ?>"><?php echo e(__('Home')); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><?php echo e(__('Service')); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('login')); ?>"><?php echo e(__('Login')); ?></a>
                        </li>
                        <?php if(Route::has('register')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('register')); ?>"> <?php echo e(__('Register')); ?></a>
                            </li>
                        <?php endif; ?>

                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('/home')); ?>"><?php echo e(__('Home')); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><?php echo e(__('Service')); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href='<?php echo e(URL::to("file/fetch")); ?>'><?php echo e(__('My Account')); ?></a>
                        </li>
                        <li class="nav-item">
                        <!-- <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <?php echo e(Auth::user()->name); ?>

                            </a> -->

                            <!-- <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown"> -->
                            <a class="nav-link" href="<?php echo e(route('logout')); ?>"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <?php echo e(__('Sign Out')); ?>

                            </a>

                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                <?php echo csrf_field(); ?>
                            </form>


                            <!-- </div> -->
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div id="waveform"></div>

        <?php echo $__env->yieldContent('content'); ?>
    </main>
</div>
</body>
</html>
<?php /**PATH /opt/lampp/htdocs/cymatrax_01/resources/views/layouts/app.blade.php ENDPATH**/ ?>
<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <h3><b>Payment Details </b></h3>
      <div class="outer-box">

        <?php $__currentLoopData = $getData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


        <div class="card" style="margin-bottom:1%;">
        <div class="card-body">
        <p id="demo"></p>


           <b> File Name:</b><p><?php echo e($item->file_name); ?></p>


            <audio id="audio<?php echo e($key); ?>" controls="" style="vertical-align: middle" src="<?php echo e(asset('public/upload/'.$item->file_name)); ?>" type="audio/mp3" controlslist="nodownload">
                Your browser does not support the audio element.
            </audio>
            <input type="hidden" id="duration_in_sec<?php echo e($key); ?>" class="durValue"/>
             <b> File duration = <span id="duration<?php echo e($key); ?>" ></span> </b>
              <button style="visibility:hidden;" type="button" onclick="getDuration(<?php echo e($key); ?>)" class="getdur">Get Duration</button>
              <span id="ids<?php echo e($key); ?>" ></span>
            </div>

            </div>


        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


       <b>Total duration = <span id="total-duration"></span></b> <br>
       <b>Total Cost =  <span id="total-cost"></span> </b><br>
       <b>($1 per minute) </b>

     <!-- paypal code -->
           <div class="content">
                  

              
  
            </div>
     <!-- end paypal code -->
    
        </div>
        </div>
        </div>
        </div>




<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/cymatrax_waves/resources/views/paymentinfo.blade.php ENDPATH**/ ?>
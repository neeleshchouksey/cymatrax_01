<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <h3><b>Upload Summary</b></h3>
      <div class="outer-box">

        <?php $__currentLoopData = $getData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


        <div class="card" style="margin-bottom:1%;">
        <div class="card-body">
        <p id="demo"></p>


           <b> File Name:</b><p><?php echo e($item->file_name); ?></p>


            <audio  id="audio<?php echo e($key); ?>" controls="" style="vertical-align: middle" src="<?php echo e(asset('public/upload/'.$item->file_name)); ?>" type="audio/mp3" controlslist="nodownload">
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
           <div class="content" >
                <!-- <form  method="Post" action="<?php echo e(route('payment')); ?>"> -->
                  <!-- <?php echo csrf_field(); ?> -->
                <!-- <input type="hidden" name="totalcost" value="" id="paypal_total_cost"/>
                <input type="hidden" name="fileids" value="<?php echo e($audioids); ?>" id="paypal_audio_ids"/>
                <input type="hidden" name="totalduration" value="" id="paypal_total_duration"/> -->
                <!-- <input type="submit" value="Pay & Checkout" class="btn btn-success" name="submit"/>
                </form> -->
                <span>   <a href="<?php echo e(URL::to('/file/fetch')); ?>" class="btn btn-success" style="float:right;">Cancel</a></span>
                <a href="<?php echo e(URL::to('/')); ?>/propaypal/<?php echo e($id); ?>" class="btn btn-warning" style="float:right;">Propaypal</a>    

            </div>





     <!-- end paypal code -->
   

   
         
  <!-- direct payment code --> 
             <form  method="Post" action="<?php echo e(URL::to('/directpayment')); ?>" style="visibility:hidden;">
                  <?php echo csrf_field(); ?>
                <input type="hidden" name="totalcost" value="" id="paypal_total_cost"/>
                <input type="hidden" name="fileids" value="<?php echo e($audioids); ?>" id="paypal_audio_ids"/>
                <input type="hidden" name="totalduration" value="" id="paypal_total_duration"/>
                <input type="submit" value="Direct DPay & Checkout" class="btn btn-success" name="submit"/>
              </form>
  
     <!-- direct payment code end--> 




        </div>
        </div>
        </div>
        </div>




<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/cymatrax_waves/resources/views/filedetail.blade.php ENDPATH**/ ?>
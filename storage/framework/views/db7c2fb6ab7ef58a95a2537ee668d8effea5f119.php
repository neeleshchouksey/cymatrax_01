<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="card-header">My Account</div>

        <?php $__currentLoopData = $getData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($item->cleaned == 0): ?>
        <div class="card" style="margin-bottom:1%;">
        <div class="card-body">


           <b> File Name:</b><p><?php echo e($item->file_name); ?></p>
           <b> Upload Time:</b>
           <p> <?php echo e(Carbon\Carbon::parse($item->created_at)->format('d-m-Y, H: i: s')); ?></p>


            <audio controls="" style="vertical-align: middle" src="<?php echo e(asset('public/upload/'.$item->file_name)); ?>" type="audio/mp3" controlslist="nodownload">
                Your browser does not support the audio element.
            </audio>


            <a class="btn btn-success" href="<?php echo e(asset('public/upload/'.$item->file_name)); ?>" download>Download</a>

            <!-- <a class="btn btn-warning" download style="margin-left:2%;">Pay & Clean</a> -->

          <!-- paypal code -->





<!-- get duration end -->

            <div class="card" style="display:none;">
            <div class="card-body">
            <p id="demo"></p>
                <audio style="display:none;" id="audio<?php echo e($key); ?>" controls="" style="vertical-align: middle" src="<?php echo e(asset('public/upload/'.$item->file_name)); ?>" type="audio/mp3" controlslist="nodownload">
                    Your browser does not support the audio element.
                </audio>
                <!-- <b> File duration = <span id="duration<?php echo e($key); ?>" ></span> </b> -->
                <button style="visibility:hidden;" type="button" onclick="getDuration(<?php echo e($key); ?>)" class="getdur">Get Duration</button>
                <span id="ids<?php echo e($key); ?>" ></span>
                </div>

                </div>


<!-- get duration end -->




            <div class="content" style="display:inline-flex;">

                  <form  method="post" action="<?php echo e(route('payment')); ?>">
                    <?php echo csrf_field(); ?>
                  <input type="hidden"  name="totalduration" value=""  id="duration_in_sec<?php echo e($key); ?>" class="durValue"/>


                  <input type="hidden" name="totalcost" value="singlefile" >
                  <input type="hidden" name="fileids" value="<?php echo e($item->id); ?>" id="paypal_audio_ids"/>
                  <input type="submit" value="Pay & Checkout" class="btn btn-warning" name="submit"/>
                  </form>

              </div>

              <a href="<?php echo e(URL::to('/')); ?>/propaypalsingle/<?php echo e($item->id); ?>" class="btn btn-warning">Propaypal</a>

         <!-- end paypal code -->



            </div>
            </div>

            <?php else: ?>

            <div class="card" style="margin-bottom:1%;">
            <div class="card-body">
            <b> File Name:</b><p><?php echo e($item->processed_file); ?></p>
            <b> Upload Time:</b>
            <p> <?php echo e(Carbon\Carbon::parse($item->created_at)->format('d-m-Y, H: i: s')); ?></p>
            <audio controls="" style="vertical-align: middle" src="<?php echo e(asset('public/upload/'.$item->processed_file)); ?>" type="audio/mp3" controlslist="nodownload">
                Your browser does not support the audio element.
            </audio>
            <a class="btn btn-success" href="<?php echo e(asset('public/upload/'.$item->processed_file)); ?>" download>Download</a>
            </div>
            </div>

            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>




        </div>
        </div>
        </div>








<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/cymatrax_01/resources/views/displayprofile.blade.php ENDPATH**/ ?>
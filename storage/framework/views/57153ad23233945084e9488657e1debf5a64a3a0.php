<?php $__env->startSection('content'); ?>

<link href="<?php echo e(asset('public/css/card.css')); ?>" rel="stylesheet">

<div class="container">
<?php if(session()->has('error')): ?>
    <div class="alert alert-danger">
        <?php echo e(session()->get('error')); ?>

    </div>
<?php endif; ?>
    <div class="row justify-content-center">
        <div class="col-md-8">

<?php $__currentLoopData = $getData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


<div class="card" style="display:none;">
   <div class="card-body">
    <audio  id="audio<?php echo e($key); ?>" controls=""  src="<?php echo e(asset('public/upload/'.$item->file_name)); ?>" type="audio/mp3" controlslist="nodownload">
       hello
    </audio>
    <input type="hidden" id="duration_in_sec<?php echo e($key); ?>" class="durValue"/>
      <button style="visibility:hidden;" type="button" onclick="getDuration(<?php echo e($key); ?>)" class="getdur">Get Duration</button>
    </div>
    </div>


<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<form method="POST" action="<?php echo e(URL::to('/')); ?>/payment/store"  id="form_id">
    <?php echo e(csrf_field()); ?>


    <?php if(sizeof($card)>0): ?>
        <?php $__currentLoopData = $card; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <input type="radio" name="method_type"> Use this card
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
    <input type="radio" name="method_type">Add New Card
    <div class="form-container">
        <input id="column-left" type="text" name="first-name" placeholder="First Name" required="required" />
        <input id="column-right" type="text" name="last-name" placeholder="Surname" required="required" />
        <input id="input-field" type="text" name="number" placeholder="Card Number"  />
        <input id="column-left" type="text" name="expiry" placeholder="MM / YY" required="required" />
        <input id="column-right" type="text" name="cvc" placeholder="CCV" required="required" />

        <div class="card-wrapper"></div>



        <input id="input-field" type="text" name="streetaddress" required="required" autocomplete="on" maxlength="45" placeholder="Streed Address"/>
        <input id="column-left" type="text" name="city" required="required" autocomplete="on" maxlength="20" placeholder="City"/>
        <input id="column-right" type="text" name="zipcode" required="required" autocomplete="on" pattern="[0-9]*" maxlength="5" placeholder="ZIP code"/>
        <input id="input-field" type="email" name="email" required="required" autocomplete="on" maxlength="40" placeholder="Email"/>
        <!-- <input id="input-field" type="text" name="amount" required="required" autocomplete="on" maxlength="40" placeholder="Amount" id="paypal_total_cost"/> -->

       <!-- file data pass -->
        <input type="text" name="amount" value="" id="paypal_total_cost"/>
        <input type="text" name="fileids" value="<?php echo e($audioids); ?>" id="paypal_audio_ids"/>
        <input type="text" name="totalduration" value="" id="paypal_total_duration"/>
       <!-- file data pass -->
        <input id="input-button" name="submit" type="submit" value="Submit"/>


      </div>
</form>


<div class="content" style="display:inline-flex;margin-left: 58%;">


                  <!-- <form  method="Post" action="<?php echo e(route('payment')); ?>">
                    <?php echo csrf_field(); ?>
                  <input type="text" name="totalcost" value="" id="paypal_total_cost"/>
                  <input type="text" name="fileids" value="<?php echo e($audioids); ?>" id="paypal_audio_ids"/>
                  <input type="text" name="totalduration" value="" id="paypal_total_duration"/>
                  <input type="submit" value="Pay & Checkout" class="btn btn-success" name="submit"/>
                  </form> -->
                  <span style="margin-left:1%;"><a href="<?php echo e(URL::to('/file/fetch')); ?>" class="btn btn-success">Cancel</a></span>

              </div>

</div>
</div>
</div>






<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/cymatrax_01/resources/views/propaypal.blade.php ENDPATH**/ ?>
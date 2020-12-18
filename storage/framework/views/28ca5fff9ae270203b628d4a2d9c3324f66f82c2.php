<?php $__env->startSection('content'); ?>

    <section class="contained">
        <?php echo $__env->make('layouts/menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="checkouttotal">
            <table class="tr-table">
                <tbody>
                <?php $__currentLoopData = $getData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <audio  id="audio<?php echo e($key); ?>" controls="" style="vertical-align: middle" src="<?php echo e(asset('public/upload/'.$item->file_name)); ?>" type="audio/mp3" controlslist="nodownload">
                                Your browser does not support the audio element.
                            </audio>
                            <input type="hidden" id="duration_in_sec<?php echo e($key); ?>" class="durValue"/>
                        </td>

                        <td>
                            <b> File Duration : <span id="duration<?php echo e($key); ?>" ></span> </b>
                            <button style="visibility:hidden;" type="button" onclick="getDuration(<?php echo e($key); ?>)" class="getdur">Get Duration</button>
                            <span id="ids<?php echo e($key); ?>" ></span>
                        </td>
                        <td>
                            <b> File Name : <span><?php echo e($item->file_name); ?></span> </b>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <b>Total duration = <span id="total-duration"></span></b> <br>
            <b>Total Cost =  <span id="total-cost"></span> </b>
            <b>($1 per minute) </b><br><br><br>

            <a href="<?php echo e(URL::to('/')); ?>/checkout/<?php echo e($id); ?>" style="margin-top: 1rem">Proceed to Checkout</a>

        </div>
    </section>



<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/cymatrax_waves/resources/views/upload-summary.blade.php ENDPATH**/ ?>
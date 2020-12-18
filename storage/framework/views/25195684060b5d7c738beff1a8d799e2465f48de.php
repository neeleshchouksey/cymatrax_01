<?php $__env->startSection('content'); ?>

    <div class="content">
        <?php echo $__env->make('layouts/menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <section class="contained">
            <div class="relative">
                <h3>Transaction Details</h3>

                <table class="tr-table">
                    <tbody>
                    <?php $__currentLoopData = $getData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <audio  id="audio<?php echo e($key); ?>" controls="" style="vertical-align: middle" src="<?php echo e(asset('public/upload/'.$item->processed_file)); ?>" type="audio/mp3" controlslist="nodownload">
                                    Your browser does not support the audio element.
                                </audio>
                                <input type="hidden" id="duration_in_sec<?php echo e($key); ?>" class="durValue"/>
                                <b> File duration : <span id="duration<?php echo e($key); ?>" ></span> </b>
                                <button style="visibility:hidden;" type="button" onclick="getDuration(<?php echo e($key); ?>)" class="getdur">Get Duration</button>
                                <span id="ids<?php echo e($key); ?>" ></span>
                            </td>
                            <td>
                                <b> File Name : <span><?php echo e($item->file_name); ?></span> </b>

                            </td>
                            <td>
                                <button class="wave-btn" onclick="window.location='<?php echo e(URL::to('/')); ?>/download-file/<?php echo e($item->processed_file); ?>'">Download File</button>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

                <b>Total duration = <span id="total-duration"></span></b> <br>
                <b>Total Cost = <span id="total-cost"></span> </b><br>
                <b>($1 per minute) </b>

            </div>
        </section>
    </div>




<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/cymatrax_waves/resources/views/transaction-details.blade.php ENDPATH**/ ?>
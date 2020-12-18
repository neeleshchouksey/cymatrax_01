<?php $__env->startSection('content'); ?>

    <section class="contained">
        <?php echo $__env->make('layouts/menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="checkouttotal">
            <table class="tr-table">
                <tbody>
                <?php $__currentLoopData = $getData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <b> Upload Date:</b>
                            <p> <?php echo e(Carbon\Carbon::parse($item->created_at)->format('d-M-Y, H: i A')); ?></p>
                        </td>
                        <td>
                            <audio id="audio<?php echo e($key); ?>" controls="" style="vertical-align: middle"
                                   src="<?php echo e(asset('public/upload/'.$item->file_name)); ?>" type="audio/mp3"
                                   controlslist="nodownload">
                                Your browser does not support the audio element.
                            </audio>
                        </td>
                        <td>
                            <?php if(!$item->cleaned): ?>
                                <b>File Name:</b>
                                <p><?php echo e($item->file_name); ?></p>
                            <?php else: ?>
                                <b>File Name: </b>
                                <p><?php echo e($item->processed_file); ?></p>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if(!$item->cleaned): ?>

                            <a class="btn btn-success" href="<?php echo e(URL::to('/')); ?>/download-file/<?php echo e($item->file_name); ?>"
                               download>Download</a>
                            <?php else: ?>
                                <a class="btn btn-success" href="<?php echo e(URL::to('/')); ?>/download-file/<?php echo e($item->processed_file); ?>"
                                   download>Download</a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if(!$item->cleaned): ?>
                                <a href="<?php echo e(URL::to('/')); ?>/checkout-single/<?php echo e($item->id); ?>" class="btn btn-sucess">Pay &
                                    Checkout</a>
                            <?php else: ?>
                                <a href="<?php echo e(URL::to('/')); ?>/audio-analysis/<?php echo e($item->id); ?>" class="btn btn-sucess">Audio Analysis</a>
                            <?php endif; ?>
                        </td>

                    </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </section>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/cymatrax_waves/resources/views/account.blade.php ENDPATH**/ ?>
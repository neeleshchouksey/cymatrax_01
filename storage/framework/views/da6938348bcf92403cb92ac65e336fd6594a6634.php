<?php $__env->startSection('content'); ?>

    <section class="contained">
       <?php echo $__env->make('layouts/menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="tool">
            <h3>Audio Conversion Tool</h3>
            <p>$<?php echo "1" ?> per minute</p>
            <form id="dropzoneForm" enctype="multipart/form-data" class="dropzone"
                  action="<?php echo e(route('file.upload')); ?>">
                <?php echo csrf_field(); ?>
            </form>
            <button type="button" class="upload-btn" id="submit-all">Upload</button>
        </div>
    </section>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/cymatrax_waves/resources/views/upload.blade.php ENDPATH**/ ?>
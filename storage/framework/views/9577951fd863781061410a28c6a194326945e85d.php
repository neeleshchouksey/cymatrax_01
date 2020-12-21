<?php $__env->startSection('content'); ?>

    <section class="contained">
        <?php echo $__env->make('layouts/menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="wave-div">
            <h5>Input Audio Analysis</h5>
            <div id="input-waveform"></div>
            <button id="play-btn" class="wave-btn">
                Play
            </button>
            <button id="pause-btn" class="wave-btn">
                Pause
            </button>
            <button class="wave-btn"
                    onclick="window.location='<?php echo e(URL::to('/')); ?>/download-file/<?php echo e($file->file_name); ?>'">Download File
            </button>

            <h5>Output Audio Analysis</h5>
            <div id="output-waveform"></div>
            <button id="play-btn1" class="wave-btn">
                Play
            </button>
            <button id="pause-btn1" class="wave-btn">
                Pause
            </button>
            <button class="wave-btn"
                    onclick="window.location='<?php echo e(URL::to('/')); ?>/download-file/<?php echo e($file->processed_file); ?>'">Download
                File
            </button>
        </div>

    </section>



<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/cymatrax_waves/resources/views/audio-analysis.blade.php ENDPATH**/ ?>
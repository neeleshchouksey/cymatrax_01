<?php $__env->startSection('content'); ?>


    <div class="content">
        <?php echo $__env->make('layouts/menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <section class="contained">
            <div class="relative">
                <table class="transaction-table" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                        <th>S. No.</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th> Email</th>
                        <th>Total Duration</th>
                        <th>Total Price</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $paymentdetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key+1); ?></td>
                            <td><?php echo e($item->firstname); ?></td>
                            <td><?php echo e($item->lastname); ?></td>
                            <td><?php echo e($item->email); ?></td>
                            <td><?php echo e($item->duration); ?></td>
                            <td>$<?php echo e($item->totalprice); ?></td>
                            <td><a href="<?php echo e(URL::to('/')); ?>/transaction-details/<?php echo e($item->id); ?>">View Details</a></td>

                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

            </div>
        </section>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/cymatrax_waves/resources/views/transactions.blade.php ENDPATH**/ ?>
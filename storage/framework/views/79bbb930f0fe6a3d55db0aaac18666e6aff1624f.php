<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

            <table class="table">
            <thead>
                <tr>
                    <!-- <th>id </th> -->
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th> Email</th>
                    <th>Total Duration</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $paymentdetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
               <!-- <td>id<?php echo e($item->id); ?></td> -->
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
</div>
</div>
<script>
    var msg = '<?php echo e(Session::get('alert')); ?>';
    var exist = '<?php echo e(Session::has('alert')); ?>';
    if(exist){

            Swal.fire({
                title: 'Thank You',
                text: 'Payment Completed Successfully',
                icon: 'success',
                showCancelButton: false,
            });
    }
  </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/cymatrax_waves/resources/views/transactonHistory.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title','Admin | Bugs'); ?>
<?php $__env->startSection('content'); ?>


    <?php echo $__env->make('includes.session_message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Previous Version -->
    <?php if(!$bugNotificationEnable): ?>
        <section id="noBug" class="container mt-5 text-center">
            <div class="card">
                <div class="card-body">
                    <?php if(session('successMessage')): ?>
                            <h2 class="text-center text-success"><strong>Congratulation !!!</strong> <?php echo e(session('successMessage')); ?></span></h2>
                    <?php endif; ?>
                    <h4 class="text-center text-info">Your current version is <span><?php echo e(config('auto_update.version')); ?></span></h4>
                    <p>Right now no bug found.</p>
                </div>
            </div>
        </section>
    <?php else: ?>
        <!-- For New Version -->
        <section id="bugSection" class="container mt-5 text-center">
            <div class="card">
                <div class="card-body">
                    <h4 class="text-center text-success">Minor bug found. Please update it.</h4>
                    <p>Before updating, we highly recomended you to keep a backup of your current script and database.</p>
                </div>
            </div>

            <?php if(isset($getBugUpdateDetails->short_note)): ?>
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="text-left text-danger"><b>Important Note : </b> <?php echo e($getBugUpdateDetails->short_note); ?> </h5>
                    </div>
                </div>
            <?php endif; ?>

            <div id="changeLog" class="card mt-3">
                <div class="card-body">
                    <h4 class="text-left p-4">Change Log</h4>
                    <ul class="list-group text-left ml-4" id="logUL">
                        <?php if(isset($getBugUpdateDetails->logs)): ?>
                            <?php $__currentLoopData = $getBugUpdateDetails->logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <p> <?php echo e($item->text); ?> </p>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <p class="text-danger"> No Data Found </p>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-3 mb-3">
                <div id="spinner" class="d-none spinner-border text-success" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <form action="<?php echo e(route('bug-update')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <button type="submit" class="mt-5 mb-5 btn btn-primary btn-lg">Update</button>
            </form>
        </section>
    <?php endif; ?>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
<script type='text/javascript'>
    // (function() {
    //     if( window.localStorage ) {
    //         if( !localStorage.getItem('firstLoad') ) {
    //             localStorage['firstLoad'] = true;
    //             window.location.reload();
    //         }
    //         else {
    //             localStorage.removeItem('firstLoad');
    //         }
    //     }
    // })();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/abdullah/Downloads/POS/SalePro/resources/views/bug_update/index.blade.php ENDPATH**/ ?>
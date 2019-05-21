<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm">
                <?php if(Session::has('message')): ?>
                    <p class="alert alert-info"><?php echo e(Session::get('message')); ?></p>
                <?php endif; ?>
                <h1><?php echo e($repo->getName()); ?></h1>
                <a href="<?php echo e($repo->getGithubLink()); ?>">Vew on Github</a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col">
                <h2>Issues</h2>
            </div>
        </div>
        <div class="row">
            <?php $__currentLoopData = $issues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $issue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-6 pb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row"></div>
                            <h3><?php echo e($issue->getTitle()); ?></h3>
                            <p><?php echo $issue->getDescription(); ?></p>
                            <div class="row">
                                <div class="col-sm">
                                    <?php $__currentLoopData = json_decode(json_encode($issue->getTags()), true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="badge badge-secondary" style="background-color: <?php echo e($tag['color']); ?>">
                                            <?php echo e($tag['name']); ?>

                                        </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm">

                                    
                                        
                                            
                                            
                                        
                                    
                                </div>
                            </div>
                            <div class="row pt-4">
                                <div class="col-sm">
                                    <button class="btn btn-primary">Edit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/code/resources/views/repository/index.blade.php ENDPATH**/ ?>
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm">
                <h1><?php echo e($repo->getFullName()); ?></h1>
                <h3>Create Issue for Audit</h3>
                <form id="create-issue" class="create-issue">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="form-row">
                        <div class="col">
                            <label for="issue-title">Issue Title</label>
                            <input type="text" class="form-control" id="issue-title"  name="issue-title" placeholder="Issue Title">
                        </div>
                        <div class="col">
                            
                            <label for="issue-project">Issue Project</label>
                            <input type="text" class="form-control" id="issue-project"  name="issue-project" placeholder="Associated Project">
                        </div>
                    </div>
                    <div class="form-row pt-4">
                        <div class="col">
                            <label for="issue-labels">Issue Tags</label>
                            <select class="form-control issue-labels" name="issue-labels[]" id="issue-labels" multiple size=5>
                                <?php $__currentLoopData = $labels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($label->getName()); ?>"><?php echo e($label->getName()); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row pt-4">
                        <label for="issue-description">Description</label>
                        <textarea name="issue-description" class="form-control" id="issue-description" cols="30" rows="10">
## Description

## Current Code

## Solution

## Suggested Code

## Affected Communities
* Vision
* Motor
* Hearing
* Cognitive

## Screenshots
If applicable, add screenshots to help explain your problem.

## Environment
- OS: [e.g. iOS]
- Browser [e.g. chrome, safari]
- Version [e.g. 22]
                        </textarea>
                    </div>
                    <div class="form-row pt-4">
                        <div class="col">
                            
                            <label for="issue-milestone">Milestone</label>
                            
                            <select class="form-control custom-select" name="issue-milestone" id="issue-milestone">
                                <?php $__currentLoopData = $milestones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $milestone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($milestone->getNumber()); ?>"><?php echo e($milestone->getTitle()); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="form-row pt-4">
                        <button class="btn btn-primary" type="button" onclick="submitForm(); return false;">Save Issue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(".issue-labels").chosen();

        function submitForm() {
          var repo = JSON.parse('<?php echo json_encode($repo->getName()); ?>');
          var formData = new FormData(document.querySelector('form'));
          var request = new XMLHttpRequest();

          request.open('POST', `/${repo}/issue/create`);
          request.send(formData);
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/code/resources/views/audit/index.blade.php ENDPATH**/ ?>
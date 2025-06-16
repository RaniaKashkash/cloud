<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Upload Document</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">⬆️ Upload Document</h4>
                <a href="<?php echo e(route('documents.index')); ?>" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-arrow-left"></i> Back to Documents
                </a>
            </div>

            <div class="card-body">

                
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                
                <?php if(session('success')): ?>
                    <div class="alert alert-success">
                        <?php echo e(session('success')); ?>

                        <?php if(session('duration')): ?>
                            <br><strong><?php echo e(session('duration')); ?></strong>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                
                <form action="<?php echo e(route('documents.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <div class="mb-3">
                        <label for="document" class="form-label">Select Document (PDF or DOCX):</label>
                        <input type="file" name="document" id="document" class="form-control" accept=".pdf,.docx"
                            required>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-upload"></i> Upload
                    </button>
                </form>
            </div>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html><?php /**PATH C:\Users\aya\Desktop\document-management-system-updated\document-management-system\laravel-app\resources\views/documents/create.blade.php ENDPATH**/ ?>
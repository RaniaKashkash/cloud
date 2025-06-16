<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>All Documents</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container my-5">
        <h1 class="mb-4 text-primary">📄 All Documents</h1>

        
        <div class="mb-4 d-flex gap-3 flex-wrap">
            <a href="<?php echo e(route('documents.search')); ?>" class="btn btn-outline-primary">
                🔍 Go to Search
            </a>
            <a href="<?php echo e(route('documents.create')); ?>" class="btn btn-outline-success">
                ⬆️ Upload Document
            </a>
        </div>

        
        <div class="alert alert-info">
            <p class="mb-1"><strong>Total Documents:</strong> <?php echo e($documents->total()); ?></p>
            <p class="mb-1"><strong>Total Documents size:</strong> <?php echo e($totalSize); ?> KB</p>
            <p class="mb-0"><strong>Sorting Time:</strong> <?php echo e(number_format($timeTaken, 3)); ?> seconds</p>
        </div>

        
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Original Filename</th>
                        <th>Type</th>
                        <th>Size (KB)</th>
                        <th>Category</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($document->title); ?></td>
                            <td><?php echo e($document->original_filename); ?></td>
                            <td><?php echo e(strtoupper($document->file_type)); ?></td>
                            <td><?php echo e(number_format($document->file_size / 1024, 2)); ?></td>
                            <td><?php echo e(optional($document->category)->name ?? 'Uncategorized'); ?></td>
                            <td><?php echo e($document->created_at->format('Y-m-d H:i')); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        
        <div class="mt-3 d-flex justify-content-center">
            <?php echo e($documents->links()); ?>

        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html><?php /**PATH C:\Users\aya\Desktop\document-management-system-updated\document-management-system\laravel-app\resources\views/documents/index.blade.php ENDPATH**/ ?>
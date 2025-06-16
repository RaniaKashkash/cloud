<form action="<?php echo e(route('documents.searchHandle')); ?>" method="GET">
    <div style="display: flex; gap: 10px;">
        <input type="text" name="query" class="form-control" placeholder="Search..." value="<?php echo e(request('query')); ?>">

        <button type="submit" class="btn btn-primary">Search</button>
    </div>
    <?php if($documents->count()): ?>
                <table class="table table-bordered" border="1">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Preview (matched text)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($document->title); ?></td>
                                
                                <td><?php echo $document->highlighted_content ?? ''; ?></td>


                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

                
        <?php if(method_exists($documents, 'links')): ?>
            <?php echo e($documents->withQueryString()->links()); ?>

        <?php endif; ?>

    <?php else: ?>
        <p>No documents found for this search.</p>
    <?php endif; ?>

</form>

<?php if(isset($timeTaken)): ?>
    <p><strong>Search took:</strong> <?php echo e(number_format($timeTaken, 3)); ?> seconds</p>
<?php endif; ?><?php /**PATH C:\Users\aya\Desktop\document-management-system-updated\document-management-system\laravel-app\resources\views/documents/search.blade.php ENDPATH**/ ?>
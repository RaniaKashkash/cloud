
<?php $__env->startSection('title'); ?>
  <title>Upload </title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('main-content'); ?>
<body class="g-sidenav-show bg-dark">
  <main class="main-content position-relative border-radius-lg">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur"
      data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="<?php echo e(route('documents.index')); ?>">Dashboard</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Upload</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Upload new document</h6>
        </nav>
      </div>
    </nav>

    <!-- ^ Search,upload file icons -->
    <div class="container-fluid py-4">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card pt-5">
            <h6 class="text-center mb-0 mb-3">Select a document in PDF / DOCX format</h6>

            <div class="card-header d-flex justify-content-center mx-4 p-3 text-center">
              <button type="button" class="border-0 bg-transparent"
                onclick="document.getElementById('fileUpload').click();">
                <i class="fa-solid fa-cloud-arrow-up fs-1" style="color:rgb(116, 111, 160)"></i>
              </button>
            </div>
            <div class="card-body pt-0 p-3 text-center">
            <form action="<?php echo e(route('documents.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <!-- نخفي ال input -->
                <input type="file" name="document" id="fileUpload" style="display: none;"  accept=".pdf,.docx" required>
                <!-- زر الرفع الحقيقي -->
                <button type="submit" class="btn btn-success bg-gradient-primary">Upload</button>
              </form>
              <?php if(session('success')): ?>
    <div class="text-success">
        <?php echo e(session('success')); ?>

        <?php if(session('duration')): ?>
            <br>
              <p class="fs-6 fw-bold text-success"><?php echo e(session('duration')); ?></p>       
     <?php endif; ?>
    </div>
<?php endif; ?>
    <?php if($errors->any()): ?>
        <div style="color:red;">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <p class="fs-6 fw-bold text-warning"><?php echo e($error); ?></p>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>



  </main>
</body>
<?php $__env->stopSection(); ?>
</html>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\UCI Dropbox\Hanan Thuraia\9- IT\Rania\laravel\laravel-app\resources\views/documents/create.blade.php ENDPATH**/ ?>
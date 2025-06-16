
<?php $__env->startSection('title'); ?>
<title>Dashboard</title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('main-content'); ?>
<body class="g-sidenav-show  bg-gray-200 ">
  <div class="min-height-300 bg-dark position-absolute w-100"></div>

  <main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Dashboard</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Dashboard</h6>
        </nav>
      </div>
    </nav>

    <!-- ^ Search,upload file icons -->
    <div class="container-fluid py-4">
              <div class="row justify-content-center">
                  <div class="col-md-3">
                    <div class="card">
                      <a class="text-decoration-none fw-bolder" href="http://localhost:8000/documents/create">                          
                             
                      <div class="card-header mx-4 p-3 d-flex justify-content-center">
                        <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                            
                              <i class="fa-solid fa-cloud-arrow-up"></i>
                           
                        </div>
                      </div>
                      <div class="card-body pt-0 p-3 text-center">
                        <h6 class="text-center mb-0">Upload file</h6>
                        <span class="text-xs">Go to upload page</span>
                      </div>
                    </a></div>

                  </div>

                  <div class="col-md-3 mt-md-0 mt-4">
                    <div class="card">
                      <a class="text-decoration-none fw-bolder" href="<?php echo e(route('documents.search')); ?>">   
                      <div class="card-header mx-4 p-3 d-flex justify-content-center">
                        <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                                   
                              <i class="fa-solid fa-magnifying-glass"></i>
                          
                        </div>
                      </div>
                      <div class="card-body pt-0 p-3 text-center">
                        <h6 class="text-center mb-0">Search</h6>
                        <span class="text-xs">Go to search page</span>
                      </div>
</a></div>
                  </div>
              </div>
    </div>

    <!-- Table -->
    <div class="container-fluid py-4">
      <div class="row justify-content-center">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total documents</p>
                    <h5 class="font-weight-bolder">
                      <?php echo e($documents->total()); ?>

                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                    <i class="text-white fs-5 fa-solid fa-folder-open"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total document size</p>
                    <h5 class="font-weight-bolder">
                       <?php echo e($totalSize); ?> KB
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                    <i class="text-white fs-5 fa-solid fa-database"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Sorting time</p>
                    <h5 class="font-weight-bolder">
                      <?php echo e(number_format($timeTaken, 3)); ?> seconds
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                      <i class="text-white fs-5 fa-solid fa-arrow-up-a-z"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Table -->
      <div class="row mt-4 justify-content-center">
        <div class="col-lg-10 mb-lg-0 mb-4">
          <div class="card ">
            <div class="card-header pb-0 p-3">
              <div class="d-flex justify-content-between">
                <h6 class="mb-2">Documents</h6>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center ">
                <thead>
                  <tr>
                    <th >Title</th>
                    <th >Original file name</th>
                    <th >Type</th>
                    <th >Size(KB)</th>
                    <th >Category</th>
                    <th >Created-At</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                    <td>
                      <div>
                        <div>
                          <h6 class="text-sm mb-0 px-3 py-1"><?php echo e($document->title); ?></h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div>
                        <h6 class="text-sm mb-0 px-3 py-1"><?php echo e($document->original_filename); ?></h6>
                      </div>
                    </td>
                    <td>
                      <div class="">
                        <h6 class="text-sm mb-0 px-3 py-1"><?php echo e(strtoupper($document->file_type)); ?></h6>
                      </div>
                    </td>
                    <td class="align-middle text-sm">
                      <div class="col ">
                        <h6 class="text-sm mb-0 px-3 py-1"><?php echo e(number_format($document->file_size / 1024, 2)); ?></h6>
                      </div>
                    </td>
                    <td>
                      <div class="">
                        <h6 class="text-sm mb-0 px-3 py-1"><?php echo e(optional($document->category)->name ?? 'Uncategorized'); ?></h6>
                      </div>
                    </td>
                    <td>
                      <div class="">
                        <h6 class="text-sm mb-0 px-3 py-1"><?php echo e($document->created_at->format('Y-m-d H:i')); ?></h6>
                      </div>
                    </td>
                  </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      
    </div>

  </main>
</body>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\UCI Dropbox\Hanan Thuraia\9- IT\Rania\laravel\cloud3\resources\views/documents/index.blade.php ENDPATH**/ ?>
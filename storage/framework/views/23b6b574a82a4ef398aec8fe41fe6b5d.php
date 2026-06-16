<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Dashboard Mahasiswa')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <?php if(session('success')): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline"><?php echo e(session('success')); ?></span>
                </div>
            <?php endif; ?>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-bold text-indigo-600 mb-4 border-b pb-2">Kelas Aktif Saya</h3>
                    
                    <?php if($myCourses->isEmpty()): ?>
                        <p class="text-gray-500">Anda belum mendaftar ke kelas mana pun.</p>
                    <?php else: ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <?php $__currentLoopData = $myCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="border border-indigo-200 rounded-lg p-4 bg-indigo-50">
                                    <h4 class="font-bold text-lg text-gray-800"><?php echo e($course->title); ?></h4>
                                    <p class="text-sm text-gray-600 mt-2"><?php echo e(\Illuminate\Support\Str::limit($course->description, 80)); ?></p>
                                    <div class="mt-4 pt-4 border-t border-indigo-100">
                                        
                                        <a href="<?php echo e(route('modules.show', $course->id)); ?>" class="block text-center w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-semibold transition">
                                            Masuk Kelas
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Eksplorasi Kelas Tersedia</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php $__currentLoopData = $availableCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                <h4 class="font-bold text-lg text-gray-800"><?php echo e($course->title); ?></h4>
                                <p class="text-sm text-gray-500 mb-2">Dosen: <?php echo e($course->teacher->name ?? 'Tidak diketahui'); ?></p>
                                <p class="text-sm text-gray-600"><?php echo e(\Illuminate\Support\Str::limit($course->description, 80)); ?></p>
                                
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <?php if(Auth::user()->enrolledCourses->contains($course->id)): ?>
                                        <span class="inline-block w-full text-center bg-gray-200 text-gray-600 px-4 py-2 rounded-md text-sm font-semibold">
                                            Sudah Terdaftar
                                        </span>
                                    <?php else: ?>
                                        <form action="<?php echo e(route('courses.enroll', $course->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" style="background-color: #16a34a; color: white;" class="w-full px-4 py-2 rounded-md text-sm font-semibold transition hover:opacity-80">
                                                Daftar Kelas Ini
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                </div>
            </div>

        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\Dimas Rizky\cobacoba\resources\views/dashboard.blade.php ENDPATH**/ ?>
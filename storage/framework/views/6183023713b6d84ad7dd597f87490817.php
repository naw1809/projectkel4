<?php $__env->startSection('title', 'Laporan Transaksi'); ?>

<?php $__env->startSection('header'); ?>
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Laporan Transaksi</h1>
        <div class="mt-4 md:mt-0">
            <a href="<?php echo e(route('reports.transactions.download')); ?>?<?php echo e(http_build_query(request()->query())); ?>"
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                <i class="fas fa-download mr-2"></i> Unduh PDF
            </a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Filter Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6 border border-gray-200">
        <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                <i class="fas fa-filter mr-2 text-gray-500"></i> Filter Laporan
            </h3>
        </div>
        <div class="p-5">
            <form action="<?php echo e(route('reports.transactions')); ?>" method="GET"
                class="space-y-4 md:space-y-0 md:grid md:grid-cols-4 md:gap-4">
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="far fa-calendar text-gray-400"></i>
                        </div>
                        <input type="date" name="date_from" id="date_from" value="<?php echo e(request('date_from')); ?>"
                            class="block w-full pl-10 pr-3 py-2 text-base border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md"
                            style="min-height: 38px;">
                    </div>
                </div>

                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="far fa-calendar text-gray-400"></i>
                        </div>
                        <input type="date" name="date_to" id="date_to" value="<?php echo e(request('date_to')); ?>"
                            class="block w-full pl-10 pr-3 py-2 text-base border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md"
                            style="min-height: 38px;">
                    </div>
                </div>

                <div class="flex items-end space-x-2 md:col-span-2">
                    <button type="submit"
                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 w-full md:w-auto">
                        <i class="fas fa-check-circle mr-2"></i> Terapkan Filter
                    </button>
                    <a href="<?php echo e(route('reports.transactions')); ?>"
                        class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 w-full md:w-auto">
                        <i class="fas fa-undo mr-2"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barang
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengguna
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catatan
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($transaction->date->format('d M Y')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <?php echo e($transaction->item->name); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-medium <?php echo e($transaction->type === 'in' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                    <?php echo e($transaction->type === 'in' ? 'Masuk' : 'Keluar'); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($transaction->quantity); ?> <?php echo e($transaction->item->unit->symbol); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($transaction->user->name); ?>

                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <?php echo e($transaction->note ?? '-'); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                Tidak ada transaksi ditemukan
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($transactions->hasPages()): ?>
            <div class="bg-gray-50 px-4 py-3 border-t border-gray-200 sm:px-6">
                <?php echo e($transactions->links()); ?>

            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\laravel-inventory-gudang\resources\views/reports/transaction.blade.php ENDPATH**/ ?>
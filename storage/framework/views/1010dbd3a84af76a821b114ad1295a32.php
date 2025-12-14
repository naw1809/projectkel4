<?php $__env->startSection('title', 'Edit Barang'); ?>

<?php $__env->startSection('header'); ?>
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Edit Barang</h1>
        <div>
            <a href="<?php echo e(route('items.index')); ?>"
                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card bg-white rounded-lg overflow-hidden">
        <div class="p-6">
            <form action="<?php echo e(route('items.update', $item->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700">Kode Barang</label>
                        <input type="text" name="code" id="code" required value="<?php echo e(old('code', $item->code)); ?>"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm border p-2">
                        <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select name="category_id" id="category_id" required onchange="checkCategory()"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm border p-2">
                            <option value="">Pilih Kategori</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" data-name="<?php echo e(Str::lower($category->name)); ?>"
                                    <?php echo e(old('category_id', $item->category_id) == $category->id ? 'selected' : ''); ?>>
                                    <?php echo e($category->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <p class="mt-1 text-xs text-gray-500" id="categoryHelper">Pilih kategori untuk penyesuaian ukuran otomatis.</p>
                        <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Barang</label>
                        <input type="text" name="name" id="name" required value="<?php echo e(old('name', $item->name)); ?>"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm border p-2">
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="md:col-span-2 bg-gray-50 p-5 rounded-md border border-gray-200">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Varian Ukuran & Stok</h3>
                                <p class="text-sm text-gray-500">Edit detail stok untuk setiap ukuran.</p>
                            </div>
                            <div class="text-right">
                                <span class="block text-xs text-gray-500">Total Stok</span>
                                <span class="text-2xl font-bold text-primary-600" id="displayTotalStock"><?php echo e($item->stock); ?></span>
                            </div>
                        </div>

                        <table class="min-w-full divide-y divide-gray-200" id="variantTable">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 w-1/2">Ukuran</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 w-1/3">Stok</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="variantContainer">
                                
                            </tbody>
                        </table>

                        <button type="button" onclick="addVariantRow()"
                            class="mt-3 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            <i class="fas fa-plus mr-2"></i> Tambah Ukuran
                        </button>
                    </div>

                    <div>
                        <label for="unit_id" class="block text-sm font-medium text-gray-700">Satuan</label>
                        <select name="unit_id" id="unit_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm border p-2">
                            <option value="">Pilih Satuan</option>
                            <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($unit->id); ?>"
                                    <?php echo e(old('unit_id', $item->unit_id) == $unit->id ? 'selected' : ''); ?>>
                                    <?php echo e($unit->name); ?> (<?php echo e($unit->symbol); ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['unit_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">Harga</label>
                        <input type="number" name="price" id="price" required
                            value="<?php echo e(old('price', $item->price)); ?>" min="0" step="0.01"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm border p-2">
                        <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="description" id="description" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm border p-2"><?php echo e(old('description', $item->description)); ?></textarea>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="md:col-span-2 flex justify-end">
                        <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <i class="fas fa-save mr-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        let variantCount = 0;
        let currentType = 'text'; 

        function checkCategory() {
            const categorySelect = document.getElementById('category_id');
            const selectedOption = categorySelect.options[categorySelect.selectedIndex];
            const categoryName = selectedOption ? selectedOption.getAttribute('data-name') : '';
            const helper = document.getElementById('categoryHelper');
            
            let newType = 'text';
            let message = 'Input ukuran manual.';

            if (['baju', 'kemeja', 'jaket', 'kaos', 'hoodie', 'jersey', 'rompi', 'blazer'].some(el => categoryName.includes(el))) {
                newType = 'tops';
                message = 'Mode Atasan: Ukuran S, M, L...';
            } 
            else if (['celana', 'rok', 'jeans', 'chino', 'shorts', 'trousers'].some(el => categoryName.includes(el))) {
                newType = 'bottoms';
                message = 'Mode Bawahan: Ukuran 27-40';
            } 
            else if (['sepatu', 'sandal', 'sneakers', 'boots', 'flat'].some(el => categoryName.includes(el))) {
                newType = 'shoes';
                message = 'Mode Sepatu: Ukuran 36-46';
            }

            currentType = newType;
            helper.innerText = message;
        }

        function addVariantRow(sizeValue = '', stockValue = 0) {
            const container = document.getElementById('variantContainer');
            const index = variantCount++;
            let sizeInputHtml = '';

            // GENERATE DROPDOWN
            if (currentType === 'tops') {
                const sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL', '4XL'];
                let options = `<option value="">Pilih</option>`;
                sizes.forEach(s => {
                    const selected = sizeValue == s ? 'selected' : '';
                    options += `<option value="${s}" ${selected}>${s}</option>`;
                });
                sizeInputHtml = `<select name="sizes[]" class="block w-full p-2 border border-gray-300 rounded-md sm:text-sm" required>${options}</select>`;
            } 
            else if (currentType === 'bottoms') {
                let options = `<option value="">Pilih</option>`;
                for(let i=27; i<=40; i++) {
                    const selected = sizeValue == i ? 'selected' : '';
                    options += `<option value="${i}" ${selected}>${i}</option>`;
                }
                sizeInputHtml = `<select name="sizes[]" class="block w-full p-2 border border-gray-300 rounded-md sm:text-sm" required>${options}</select>`;
            } 
            else if (currentType === 'shoes') {
                let options = `<option value="">Pilih</option>`;
                for(let i=36; i<=46; i++) {
                    const selected = sizeValue == i ? 'selected' : '';
                    options += `<option value="${i}" ${selected}>${i}</option>`;
                }
                sizeInputHtml = `<select name="sizes[]" class="block w-full p-2 border border-gray-300 rounded-md sm:text-sm" required>${options}</select>`;
            } 
            else {
                sizeInputHtml = `<input type="text" name="sizes[]" value="${sizeValue}" class="block w-full p-2 border border-gray-300 rounded-md sm:text-sm" required>`;
            }

            const row = document.createElement('tr');
            row.id = `row-${index}`;
            row.innerHTML = `
                <td class="px-4 py-2">${sizeInputHtml}</td>
                <td class="px-4 py-2">
                    <input type="number" name="stocks[]" value="${stockValue}" min="0" oninput="calculateTotal()" class="stock-input block w-full p-2 border border-gray-300 rounded-md sm:text-sm" required>
                </td>
                <td class="px-4 py-2 text-right">
                    <button type="button" onclick="removeRow(${index})" class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></button>
                </td>
            `;
            container.appendChild(row);
            calculateTotal();
        }

        function removeRow(index) {
            const row = document.getElementById(`row-${index}`);
            if (row) row.remove();
            calculateTotal();
        }

        function calculateTotal() {
            const inputs = document.querySelectorAll('.stock-input');
            let total = 0;
            inputs.forEach(input => total += parseInt(input.value) || 0);
            document.getElementById('displayTotalStock').innerText = total;
        }

        document.addEventListener('DOMContentLoaded', function() {
            checkCategory(); // Set initial type based on selected category
            
            // Load existing data
            const existingSizes = <?php echo json_encode($item->sizes, 15, 512) ?>;
            
            if (existingSizes.length > 0) {
                existingSizes.forEach(item => {
                    addVariantRow(item.size, item.stock);
                });
            } else {
                // Jika belum ada data varian (misal barang lama)
                // Coba gunakan data lama, atau buat 1 row kosong
                const oldSize = '<?php echo e($item->size); ?>';
                if(oldSize && oldSize !== '-') {
                    // Jika ada size di kolom size (legacy)
                    addVariantRow(oldSize, <?php echo e($item->stock); ?>);
                } else {
                    addVariantRow();
                }
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\laravel-inventory-gudang\resources\views/items/edit.blade.php ENDPATH**/ ?>
<!-- resources/views/found-items/index.blade.php -->

<h1>Found Items</h1>


<?php if($foundItems): ?>
<ul>
    <?php $__currentLoopData = $foundItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $foundItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><?php echo e($foundItem->name); ?></li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul><?php else: ?>
    <p>No items found.</p>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\FYP-1\resources\views/found-items/index.blade.php ENDPATH**/ ?>
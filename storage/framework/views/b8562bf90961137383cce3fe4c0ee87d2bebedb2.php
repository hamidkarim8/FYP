<?php if(session('success')): ?>
<script>
    Toastify({
        text: '<?php echo e(session('success')); ?>',
        duration: 3000,
        backgroundColor: '#28a745',
        gravity: 'top',
        position: 'center',
        close: true
    }).showToast();
</script>
<?php endif; ?>

<?php if(session('error')): ?>
<script>
    Toastify({
        text: '<?php echo e(session('error')); ?>',
        duration: 3000,
        backgroundColor: '#dc3545',
        gravity: 'top',
        position: 'center',
        close: true
    }).showToast();
</script>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\FYP-TESTING\resources\views/components/custom-toast.blade.php ENDPATH**/ ?>
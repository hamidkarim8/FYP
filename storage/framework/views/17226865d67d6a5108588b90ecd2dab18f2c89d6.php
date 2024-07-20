<!DOCTYPE html>
<html>
<head>
    <title>Contact Form Submission</title>
</head>
<body>
    <h2>Contact Form Submission</h2>
    <p><strong>Name:</strong> <?php echo e($data['name']); ?></p>
    <p><strong>Email:</strong> <?php echo e($data['email']); ?></p>
    <p><strong>Subject:</strong> <?php echo e($data['subject']); ?></p>
    <p><strong>Message:</strong> <?php echo e($data['comments']); ?></p>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\FYP-TESTING\resources\views\emails\contact.blade.php ENDPATH**/ ?>
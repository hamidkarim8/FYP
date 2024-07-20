@if (session('success'))
<script>
    Toastify({
        text: '{{ session('success') }}',
        duration: 3000,
        backgroundColor: '#28a745',
        gravity: 'top',
        position: 'center',
        close: true
    }).showToast();
</script>
@endif

@if (session('error'))
<script>
    Toastify({
        text: '{{ session('error') }}',
        duration: 3000,
        backgroundColor: '#dc3545',
        gravity: 'top',
        position: 'center',
        close: true
    }).showToast();
</script>
@endif
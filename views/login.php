<?php $this->layout('layouts::app', ['title' => 'Login']) ?>

<?php $this->start('main') ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-lg mt-5">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-primary">Login Sistem</h2>
                        <p class="text-muted">Silahkan login</p>
                    </div>

                    <form id="loginForm">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Name</label>
                            <input type="text" class="form-control" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Password</label>
                            <input type="password" class="form-control" id="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </button>
                    </form>

                    <div id="message" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
$('#loginForm').submit(function(e) {
    e.preventDefault();
    
    const btn = $(this).find('button[type="submit"]');
    btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Masuk...');

    $.post('action_login.php?action=login', {
        name: $('#name').val(),      // 🔥 'name' sesuai tabel
        password: $('#password').val()
    }).done(function(response) {
        if (response.success) {
            showMessage('Login berhasil!', 'success');
            setTimeout(() => {
                if (response.role === 'admin') {
                    window.location.href = '?page=users';
                } else {
                    window.location.href = '?page=dashboard';
                }
            }, 1000);
        } else {
            showMessage(response.message, 'error');
            btn.prop('disabled', false).html('<i class="fas fa-sign-in-alt me-2"></i>Login');
        }
    }).fail(function() {
        showMessage('Koneksi gagal!', 'error');
        btn.prop('disabled', false).html('<i class="fas fa-sign-in-alt me-2"></i>Login');
    });
});

function showMessage(msg, type) {
    const color = type === 'success' ? 'bg-success' : 'bg-danger';
    $('#message').html(`
        <div class="alert alert-dismissible fade show ${color} text-white">
            ${msg}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    `);
}
</script>
<?php $this->stop() ?>

<?php $this->layout('layouts::app', ['title' => 'Login']) ?>

<?php $this->start('main') ?>

<div class="login-card">
    <div class="login-header">
        <div class="login-logo"><i class="fas fa-school"></i></div>
        <h1 class="login-title">SchoolTrack</h1>
        <p class="login-subtitle">Sistem Manajemen Pelanggaran Siswa</p>
    </div>

    <form id="loginForm">
        <div class="form-group">
            <label class="form-label" for="name"><i class="fas fa-user me-2"></i>Nama Pengguna</label>
            <div class="input-wrapper">
                <i class="fas fa-user input-icon"></i>
                <input type="text" id="name" class="form-input" placeholder="Masukkan nama" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="password"><i class="fas fa-lock me-2"></i>Kata Sandi</label>
            <div class="input-wrapper">
                <i class="fas fa-lock input-icon"></i>
                <input type="password" id="password" class="form-input" placeholder="Masukkan password" required>
                <button type="button" class="password-toggle" onclick="togglePassword()">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>

        <div class="form-row">
            <label class="checkbox-label">
                <input type="checkbox" id="remember">
                <span class="checkmark"></span>
                Ingat saya
            </label>
        </div>

        <button type="submit" class="btn btn-login" id="loginBtn">
            <span class="btn-text"><i class="fas fa-sign-in-alt me-2"></i>Masuk</span>
            <span class="btn-loading" style="display: none;"><i class="fas fa-spinner fa-spin me-2"></i>Memuat...</span>
        </button>
    </form>

    <div id="message" class="message-container"></div>

    <p class="auth-footer">Belum punya akun? <a href="#">Hubungi Admin</a></p>
</div>

<!-- ACTION SCRIPT - Wrap dalam DOMContentLoaded -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Pastikan jQuery tersedia
    if (typeof $ === 'undefined') {
        console.error('jQuery tidak tersedia!');
        document.getElementById('message').innerHTML = '<div class="alert-glass alert-error-glass"><i class="fas fa-exclamation-circle"></i><span>Error: Library tidak dimuat</span></div>';
        return;
    }

    $('#loginForm').submit(function(e) {
        e.preventDefault();
        
        const btn = $('#loginBtn');
        const btnText = btn.find('.btn-text');
        const btnLoading = btn.find('.btn-loading');
        
        btn.prop('disabled', true);
        btnText.hide();
        btnLoading.show();

        $.post('action_login.php?action=login', {
            name: $('#name').val(),
            password: $('#password').val()
        }).done(function(response) {
            if (response.success) {
                showMessage('✨ Login berhasil! Mengalihkan...', 'success');
                $('.login-card').css({
                    'transform': 'scale(1.02)',
                    'box-shadow': '0 30px 60px -10px var(--glass-shadow), 0 0 40px rgba(52, 211, 153, 0.3)'
                });
                
                setTimeout(() => {
                    window.location.href = response.role === 'admin' ? '?page=users' : '?page=dashboard';
                }, 1500);
            } else {
                showMessage(response.message || 'Login gagal!', 'error');
                $('.login-card').addClass('animate-shake');
                setTimeout(() => $('.login-card').removeClass('animate-shake'), 500);
                
                btn.prop('disabled', false);
                btnText.show();
                btnLoading.hide();
            }
        }).fail(function(xhr) {
            let msg = 'Koneksi gagal! Silahkan coba lagi.';
            try {
                const resp = JSON.parse(xhr.responseText);
                msg = resp.message || msg;
            } catch(e) {}
            
            showMessage(msg, 'error');
            btn.prop('disabled', false);
            btnText.show();
            btnLoading.hide();
        });
    });

    function showMessage(msg, type) {
        const colorClass = type === 'success' ? 'alert-success-glass' : 'alert-error-glass';
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        
        $('#message').html(`
            <div class="alert-glass ${colorClass}">
                <i class="fas ${icon}"></i>
                <span>${msg}</span>
            </div>
        `).hide().fadeIn(300);
        
        setTimeout(() => $('#message').fadeOut(300, function() { $(this).html('').show(); }), 5000);
    }
});
</script>

<?php $this->stop() ?>
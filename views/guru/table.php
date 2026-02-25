<?php $this->layout('layouts::app', ['title' => 'Data Guru']) ?>
<?php $this->start('main') ?>

<!-- CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap5-theme@1.3.0/dist/select2-bootstrap5-theme.min.css" rel="stylesheet" />

<style>
    :root {
        --primary-gradient: linear-gradient(45deg, #3b82f6, #1d4ed8);
        --success-gradient: linear-gradient(45deg, #10b981, #059669);
        --warning-gradient: linear-gradient(45deg, #f59e0b, #d97706);
        --danger-gradient:  linear-gradient(45deg, #ef4444, #dc2626);
    }

    .table-card {
        box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);
        border: 1px solid rgba(0,0,0,.125);
        border-radius: 0.375rem;
        overflow: hidden;
    }
    #guruTable_wrapper { padding: 20px; }
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter { margin-bottom: 15px; }

    /* Badge user status */
    .badge-assigned   { background: var(--success-gradient) !important; color: #fff !important; font-size: .78em; }
    .badge-unassigned { background: var(--warning-gradient) !important; color: #000 !important; font-size: .78em; }

    /* Detail card */
    .detail-card {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid #3b82f6;
        box-shadow: 0 1px 3px rgba(0,0,0,.1);
    }
    .user-card { border-left-color: #10b981 !important; }

    /* Password toggle */
    .password-wrapper {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #1e293b;
        border-radius: 8px;
        padding: 6px 14px;
    }
    .password-text {
        color: #f8fafc;
        font-family: monospace;
        font-size: 1rem;
        letter-spacing: 2px;
        min-width: 120px;
    }
    .btn-toggle-pass {
        background: none;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        padding: 0 4px;
        font-size: 1rem;
        transition: color .2s;
        line-height: 1;
    }
    .btn-toggle-pass:hover { color: #f8fafc; }

    .select2-container--bootstrap5 .select2-selection {
        min-height: calc(1.5em + .75rem + 2px);
    }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h2 mb-1 fw-bold text-dark">
                        <i class="fas fa-chalkboard-teacher me-2 text-primary"></i>Data Guru
                    </h1>
                    <p class="mb-0 text-muted small">Kelola data guru &amp; assign akun guru (role: guru)</p>
                </div>
                <button class="btn btn-primary btn-lg shadow-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fas fa-plus me-2"></i>Tambah Guru
                </button>
            </div>

            <!-- TABLE -->
            <div class="table-card">
                <div class="table-responsive">
                    <table id="guruTable" class="table table-striped table-hover mb-0" style="width:100%">
                        <thead class="table-dark sticky-top">
                            <tr>
                                <th width="5%"  class="text-center fw-bold">No</th>
                                <th width="20%" class="fw-bold">Nama Guru</th>
                                <th width="13%" class="fw-bold text-center">No HP</th>
                                <th width="15%" class="fw-bold">Mapel</th>
                                <th width="12%" class="fw-bold text-center">User</th>
                                <th width="18%" class="fw-bold">Alamat</th>
                                <th width="17%" class="fw-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- ══════════════════════════════════════════════════ -->
    <!-- ADD MODAL                                         -->
    <!-- ══════════════════════════════════════════════════ -->
    <div class="modal fade" id="addModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-plus me-2"></i>Tambah Guru Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="addForm">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    Nama Guru <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="addName" required maxlength="255"
                                       placeholder="Masukkan nama lengkap guru">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    No Handphone <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="tel" class="form-control" id="addNoHp" required
                                           placeholder="08xx-xxxx-xxxx">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Mata Pelajaran</label>
                                <select class="form-select" id="addMapel">
                                    <option value="">-- Pilih Mata Pelajaran --</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    Akun User
                                    <span class="text-muted fw-normal">(opsional, ketik min. 1 huruf)</span>
                                </label>
                                <!-- FIX: pakai <select> biasa, Select2 inject via JS saat modal shown -->
                                <select class="form-select user-select2" id="addUser" style="width:100%">
                                    <option value="">-- Cari akun user guru --</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Alamat</label>
                                <textarea class="form-control" id="addAlamat" rows="3" maxlength="500"
                                          placeholder="Alamat lengkap guru"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Simpan Guru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════ -->
    <!-- EDIT MODAL                                        -->
    <!-- ══════════════════════════════════════════════════ -->
    <div class="modal fade" id="editModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-edit me-2"></i>Edit Data Guru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editForm">
                    <div class="modal-body">
                        <input type="hidden" id="editId">
                        <!-- Simpan user_id & user_name yang sudah assigned untuk inject ke Select2 -->
                        <input type="hidden" id="editCurrentUserId">
                        <input type="hidden" id="editCurrentUserName">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    Nama Guru <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="editName" required maxlength="255">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    No Handphone <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="tel" class="form-control" id="editNoHp" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Mata Pelajaran</label>
                                <select class="form-select" id="editMapel">
                                    <option value="">-- Pilih Mata Pelajaran --</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    Akun User
                                    <span class="text-muted fw-normal">(ketik min. 1 huruf)</span>
                                </label>
                                <select class="form-select user-select2" id="editUser" style="width:100%">
                                    <option value="">-- Cari akun user guru --</option>
                                </select>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Hanya akun dengan role <strong>guru</strong>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Alamat</label>
                                <textarea class="form-control" id="editAlamat" rows="3" maxlength="500"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-1"></i>Update Guru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════ -->
    <!-- DETAIL MODAL                                      -->
    <!-- ══════════════════════════════════════════════════ -->
    <div class="modal fade" id="detailModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-info-circle me-2"></i>Detail Guru Lengkap
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <div id="detailContent" class="p-4">
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status" style="width:3rem;height:3rem;">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-3 text-muted">Memuat detail guru...</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════ -->
    <!-- ASSIGN USER MODAL                                 -->
    <!-- ══════════════════════════════════════════════════ -->
    <div class="modal fade" id="assignModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-user-plus me-2"></i>Assign Akun Guru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="assignForm">
                    <div class="modal-body">
                        <input type="hidden" id="assignGuruId">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Guru</label>
                            <input type="text" class="form-control bg-light fw-bold" id="assignGuruName" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Pilih Akun Guru <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="assignUserId" required>
                                <option value="">-- Loading akun guru tersedia --</option>
                            </select>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Hanya menampilkan akun guru (role: guru) yang belum diassign
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-user-plus me-2"></i>Assign Guru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════ -->
    <!-- DELETE MODAL                                      -->
    <!-- ══════════════════════════════════════════════════ -->
    <div class="modal fade" id="deleteModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <input type="hidden" id="deleteId">
                    <i class="fas fa-exclamation-triangle text-danger fa-3x mb-4 d-block"></i>
                    <h4 class="fw-bold mb-3">Apakah Anda Yakin?</h4>
                    <p class="text-muted mb-0">
                        Guru <strong>"<span id="deleteName"></span>"</strong> akan dihapus
                        <span class="text-danger fw-bold">PERMANEN!</span>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">
                        <i class="fas fa-trash me-1"></i>Hapus Guru
                    </button>
                </div>
            </div>
        </div>
    </div>

</div><!-- /container -->

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
// ════════════════════════════════════════════════════════════
// GLOBAL STATE
// ════════════════════════════════════════════════════════════
let table, mapels = [];

// ════════════════════════════════════════════════════════════
// GLOBAL: loadAvailableUsers — harus global agar bisa
// dipanggil dari assignGuru() yang ada di onclick DataTable
// ════════════════════════════════════════════════════════════
function loadAvailableUsers() {
    return $.get('action_guru.php?action=assign_users')
        .done(function(users) {
            let options = '<option value="">-- Pilih Akun Guru Tersedia --</option>';
            if (!users.length) {
                options += '<option disabled>Tidak ada akun guru tersedia</option>';
            } else {
                users.forEach(function(u) {
                    options += '<option value="' + u.id + '">' + u.name + '</option>';
                });
            }
            $('#assignUserId').html(options);
        })
        .fail(function() {
            $('#assignUserId').html('<option value="">Error loading users</option>');
            showToast('❌ Gagal memuat akun guru', 'error');
        });
}

// ════════════════════════════════════════════════════════════
// GLOBAL: togglePassword
// ════════════════════════════════════════════════════════════
function togglePassword(btn) {
    var wrapper  = $(btn).closest('.password-wrapper');
    var textEl   = wrapper.find('.password-text');
    var icon     = $(btn).find('i');
    var isHidden = textEl.data('hidden');

    if (isHidden) {
        textEl.text(textEl.data('real'));
        textEl.data('hidden', false);
        icon.removeClass('fa-eye').addClass('fa-eye-slash');
        $(btn).attr('title', 'Sembunyikan password');
    } else {
        textEl.text('••••••••');
        textEl.data('hidden', true);
        icon.removeClass('fa-eye-slash').addClass('fa-eye');
        $(btn).attr('title', 'Tampilkan password');
    }
}

// ════════════════════════════════════════════════════════════
// GLOBAL: unassignGuru — lepas user dari guru
// dipanggil dari tombol Unassign di dalam detail modal
// ════════════════════════════════════════════════════════════
function unassignGuru(guruId) {
    if (!confirm('Yakin ingin melepas akun user dari guru ini?')) return;

    $.post('action_guru.php', { action: 'unassign', guru_id: guruId })
        .done(function(response) {
            if (response.success) {
                showToast('✅ Akun guru berhasil di-unassign!', 'success');
                // Tutup detail modal, reload table & available users
                $('#detailModal').modal('hide');
                if (table) table.ajax.reload(null, false);
                loadAvailableUsers();
            } else {
                showToast('❌ ' + (response.message || 'Gagal unassign'), 'error');
            }
        })
        .fail(function() {
            showToast('❌ Koneksi gagal', 'error');
        });
}

// ════════════════════════════════════════════════════════════
// GLOBAL: assignGuru — buka modal assign
// dipanggil dari onclick di DataTable render
// ════════════════════════════════════════════════════════════
function assignGuru(guruId, guruName) {
    $('#assignGuruId').val(guruId);
    $('#assignGuruName').val(guruName || 'Guru');
    $('#assignUserId').html('<option value="">-- Memuat akun guru... --</option>');
    loadAvailableUsers().then(function() {
        $('#assignModal').modal('show');
    });
}

// ════════════════════════════════════════════════════════════
// GLOBAL: showDetail — buka modal detail
// dipanggil dari onclick di DataTable render
// ════════════════════════════════════════════════════════════
function showDetail(id) {
    $('#detailContent').html(
        '<div class="text-center py-5">' +
            '<div class="spinner-border text-primary mb-3" style="width:3rem;height:3rem;" role="status"></div>' +
            '<p class="text-muted mb-0">Memuat detail lengkap...</p>' +
        '</div>'
    );
    $('#detailModal').modal('show');

    $.get('action_guru.php?action=detail&id=' + id)
        .done(function(data) {
            if (!data || !data.id) {
                $('#detailContent').html(
                    '<div class="alert alert-danger text-center py-5">' +
                        '<i class="fas fa-exclamation-triangle fa-3x mb-3 d-block"></i>' +
                        '<h4>Data guru tidak ditemukan</h4>' +
                    '</div>'
                );
                return;
            }

            // ── Password block ─────────────────────────────
            var passwordBlock = '';
            if (data.user_password) {
                var safePass = $('<div>').text(data.user_password).html();
                passwordBlock =
                    '<div class="password-wrapper">' +
                        '<span class="password-text" data-real="' + safePass + '" data-hidden="true">••••••••</span>' +
                        '<button type="button" class="btn-toggle-pass" title="Tampilkan password" onclick="togglePassword(this)">' +
                            '<i class="fas fa-eye"></i>' +
                        '</button>' +
                    '</div>';
            } else {
                passwordBlock = '<span class="badge bg-secondary px-3 py-2">Tidak ada</span>';
            }

            // ── Tombol Unassign ────────────────────────────
            var unassignBtn = '';
            if (data.user_id) {
                unassignBtn =
                    '<div class="mt-3 pt-3 border-top">' +
                        '<button type="button" class="btn btn-outline-danger btn-sm" onclick="unassignGuru(' + data.id + ')">' +
                            '<i class="fas fa-user-minus me-1"></i>Lepas Akun User Ini' +
                        '</button>' +
                        '<small class="text-muted ms-2">Akun user tidak akan terhapus</small>' +
                    '</div>';
            }

            // ── User info block ────────────────────────────
            var userInfo = '';
            if (data.user_id) {
                userInfo =
                    '<div class="detail-card user-card">' +
                        '<div class="d-flex align-items-center mb-3">' +
                            '<i class="fas fa-user-shield fa-2x text-success me-3"></i>' +
                            '<div>' +
                                '<h5 class="mb-1 fw-bold text-success">✅ Akun Guru Terassign</h5>' +
                                '<small class="text-success">Role: ' + (data.user_role || 'guru') + '</small>' +
                            '</div>' +
                        '</div>' +
                        '<div class="row g-3 align-items-center">' +
                            '<div class="col-md-3"><strong>ID User:</strong></div>' +
                            '<div class="col-md-9"><code>' + data.user_id + '</code></div>' +
                            '<div class="col-md-3"><strong>Nama Akun:</strong></div>' +
                            '<div class="col-md-9">' + (data.user_name || '—') + '</div>' +
                            '<div class="col-md-3"><strong>Password:</strong></div>' +
                            '<div class="col-md-9">' + passwordBlock + '</div>' +
                        '</div>' +
                        unassignBtn +
                    '</div>';
            } else {
                userInfo =
                    '<div class="alert alert-warning border-0">' +
                        '<i class="fas fa-exclamation-triangle me-2"></i>' +
                        'Belum ada akun guru yang diassign' +
                    '</div>';
            }

            // ── Mapel badge ────────────────────────────────
            var mapelHtml = data.mapel_name
                ? '<span class="badge bg-info fs-6 px-3">' + data.mapel_name + '</span>'
                : '<span class="text-muted">—</span>';

            // ── Render konten ──────────────────────────────
            $('#detailContent').html(
                '<div class="detail-card">' +
                    '<div class="d-flex align-items-center mb-4">' +
                        '<i class="fas fa-chalkboard-teacher fa-2x text-primary me-3"></i>' +
                        '<h4 class="mb-0 fw-bold">Data Guru</h4>' +
                    '</div>' +
                    '<div class="row g-3">' +
                        '<div class="col-md-3"><strong>Nama:</strong></div>' +
                        '<div class="col-md-9 fw-semibold">' + (data.name || '—') + '</div>' +

                        '<div class="col-md-3"><strong>No HP:</strong></div>' +
                        '<div class="col-md-9">' +
                            '<a href="tel:' + (data.no_handphone || '') + '" class="text-decoration-none">' +
                                '<i class="fas fa-phone me-1 text-muted"></i>' + (data.no_handphone || '—') +
                            '</a>' +
                        '</div>' +

                        '<div class="col-md-3"><strong>Mata Pelajaran:</strong></div>' +
                        '<div class="col-md-9">' + mapelHtml + '</div>' +

                        '<div class="col-md-3"><strong>Alamat:</strong></div>' +
                        '<div class="col-md-9">' + (data.alamat || '—') + '</div>' +
                    '</div>' +
                '</div>' +
                userInfo
            );
        })
        .fail(function() {
            $('#detailContent').html(
                '<div class="alert alert-danger text-center py-5">' +
                    '<i class="fas fa-database fa-3x mb-3 d-block text-danger"></i>' +
                    '<h4>Gagal memuat detail</h4>' +
                    '<p class="mb-0">Coba lagi atau refresh halaman</p>' +
                '</div>'
            );
        });
}

// ════════════════════════════════════════════════════════════
// GLOBAL: confirmDelete — buka modal hapus
// dipanggil dari onclick di DataTable render
// ════════════════════════════════════════════════════════════
function confirmDelete(id, name) {
    $('#deleteId').val(id);
    $('#deleteName').text(name || 'Guru');
    $('#deleteModal').modal('show');
}

// ════════════════════════════════════════════════════════════
// GLOBAL: showToast
// ════════════════════════════════════════════════════════════
function showToast(message, type) {
    type = type || 'success';
    var bgClass   = type === 'success' ? 'bg-success' : 'bg-danger';
    var iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
    var html =
        '<div class="toast align-items-center text-white ' + bgClass + ' border-0 position-fixed top-0 end-0 m-4 shadow-lg"' +
             ' role="alert" style="z-index:9999;min-width:300px;max-width:400px;">' +
            '<div class="d-flex">' +
                '<div class="toast-body d-flex align-items-center">' +
                    '<i class="fas ' + iconClass + ' me-2 fs-5"></i>' + message +
                '</div>' +
                '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>' +
            '</div>' +
        '</div>';
    $('body').append(html);
    var toastEl = $('.toast').last();
    new bootstrap.Toast(toastEl[0], { delay: 4000 }).show();
    toastEl.on('hidden.bs.toast', function() { $(this).remove(); });
}

// ════════════════════════════════════════════════════════════
// DOCUMENT READY
// ════════════════════════════════════════════════════════════
$(document).ready(function() {

    // ── 1. Load data awal ──────────────────────────────────
    loadAvailableUsers();

    // ── 2. Load mapels lalu init DataTable ────────────────
    $.get('action_mapel.php?action=read')
        .done(function(data) {
            mapels = data || [];
            populateMapelDropdowns();
            initDataTable();
        })
        .fail(function() { showToast('❌ Gagal load mapel!', 'error'); });

    function populateMapelDropdowns() {
        var options = '<option value="">-- Pilih Mata Pelajaran --</option>';
        mapels.forEach(function(m) {
            options += '<option value="' + m.id + '">' + m.name + '</option>';
        });
        $('#addMapel, #editMapel').html(options);
    }

    // ── 3. DataTable ───────────────────────────────────────
    function initDataTable() {
        table = $('#guruTable').DataTable({
            ajax: {
                url: 'action_guru.php?action=read',
                dataSrc: '',
                error: function() { showToast('❌ Gagal load data guru!', 'error'); }
            },
            columns: [
                {
                    data: null, orderable: false, className: 'text-center fw-semibold',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data: 'name', className: 'fw-medium align-middle' },
                { data: 'no_handphone', className: 'text-center fw-semibold align-middle' },
                {
                    data: null,
                    className: 'align-middle',
                    render: function(data) {
                        var mapelObj  = mapels.find(function(m) { return m.id == data.id_mapel; });
                        var mapelName = mapelObj ? mapelObj.name : null;
                        return mapelName
                            ? '<span class="badge bg-info">' + mapelName + '</span>'
                            : '<span class="text-muted">—</span>';
                    }
                },
                {
                    data: 'user_status', className: 'text-center align-middle',
                    render: function(data) {
                        return data === 'Assigned'
                            ? '<span class="badge badge-assigned">✅ Assigned</span>'
                            : '<span class="badge badge-unassigned">⏳ Belum Assign</span>';
                    }
                },
                {
                    data: 'alamat', className: 'align-middle',
                    render: function(data) {
                        if (!data) return '<span class="text-muted">—</span>';
                        var short = data.length > 40 ? data.substring(0, 40) + '…' : data;
                        return '<span title="' + $('<div>').text(data).html() + '">' + short + '</span>';
                    }
                },
                {
                    // ────────────────────────────────────────────
                    // FIX UTAMA: Sebelumnya onclick string tidak
                    // ditutup dengan benar sehingga tombol tidak
                    // bisa diklik. Sekarang pakai data-* attribute
                    // + delegated event agar 100% aman.
                    // ────────────────────────────────────────────
                    data: null, orderable: false, className: 'text-center align-middle',
                    render: function(data, type, row) {
                        var safeId   = row.id;
                        var safeName = $('<div>').text(row.name || '').html();

                        var assignBtn = !row.id_user
                            ? '<button class="btn btn-success btn-sm px-2 py-1 btn-assign-tbl"' +
                              ' data-id="' + safeId + '" data-name="' + safeName + '" title="Assign Akun">' +
                              '<i class="fas fa-user-plus"></i></button> '
                            : '';

                        return '<div class="d-flex justify-content-center gap-1 flex-wrap">' +
                                   assignBtn +
                                   '<button class="btn btn-info btn-sm px-2 py-1 btn-detail-tbl"' +
                                   ' data-id="' + safeId + '" title="Detail">' +
                                   '<i class="fas fa-eye"></i></button>' +

                                   '<button class="btn btn-warning btn-sm px-2 py-1 btn-edit-tbl"' +
                                   ' data-id="' + safeId + '" title="Edit">' +
                                   '<i class="fas fa-edit"></i></button>' +

                                   '<button class="btn btn-danger btn-sm px-2 py-1 btn-delete-tbl"' +
                                   ' data-id="' + safeId + '" data-name="' + safeName + '" title="Hapus">' +
                                   '<i class="fas fa-trash"></i></button>' +
                               '</div>';
                    }
                }
            ],
            language: {
                emptyTable:   'Belum ada data guru',
                info:         'Menampilkan _START_–_END_ dari _TOTAL_ guru',
                infoEmpty:    'Menampilkan 0 guru',
                infoFiltered: '(disaring dari _MAX_ guru)',
                lengthMenu:   'Tampilkan _MENU_ guru',
                search:       'Cari guru:',
                zeroRecords:  'Tidak ditemukan guru',
                paginate: { first: '⏮', last: '⏭', next: '▶', previous: '◀' }
            },
            pageLength: 25,
            responsive: true,
            order: [[1, 'asc']]
        });
    }

    // ── 4. Delegated click untuk tombol di dalam DataTable ─
    // Lebih aman dari onclick string karena tidak tergantung
    // escaping nama di dalam HTML attribute

    // Tombol Assign
    $(document).on('click', '.btn-assign-tbl', function() {
        var id   = $(this).data('id');
        var name = $(this).data('name');
        assignGuru(id, name);
    });

    // Tombol Detail
    $(document).on('click', '.btn-detail-tbl', function() {
        showDetail($(this).data('id'));
    });

    // Tombol Edit
    $(document).on('click', '.btn-edit-tbl', function() {
        var id = $(this).data('id');
        $.get('action_guru.php?action=get&id=' + id)
            .done(function(data) {
                if (!data || !data.length) {
                    showToast('❌ Data guru tidak ditemukan', 'error');
                    return;
                }
                var guru = data[0];

                // Isi field biasa
                $('#editId').val(guru.id);
                $('#editName').val(guru.name || '');
                $('#editNoHp').val(guru.no_handphone || '');
                $('#editMapel').val(guru.id_mapel || '');
                $('#editAlamat').val(guru.alamat || '');

                // Simpan user saat ini untuk di-inject ke Select2
                // setelah modal shown (Select2 belum init sebelum modal muncul)
                $('#editCurrentUserId').val(guru.user_id || '');
                $('#editCurrentUserName').val(guru.user_name || '');

                $('#editModal').modal('show');
            })
            .fail(function() { showToast('❌ Gagal memuat data edit', 'error'); });
    });

    // Tombol Delete
    $(document).on('click', '.btn-delete-tbl', function() {
        confirmDelete($(this).data('id'), $(this).data('name'));
    });

    // ── 5. Select2 — init saat modal ADD atau EDIT dibuka ─
    $('#addModal, #editModal').on('shown.bs.modal', function() {
        var $modal  = $(this);
        var isEdit  = $modal.is('#editModal');

        $modal.find('.user-select2').each(function() {
            var $select = $(this);

            // Init Select2 hanya sekali per elemen
            if (!$select.hasClass('select2-hidden-accessible')) {
                $select.select2({
                    theme: 'bootstrap-5',
                    placeholder: 'Ketik nama user min. 1 huruf...',
                    allowClear: true,
                    dropdownParent: $modal,
                    ajax: {
                        url: 'action_guru.php?action=users',
                        dataType: 'json',
                        delay: 300,
                        data: function(params) { return { search: params.term || '' }; },
                        processResults: function(res) {
                            return {
                                results: res.map(function(u) {
                                    return { id: u.id, text: u.name };
                                })
                            };
                        },
                        cache: true
                    },
                    minimumInputLength: 1
                });
            }

            // FIX: Inject nilai user yang sudah assigned ke edit form
            // Harus dilakukan setelah Select2 init
            if (isEdit && $select.is('#editUser')) {
                var userId   = $('#editCurrentUserId').val();
                var userName = $('#editCurrentUserName').val();

                if (userId && userName) {
                    // Buat option baru dan set sebagai nilai terpilih
                    var newOption = new Option(userName, userId, true, true);
                    $select.append(newOption).trigger('change');
                } else {
                    $select.val('').trigger('change');
                }
            }
        });
    });

    // Clear Select2 & hidden fields saat modal ditutup
    $('#addModal, #editModal').on('hidden.bs.modal', function() {
        $(this).find('.user-select2').val(null).trigger('change');
        $('#editCurrentUserId, #editCurrentUserName').val('');
    });

    // ── 6. Auto-reload setelah modal assign/delete/edit ditutup
    $(document).on('hidden.bs.modal', '#assignModal, #editModal, #deleteModal', function() {
        loadAvailableUsers();
        if (table) table.ajax.reload(null, false);
    });

    // ── 7. ADD form submit ─────────────────────────────────
    $('#addForm').on('submit', function(e) {
        e.preventDefault();
        var $btn = $(this).find('[type=submit]');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...');

        $.post('action_guru.php', {
            action:       'add',
            name:         $('#addName').val().trim(),
            no_handphone: $('#addNoHp').val().trim(),
            id_mapel:     $('#addMapel').val()  || '',
            id_user:      $('#addUser').val()   || '',
            alamat:       $('#addAlamat').val().trim()
        }).done(function(response) {
            if (response.success) {
                $('#addModal').modal('hide');
                $('#addForm')[0].reset();
                // Reset Select2 juga
                $('#addUser').val(null).trigger('change');
                table.ajax.reload(null, false);
                showToast('✅ Guru berhasil ditambahkan!', 'success');
            } else {
                showToast('❌ ' + (response.message || 'Gagal menambah guru'), 'error');
            }
        }).fail(function() {
            showToast('❌ Koneksi gagal', 'error');
        }).always(function() {
            $btn.prop('disabled', false).html('<i class="fas fa-save me-1"></i>Simpan Guru');
        });
    });

    // ── 8. EDIT form submit ────────────────────────────────
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        var $btn = $(this).find('[type=submit]');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...');

        $.post('action_guru.php', {
            action:       'edit',
            id:           $('#editId').val(),
            name:         $('#editName').val().trim(),
            no_handphone: $('#editNoHp').val().trim(),
            id_mapel:     $('#editMapel').val()  || '',
            id_user:      $('#editUser').val()   || '',
            alamat:       $('#editAlamat').val().trim()
        }).done(function(response) {
            if (response.success) {
                $('#editModal').modal('hide');
                table.ajax.reload(null, false);
                showToast('✅ Data guru berhasil diupdate!', 'success');
            } else {
                showToast('❌ ' + (response.message || 'Gagal update'), 'error');
            }
        }).fail(function() {
            showToast('❌ Koneksi gagal', 'error');
        }).always(function() {
            $btn.prop('disabled', false).html('<i class="fas fa-save me-1"></i>Update Guru');
        });
    });

    // ── 9. ASSIGN form submit ──────────────────────────────
    $('#assignForm').on('submit', function(e) {
        e.preventDefault();
        var $btn = $(this).find('[type=submit]');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Assign...');

        $.post('action_guru.php', {
            action:  'assign',
            guru_id: $('#assignGuruId').val(),
            user_id: $('#assignUserId').val()
        }).done(function(response) {
            if (response.success) {
                $('#assignModal').modal('hide');
                table.ajax.reload(null, false);
                loadAvailableUsers();
                showToast('✅ Akun guru berhasil diassign!', 'success');
            } else {
                showToast('❌ ' + (response.message || 'Gagal assign'), 'error');
            }
        }).fail(function() {
            showToast('❌ Koneksi gagal', 'error');
        }).always(function() {
            $btn.prop('disabled', false).html('<i class="fas fa-user-plus me-2"></i>Assign Guru');
        });
    });

    // ── 10. DELETE confirm click ───────────────────────────
    $('#confirmDelete').on('click', function() {
        var id   = $('#deleteId').val();
        var $btn = $(this);

        if (!id) {
            showToast('❌ ID tidak ditemukan', 'error');
            return;
        }

        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Menghapus...');

        $.post('action_guru.php', { action: 'delete', id: id })
            .done(function(response) {
                if (response.success) {
                    $('#deleteModal').modal('hide');
                    table.ajax.reload(null, false);
                    loadAvailableUsers();
                    showToast('✅ Guru berhasil dihapus!', 'success');
                } else {
                    showToast('❌ ' + (response.message || 'Gagal menghapus guru'), 'error');
                }
            })
            .fail(function() {
                showToast('❌ Koneksi gagal', 'error');
            })
            .always(function() {
                $btn.prop('disabled', false).html('<i class="fas fa-trash me-1"></i>Hapus Guru');
            });
    });

}); // END document.ready
</script>

<?php $this->stop() ?>
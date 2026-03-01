<?php $this->layout('layouts::app', ['title' => 'Data Users']) ?>
<?php $this->start('main') ?>

<!-- CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    .table-card {
        box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);
        border: 1px solid rgba(0,0,0,.125);
        border-radius: 0.375rem;
        overflow: hidden;
    }
    #usersTable_wrapper { padding: 20px; }

    /* Badge role */
    .role-badge {
        font-size: .8em;
        padding: .35em .75em;
        border-radius: 20px;
        font-weight: 600;
        letter-spacing: .02em;
    }
    .role-admin   { background: #dbeafe; color: #1d4ed8; }
    .role-guru    { background: #dcfce7; color: #15803d; }
    .role-siswa   { background: #fef9c3; color: #854d0e; }
    .role-default { background: #f1f5f9; color: #475569; }

    /* Password field */
    .pass-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }
    .pass-wrapper input { padding-right: 2.5rem; }
    .btn-eye {
        position: absolute;
        right: 8px;
        background: none;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        padding: 0;
        font-size: .95rem;
        line-height: 1;
        z-index: 5;
    }
    .btn-eye:hover { color: #334155; }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h2 mb-1 fw-bold text-dark">
                        <i class="fas fa-users me-2 text-primary"></i>Data Users
                    </h1>
                    <p class="mb-0 text-muted small">Kelola akun user sistem (admin, guru, siswa)</p>
                </div>
                <button class="btn btn-primary btn-lg shadow-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fas fa-plus me-2"></i>Tambah User
                </button>
            </div>

            <!-- TABLE -->
            <div class="table-card">
                <div class="table-responsive">
                    <table id="usersTable" class="table table-striped table-hover mb-0" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th width="8%"  class="text-center fw-bold">No</th>
                                <th width="35%" class="fw-bold">Nama</th>
                                <th width="15%" class="fw-bold text-center">Role</th>
                                <th width="22%" class="fw-bold text-center">Aksi</th>
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
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-user-plus me-2"></i>Tambah User Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="addForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Nama <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="addName" required maxlength="255"
                                   placeholder="Nama lengkap user">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Password <span class="text-danger">*</span>
                            </label>
                            <div class="pass-wrapper">
                                <input type="password" class="form-control" id="addPassword"
                                       required placeholder="Password user" autocomplete="new-password">
                                <button type="button" class="btn-eye" onclick="toggleEye(this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-1">
                            <label class="form-label fw-bold">
                                Role <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="addRole" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="admin">Admin</option>
                                <option value="guru">Guru</option>
                                <option value="guru">Guru BK</option>
                                <option value="siswa">Siswa</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Simpan User
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
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-user-edit me-2"></i>Edit User
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editForm">
                    <div class="modal-body">
                        <input type="hidden" id="editId">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Nama <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="editName" required maxlength="255">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Password</label>
                            <div class="pass-wrapper">
                                <input type="password" class="form-control" id="editPassword"
                                       placeholder="Kosongkan jika tidak ingin ganti"
                                       autocomplete="new-password">
                                <button type="button" class="btn-eye" onclick="toggleEye(this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Biarkan kosong jika tidak ingin mengganti password
                            </div>
                        </div>
                        <div class="mb-1">
                            <label class="form-label fw-bold">
                                Role <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="editRole" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="admin">Admin</option>
                                <option value="guru">Guru</option>
                                <option value="siswa">Siswa</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-1"></i>Update User
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
                    <i class="fas fa-exclamation-triangle text-danger fa-3x mb-3 d-block"></i>
                    <h4 class="fw-bold mb-3">Apakah Anda Yakin?</h4>
                    <p class="text-muted mb-1">
                        User <strong>"<span id="deleteName"></span>"</strong> akan dihapus
                        <span class="text-danger fw-bold">PERMANEN!</span>
                    </p>
                    <p class="text-muted small mb-0">
                        <i class="fas fa-info-circle me-1"></i>
                        Relasi ke siswa / guru akan dilepas otomatis
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">
                        <i class="fas fa-trash me-1"></i>Hapus User
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════ -->
    <!-- WORD EXPORT MODAL (dipertahankan dari kode lama)  -->
    <!-- ══════════════════════════════════════════════════ -->
    <div class="modal fade" id="dateModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-file-word me-2"></i>Export Laporan Word
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="userId">
                    <div class="mb-3">
                        <label class="form-label fw-bold">User</label>
                        <input type="text" class="form-control bg-light fw-bold" id="wordUserName" readonly>
                    </div>
                    <div class="mb-1">
                        <label class="form-label fw-bold">Tanggal Laporan</label>
                        <input type="date" class="form-control" id="reportDate">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-info text-white" onclick="downloadWord()">
                        <i class="fas fa-download me-1"></i>Download Word
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

<script>
// ════════════════════════════════════════════════════════
// GLOBAL: Toggle show/hide password
// ════════════════════════════════════════════════════════
function toggleEye(btn) {
    var inp  = $(btn).closest('.pass-wrapper').find('input');
    var icon = $(btn).find('i');
    if (inp.attr('type') === 'password') {
        inp.attr('type', 'text');
        icon.removeClass('fa-eye').addClass('fa-eye-slash');
    } else {
        inp.attr('type', 'password');
        icon.removeClass('fa-eye-slash').addClass('fa-eye');
    }
}

// ════════════════════════════════════════════════════════
// GLOBAL: Word export modal
// ════════════════════════════════════════════════════════
function openWordModal(userId, userName) {
    $('#userId').val(userId);
    $('#wordUserName').val(userName);
    $('#reportDate').val(new Date().toISOString().split('T')[0]);
    new bootstrap.Modal(document.getElementById('dateModal')).show();
}

function downloadWord() {
    var uid  = $('#userId').val();
    var date = $('#reportDate').val();
    window.location.href = 'export_user.php?id=' + uid + '&date=' + date;
}

// ════════════════════════════════════════════════════════
// GLOBAL: Delete modal
// ════════════════════════════════════════════════════════
function confirmDelete(id, name) {
    $('#deleteId').val(id);
    $('#deleteName').text(name);
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

// ════════════════════════════════════════════════════════
// GLOBAL: Toast
// ════════════════════════════════════════════════════════
function showToast(msg, type) {
    type = type || 'success';
    var bg   = type === 'success' ? 'bg-success' : 'bg-danger';
    var icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
    var html =
        '<div class="toast align-items-center text-white ' + bg +
            ' border-0 position-fixed top-0 end-0 m-4 shadow-lg"' +
            ' role="alert" style="z-index:9999;min-width:300px;">' +
            '<div class="d-flex">' +
                '<div class="toast-body d-flex align-items-center">' +
                    '<i class="fas ' + icon + ' me-2 fs-5"></i>' + msg +
                '</div>' +
                '<button type="button" class="btn-close btn-close-white me-2 m-auto"' +
                    ' data-bs-dismiss="toast"></button>' +
            '</div>' +
        '</div>';
    $('body').append(html);
    var el = $('.toast').last();
    new bootstrap.Toast(el[0], { delay: 4000 }).show();
    el.on('hidden.bs.toast', function() { $(this).remove(); });
}

// ════════════════════════════════════════════════════════
// Helper: render badge role berwarna
// ════════════════════════════════════════════════════════
function roleBadge(role) {
    var cls = { admin: 'role-admin', guru: 'role-guru', siswa: 'role-siswa' }[role] || 'role-default';
    return '<span class="role-badge ' + cls + '">' + (role || '—') + '</span>';
}

// ════════════════════════════════════════════════════════
// DOCUMENT READY
// ════════════════════════════════════════════════════════
$(document).ready(function() {

    // ── DataTable ──────────────────────────────────────
    var table = $('#usersTable').DataTable({
        ajax: {
            url: 'action_users.php?action=read',
            dataSrc: '',
            error: function() { showToast('❌ Gagal load data user!', 'error'); }
        },
        columns: [
            {
                data: null, orderable: false, className: 'text-center fw-semibold',
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { data: 'name', className: 'fw-medium align-middle' },
            {
                data: 'role', className: 'text-center align-middle',
                render: function(data) { return roleBadge(data); }
            },
            {
                data: null, orderable: false, className: 'text-center align-middle',
                render: function(data, type, row) {
                    var id   = row.id;
                    var name = $('<div>').text(row.name || '').html();
                    return '<div class="d-flex justify-content-center gap-1 flex-wrap">' +
                        '<button class="btn btn-info btn-sm px-2 py-1 btn-word-tbl text-white"' +
                            ' data-id="' + id + '" data-name="' + name + '" title="Export Word">' +
                            '<i class="fas fa-file-word"></i></button>' +
                        '<button class="btn btn-warning btn-sm px-2 py-1 btn-edit-tbl"' +
                            ' data-id="' + id + '" title="Edit">' +
                            '<i class="fas fa-edit"></i></button>' +
                        '<button class="btn btn-danger btn-sm px-2 py-1 btn-delete-tbl"' +
                            ' data-id="' + id + '" data-name="' + name + '" title="Hapus">' +
                            '<i class="fas fa-trash"></i></button>' +
                    '</div>';
                }
            }
        ],
        language: {
            emptyTable:   'Belum ada data user',
            info:         'Menampilkan _START_–_END_ dari _TOTAL_ user',
            infoEmpty:    'Menampilkan 0 user',
            infoFiltered: '(disaring dari _MAX_ user)',
            lengthMenu:   'Tampilkan _MENU_ user',
            search:       'Cari:',
            zeroRecords:  'User tidak ditemukan',
            paginate: { first: '⏮', last: '⏭', next: '▶', previous: '◀' }
        },
        pageLength: 25,
        responsive: true,
        order: [[1, 'asc']]
    });

    // ── Delegated click ────────────────────────────────

    $(document).on('click', '.btn-word-tbl', function() {
        openWordModal($(this).data('id'), $(this).data('name'));
    });

    $(document).on('click', '.btn-edit-tbl', function() {
        var id = $(this).data('id');
        $.get('action_users.php?action=get&id=' + id)
            .done(function(data) {
                if (!data || !data.id) {
                    showToast('❌ Data tidak ditemukan', 'error');
                    return;
                }
                $('#editId').val(data.id);
                $('#editName').val(data.name || '');
                $('#editRole').val(data.role || '');
                // Password selalu dikosongkan & di-reset ke tipe password
                $('#editPassword').val('').attr('type', 'password');
                $('#editModal .btn-eye i').removeClass('fa-eye-slash').addClass('fa-eye');
                new bootstrap.Modal(document.getElementById('editModal')).show();
            })
            .fail(function() { showToast('❌ Gagal memuat data', 'error'); });
    });

    $(document).on('click', '.btn-delete-tbl', function() {
        confirmDelete($(this).data('id'), $(this).data('name'));
    });

    // ── ADD submit ─────────────────────────────────────
    $('#addForm').on('submit', function(e) {
        e.preventDefault();
        var $btn = $(this).find('[type=submit]');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...');

        $.post('action_users.php', {
            action:   'add',
            name:     $('#addName').val().trim(),
            password: $('#addPassword').val(),
            role:     $('#addRole').val()
        }).done(function(res) {
            if (res.success) {
                $('#addModal').modal('hide');
                $('#addForm')[0].reset();
                $('#addPassword').attr('type', 'password');
                $('#addModal .btn-eye i').removeClass('fa-eye-slash').addClass('fa-eye');
                table.ajax.reload(null, false);
                showToast('✅ User berhasil ditambahkan!', 'success');
            } else {
                showToast('❌ ' + (res.message || 'Gagal menambah user'), 'error');
            }
        }).fail(function() {
            showToast('❌ Koneksi gagal', 'error');
        }).always(function() {
            $btn.prop('disabled', false).html('<i class="fas fa-save me-1"></i>Simpan User');
        });
    });

    // ── EDIT submit ────────────────────────────────────
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        var $btn = $(this).find('[type=submit]');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...');

        $.post('action_users.php', {
            action:   'edit',
            id:       $('#editId').val(),
            name:     $('#editName').val().trim(),
            password: $('#editPassword').val(),   // kosong = tidak ganti
            role:     $('#editRole').val()
        }).done(function(res) {
            if (res.success) {
                $('#editModal').modal('hide');
                table.ajax.reload(null, false);
                showToast('✅ User berhasil diupdate!', 'success');
            } else {
                showToast('❌ ' + (res.message || 'Gagal update user'), 'error');
            }
        }).fail(function() {
            showToast('❌ Koneksi gagal', 'error');
        }).always(function() {
            $btn.prop('disabled', false).html('<i class="fas fa-save me-1"></i>Update User');
        });
    });

    // ── DELETE confirm ─────────────────────────────────
    $('#confirmDelete').on('click', function() {
        var id   = $('#deleteId').val();
        var $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Menghapus...');

        $.post('action_users.php', { action: 'delete', id: id })
            .done(function(res) {
                if (res.success) {
                    $('#deleteModal').modal('hide');
                    table.ajax.reload(null, false);
                    showToast('✅ User berhasil dihapus!', 'success');
                } else {
                    showToast('❌ ' + (res.message || 'Gagal hapus user'), 'error');
                }
            }).fail(function() {
                showToast('❌ Koneksi gagal', 'error');
            }).always(function() {
                $btn.prop('disabled', false).html('<i class="fas fa-trash me-1"></i>Hapus User');
            });
    });

}); // END ready
</script>

<?php $this->stop() ?>
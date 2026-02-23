<?php $this->layout('layouts::app', ['title' => 'Data Siswa - Management System']) ?>

<?php $this->start('main') ?>

<style>
    :root {
        --primary-gradient: linear-gradient(45deg, #3b82f6, #1d4ed8);
        --success-gradient: linear-gradient(45deg, #10b981, #059669);
        --warning-gradient: linear-gradient(45deg, #f59e0b, #d97706);
        --danger-gradient: linear-gradient(45deg, #ef4444, #dc2626);
    }

    .badge-point {
        background: var(--primary-gradient) !important;
        color: white !important;
        font-weight: 600;
        font-size: 0.85em;
        padding: 0.5em 0.75em;
    }

    .badge-status {
        background: #6c757d !important;
        color: white !important;
        font-size: 0.8em;
    }

    .badge-assigned {
        background: var(--success-gradient) !important;
        color: white !important;
        font-size: 0.8em;
    }

    .badge-unassigned {
        background: var(--warning-gradient) !important;
        color: black !important;
        font-size: 0.8em;
    }

    .detail-card {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid #3b82f6;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .user-card {
        border-left: 4px solid #10b981 !important;
    }

    .card-main {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        border: none;
        border-radius: 16px;
        overflow: hidden;
    }

    /* Style untuk password toggle */
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
        transition: color 0.2s;
        line-height: 1;
    }

    .btn-toggle-pass:hover {
        color: #f8fafc;
    }
</style>

<!-- EXTERNAL CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<div class="container-fluid py-4">
    <!-- HEADER -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="mb-1 fw-bold fs-1">
                        <i class="fas fa-users text-primary me-3"></i>
                        Data Siswa
                    </h1>
                    <p class="mb-0 text-muted fs-6">Kelola data siswa & assign akun siswa (role: siswa)</p>
                </div>
                <button class="btn btn-primary btn-lg px-4 py-2 shadow-lg" data-bs-toggle="modal"
                    data-bs-target="#addModal">
                    <i class="fas fa-plus me-2"></i>
                    Tambah Siswa Baru
                </button>
            </div>
        </div>
    </div>

    <!-- MAIN TABLE -->
    <div class="card card-main">
        <div class="card-header bg-primary text-white py-4">
            <h3 class="mb-0 fw-bold">
                <i class="fas fa-table-list me-2"></i>
                Daftar Siswa Lengkap
            </h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="siswaTable" class="table table-hover mb-0" style="width:100%">
                    <thead class="table-dark sticky-top">
                        <tr>
                            <th width="5%" class="text-center align-middle">No</th>
                            <th width="16%" class="align-middle">Nama Siswa</th>
                            <th width="10%" class="text-center align-middle">NIS</th>
                            <th width="12%" class="align-middle">Kelas</th>
                            <th width="16%" class="align-middle">Nama Orang Tua</th>
                            <th width="10%" class="text-center align-middle">Telp Siswa</th>
                            <th width="8%" class="text-center align-middle">Point</th>
                            <th width="8%" class="text-center align-middle">Status</th>
                            <th width="10%" class="text-center align-middle">User</th>
                            <th width="15%" class="text-center align-middle">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ADD SISWA MODAL -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-user-plus me-2"></i>
                        Tambah Siswa Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="addForm">
                    <div class="modal-body">
                        <input type="hidden" id="addDetail" value="">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nama Siswa <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="addName" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">NIS <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="addNis" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Kelas <span class="text-danger">*</span></label>
                            <select class="form-select" id="addIdKelas" required>
                                <option value="">-- Pilih Kelas --</option>
                            </select>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nama Orang Tua <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="addNamaOrtu" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pekerjaan Orang Tua</label>
                                <input type="text" class="form-control" id="addPekerjaanOrtu">
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Telp Orang Tua</label>
                                <input type="tel" class="form-control" id="addTelpOrtu">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Telp Siswa</label>
                                <input type="tel" class="form-control" id="addTelp">
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Alamat Siswa <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" rows="3" id="addAlamat" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Alamat Orang Tua</label>
                                <textarea class="form-control" rows="3" id="addAlamatOrtu"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Point Pelanggaran</label>
                                <input type="number" class="form-control bg-light" id="addPoint" value="0" readonly>
                                <small class="text-muted">Otomatis dari pelanggaran</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Siswa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- EDIT MODAL -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>
                        Edit Data Siswa
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editForm">
                    <div class="modal-body">
                        <input type="hidden" id="editId">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nama Siswa <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="editName" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">NIS <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="editNis" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Kelas</label>
                            <select class="form-select" id="editIdKelas">
                                <option value="">-- Pilih Kelas --</option>
                            </select>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nama Orang Tua <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="editNamaOrtu" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pekerjaan Orang Tua</label>
                                <input type="text" class="form-control" id="editPekerjaanOrtu">
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Telp Orang Tua</label>
                                <input type="tel" class="form-control" id="editTelpOrtu">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Telp Siswa</label>
                                <input type="tel" class="form-control" id="editTelp">
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Alamat Siswa <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" rows="3" id="editAlamat" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Alamat Orang Tua</label>
                                <textarea class="form-control" rows="3" id="editAlamatOrtu"></textarea>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">ID User (Siswa)</label>
                                <input type="number" class="form-control" id="editIdUser"
                                    placeholder="Kosongkan jika tidak assign">
                                <small class="text-muted">Assign user role siswa ke siswa ini</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Point Pelanggaran</label>
                                <input type="number" class="form-control bg-light" id="editPoint" readonly>
                                <small class="text-muted">Otomatis dari pelanggaran</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Update Siswa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- DETAIL MODAL -->
    <div class="modal fade" id="detailModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-info-circle me-2"></i>
                        Detail Siswa Lengkap
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div id="detailContent" class="p-4">
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-3 text-muted">Memuat detail siswa...</p>
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

    <!-- ASSIGN USER MODAL -->
    <div class="modal fade" id="assignModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-user-plus me-2"></i>
                        Assign Akun Siswa
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="assignForm">
                    <div class="modal-body">
                        <input type="hidden" id="assignSiswaId">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Siswa</label>
                            <input type="text" class="form-control bg-light fw-bold" id="assignSiswaName" readonly>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Pilih Akun Siswa <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="assignUserId" required>
                                <option value="">-- Loading akun siswa tersedia --</option>
                            </select>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Hanya menampilkan akun siswa (role: siswa) yang belum diassign
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-user-plus me-2"></i>Assign Siswa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- DELETE CONFIRM MODAL -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-trash me-2"></i>
                        Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="mb-4">
                        <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                        <h4 id="deleteMessage" class="text-danger mb-0"></h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">
                        <i class="fas fa-trash me-2"></i>Hapus Permanen
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JAVASCRIPT -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
    // ============================================================
    // GLOBAL VARIABLES
    // ============================================================
    let kelasData = [];
    let siswaTable;
    let deleteSiswaId = null;
    let availableUsers = [];

    // ============================================================
    // GLOBAL: loadAvailableUsers
    // ============================================================
    function loadAvailableUsers() {
        return $.get('action_siswa.php?action=assign_users')
            .done(function (users) {
                availableUsers = users;
                let options = '<option value="">-- Pilih Akun Siswa Tersedia --</option>';
                if (users.length === 0) {
                    options += '<option disabled>Tidak ada akun siswa tersedia</option>';
                } else {
                    users.forEach(function (user) {
                        options += `<option value="${user.id}">${user.name}</option>`;
                    });
                }
                $('#assignUserId').html(options);
            })
            .fail(function () {
                $('#assignUserId').html('<option value="">Error loading users</option>');
                showToast('❌ Gagal memuat akun siswa', 'error');
            });
    }

    // ============================================================
    // GLOBAL: togglePassword - show/hide password di detail modal
    // ============================================================
    function togglePassword(btn) {
        const wrapper = $(btn).closest('.password-wrapper');
        const textEl = wrapper.find('.password-text');
        const icon = $(btn).find('i');
        const isHidden = textEl.data('hidden');

        if (isHidden) {
            // Tampilkan password asli
            textEl.text(textEl.data('real'));
            textEl.data('hidden', false);
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
            $(btn).attr('title', 'Sembunyikan password');
        } else {
            // Sembunyikan kembali
            textEl.text('••••••••');
            textEl.data('hidden', true);
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
            $(btn).attr('title', 'Tampilkan password');
        }
    }

    // ============================================================
    // DOCUMENT READY
    // ============================================================
    $(document).ready(function () {

        // 1. LOAD KELAS
        $.get('action_kelas.php?action=read')
            .done(function (data) {
                kelasData = data || [];
                populateKelasDropdown();
            })
            .fail(function () {
                showToast('❌ Gagal memuat kelas', 'error');
            });

        function populateKelasDropdown() {
            let options = '<option value="">-- Pilih Kelas --</option>';
            kelasData.forEach(function (kelas) {
                options += `<option value="${kelas.id}">${kelas.tingkat || ''} ${kelas.jurusan || ''} ${kelas.kelas || ''}</option>`;
            });
            $('#addIdKelas, #editIdKelas').html(options);
        }

        // 2. INIT LOAD AVAILABLE USERS
        loadAvailableUsers();

        // 3. DATATABLE
        siswaTable = $('#siswaTable').DataTable({
            ajax: {
                url: 'action_siswa.php?action=read',
                dataSrc: function (json) {
                    console.log(`✅ Loaded ${json.length} siswa records`);
                    return json;
                },
                error: function (xhr) {
                    console.error('AJAX Error:', xhr.responseText);
                    showToast(`❌ Gagal memuat data: ${xhr.status}`, 'error');
                }
            },
            columns: [
                {
                    data: null, orderable: false, className: 'text-center',
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'name', className: 'fw-semibold',
                    render: function (data) { return data || '<i class="text-muted">—</i>'; }
                },
                {
                    data: 'nis', className: 'text-center fw-semibold',
                    render: function (data) { return data || '<span class="text-muted">—</span>'; }
                },
                {
                    data: null,
                    render: function (data) {
                        return data.kelas_name
                            ? `<span class="badge bg-info">${data.kelas_name}</span>`
                            : '<span class="text-muted">Belum ada kelas</span>';
                    }
                },
                {
                    data: 'name_orang_tua',
                    render: function (data) { return data || '<i class="text-muted">—</i>'; }
                },
                {
                    data: 'telphone', className: 'text-center',
                    render: function (data) { return data || '<i class="text-muted">—</i>'; }
                },
                {
                    data: 'point', className: 'text-center fw-bold',
                    render: function (data) { return `<span class="badge badge-point">${data || 0} pt</span>`; }
                },
                {
                    data: null, className: 'text-center',
                    render: function () { return '<span class="badge badge-status">—</span>'; }
                },
                {
                    data: 'user_status', className: 'text-center fw-semibold',
                    render: function (data) {
                        return data === 'Assigned'
                            ? '<span class="badge badge-assigned">✅ Assigned</span>'
                            : '<span class="badge badge-unassigned">⏳ Belum Assign</span>';
                    }
                },
                {
                    data: null, orderable: false, className: 'text-center',
                    render: function (data, type, row) {
                        let assignBtn = row.id_user ? '' :
                            `<button class="btn btn-success btn-sm me-1" onclick="assignUser(${row.id}, '${row.name}')" title="Assign Akun Siswa">
                                <i class="fas fa-user-plus"></i>
                            </button>`;
                        return `
                            <div class="btn-group btn-group-sm" role="group">
                                ${assignBtn}
                                <button class="btn btn-info btn-sm me-1" onclick="showDetail(${row.id})" title="Detail Lengkap">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-warning btn-sm me-1" onclick="editData(${row.id})" title="Edit Data">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="confirmDelete(${row.id}, '${row.name}')" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>`;
                    }
                }
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
                emptyTable: "Belum ada data siswa"
            },
            pageLength: 25,
            responsive: true,
            order: [[1, 'asc']],
            drawCallback: function () {
                $('[title]').tooltip({ trigger: 'hover', placement: 'top' });
            }
        });

        // 4. AUTO REFRESH saat modal ditutup
        $(document).on('hidden.bs.modal', '#assignModal, #editModal, #deleteModal', function () {
            loadAvailableUsers();
            siswaTable.ajax.reload(null, false);
        });

        // 5. ADD FORM SUBMIT
        $('#addForm').submit(function (e) {
            e.preventDefault();
            const formData = {
                action: 'add',
                name: $('#addName').val().trim(),
                nis: $('#addNis').val().trim(),
                id_kelas: $('#addIdKelas').val(),
                name_orang_tua: $('#addNamaOrtu').val().trim(),
                pekerjaan_orang_tua: $('#addPekerjaanOrtu').val().trim(),
                telphone_orang_tua: $('#addTelpOrtu').val().trim(),
                telphone: $('#addTelp').val().trim(),
                alamat: $('#addAlamat').val().trim(),
                alamat_orang_tua: $('#addAlamatOrtu').val().trim(),
                detail: $('#addDetail').val().trim()
            };
            $.post('action_siswa.php', formData)
                .done(function (response) {
                    if (response.success) {
                        $('#addModal').modal('hide');
                        $('#addForm')[0].reset();
                        siswaTable.ajax.reload();
                        showToast('✅ Siswa berhasil ditambahkan!', 'success');
                    } else {
                        showToast(`❌ ${response.message || 'Gagal menambah siswa'}`, 'error');
                    }
                })
                .fail(function () { showToast('❌ Koneksi gagal', 'error'); });
        });

        // 6. EDIT FORM SUBMIT
        $('#editForm').submit(function (e) {
            e.preventDefault();
            const formData = {
                action: 'update',
                id: $('#editId').val(),
                name: $('#editName').val().trim(),
                nis: $('#editNis').val().trim(),
                id_kelas: $('#editIdKelas').val(),
                name_orang_tua: $('#editNamaOrtu').val().trim(),
                pekerjaan_orang_tua: $('#editPekerjaanOrtu').val().trim(),
                telphone_orang_tua: $('#editTelpOrtu').val().trim(),
                telphone: $('#editTelp').val().trim(),
                alamat: $('#editAlamat').val().trim(),
                alamat_orang_tua: $('#editAlamatOrtu').val().trim(),
                id_user: $('#editIdUser').val().trim() || null,
                point: parseInt($('#editPoint').val()) || 0
            };
            $.post('action_siswa.php', formData)
                .done(function (response) {
                    if (response.success) {
                        $('#editModal').modal('hide');
                        siswaTable.ajax.reload();
                        showToast('✅ Data siswa berhasil diupdate!', 'success');
                    } else {
                        showToast(`❌ ${response.message || 'Gagal update'}`, 'error');
                    }
                });
        });

        // 7. ASSIGN FORM SUBMIT
        $('#assignForm').submit(function (e) {
            e.preventDefault();
            const formData = {
                action: 'assign',
                siswa_id: $('#assignSiswaId').val(),
                user_id: $('#assignUserId').val()
            };
            $.post('action_siswa.php', formData)
                .done(function (response) {
                    if (response.success) {
                        $('#assignModal').modal('hide');
                        siswaTable.ajax.reload();
                        loadAvailableUsers();
                        showToast('✅ Akun siswa berhasil diassign!', 'success');
                    } else {
                        showToast(`❌ ${response.message || 'Gagal assign'}`, 'error');
                    }
                });
        });

        // 8. CONFIRM DELETE
        $('#confirmDelete').click(function () {
            if (!deleteSiswaId) return;
            $.post('action_siswa.php', { action: 'delete', id: deleteSiswaId })
                .done(function (response) {
                    if (response.success) {
                        $('#deleteModal').modal('hide');
                        siswaTable.ajax.reload();
                        loadAvailableUsers();
                        showToast('✅ Siswa berhasil dihapus!', 'success');
                    } else {
                        showToast('❌ Gagal menghapus siswa', 'error');
                    }
                });
        });

    }); // END document.ready

    // ============================================================
    // GLOBAL FUNCTIONS
    // ============================================================

    function editData(id) {
        $.get(`action_siswa.php?action=edit&id=${id}`)
            .done(function (data) {
                if (data && data[0]) {
                    const siswa = data[0];
                    $('#editId').val(siswa.id);
                    $('#editName').val(siswa.name || '');
                    $('#editNis').val(siswa.nis || '');
                    $('#editIdKelas').val(siswa.id_kelas || '');
                    $('#editNamaOrtu').val(siswa.name_orang_tua || '');
                    $('#editPekerjaanOrtu').val(siswa.pekerjaan_orang_tua || '');
                    $('#editTelpOrtu').val(siswa.telphone_orang_tua || '');
                    $('#editTelp').val(siswa.telphone || '');
                    $('#editAlamat').val(siswa.alamat || '');
                    $('#editAlamatOrtu').val(siswa.alamat_orang_tua || '');
                    $('#editPoint').val(siswa.point || 0);
                    $('#editIdUser').val(siswa.id_user || '');
                    $('#editModal').modal('show');
                }
            })
            .fail(function () { showToast('❌ Gagal memuat data edit', 'error'); });
    }

    function assignUser(siswaId, siswaName) {
        $('#assignSiswaId').val(siswaId);
        $('#assignSiswaName').val(siswaName || 'Siswa');
        $('#assignUserId').html('<option value="">-- Memuat akun siswa... --</option>');
        loadAvailableUsers().then(function () {
            $('#assignModal').modal('show');
        });
    }

    function showDetail(id) {
        // Tampilkan loading dulu
        $('#detailContent').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="text-muted mb-0">Memuat detail lengkap...</p>
            </div>
        `);
        $('#detailModal').modal('show');

        $.get(`action_siswa.php?action=detail&id=${id}`)
            .done(function (data) {
                if (data && data.id) {

                    // ============================================================
                    // BAGIAN YANG DITAMBAHKAN: Password dengan tombol show/hide
                    // ============================================================
                    let passwordBlock = '';
                    if (data.user_password) {
                        // Escape password agar aman di dalam HTML attribute
                        const safePass = $('<div>').text(data.user_password).html();
                        passwordBlock = `
                            <div class="password-wrapper">
                                <span
                                    class="password-text"
                                    data-real="${safePass}"
                                    data-hidden="true"
                                >••••••••</span>
                                <button
                                    type="button"
                                    class="btn-toggle-pass"
                                    title="Tampilkan password"
                                    onclick="togglePassword(this)"
                                >
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        `;
                    } else {
                        passwordBlock = '<span class="badge bg-secondary px-3 py-2">Tidak ada</span>';
                    }
                    // ============================================================

                    const userInfo = data.user_id ? `
                        <div class="detail-card user-card">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-user-shield fa-2x text-success me-3"></i>
                                <div>
                                    <h5 class="mb-1 fw-bold text-success">✅ Akun Siswa Terassign</h5>
                                    <small class="text-success">Role: ${data.role || 'siswa'}</small>
                                </div>
                            </div>
                            <div class="row g-3 align-items-center">
                                <div class="col-md-3"><strong>ID User:</strong></div>
                                <div class="col-md-9"><code>${data.user_id}</code></div>

                                <div class="col-md-3"><strong>Nama:</strong></div>
                                <div class="col-md-9">${data.user_name || '—'}</div>

                                <div class="col-md-3"><strong>Password:</strong></div>
                                <div class="col-md-9">${passwordBlock}</div>
                            </div>
                        </div>
                    ` : `
                        <div class="alert alert-warning border-0">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Belum ada akun siswa yang diassign
                        </div>
                    `;

                    $('#detailContent').html(`
                        <div class="detail-card">
                            <div class="d-flex align-items-center mb-4">
                                <i class="fas fa-user-graduate fa-2x text-primary me-3"></i>
                                <h4 class="mb-0 fw-bold">Data Siswa</h4>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-3"><strong>Nama:</strong></div>
                                <div class="col-md-9 fw-semibold">${data.name || '—'}</div>
                                <div class="col-md-3"><strong>NIS:</strong></div>
                                <div class="col-md-9">${data.nis || '—'}</div>
                                <div class="col-md-3"><strong>Kelas:</strong></div>
                                <div class="col-md-9">${data.kelas_name || 'Belum ada'}</div>
                                <div class="col-md-3"><strong>Telp:</strong></div>
                                <div class="col-md-9">${data.telphone || '—'}</div>
                                <div class="col-md-3"><strong>Point:</strong></div>
                                <div class="col-md-9">
                                    <span class="badge badge-point fs-6">${data.point || 0} pt</span>
                                </div>
                            </div>
                        </div>

                        <div class="detail-card">
                            <div class="d-flex align-items-center mb-4">
                                <i class="fas fa-users fa-2x text-info me-3"></i>
                                <h4 class="mb-0 fw-bold text-info">Data Orang Tua</h4>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-3"><strong>Nama:</strong></div>
                                <div class="col-md-9 fw-semibold">${data.name_orang_tua || '—'}</div>
                                <div class="col-md-3"><strong>Pekerjaan:</strong></div>
                                <div class="col-md-9">${data.pekerjaan_orang_tua || '—'}</div>
                                <div class="col-md-3"><strong>Telp:</strong></div>
                                <div class="col-md-9">${data.telphone_orang_tua || '—'}</div>
                                <div class="col-md-3"><strong>Alamat:</strong></div>
                                <div class="col-md-9">${data.alamat_orang_tua || '—'}</div>
                            </div>
                        </div>

                        ${userInfo}

                        <div class="row g-4">
                            <div class="col-md-8">
                                <div class="detail-card">
                                    <h6 class="mb-3"><i class="fas fa-map-marker-alt text-danger me-2"></i>Alamat Siswa</h6>
                                    <div class="bg-light p-3 rounded">${data.alamat || '—'}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="detail-card">
                                    <h6 class="mb-3"><i class="fas fa-sticky-note text-warning me-2"></i>Catatan</h6>
                                    <div class="bg-light p-3 rounded">${data.detail || '—'}</div>
                                </div>
                            </div>
                        </div>
                    `);

                } else {
                    $('#detailContent').html(`
                        <div class="alert alert-danger text-center py-5">
                            <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                            <h4>Data siswa tidak ditemukan</h4>
                        </div>
                    `);
                }
            })
            .fail(function () {
                $('#detailContent').html(`
                    <div class="alert alert-danger text-center py-5">
                        <i class="fas fa-database fa-3x mb-3 text-danger"></i>
                        <h4>Gagal memuat detail</h4>
                        <p class="mb-0">Coba lagi atau refresh halaman</p>
                    </div>
                `);
            });
    }

    function confirmDelete(id, name) {
        deleteSiswaId = id;
        $('#deleteMessage').html(`Hapus siswa <strong>"${name || 'Siswa'}"</strong>? Data akan terhapus permanen.`);
        $('#deleteModal').modal('show');
    }

    function showToast(message, type = 'success') {
        const bgClass = type === 'success' ? 'bg-success' : 'bg-danger';
        const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
        const toastHtml = `
            <div class="toast align-items-center text-white ${bgClass} border-0 position-fixed top-0 end-0 m-4 shadow-lg"
                 role="alert" style="min-width: 300px; max-width: 400px; z-index: 9999;">
               <div class="d-flex">
                   <div class="toast-body d-flex align-items-center">
                       <i class="fas ${iconClass} me-3 fs-5"></i>
                       <span>${message}</span>
                   </div>
                   <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
               </div>
            </div>`;
        $('body').append(toastHtml);
        const toastEl = $('.toast').last();
        new bootstrap.Toast(toastEl[0], { delay: 4000 }).show();
        toastEl.on('hidden.bs.toast', function () { $(this).remove(); });
    }
</script>

<?php $this->stop() ?>
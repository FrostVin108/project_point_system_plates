<?php $this->layout('layouts::app', ['title' => 'Data Guru']) ?>

<?php $this->start('main') ?>

<!-- CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<!-- 🔥 SELECT2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap5-theme@1.3.0/dist/select2-bootstrap5-theme.min.css"
    rel="stylesheet" />

<style>
    .table-card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid rgba(0, 0, 0, 0.125);
        border-radius: 0.375rem;
        overflow: hidden;
    }

    #guruTable_wrapper {
        padding: 20px;
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 15px;
    }

    .select2-container--bootstrap5 .select2-selection {
        min-height: calc(1.5em + 0.75rem + 2px);
    }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h2 mb-0 fw-bold text-dark">
                    <i class="fas fa-chalkboard-teacher me-2 text-primary"></i>Data Guru
                </h1>
                <button class="btn btn-primary btn-lg shadow-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fas fa-plus me-2"></i>Tambah Guru
                </button>
            </div>

            <div class="table-card">
                <div class="table-responsive">
                    <table id="guruTable" class="table table-striped table-hover mb-0" style="width:100%">
                        <thead class="table-dark sticky-top">
                            <tr>
                                <th width="8%" class="text-center fw-bold">No</th>
                                <th width="22%" class="fw-bold">Nama Guru</th>
                                <th width="15%" class="fw-bold">No HP</th>
                                <th width="18%" class="fw-bold">Mapel</th>
                                <th width="20%" class="fw-bold">User</th>
                                <th width="17%" class="fw-bold">Alamat</th>
                                <th width="10%" class="text-center fw-bold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ADD MODAL -->
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
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Nama Guru <span class="text-danger">*</span></label>
                                <input type="text" class="form-control shadow-sm" id="addName" required maxlength="255">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">No Handphone <span
                                        class="text-danger">*</span></label>
                                <input type="tel" class="form-control shadow-sm" id="addNoHp" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Mapel</label>
                                <select class="form-select shadow-sm" id="addMapel">
                                    <option value="">Pilih Mapel</option>
                                </select>
                            </div>
                            <!-- 🔥 SELECT2 USER DROPDOWN -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">User <span class="text-muted">(Cari
                                        nama)</span></label>
                                <select class="form-select shadow-sm user-select2" id="addUser" style="width:100%">
                                    <option value="">-- Cari User --</option>
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Alamat</label>
                                <textarea class="form-control shadow-sm" id="addAlamat" rows="2"
                                    maxlength="500"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary shadow-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary shadow-sm">
                            <i class="fas fa-save me-1"></i>Simpan Guru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- EDIT MODAL -->
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
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Nama Guru <span class="text-danger">*</span></label>
                                <input type="text" class="form-control shadow-sm" id="editName" required
                                    maxlength="255">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">No Handphone <span
                                        class="text-danger">*</span></label>
                                <input type="tel" class="form-control shadow-sm" id="editNoHp" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Mapel</label>
                                <select class="form-select shadow-sm" id="editMapel">
                                    <option value="">Pilih Mapel</option>
                                </select>
                            </div>
                            <!-- 🔥 SELECT2 USER DROPDOWN -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">User <span class="text-muted">(Cari
                                        nama)</span></label>
                                <select class="form-select shadow-sm user-select2" id="editUser" style="width:100%">
                                    <option value="">-- Cari User --</option>
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Alamat</label>
                                <textarea class="form-control shadow-sm" id="editAlamat" rows="2"
                                    maxlength="500"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary shadow-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning shadow-sm">
                            <i class="fas fa-save me-1"></i>Update Guru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- DELETE MODAL -->
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
                    <i class="fas fa-exclamation-triangle text-danger fa-3x mb-4"></i>
                    <h4 class="fw-bold mb-3">Apakah Anda Yakin?</h4>
                    <p class="text-muted fs-6 mb-0">Guru "<strong><span id="deleteName"></span></strong>" akan dihapus
                        PERMANEN!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary shadow-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger shadow-sm" id="confirmDelete">Hapus Guru</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<!-- 🔥 SELECT2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    let table, mapels = [];

    $(document).ready(function () {
        // Load mapels
        $.get('action_mapel.php?action=read').done(data => {
            mapels = data;
            populateMapelDropdowns();
            initDataTable();
        }).fail(() => showToast('Gagal load mapel!', 'error'));

        // 🔥 SELECT2 - INIT saat modal dibuka
        $('#addModal, #editModal').on('shown.bs.modal', function () {
            let $modal = $(this);
            $modal.find('.user-select2').each(function () {
                let $select = $(this);
                if (!$select.hasClass('select2-hidden-accessible')) {
                    $select.select2({
                        theme: 'bootstrap-5',
                        placeholder: 'Ketik nama user minimum 1 huruf...',
                        allowClear: true,
                        dropdownParent: $modal,
                        ajax: {
                            url: 'action_guru.php?action=users',
                            dataType: 'json',
                            delay: 250,
                            data: params => ({ search: params.term || '' }),
                            processResults: data => ({
                                results: data.map(user => ({
                                    id: user.id,
                                    text: user.name
                                }))
                            }),
                            cache: true
                        },
                        minimumInputLength: 1
                    });
                }
            });
        });

        // Clear Select2 saat modal tutup
        $('#addModal, #editModal').on('hidden.bs.modal', function () {
            $(this).find('.user-select2').val('').trigger('change');
        });
    });

    // Inisialisasi DataTable
    function initDataTable() {
        table = $('#guruTable').DataTable({
            ajax: {
                url: 'action_guru.php?action=read',
                dataSrc: '',
                error: () => showToast('Gagal load data guru!', 'error')
            },
            columns: [
                {
                    data: null, orderable: false, className: 'text-center fw-semibold',
                    render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1
                },
                { data: 'name', className: 'fw-medium align-middle' },
                { data: 'no_handphone', className: 'text-center fw-semibold' },
                {
                    data: null,
                    render: data => {
                        let mapelName = mapels.find(m => m.id == data.id_mapel)?.name || '-';
                        return `<span class="badge bg-info">${mapelName}</span>`;
                    }
                },
                {
                    data: null,
                    render: data => {
                        let userName = data.user_name || '-';
                        return `<span class="badge bg-secondary">${userName}</span>`;
                    }
                },
                { data: 'alamat', className: 'align-middle' },
                {
                    data: null, orderable: false, className: 'text-center',
                    render: data => `
                    <div class="btn-group">
                        <button class="btn btn-warning btn-sm px-2 py-1 edit-btn" data-id="${data.id}" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-sm px-2 py-1 delete-btn" data-id="${data.id}" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `
                }
            ],
            language: {
                "decimal": ",", "emptyTable": "Belum ada data guru",
                "info": "Menampilkan _START_ - _END_ dari _TOTAL_ guru",
                "infoEmpty": "Menampilkan 0 - 0 dari 0 guru",
                "infoFiltered": "(disaring dari _MAX_ total guru)",
                "lengthMenu": "Tampilkan _MENU_ guru",
                "loadingRecords": "⏳ Memuat...", "processing": "⏳ Memproses...",
                "search": "Cari guru:", "zeroRecords": "Tidak ditemukan guru",
                "paginate": { "first": "⏮️", "last": "⏭️", "next": "▶️", "previous": "◀️" }
            },
            pageLength: 25, responsive: true, order: [[1, 'asc']]
        });
    }

    // Populate Mapel Dropdowns
    function populateMapelDropdowns() {
        let options = '<option value="">Pilih Mapel</option>';
        mapels.forEach(mapel => {
            options += `<option value="${mapel.id}">${mapel.name}</option>`;
        });
        $('#addMapel, #editMapel').html(options);
    }

    // Edit Data
    $(document).on('click', '.edit-btn', function () {
        let id = $(this).data('id');
        $.get(`action_guru.php?action=get&id=${id}`).done(data => {
            if (data && data.length) {
                let guru = data[0];
                $('#editId').val(guru.id);
                $('#editName').val(guru.name);
                $('#editNoHp').val(guru.no_handphone);
                $('#editMapel').val(guru.id_mapel || '');
                $('#editAlamat').val(guru.alamat || '');
                // Select2 akan load user saat modal dibuka
                new bootstrap.Modal(document.getElementById('editModal')).show();
            }
        });
    });

    // Delete Data
    $(document).on('click', '.delete-btn', function () {
        let id = $(this).data('id');
        let row = $(this).closest('tr');
        let name = row.find('td:eq(1)').text().trim();
        $('#deleteId').val(id);
        $('#deleteName').text(name);
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    });

    // Form Submit
    $('#addForm, #editForm').submit(function (e) {
        e.preventDefault();
        let $form = $(this);
        let $btn = $form.find('button[type="submit"]');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...');

        let data = {
            action: $form.is('#addForm') ? 'add' : 'edit',
            id: $('#editId').val(),
            name: $(`#${$form.is('#addForm') ? 'add' : 'edit'}Name`).val().trim(),
            no_handphone: $(`#${$form.is('#addForm') ? 'add' : 'edit'}NoHp`).val(),
            id_mapel: $(`#${$form.is('#addForm') ? 'add' : 'edit'}Mapel`).val() || null,
            id_user: $(`#${$form.is('#addForm') ? 'add' : 'edit'}User`).val() || null, // 🔥 SELECT2
            alamat: $(`#${$form.is('#addForm') ? 'add' : 'edit'}Alamat`).val().trim()
        };

        if (!data.name || !data.no_handphone) {
            showToast('Nama & No HP wajib!', 'error');
            $btn.prop('disabled', false).html('<i class="fas fa-save me-1"></i>Simpan');
            return;
        }

        $.post('action_guru.php', data).done(response => {
            if (response.success) {
                $($form.is('#addForm') ? '#addModal' : '#editModal').modal('hide');
                table.ajax.reload(null, false);
                if ($form.is('#addForm')) $form[0].reset();
                showToast(`✅ Guru berhasil ${data.action}!`, 'success');
            } else {
                showToast('❌ ' + (response.message || 'Gagal'), 'error');
            }
        }).always(() => {
            $btn.prop('disabled', false).html('<i class="fas fa-save me-1"></i>Simpan');
        });
    });

    // Delete Confirm
    $('#confirmDelete').click(function () {
        let id = $('#deleteId').val();
        $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Menghapus...');
        $.post('action_guru.php', { action: 'delete', id: id })
            .done(response => {
                if (response.success) {
                    $('#deleteModal').modal('hide');
                    table.ajax.reload(null, false);
                    showToast('✅ Guru berhasil dihapus!', 'success');
                } else {
                    showToast('❌ Gagal hapus', 'error');
                }
            }).always(() => {
                $('#confirmDelete').prop('disabled', false).html('Hapus Guru');
            });
    });

    // Toast Notification
    function showToast(message, type = 'success') {
        const bgClass = type === 'success' ? 'bg-success' : 'bg-danger';
        const icon = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
        const toastHtml = `
        <div class="toast align-items-center text-white ${bgClass} border-0 position-fixed top-0 end-0 m-4 shadow-lg" 
             role="alert" style="z-index: 1099; min-width: 320px;">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center">
                    <i class="${icon} me-2 fs-5"></i>${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `;
        $('body').append(toastHtml);
        let toastEl = $('.toast').last();
        new bootstrap.Toast(toastEl[0], { delay: 4000 }).show();
        toastEl.on('hidden.bs.toast', function () { $(this).remove(); });
    }
</script>

<?php $this->stop() ?>
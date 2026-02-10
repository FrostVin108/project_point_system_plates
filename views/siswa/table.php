<?php $this->layout('layouts::app', ['title' => 'Table Siswa']) ?>

<?php $this->start('main') ?>

<style>
    .badge-point {
        background-color: #6f42c1 !important;
        color: white !important;
        font-weight: 600;
        font-size: 0.85em;
    }

    .badge-status {
        background-color: #6c757d !important;
        color: white !important;
        font-size: 0.8em;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Data Siswa</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            Tambah Siswa Baru
        </button>
    </div>

    <!-- Bootstrap + DataTables CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <table id="siswaTable" class="table table-striped table-hover" style="width:100%">
        <thead class="table-dark">
            <tr>
                <th width="5%">No</th>
                <th width="18%">Nama</th>
                <th width="12%">NIS</th>
                <th width="14%">Kelas</th>
                <th width="18%">Nama Orang Tua</th>
                <th width="10%">Telp Siswa</th>
                <th width="8%" class="text-center">Point</th> <!-- 🔥 BARU -->
                <th width="8%" class="text-center">Status</th> <!-- 🔥 BARU -->
                <th width="12%">Aksi</th>
            </tr>
        </thead>
    </table>

    <!-- ADD MODAL -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Siswa Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="addForm">
                    <div class="modal-body">
                        <input type="hidden" id="addDetail" value="">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Nama Siswa <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="addName" required>
                            </div>
                            <div class="col-md-6 mb-3">
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
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Nama Orang Tua <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="addNamaOrtu" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Pekerjaan Orang Tua</label>
                                <input type="text" class="form-control" id="addPekerjaanOrtu">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Telp Orang Tua</label>
                                <input type="tel" class="form-control" id="addTelpOrtu">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Telp Siswa</label>
                                <input type="tel" class="form-control" id="addTelp">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Alamat Siswa <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="addAlamat" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Alamat Orang Tua</label>
                                <input type="text" class="form-control" id="addAlamatOrtu">
                            </div>
                        </div>
                        <!-- 🔥 POINT (READONLY - AUTO 0) -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Point Pelanggaran</label>
                                <input type="number" class="form-control bg-light" id="addPoint" value="0" readonly>
                                <small class="text-muted">Otomatis dari pelanggaran</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- EDIT MODAL (SAMA TAPI TAMBAH POINT) -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title">Edit Data Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editForm">
                    <div class="modal-body">
                        <input type="hidden" id="editId">
                        <input type="hidden" id="editDetail" value="">
                        <!-- FORM SAMA kayak ADD, tambah POINT -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Nama Siswa <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="editName" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">NIS <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="editNis" required>
                            </div>
                        </div>
                        <!-- ... form lain sama ... -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Point Pelanggaran</label>
                                <input type="number" class="form-control bg-light" id="editPoint" readonly>
                                <small class="text-muted">Otomatis dari pelanggaran</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- DELETE MODAL (SAMA) -->
    <!-- ... sama kayak sebelumnya ... -->
</div>

<!-- Scripts (UPDATE DATATABLE COLUMNS) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        let kelasData = [];
        let table;

        // LOAD KELAS
        $.get('action_kelas.php?action=read', function (data) {
            kelasData = data;
            populateKelasDropdown();
        }, 'json');

        function populateKelasDropdown() {
            let options = '<option value="">-- Pilih Kelas --</option>';
            kelasData.forEach(function (kelas) {
                options += `<option value="${kelas.id}">
                ${kelas.tingkat} ${kelas.jurusan} ${kelas.kelas}
            </option>`;
            });
            $('#addIdKelas, #editIdKelas').html(options);
        }

        // 🔥 DATATABLE - TAMBAH POINT & STATUS
        table = $('#siswaTable').DataTable({
            ajax: { url: 'action_siswa.php?action=read', dataSrc: '' },
            columns: [
                {
                    data: null, orderable: false, render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data: 'name' },
                { data: 'nis' },
                {
                    data: null, render: function (data) {
                        return data.kelas_name || '<span class="text-muted">Belum ada kelas</span>';
                    }
                },
                { data: 'name_orang_tua' },
                { data: 'telphone' },
                {
                    data: 'point',
                    className: 'text-center fw-bold',
                    render: function (data) {
                        return `<span class="badge badge-point">${data || 0} pt</span>`;
                    }
                },
                {
                    data: 'status',
                    className: 'text-center',
                    render: function (data) {
                        return `<span class="badge badge-status">-</span>`;
                    }
                },
                {
                    data: null, orderable: false, render: function (data) {
                        return `
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-warning" onclick="editData(${data.id})" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-danger" onclick="deleteData(${data.id}, '${data.name}')" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
                    }
                }
            ],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json' },
            pageLength: 25, responsive: true
        });

        // 🔥 ADD FORM - TAMBAH POINT=0
        $('#addForm').submit(function (e) {
            e.preventDefault();
            let formData = {
                action: 'add',
                name: $('#addName').val(),
                nis: $('#addNis').val(),
                id_kelas: $('#addIdKelas').val(),
                name_orang_tua: $('#addNamaOrtu').val(),
                pekerjaan_orang_tua: $('#addPekerjaanOrtu').val() || '',
                telphone_orang_tua: $('#addTelpOrtu').val() || '',
                telphone: $('#addTelp').val() || '',
                alamat: $('#addAlamat').val(),
                alamat_orang_tua: $('#addAlamatOrtu').val() || '',
                detail: $('#addDetail').val() || '',
                point: 0  // 🔥 AUTO 0
            };

            $.post('action_siswa.php', formData).done(function (response) {
                if (response.success) {
                    $('#addModal').modal('hide');
                    table.ajax.reload();
                    $('#addForm')[0].reset();
                    showToast('Siswa berhasil ditambahkan!', 'success');
                } else {
                    showToast('Error: ' + (response.message || 'Gagal simpan'), 'error');
                }
            });
        });

        // 🔥 EDIT FORM - LOAD POINT
        $('#editForm').submit(function (e) {
            e.preventDefault();
            let formData = {
                action: 'update',  // 🔥 UPDATE bukan edit
                id: $('#editId').val(),
                name: $('#editName').val(),
                nis: $('#editNis').val(),
                id_kelas: $('#editIdKelas').val(),
                name_orang_tua: $('#editNamaOrtu').val(),
                pekerjaan_orang_tua: $('#editPekerjaanOrtu').val() || '',
                telphone_orang_tua: $('#editTelpOrtu').val() || '',
                telphone: $('#editTelp').val() || '',
                alamat: $('#editAlamat').val(),
                alamat_orang_tua: $('#editAlamatOrtu').val() || '',
                detail: $('#editDetail').val() || '',
                point: $('#editPoint').val() || 0  // 🔥 POINT
            };

            $.post('action_siswa.php', formData).done(function (response) {
                if (response.success) {
                    $('#editModal').modal('hide');
                    table.ajax.reload();
                    showToast('Data siswa berhasil diupdate!', 'success');
                } else {
                    showToast('Error: ' + (response.message || 'Gagal update'), 'error');
                }
            });
        });

        // ... delete function sama ...
    });

    // 🔥 EDIT FUNCTION - LOAD POINT
    function editData(id) {
        $.get(`action_siswa.php?action=edit&id=${id}`, function (data) {
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
            $('#editPoint').val(siswa.point || 0);  // 🔥 LOAD POINT
            new bootstrap.Modal(document.getElementById('editModal')).show();
        }, 'json');
    }

    // ... function lainnya sama ...
    function showToast(message, type = 'success') {
        const bgClass = type === 'success' ? 'bg-success' : 'bg-danger';
        const toastHtml = `
        <div class="toast align-items-center text-white ${bgClass} border-0 position-fixed top-0 end-0 m-3" role="alert">
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `;
        $('body').append(toastHtml);
        $('.toast').toast({ delay: 3000 }).toast('show');
    }
</script>

<?php $this->stop() ?>
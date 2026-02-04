<?php $this->layout('layouts::app', ['title' => 'Table Siswa']) ?>

<?php $this->start('main') ?>
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
                <th width="20%">Nama</th>
                <th width="12%">NIS</th>
                <th width="15%">Kelas</th>
                <th width="20%">Nama Orang Tua</th>
                <th width="12%">Telp Siswa</th>
                <th width="16%">Aksi</th>
            </tr>
        </thead>
    </table>

    <?php include 'database.php'; ?>

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
                        <input type="hidden" id="operation" value="add">
                        <!-- 🔥 TAMBAH INI -->
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

    <!-- EDIT MODAL -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title">Edit Data Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editForm">
                    <div class="modal-body">
<!-- ✅ BENAR -->
<input type="hidden" id="editId">
<input type="hidden" id="editDetail" value="">
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
                        <div class="mb-3">
                            <label class="form-label fw-bold">Kelas <span class="text-danger">*</span></label>
                            <select class="form-select" id="editIdKelas" required>
                                <option value="">-- Pilih Kelas --</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Nama Orang Tua <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="editNamaOrtu" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Pekerjaan Orang Tua</label>
                                <input type="text" class="form-control" id="editPekerjaanOrtu">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Telp Orang Tua</label>
                                <input type="tel" class="form-control" id="editTelpOrtu">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Telp Siswa</label>
                                <input type="tel" class="form-control" id="editTelp">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Alamat Siswa <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="editAlamat" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Alamat Orang Tua</label>
                                <input type="text" class="form-control" id="editAlamatOrtu">
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

    <!-- DELETE MODAL -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="deleteId">
                    <div class="text-center">
                        <i class="fas fa-exclamation-triangle text-danger fa-3x mb-3"></i>
                        <h5>Apakah Anda yakin?</h5>
                        <p class="text-muted">Data siswa "<strong><span id="deleteName"></span></strong>" akan dihapus
                            permanen!</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://kit.fontawesome.com/your-fontawesome-kit.js"></script>

<script>
    $(document).ready(function () {
        let kelasData = [];
        let table;

        // 🔥 FIX MODAL INPUT DISABLED
        $(document).on('shown.bs.modal', '.modal', function () {
            $(this).find('input, select, textarea').prop('disabled', false).prop('readonly', false);
        });

        // 🔥 LOAD KELAS untuk dropdown
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

        // 🔥 DataTable dengan JOIN kelas
        table = $('#siswaTable').DataTable({
            ajax: {
                url: 'action_siswa.php?action=read',
                dataSrc: ''
            },
            columns: [
                {
                    data: null, orderable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data: 'name' },
                { data: 'nis' },
                {
                    data: null,
                    render: function (data) {
                        return data.kelas_name || '<span class="text-muted">Belum ada kelas</span>';
                    }
                },
                { data: 'name_orang_tua' },
                { data: 'telphone' },
                {
                    data: null, orderable: false,
                    render: function (data) {
                        return `
                        <div class="btn-group btn-group-sm" role="group">
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
            pageLength: 25,
            responsive: true
        });

        // 🔥 ADD FORM - MANUAL DATA + DETAIL FIELD
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
                detail: $('#addDetail').val() || ''  // 🔥 DETAIL FIELD
            };

            $.post('action_siswa.php', formData)
                .done(function (response) {
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

        // 🔥 EDIT FORM - MANUAL DATA + DETAIL FIELD
        $('#editForm').submit(function (e) {
            e.preventDefault();
            let formData = {
                action: 'edit',
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
                detail: $('#editDetail').val() || ''  // 🔥 DETAIL FIELD
            };

            $.post('action_siswa.php', formData)
                .done(function (response) {
                    if (response.success) {
                        $('#editModal').modal('hide');
                        table.ajax.reload();
                        showToast('Data siswa berhasil diupdate!', 'success');
                    } else {
                        showToast('Error: ' + (response.message || 'Gagal update'), 'error');
                    }
                });
        });

        // 🔥 DELETE
        $(document).on('click', '#confirmDelete', function () {
            $.post('action_siswa.php', {
                action: 'delete',
                id: $('#deleteId').val()
            }).done(function (response) {
                if (response.success) {
                    $('#deleteModal').modal('hide');
                    table.ajax.reload();
                    showToast('Siswa berhasil dihapus!', 'success');
                } else {
                    showToast('Error: ' + (response.message || 'Gagal hapus'), 'error');
                }
            });
        });
    });

    // 🔥 EDIT FUNCTION - populate modal
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
            $('#editDetail').val(siswa.detail || '');  // 🔥 DETAIL FIELD
            new bootstrap.Modal(document.getElementById('editModal')).show();
        }, 'json');
    }

    // 🔥 DELETE FUNCTION
    function deleteData(id, name) {
        $('#deleteId').val(id);
        $('#deleteName').text(name);
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }

    // 🔥 Toast notification
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
<?php $this->layout('layouts::app', ['title' => 'Kelas']) ?>

<?php $this->start('main') ?>
<h1>Kelas</h1>

<h2>Statistik</h2>

<!-- Bootstrap + DataTables CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
    Tambah Kelas
</button>

<table id="kelasTable" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Tingkat</th>
            <th>Jurusan</th>
            <th>Kelas</th>
            <th>Aksi</th>
        </tr>
    </thead>
</table>

<?php include 'database.php'; ?>

<!-- ADD MODAL -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addForm">
                <div class="modal-body">
                    <input type="hidden" id="operation" value="add">
                    <div class="mb-3">
                        <label class="form-label">Tingkat</label>
                        <select class="form-select" id="addTingkat" required>
                            <option value="">Pilih Tingkat</option>
                            <option value="X">X</option>
                            <option value="XI">XI</option>
                            <option value="XII">XII</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jurusan</label>
                        <input type="text" class="form-control" id="addJurusan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <input type="text" class="form-control" id="addKelas" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- EDIT MODAL -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm">
                <div class="modal-body">
                    <input type="hidden" id="editId">
                    <input type="hidden" id="operation" value="edit">
                    <div class="mb-3">
                        <label class="form-label">Tingkat</label>
                        <select class="form-select" id="editTingkat" required>
                            <option value="X">X</option>
                            <option value="XI">XI</option>
                            <option value="XII">XII</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jurusan</label>
                        <input type="text" class="form-control" id="editJurusan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <input type="text" class="form-control" id="editKelas" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- DELETE MODAL -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="deleteId">
                <p>Apakah Anda yakin ingin menghapus "<span id="deleteName"></span>"?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        // Load DataTable with data
        let table = $('#kelasTable').DataTable({
            ajax: {
                url: 'action_kelas.php?action=read',
                dataSrc: ''
            },
            columns: [
                {
                    data: null,
                    orderable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;  // Auto numbering
                    }
                },
                { data: 'tingkat' },
                { data: 'jurusan' },
                { data: 'kelas' },
                {
                    data: null,
                    orderable: false,
                    render: function (data) {
                        return `
                        <button class="btn btn-sm btn-warning" onclick="editData(${data.id}, '${data.tingkat}', '${data.jurusan}', '${data.kelas}')">
                            Edit
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteData(${data.id}, '${data.tingkat} ${data.jurusan} ${data.kelas}')">
                            Hapus
                        </button>
                    `;
                    }
                }
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            },
            pageLength: 25,
            order: [[1, 'asc']]  // Sort by Tingkat
        });
    });


    // Add form
    $('#addForm').submit(function (e) {
        e.preventDefault();
        $.post('action_kelas.php', {
            action: 'add',
            tingkat: $('#addTingkat').val(),
            jurusan: $('#addJurusan').val(),
            kelas: $('#addKelas').val()
        }).done(function (response) {
            if (response.success) {
                $('#addModal').modal('hide');
                table.ajax.reload();
                $('#addTingkat, #addJurusan, #addKelas').val('');
            } else {
                alert('Error: ' + response.message);
            }
        });
    });

    // Edit form
    $('#editForm').submit(function (e) {
        e.preventDefault();
        $.post('action_kelas.php', {
            action: 'edit',
            id: $('#editId').val(),
            tingkat: $('#editTingkat').val(),
            jurusan: $('#editJurusan').val(),
            kelas: $('#editKelas').val()
        }).done(function (response) {
            if (response.success) {
                $('#editModal').modal('hide');
                table.ajax.reload();
            } else {
                alert('Error: ' + response.message);
            }
        });
    });

    // Delete confirm
    $('#confirmDelete').click(function () {
        $.post('action_kelas.php', {
            action: 'delete',
            id: $('#deleteId').val()
        }).done(function (response) {
            if (response.success) {
                $('#deleteModal').modal('hide');
                table.ajax.reload();
            } else {
                alert('Error: ' + response.message);
            }
        });
    });

    // Edit function
    function editData(id, tingkat, jurusan, kelas) {
        $('#editId').val(id);
        $('#editTingkat').val(tingkat);  // Dropdown akan pilih otomatis
        $('#editJurusan').val(jurusan);
        $('#editKelas').val(kelas);
        new bootstrap.Modal(document.getElementById('editModal')).show();
    }

    // Delete function
    function deleteData(id, name) {
        $('#deleteId').val(id);
        $('#deleteName').text(name);
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }
</script>

<?php $this->stop() ?>
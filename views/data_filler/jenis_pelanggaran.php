<?php $this->layout('layouts::app', ['title' => 'Jenis Pelanggaran']) ?>

<?php $this->start('main') ?>
<h1>Jenis Pelanggaran</h1>

<?php include 'database.php'; ?>
<h2>Statistik</h2>

<!-- Bootstrap + DataTables CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
    Tambah Jenis Pelanggaran
</button>

<table id="jenisTable" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Point</th>
            <th>Aksi</th>
        </tr>
    </thead>
</table>


<!-- ADD MODAL -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Jenis Pelanggaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addForm">
                <div class="modal-body">
                    <input type="hidden" id="operation" value="add">
                    <div class="mb-3">
                        <label class="form-label">Nama Pelanggaran</label>
                        <input type="text" class="form-control" id="addName" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Point</label>
                        <input type="number" class="form-control" id="addPoint" min="1" required>
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
                <h5 class="modal-title">Edit Jenis Pelanggaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm">
                <div class="modal-body">
                    <input type="hidden" id="editId">
                    <input type="hidden" id="operation" value="edit">
                    <div class="mb-3">
                        <label class="form-label">Nama Pelanggaran</label>
                        <input type="text" class="form-control" id="editName" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Point</label>
                        <input type="number" class="form-control" id="editPoint" min="1" required>
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
                <h5 class="modal-title">Hapus Jenis Pelanggaran</h5>
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
        let table = $('#jenisTable').DataTable({
            ajax: {
                url: 'action_jenis.php?action=read',
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
                { data: 'name' },
                { data: 'point' },
                {
                    data: null,
                    orderable: false,
                    render: function (data) {
                        return `
                        <button class="btn btn-sm btn-warning" onclick="editData(${data.id}, '${data.name}', ${data.point})">
                            Edit
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteData(${data.id}, '${data.name}')">
                            Hapus
                        </button>
                    `;
                    }
                }
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            },
            pageLength: 25,  // Show more rows per page
            order: [[1, 'asc']]  // Sort by Nama by default
        });
    });


    // Add form
    $('#addForm').submit(function (e) {
        e.preventDefault();
        $.post('action_jenis.php', {
            action: 'add',
            name: $('#addName').val(),
            point: $('#addPoint').val()
        }).done(function (response) {
            if (response.success) {
                $('#addModal').modal('hide');
                table.ajax.reload();
                $('#addName, #addPoint').val('');
            } else {
                alert('Error: ' + response.message);
            }
        });
    });

    // Edit form
    $('#editForm').submit(function (e) {
        e.preventDefault();
        $.post('action_jenis.php', {
            action: 'edit',
            id: $('#editId').val(),
            name: $('#editName').val(),
            point: $('#editPoint').val()
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
        $.post('action_jenis.php', {
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
    function editData(id, name, point) {
        $('#editId').val(id);
        $('#editName').val(name);
        $('#editPoint').val(point);
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
<?php $this->layout('layouts::app', ['title' => 'Mapel']) ?>

<?php $this->start('main') ?>
<!-- Bootstrap + DataTables + Font Awesome CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 mb-0"><i class="fas fa-book me-2 text-primary"></i>Data Mapel</h1>
        <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fas fa-plus me-2"></i>Tambah Mapel
        </button>
    </div>


    <div class="card shadow-lg">
        <div class="card-body p-0">
            <table id="mapelTable" class="table table-striped table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th width="10%" class="text-center">No</th>
                        <th width="70%">Nama Mapel</th>
                        <th width="20%" class="text-center">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <?php include 'database.php'; ?>

    <!-- ADD MODAL -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Tambah Mapel Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="addForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Mapel <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="addName" placeholder="Contoh: Matematika" required maxlength="100">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- EDIT MODAL -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Mapel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editForm">
                    <div class="modal-body">
                        <input type="hidden" id="editId">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Mapel <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editName" required maxlength="100">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-1"></i>Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- DELETE MODAL -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <input type="hidden" id="deleteId">
                    <i class="fas fa-exclamation-triangle text-danger fa-3x mb-3"></i>
                    <h5>Apakah Anda yakin?</h5>
                    <p class="text-muted">Mapel "<strong><span id="deleteName"></span></strong>" akan dihapus permanen!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
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

<script>
$(document).ready(function() {
    let table;

    // Fix modal input disabled
    $(document).on('shown.bs.modal', '.modal', function() {
        $(this).find('input, select').prop('disabled', false);
    });

    // DataTable - NO CORS ERROR
    table = $('#mapelTable').DataTable({
        ajax: { url: 'action_mapel.php?action=read', dataSrc: '' },
        columns: [
            {
                data: null, orderable: false, className: 'text-center',
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { data: 'name' },
            {
                data: null, orderable: false, className: 'text-center',
                render: function(data) {
                    return `
                        <div style="white-space:nowrap">
                            <button class="btn btn-warning btn-sm me-1 px-2" onclick="editData(${data.id}, '${data.name.replace(/'/g, "\\'")}')" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm px-2" onclick="deleteData(${data.id}, '${data.name.replace(/'/g, "\\'")}')" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ],
        language: {
            "decimal": ",", "emptyTable": "Tidak ada data mapel",
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ mapel",
            "infoEmpty": "Menampilkan 0 sampai 0 dari 0 mapel",
            "infoFiltered": "(disaring dari _MAX_ total mapel)",
            "lengthMenu": "Tampilkan _MENU_ mapel", "loadingRecords": "Memuat...",
            "processing": "Memproses...", "search": "Cari mapel:",
            "zeroRecords": "Tidak ditemukan mapel",
            "paginate": { "first": "Pertama", "last": "Terakhir", "next": "Selanjutnya", "previous": "Sebelumnya" }
        },
        pageLength: 25, responsive: true, order: [[1, 'asc']]
    });

    // ADD FORM
    $('#addForm').submit(function(e) {
        e.preventDefault();
        let name = $('#addName').val().trim();
        if(!name) { showToast('Nama mapel wajib!', 'error'); return; }
        
        $.post('action_mapel.php', { action: 'add', name: name })
        .done(function(response) {
            if(response.success) {
                $('#addModal').modal('hide');
                table.ajax.reload(null, false);
                $('#addForm')[0].reset();
                showToast('✅ Mapel berhasil ditambahkan!', 'success');
            } else {
                showToast('❌ ' + (response.message || 'Gagal tambah'), 'error');
            }
        }).fail(function() {
            showToast('❌ Server error', 'error');
        });
    });

    // EDIT FORM
    $('#editForm').submit(function(e) {
        e.preventDefault();
        let id = $('#editId').val();
        let name = $('#editName').val().trim();
        if(!name) { showToast('Nama mapel wajib!', 'error'); return; }
        
        $.post('action_mapel.php', { action: 'edit', id: id, name: name })
        .done(function(response) {
            console.log('EDIT Response:', response);
            if(response.success) {
                $('#editModal').modal('hide');
                table.ajax.reload(null, false);
                showToast('✅ Mapel berhasil diupdate!', 'success');
            } else {
                showToast('❌ ' + (response.message || 'Gagal update'), 'error');
            }
        }).fail(function() {
            showToast('❌ Server error', 'error');
        });
    });

    // DELETE
    $(document).on('click', '#confirmDelete', function() {
        let id = $('#deleteId').val();
        $.post('action_mapel.php', { action: 'delete', id: id })
        .done(function(response) {
            if(response.success) {
                $('#deleteModal').modal('hide');
                table.ajax.reload(null, false);
                showToast('✅ Mapel berhasil dihapus!', 'success');
            } else {
                showToast('❌ ' + (response.message || 'Gagal hapus'), 'error');
            }
        });
    });
});

// EDIT - Direct from table data (NO AJAX!)
function editData(id, name) {
    console.log('✅ EDIT - ID:', id, 'Name:', name);
    $('#editId').val(id);
    $('#editName').val(name);
    new bootstrap.Modal(document.getElementById('editModal')).show();
}

// DELETE
function deleteData(id, name) {
    $('#deleteId').val(id);
    $('#deleteName').text(name);
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

// Toast Notification
function showToast(message, type = 'success') {
    const bgClass = type === 'success' ? 'bg-success' : 'bg-danger';
    const toastHtml = `
        <div class="toast align-items-center text-white ${bgClass} border-0 position-fixed top-0 end-0 m-3 shadow-lg" role="alert" style="z-index: 1099">
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `;
    $('body').append(toastHtml);
    $('.toast').last().toast({ delay: 4000 }).toast('show');
}
</script>

<?php $this->stop() ?>

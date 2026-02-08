<?php $this->layout('layouts::app', ['title' => 'Alasan Pelanggaran']) ?>

<?php $this->start('main') ?>

<!-- CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    .table-card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid rgba(0, 0, 0, 0.125);
        border-radius: 0.375rem;
        overflow: hidden;
    }

    #alasanTable_wrapper {
        padding: 20px;
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 15px;
    }

    .detail-text {
        max-height: 60px;
        overflow-y: auto;
        font-size: 0.9em;
    }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h2 mb-0 fw-bold text-dark">
                    <i class="fas fa-list-alt me-2 text-danger"></i>Alasan Pelanggaran
                </h1>
                <button class="btn btn-danger btn-lg shadow-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fas fa-plus me-2"></i>Tambah Alasan
                </button>
            </div>

            <div class="table-card">
                <div class="table-responsive">
                    <table id="alasanTable" class="table table-striped table-hover mb-0" style="width:100%">
                        <thead class="table-dark sticky-top">
                            <tr>
                                <th width="8%" class="text-center fw-bold">No</th>
                                <th width="25%" class="fw-bold">Jenis Pelanggaran</th>
                                <th width="50%">Detail Alasan</th>
                                <th width="12%" class="text-center fw-bold">Tanggal</th>
                                <th width="5%" class="text-center fw-bold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ADD MODAL - SCROLL 100px dari atas -->
<div class="modal fade" id="addModal" tabindex="-1" data-bs-backdrop="static" style="margin-top: 100px;">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-list-alt me-2"></i>Tambah Alasan Pelanggaran
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="multiForm">
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    <!-- DROPDOWN Jenis Pelanggaran - DATABASE -->
                    <div class="mb-4 p-3 border rounded bg-light">
                        <label class="form-label fw-bold fs-5">Jenis Pelanggaran <span
                                class="text-danger">*</span></label>
                        <select class="form-select shadow-sm" id="id_jenis_pelanggaran" required>
                            <option value="">Pilih Jenis Pelanggaran</option>
                            <?php
                            try {
                                include 'database.php'; // Sesuaikan path ke database.php
                                $stmt = $pdo->query("SELECT id, name FROM jenis_pelanggarans ORDER BY name ASC");
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='{$row['id']}'>" . htmlspecialchars($row['name']) . "</option>";
                                }
                            } catch (Exception $e) {
                                echo "<option value=''>Error loading jenis pelanggaran</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Dynamic Detail Inputs - SCROLL setelah 7 -->
                    <div id="detailContainer" class="mb-3"
                        style="max-height: 400px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 0.375rem; padding: 1rem;">
                        <!-- Temporary Input Pertama -->
                        <div class="input-row mb-3 p-3 border rounded bg-light temporary-input">
                            <div class="row align-items-end">
                                <div class="col-md-11">
                                    <label class="form-label fw-semibold">Detail Alasan #1 <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control detail-input" name="detail[]" rows="3"
                                        placeholder="Ketik alasan pelanggaran..." maxlength="500" required></textarea>
                                    <div class="form-text">Maks 500 karakter</div>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-outline-danger remove-row w-100" disabled>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Tambah Row -->
                    <div class="text-center mb-4" id="addRowSection" style="display: none;">
                        <button type="button" class="btn btn-success btn-lg px-4" id="addRow">
                            <i class="fas fa-plus-circle me-2"></i>Tambah Detail Lagi
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger btn-lg px-4" id="submitBtn" disabled>
                        <i class="fas fa-save me-2"></i>Simpan Semua Alasan
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
                <p class="text-muted fs-6 mb-0">Alasan ini akan dihapus <strong>PERMANEN</strong>!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary shadow-sm" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger shadow-sm" id="confirmDelete">Hapus</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts - NO SELECT2 -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
    let table, rowCount = 1;

    $(document).ready(function () {
        initDataTable();

        // Native dropdown change event - NO SELECT2
        $('#id_jenis_pelanggaran').on('change', function () {
            if ($(this).val()) {
                $(this).removeClass('is-invalid');
            }
            updateSubmitButton();
        });

        // Temporary Input Logic
        $(document).on('input', '.detail-input', function () {
            let $this = $(this);
            let value = $this.val().trim();
            let $row = $this.closest('.input-row');

            if (value && $row.hasClass('temporary-input')) {
                $row.removeClass('temporary-input bg-light');
                $row.find('.remove-row').prop('disabled', false).removeClass('btn-outline-danger').addClass('btn-danger');
                $('#addRowSection').slideDown();
            }
            updateSubmitButton();
        });

        // Tambah Row Baru
        $('#addRow').click(function () {
            rowCount++;
            let newRow = `
            <div class="input-row mb-3 p-3 border rounded">
                <div class="row align-items-end">
                    <div class="col-md-11">
                        <label class="form-label fw-semibold">Detail Alasan #${rowCount}</label>
                        <textarea class="form-control detail-input" name="detail[]" rows="3" 
                                placeholder="Ketik alasan pelanggaran..." maxlength="500"></textarea>
                        <div class="form-text">Maks 500 karakter</div>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger remove-row w-100">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
            $('#detailContainer').append(newRow);
            scrollToBottom();
            updateSubmitButton();
        });

        // Hapus Row
        $(document).on('click', '.remove-row:not(:disabled)', function () {
            if ($('#detailContainer .input-row').length > 1) {
                $(this).closest('.input-row').remove();
                rowCount--;
                updateSubmitButton();
            }
        });

        // Submit Form
        $('#multiForm').submit(function (e) {
            e.preventDefault();
            let details = getValidDetails();
            if (details.length === 0) {
                showToast('Minimal 1 detail alasan!', 'error');
                return;
            }

            let $btn = $('#submitBtn');
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...');

            $.ajax({
                url: 'action_alasan.php',
                method: 'POST',
                data: {
                    action: 'add_multi',
                    id_jenis_pelanggaran: $('#id_jenis_pelanggaran').val(),
                    details: details
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $('#addModal').modal('hide');
                        resetForm();
                        table.ajax.reload(null, false);
                        showToast(`✅ ${response.inserted} alasan berhasil disimpan!`, 'success');
                    } else {
                        showToast('❌ ' + response.message, 'error');
                    }
                },
                error: function () {
                    showToast('❌ Gagal koneksi ke server!', 'error');
                },
                complete: function () {
                    $btn.prop('disabled', false).html('<i class="fas fa-save me-2"></i>Simpan Semua Alasan');
                }
            });
        });

        // Delete Confirmation
        $('#confirmDelete').click(function () {
            let id = $('#deleteId').val();
            $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Menghapus...');

            $.post('action_alasan.php', { action: 'delete', id: id })
                .done(function (response) {
                    if (response.success) {
                        $('#deleteModal').modal('hide');
                        table.ajax.reload(null, false);
                        showToast('✅ Alasan berhasil dihapus!', 'success');
                    } else {
                        showToast('❌ Gagal hapus!', 'error');
                    }
                }).always(function () {
                    $('#confirmDelete').prop('disabled', false).html('Hapus');
                });
        });
    });

    function initDataTable() {
        table = $('#alasanTable').DataTable({
            ajax: {
                url: 'action_alasan.php?action=read',
                dataSrc: '',
                error: () => showToast('Gagal load data!', 'error')
            },
            columns: [
                {
                    data: null, orderable: false, className: 'text-center fw-semibold',
                    render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1
                },
                {
                    data: null,
                    render: data => `<span class="badge bg-danger">${data.jenis_pelanggarans || '-'}</span>`
                },
                {
                    data: null, className: 'align-middle',
                    render: data => `<div class="detail-text p-2 border rounded bg-light">${data.detail}</div>`
                },
                {
                    data: null, className: 'text-center',
                    render: data => new Date(data.created_at || Date.now()).toLocaleDateString('id-ID')
                },
                {
                    data: null, orderable: false, className: 'text-center',
                    render: data => `
                    <div class="btn-group">
                        <button class="btn btn-danger btn-sm delete-btn" data-id="${data.id}" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `
                }
            ],
            language: {
                "decimal": ",", "emptyTable": "Belum ada data alasan",
                "info": "Menampilkan _START_ - _END_ dari _TOTAL_ alasan",
                "infoEmpty": "Menampilkan 0 - 0 dari 0 alasan",
                "infoFiltered": "(disaring dari _MAX_ total alasan)",
                "lengthMenu": "Tampilkan _MENU_ alasan",
                "loadingRecords": "⏳ Memuat...", "processing": "⏳ Memproses...",
                "search": "Cari alasan:", "zeroRecords": "Tidak ditemukan alasan",
                "paginate": { "first": "⏮️", "last": "⏭️", "next": "▶️", "previous": "◀️" }
            },
            pageLength: 25, responsive: true, order: [[0, 'desc']]
        });
    }

    $(document).on('click', '.delete-btn', function () {
        let id = $(this).data('id');
        $('#deleteId').val(id);
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    });

    function getValidDetails() {
        return $('.detail-input').filter(function () {
            return $(this).val().trim().length > 0;
        }).map(function () {
            return $(this).val().trim();
        }).get();
    }

    function updateSubmitButton() {
        let jenisSelected = $('#id_jenis_pelanggaran').val();
        let hasDetails = getValidDetails().length > 0;
        $('#submitBtn').prop('disabled', !(jenisSelected && hasDetails));
    }

    function resetForm() {
        $('#detailContainer').html(`
        <div class="input-row mb-3 p-3 border rounded bg-light temporary-input">
            <div class="row align-items-end">
                <div class="col-md-11">
                    <label class="form-label fw-semibold">Detail Alasan #1 <span class="text-danger">*</span></label>
                    <textarea class="form-control detail-input" name="detail[]" rows="3" 
                            placeholder="Ketik alasan pelanggaran..." maxlength="500" required></textarea>
                    <div class="form-text">Maks 500 karakter</div>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-outline-danger remove-row w-100" disabled>
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `);
        $('#addRowSection').hide();
        rowCount = 1;
        updateSubmitButton();
    }

    function scrollToBottom() {
        $('#detailContainer')[0].scrollTop = $('#detailContainer')[0].scrollHeight;
    }

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
        new bootstrap.Toast($('.toast').last()[0], { delay: 4000 }).show();
        $('.toast').last().on('hidden.bs.toast', function () { $(this).remove(); });
    }
</script>

<?php $this->stop() ?>
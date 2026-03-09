<?php $this->layout('layouts::app', ['title' => 'Pelanggaran']) ?>

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

    #pelanggaranTable_wrapper { padding: 20px; }
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter { margin-bottom: 15px; }

    .badge-siswa  { background-color: #0d6efd !important; color: white !important; }
    .badge-guru   { background-color: #198754 !important; color: white !important; }
    .badge-jenis  { background-color: #dc3545 !important; color: white !important; }
    .badge-alasan {
        background-color: #ffc107 !important;
        color: black !important;
        font-weight: 500;
        font-size: 0.8em;
        padding: 0.4em 0.8em;
    }
    .badge-point { background-color: #6f42c1 !important; color: white !important; }

    .point-auto {
        background-color: #e9ecef !important;
        color: #495057 !important;
        cursor: not-allowed;
        border: 1px solid #ced4da;
    }

    /* Preview box di modal export */
    .preview-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: .9rem;
    }
    .preview-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 5px 0;
    }
    .preview-row + .preview-row { border-top: 1px dashed #e2e8f0; }

    /* Shortcut bulan aktif */
    .shortcut-btn.active {
        background: #198754 !important;
        color: #fff !important;
        border-color: #198754 !important;
    }

    /* FIX MODAL BACKDROP */
    .modal-backdrop { z-index: 1040 !important; }
    .modal { z-index: 1055 !important; }
    .modal .modal-dialog { z-index: 1056 !important; }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h2 mb-0 fw-bold text-dark">
                    <i class="fas fa-user-slash me-2 text-danger"></i>Data Pelanggaran
                </h1>

                <div class="d-flex gap-2">
                    <!-- ✅ TOMBOL EXPORT WORD (BARU) -->
                    <button class="btn btn-success btn-lg shadow-sm"
                            data-bs-toggle="modal" data-bs-target="#exportModal">
                        <i class="fas fa-file-word me-2"></i>Export Word
                    </button>

                    <!-- Tombol asli -->
                    <button class="btn btn-danger btn-lg shadow-sm"
                            data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="fas fa-plus me-2"></i>Tambah Pelanggaran
                    </button>
                </div>
            </div>

            <div class="table-card">
                <div class="table-responsive">
                    <table id="pelanggaranTable" class="table table-striped table-hover mb-0" style="width:100%">
                        <thead class="table-dark sticky-top">
                            <tr>
                                <th width="5%"  class="text-center fw-bold">No</th>
                                <th width="14%" class="fw-bold">Siswa</th>
                                <th width="14%" class="fw-bold">Jenis Pelanggaran</th>
                                <th width="17%" class="fw-bold">Alasan Pelanggaran</th>
                                <th width="11%" class="fw-bold">Guru</th>
                                <th width="10%" class="text-center fw-bold">Point</th>
                                <th width="12%" class="text-center fw-bold">Tanggal</th>
                                <th width="10%" class="text-center fw-bold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════ -->
<!-- EXPORT WORD MODAL (BARU)                              -->
<!-- ══════════════════════════════════════════════════════ -->
<div class="modal fade" id="exportModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">

            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-file-word me-2"></i>Export Laporan Pelanggaran
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <!-- Range tanggal -->
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-bold small text-muted">DARI TANGGAL</label>
                        <input type="date" class="form-control" id="exportDateStart">
                        <div class="form-text">
                            <i class="fas fa-magic me-1"></i>
                            Ubah ini → akhir bulan otomatis terisi
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold small text-muted">SAMPAI TANGGAL</label>
                        <input type="date" class="form-control" id="exportDateEnd">
                    </div>
                </div>

                <!-- Shortcut periode -->
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">SHORTCUT PERIODE</label>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="btn btn-outline-success btn-sm shortcut-btn" data-months-ago="0">
                            Bulan Ini
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm shortcut-btn" data-months-ago="1">
                            1 Bln Lalu
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm shortcut-btn" data-months-ago="2">
                            2 Bln Lalu
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm shortcut-btn" data-months-ago="3">
                            3 Bln Lalu
                        </button>
                    </div>
                </div>

                <!-- Preview jumlah data -->
                <div class="preview-box" id="exportPreview">
                    <div class="text-center text-muted py-2">
                        <i class="fas fa-spinner fa-spin me-1"></i> Memuat preview...
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Batal
                </button>
                <button type="button" class="btn btn-success" id="btnExportDownload" disabled>
                    <i class="fas fa-download me-2"></i>Download Word
                </button>
            </div>

        </div>
    </div>
</div>

<!-- EDIT MODAL (tidak diubah) -->
<div class="modal fade" id="editModal" tabindex="-1" data-bs-backdrop="static" style="margin-top: 100px;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-edit me-2"></i>Edit Pelanggaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm">
                <div class="modal-body">
                    <input type="hidden" id="editId">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Siswa <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_id_siswa" required>
                                <option value="">Memuat...</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Guru <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_id_guru" required>
                                <option value="">Memuat...</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Jenis Pelanggaran <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_id_jenis_pelanggaran" required>
                                <option value="">Memuat...</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Alasan Pelanggaran <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_id_alasan_pelanggaran" required disabled>
                                <option value="">Pilih Jenis Dulu</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Total Point</label>
                            <input type="number" class="form-control point-auto" id="edit_total_point" readonly value="0">
                            <small class="text-muted">Otomatis dari Jenis Pelanggaran</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning btn-lg px-4" id="editSubmitBtn" disabled>
                        <i class="fas fa-save me-2"></i>Update Pelanggaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ADD MODAL (tidak diubah) -->
<div class="modal fade" id="addModal" tabindex="-1" data-bs-backdrop="static" style="margin-top: 100px;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-plus me-2"></i>Tambah Pelanggaran Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="addForm">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-white">Siswa <span class="text-danger">*</span></label>
                            <select class="form-select" id="add_id_siswa" required>
                                <option value="">Memuat...</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-white">Guru <span class="text-danger">*</span></label>
                            <select class="form-select" id="add_id_guru" required>
                                <option value="">Memuat...</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-white">Jenis Pelanggaran <span class="text-danger">*</span></label>
                            <select class="form-select" id="add_id_jenis_pelanggaran" required>
                                <option value="">Memuat...</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-white">Alasan Pelanggaran <span class="text-danger">*</span></label>
                            <select class="form-select" id="add_id_alasan_pelanggaran" required disabled>
                                <option value="">Pilih Jenis Dulu</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-white">Total Point</label>
                            <input type="number" class="form-control point-auto" id="add_total_point" readonly value="0">
                            <small class="text-white-50">Otomatis dari Jenis Pelanggaran</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger btn-lg px-4" id="addSubmitBtn" disabled>
                        <i class="fas fa-save me-2"></i>Simpan Pelanggaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- DELETE MODAL (tidak diubah) -->
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
                <p class="text-muted fs-6 mb-0">Data pelanggaran akan dihapus <strong>PERMANEN</strong>!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary shadow-sm" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger shadow-sm" id="confirmDelete">Hapus</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
let table;

// ════════════════════════════════════════════════════════════
// HELPER: hitung awal & akhir bulan relatif
//   monthsAgo = 0 → bulan ini
//   monthsAgo = 1 → 1 bulan lalu, dst.
// ════════════════════════════════════════════════════════════
function getMonthRange(monthsAgo) {
    var now   = new Date();
    var year  = now.getFullYear();
    var month = now.getMonth() - monthsAgo; // 0-based

    // Normalize: geser tahun jika month < 0
    while (month < 0) { month += 12; year--; }

    var firstDay = new Date(year, month, 1);
    var lastDay  = new Date(year, month + 1, 0); // hari terakhir bulan tsb

    function pad(n) { return String(n).padStart(2, '0'); }
    function fmt(d) { return d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate()); }

    return { start: fmt(firstDay), end: fmt(lastDay) };
}

// ════════════════════════════════════════════════════════════
// FORMAT tanggal untuk display (1 Jan 2025)
// ════════════════════════════════════════════════════════════
function fmtDisplay(dateStr) {
    if (!dateStr) return '-';
    var bulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    var p = dateStr.split('-');
    return parseInt(p[2]) + ' ' + bulan[parseInt(p[1]) - 1] + ' ' + p[0];
}

// ════════════════════════════════════════════════════════════
// EXPORT MODAL: set periode & trigger preview
// ════════════════════════════════════════════════════════════
var previewTimer = null;

function setExportPeriode(start, end) {
    $('#exportDateStart').val(start);
    $('#exportDateEnd').val(end);
    loadExportPreview();
}

function loadExportPreview() {
    var start = $('#exportDateStart').val();
    var end   = $('#exportDateEnd').val();

    // Validasi kosong
    if (!start || !end) {
        $('#exportPreview').html(
            '<p class="text-muted text-center mb-0">Pilih tanggal terlebih dahulu</p>'
        );
        $('#btnExportDownload').prop('disabled', true);
        return;
    }

    // Validasi urutan
    if (start > end) {
        $('#exportPreview').html(
            '<p class="text-danger text-center mb-0">' +
            '<i class="fas fa-exclamation-triangle me-1"></i>' +
            'Tanggal awal tidak boleh melebihi tanggal akhir</p>'
        );
        $('#btnExportDownload').prop('disabled', true);
        return;
    }

    $('#exportPreview').html(
        '<div class="text-center text-muted py-1">' +
        '<i class="fas fa-spinner fa-spin me-1"></i> Memuat data...</div>'
    );
    $('#btnExportDownload').prop('disabled', true);

    $.get('action_pelanggaran.php', {
        action: 'count_range',
        date_start: start,
        date_end: end
    }).done(function(data) {
        var total = parseInt(data.total || 0);
        var poin  = parseInt(data.total_poin || 0);
        var label = (start === end)
            ? fmtDisplay(start)
            : fmtDisplay(start) + ' &ndash; ' + fmtDisplay(end);

        var html =
            '<div class="preview-row">' +
                '<span class="text-muted">Periode</span>' +
                '<strong>' + label + '</strong>' +
            '</div>' +
            '<div class="preview-row">' +
                '<span class="text-muted">Jumlah pelanggaran</span>' +
                '<span class="badge bg-danger fs-6 px-3">' + total + ' data</span>' +
            '</div>';

        if (total === 0) {
            html += '<p class="text-warning small mt-2 mb-0">' +
                    '<i class="fas fa-info-circle me-1"></i>' +
                    'Tidak ada data pada periode ini, download tetap bisa dilakukan.</p>';
        }

        $('#exportPreview').html(html);
        // Aktifkan tombol download (bahkan jika 0 data, biarkan user memutuskan)
        $('#btnExportDownload').prop('disabled', false);

    }).fail(function() {
        $('#exportPreview').html(
            '<p class="text-danger text-center mb-0">Gagal memuat preview</p>'
        );
    });
}

$(document).ready(function () {
    loadDropdowns();
    initDataTable();

    // ── FIX MODAL BACKDROP ──────────────────────────────────
    $(document).on('hidden.bs.modal', '.modal', function () {
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open').css('padding-right', '');
    });

    // ════════════════════════════════════════════════════════
    // EXPORT MODAL — init saat modal dibuka
    // ════════════════════════════════════════════════════════
    $('#exportModal').on('show.bs.modal', function() {
        // Default: bulan ini
        var def = getMonthRange(0);
        setExportPeriode(def.start, def.end);
        // Aktifkan shortcut "Bulan Ini"
        $('.shortcut-btn').removeClass('active');
        $('.shortcut-btn[data-months-ago="0"]').addClass('active');
    });

    // Shortcut tombol bulan
    $(document).on('click', '.shortcut-btn', function() {
        var ago   = parseInt($(this).data('months-ago'));
        var range = getMonthRange(ago);
        setExportPeriode(range.start, range.end);
        $('.shortcut-btn').removeClass('active');
        $(this).addClass('active');
    });

    // Saat user ubah tanggal START → auto-set END ke akhir bulan yang sama,
    // lalu clear shortcut aktif karena user custom
    $('#exportDateStart').on('change', function() {
        var val = $(this).val();
        if (val) {
            var p     = val.split('-');
            var year  = parseInt(p[0]);
            var month = parseInt(p[1]) - 1; // 0-based
            // Akhir bulan = hari ke-0 dari bulan berikutnya
            var lastDay = new Date(year, month + 1, 0);
            function pad(n) { return String(n).padStart(2, '0'); }
            var endVal = year + '-' + pad(lastDay.getMonth() + 1) + '-' + pad(lastDay.getDate());
            $('#exportDateEnd').val(endVal);
        }
        $('.shortcut-btn').removeClass('active');
        clearTimeout(previewTimer);
        previewTimer = setTimeout(loadExportPreview, 400);
    });

    // Saat user ubah tanggal END secara manual → hanya reload preview
    $('#exportDateEnd').on('change', function() {
        $('.shortcut-btn').removeClass('active');
        clearTimeout(previewTimer);
        previewTimer = setTimeout(loadExportPreview, 400);
    });

    // Tombol Download Word
    $('#btnExportDownload').on('click', function() {
        var start = $('#exportDateStart').val();
        var end   = $('#exportDateEnd').val();
        if (!start || !end) return;

        var $btn = $(this);
        $btn.prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin me-2"></i>Membuat file...');

        // Buka di tab baru — modal tidak ikut tertutup
        window.open(
            'export_pelanggaran.php?date_start=' + start + '&date_end=' + end,
            '_blank'
        );

        // Kembalikan tombol setelah 2 detik
        setTimeout(function() {
            $btn.prop('disabled', false)
                .html('<i class="fas fa-download me-2"></i>Download Word');
        }, 2000);
    });

    // ════════════════════════════════════════════════════════
    // EVENT LISTENERS ASLI (tidak diubah)
    // ════════════════════════════════════════════════════════
    $('#add_id_jenis_pelanggaran, #edit_id_jenis_pelanggaran').on('change', function() {
        const modal = this.id.includes('add') ? 'add' : 'edit';
        handleJenisChange(modal);
    });

    $('#add_id_siswa, #add_id_guru, #add_id_alasan_pelanggaran').on('change', updateAddSubmit);
    $('#edit_id_siswa, #edit_id_guru, #edit_id_alasan_pelanggaran').on('change', updateEditSubmit);

    $('#addForm').submit(handleAddSubmit);
    $('#editForm').submit(handleEditSubmit);
    $('#confirmDelete').click(handleDelete);

    $(document).on('click', '.edit-btn', showEditModal);
    $(document).on('click', '.delete-btn', showDeleteModal);
});

// ════════════════════════════════════════════════════════════
// FUNGSI ASLI (tidak diubah sama sekali)
// ════════════════════════════════════════════════════════════

function loadDropdowns() {
    $.get('action_pelanggaran.php?action=siswa', function(data) {
        let html = '<option value="">Pilih Siswa</option>';
        data.forEach(s => html += `<option value="${s.id}">${s.name}</option>`);
        $('#add_id_siswa, #edit_id_siswa').html(html);
    });

    $.get('action_pelanggaran.php?action=guru', function(data) {
        let html = '<option value="">Pilih Guru</option>';
        data.forEach(g => html += `<option value="${g.id}">${g.name}</option>`);
        $('#add_id_guru, #edit_id_guru').html(html);
    });

    $.get('action_pelanggaran.php?action=jenis', function(data) {
        let html = '<option value="">Pilih Jenis</option>';
        data.forEach(j => html += `<option value="${j.id}">${j.name}</option>`);
        $('#add_id_jenis_pelanggaran, #edit_id_jenis_pelanggaran').html(html);
    });
}

function handleJenisChange(modal) {
    const jenisId      = $(`#${modal}_id_jenis_pelanggaran`).val();
    const alasanSelect = $(`#${modal}_id_alasan_pelanggaran`);
    const pointInput   = $(`#${modal}_total_point`);

    if (!jenisId) {
        alasanSelect.html('<option value="">Pilih Jenis Dulu</option>').prop('disabled', true);
        pointInput.val(0);
        return;
    }

    $.get(`action_pelanggaran.php?action=alasan&id_jenis=${jenisId}`, function(alasanData) {
        let html = '<option value="">Pilih Alasan</option>';
        alasanData.forEach(a => { html += `<option value="${a.id}">${a.detail}</option>`; });
        alasanSelect.html(html).prop('disabled', false);
    });

    $.get(`action_pelanggaran.php?action=jenis_point&id_jenis=${jenisId}`, function(pointData) {
        pointInput.val(pointData.point);
        updateSubmit(modal);
    });
}

function updateAddSubmit()  { updateSubmit('add'); }
function updateEditSubmit() { updateSubmit('edit'); }

function updateSubmit(modal) {
    const valid = $(`#${modal}_id_siswa`).val()             &&
                  $(`#${modal}_id_guru`).val()              &&
                  $(`#${modal}_id_jenis_pelanggaran`).val() &&
                  $(`#${modal}_id_alasan_pelanggaran`).val();
    $(`#${modal}SubmitBtn`).prop('disabled', !valid);
}

function initDataTable() {
    table = $('#pelanggaranTable').DataTable({
        ajax: {
            url: 'action_pelanggaran.php?action=read',
            dataSrc: '',
            error: () => showToast('Gagal load data!', 'error')
        },
        columns: [
            {
                data: null, orderable: false, className: 'text-center fw-semibold', width: '5%',
                render: (data, type, row, meta) => meta.row + 1
            },
            { data: null, width: '14%', render: d => `<span class="badge badge-siswa">${d.siswas || '-'}</span>` },
            { data: null, width: '14%', render: d => `<span class="badge badge-jenis">${d.jenis_pelanggarans || '-'}</span>` },
            { data: null, width: '17%', render: d => `<span class="badge badge-alasan">${d.alasan_pelanggaran || '-'}</span>` },
            { data: null, width: '11%', render: d => `<span class="badge badge-guru">${d.gurus || '-'}</span>` },
            { data: null, className: 'text-center fw-bold', width: '10%', render: d => `<span class="badge badge-point">${d.total_point || 0} pt</span>` },
            { data: null, className: 'text-center', width: '12%', render: d => new Date(d.date).toLocaleDateString('id-ID') },
            {
                data: null, orderable: false, className: 'text-center', width: '10%',
                render: d => `
                    <div class="btn-group">
                        <button class="btn btn-warning btn-sm edit-btn" data-id="${d.id}" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="${d.id}" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>`
            }
        ],
        language: {
            "decimal": ",", "emptyTable": "Belum ada data pelanggaran",
            "info": "Menampilkan _START_ - _END_ dari _TOTAL_ pelanggaran",
            "infoEmpty": "Menampilkan 0 - 0 dari 0 pelanggaran",
            "infoFiltered": "(disaring dari _MAX_ total pelanggaran)",
            "lengthMenu": "Tampilkan _MENU_ pelanggaran",
            "loadingRecords": "⏳ Memuat...", "processing": "⏳ Memproses...",
            "search": "Cari pelanggaran:", "zeroRecords": "Tidak ditemukan pelanggaran",
            "paginate": { "first": "⏮️", "last": "⏭️", "next": "▶️", "previous": "◀️" }
        },
        pageLength: 25, responsive: true, order: [[0, 'desc']],
        drawCallback: function() {
            $('.edit-btn').off('click').on('click', showEditModal);
            $('.delete-btn').off('click').on('click', showDeleteModal);
        }
    });
}

function showEditModal() {
    const id = $(this).data('id');
    $('#editId').val(id);
    $.get('action_pelanggaran.php?action=get&id=' + id, function(response) {
        if (response.success && response.data) {
            const data = response.data;
            $('#edit_id_siswa').val(data.id_siswa);
            $('#edit_id_guru').val(data.id_guru);
            $('#edit_id_jenis_pelanggaran').val(data.id_jenis_pelanggaran).trigger('change');
            $('#edit_total_point').val(data.total_point);
            new bootstrap.Modal(document.getElementById('editModal')).show();
        }
    });
}

function handleEditSubmit(e) {
    e.preventDefault();
    const formData = {
        action: 'update',
        id: $('#editId').val(),
        id_siswa: $('#edit_id_siswa').val(),
        id_guru: $('#edit_id_guru').val(),
        id_jenis_pelanggaran: $('#edit_id_jenis_pelanggaran').val(),
        id_alasan_pelanggaran: $('#edit_id_alasan_pelanggaran').val(),
        total_point: $('#edit_total_point').val()
    };
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open').css('padding-right', '');
    $.post('action_pelanggaran.php', formData, function(response) {
        if (response.success) {
            $('#editModal').modal('hide');
            table.ajax.reload(null, false);
            showToast('✅ Pelanggaran berhasil diupdate!', 'success');
        } else {
            showToast('❌ Gagal update!', 'error');
        }
    }).fail(() => showToast('❌ Gagal koneksi!', 'error'));
}

function handleAddSubmit(e) {
    e.preventDefault();
    const formData = {
        action: 'add',
        id_siswa: $('#add_id_siswa').val(),
        id_guru: $('#add_id_guru').val(),
        id_jenis_pelanggaran: $('#add_id_jenis_pelanggaran').val(),
        id_alasan_pelanggaran: $('#add_id_alasan_pelanggaran').val(),
        total_point: $('#add_total_point').val()
    };
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open').css('padding-right', '');
    $.post('action_pelanggaran.php', formData, function(response) {
        if (response.success) {
            $('#addModal').modal('hide');
            loadDropdowns();
            table.ajax.reload(null, false);
            showToast('✅ Pelanggaran berhasil disimpan!', 'success');
        } else {
            showToast('❌ Gagal simpan!', 'error');
        }
    }).fail(() => showToast('❌ Gagal koneksi!', 'error'));
}

function showDeleteModal() {
    $('#deleteId').val($(this).data('id'));
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

function handleDelete() {
    const id = $('#deleteId').val();
    $('#confirmDelete').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Menghapus...');
    $.post('action_pelanggaran.php', { action: 'delete', id: id })
        .done(function(response) {
            if (response.success) {
                $('#deleteModal').modal('hide');
                table.ajax.reload(null, false);
                showToast('✅ Pelanggaran berhasil dihapus!', 'success');
            } else {
                showToast('❌ Gagal hapus!', 'error');
            }
        }).always(() => {
            $('#confirmDelete').prop('disabled', false).html('Hapus');
        });
}

function showToast(message, type = 'success') {
    const bgClass = type === 'success' ? 'bg-success' : 'bg-danger';
    const icon    = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
    const html    = `
        <div class="toast align-items-center text-white ${bgClass} border-0 position-fixed top-0 end-0 m-4 shadow-lg"
             role="alert" style="z-index:1099;min-width:320px;">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center">
                    <i class="${icon} me-2 fs-5"></i>${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>`;
    $('body').append(html);
    new bootstrap.Toast($('.toast').last()[0], { delay: 4000 }).show();
    $('.toast').last().on('hidden.bs.toast', function() { $(this).remove(); });
}
</script>

<?php $this->stop() ?>
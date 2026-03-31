<?php $this->layout('layouts::app', ['title' => 'Jenis Pelanggaran']) ?>

<?php $this->start('main') ?>

<style>
/* ============================================
   LIQUID GLASS THEME - JENIS PELANGGARAN PAGE
   ============================================ */

:root {
    --liquid-bg: rgba(255, 255, 255, 0.05);
    --liquid-border: rgba(255, 255, 255, 0.15);
    --liquid-shadow: rgba(0, 0, 0, 0.4);
    --liquid-blur: blur(20px) saturate(180%);
    --liquid-glow: rgba(52, 211, 153, 0.1);

    --emerald: #059669;
    --emerald-light: #34d399;
    --gold: #eab308;
    --text-primary: #ffffff;
    --text-muted: rgba(255, 255, 255, 0.6);
}

/* ============================================
   BASE STYLES
   ============================================ */

.container-custom {
    position: relative;
    z-index: 1;
}

/* ============================================
   PAGE HEADER
   ============================================ */

.page-header-pelanggaran {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.page-title-pelanggaran {
    font-size: 28px;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 12px;
}

.page-title-pelanggaran i {
    color: var(--emerald-light);
    filter: drop-shadow(0 0 10px rgba(52, 211, 153, 0.5));
}

.page-subtitle {
    color: var(--text-muted);
    font-size: 14px;
    margin-top: 4px;
}

/* Add Button */
.btn-add-pelanggaran {
    background: linear-gradient(135deg, var(--emerald), var(--gold)) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    color: white !important;
    padding: 12px 24px !important;
    font-weight: 600;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(5, 150, 105, 0.3);
    transition: all 0.3s ease;
}

.btn-add-pelanggaran:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 40px rgba(5, 150, 105, 0.4);
}

/* Table Card */
.table-card-pelanggaran {
    background: var(--liquid-bg);
    backdrop-filter: var(--liquid-blur);
    border: 1px solid var(--liquid-border);
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 8px 32px var(--liquid-shadow);
}

.pelanggaran-table-wrapper {
    padding: 24px;
}

/* Point Badge */
.point-badge {
    display: inline-flex;
    padding: 8px 16px;
    border-radius: 24px;
    font-weight: 700;
    font-size: 14px;
    background: linear-gradient(135deg, rgba(234, 179, 8, 0.3), rgba(251, 191, 36, 0.2));
    border: 1px solid rgba(234, 179, 8, 0.4);
    color: #facc15;
    box-shadow: 0 4px 12px rgba(234, 179, 8, 0.2);
}

/* Action Buttons */
.btn-action-edit, .btn-action-delete {
    width: 36px;
    height: 36px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    color: white !important;
    border-radius: 10px !important;
    transition: all 0.3s ease;
}

.btn-action-edit { background: linear-gradient(135deg, rgba(234, 179, 8, 0.8), rgba(251, 191, 36, 0.6)) !important; }
.btn-action-delete { background: linear-gradient(135deg, rgba(220, 38, 38, 0.8), rgba(239, 68, 68, 0.6)) !important; }

.btn-action-edit:hover, .btn-action-delete:hover {
    transform: translateY(-2px) scale(1.1);
}

/* ============================================
   MODAL STYLES - PORTAL VERSION
   ============================================ */

/* Modal Portal Container (di body) */
.modal-portal-container {
    position: relative;
    z-index: 1;
}

/* Modal Overlay - TRUE FULLSCREEN DI BODY */
.liquid-modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    z-index: 99999;
    opacity: 0;
    transition: opacity 0.3s ease;
    background: rgba(0, 0, 0, 0.34);
    backdrop-filter: blur(8px);
    align-items: flex-start;
    justify-content: center;
    overflow-y: auto;
}

.liquid-modal-overlay.active {
    display: flex;
    opacity: 1;
}

.liquid-modal {
    margin-top: 80px;
    margin-bottom: 40px;
    background: rgba(20, 30, 48, 0.1);
    backdrop-filter: blur(60px) saturate(250%);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 28px;
    width: 90%;
    max-width: 480px;
    box-shadow: 0 32px 64px rgba(0, 0, 0, 0.28);
    transform: scale(0.9) translateY(-20px);
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    position: relative;
    flex-shrink: 0;
}

.liquid-modal-overlay.active .liquid-modal {
    transform: scale(1) translateY(0);
}

.liquid-modal-header {
    padding: 22px 26px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.32);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.liquid-modal-header.primary { background: linear-gradient(135deg, rgba(5, 150, 105, 0.2), rgba(52, 211, 153, 0.05)); }
.liquid-modal-header.warning { background: linear-gradient(135deg, rgba(234, 179, 8, 0.2), rgba(251, 191, 36, 0.05)); }
.liquid-modal-header.danger { background: linear-gradient(135deg, rgba(220, 38, 38, 0.2), rgba(239, 68, 68, 0.05)); }

.liquid-modal-title {
    font-weight: 700;
    font-size: 18px;
    color: white;
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 0;
}

.liquid-modal-close {
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.15);
    color: white;
    width: 34px;
    height: 34px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.liquid-modal-close:hover {
    background: rgba(255, 255, 255, 0.15);
    transform: rotate(90deg);
}

.liquid-modal-body {
    padding: 26px;
}

.liquid-modal-footer {
    padding: 18px 26px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    background: rgba(0, 0, 0, 0.1);
}

/* Form */
.form-group-pelanggaran { margin-bottom: 20px; }
.form-group-pelanggaran label {
    display: block;
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 8px;
    color: rgba(255, 255, 255, 0.9);
}
.form-group-pelanggaran label .required { color: #ff6b6b; margin-left: 4px; }

.form-input-pelanggaran {
    width: 100%;
    padding: 14px 18px;
    background: rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 14px;
    color: white;
    font-size: 15px;
    transition: all 0.3s ease;
}

.form-input-pelanggaran:focus {
    outline: none;
    border-color: var(--emerald-light);
    box-shadow: 0 0 0 3px rgba(52, 211, 153, 0.1);
}

.form-input-pelanggaran::placeholder {
    color: rgba(255, 255, 255, 0.4);
}

/* Buttons */
.btn-modal-cancel {
    background: rgba(255, 255, 255, 0.06);
    border: 1px solid rgba(255, 255, 255, 0.15);
    color: rgba(255, 255, 255, 0.8);
    padding: 12px 24px;
    border-radius: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-modal-cancel:hover {
    background: rgba(255, 255, 255, 0.12);
    color: white;
}

.btn-modal-submit {
    background: linear-gradient(135deg, rgba(5, 150, 105, 0.9), rgba(234, 179, 8, 0.9));
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    padding: 12px 26px;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 8px 24px rgba(5, 150, 105, 0.3);
}

.btn-modal-submit:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(5, 150, 105, 0.4);
}

.btn-modal-submit:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.btn-modal-submit.warning {
    background: linear-gradient(135deg, rgba(234, 179, 8, 0.9), rgba(251, 191, 36, 0.9));
    box-shadow: 0 8px 24px rgba(234, 179, 8, 0.3);
}

.btn-modal-submit.danger {
    background: linear-gradient(135deg, rgba(220, 38, 38, 0.9), rgba(239, 68, 68, 0.9));
    box-shadow: 0 8px 24px rgba(220, 38, 38, 0.3);
}

/* Delete Modal */
.modal-warning-box { text-align: center; padding: 20px 0; }
.modal-warning-icon {
    color: #ff6b6b;
    font-size: 64px;
    margin-bottom: 16px;
    animation: pulse-warning 2s ease-in-out infinite;
}
@keyframes pulse-warning {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}
.modal-warning-title {
    font-weight: 700;
    font-size: 24px;
    color: white;
    margin-bottom: 12px;
}
.modal-warning-text {
    color: rgba(255, 255, 255, 0.7);
    font-size: 15px;
}
.modal-warning-text strong { color: #ff6b6b; }

/* Toast */
.toast-pelanggaran {
    position: fixed;
    top: 24px;
    right: 24px;
    min-width: 320px;
    z-index: 100000;
    border-radius: 16px;
    backdrop-filter: blur(30px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    animation: slideIn 0.4s ease;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}
@keyframes slideIn {
    from { opacity: 0; transform: translateX(100%); }
    to { opacity: 1; transform: translateX(0); }
}
.toast-pelanggaran.success { background: rgba(34, 197, 94, 0.9); border-color: rgba(34, 197, 94, 0.4); color: white; }
.toast-pelanggaran.error { background: rgba(220, 38, 38, 0.9); border-color: rgba(220, 38, 38, 0.4); color: white; }

/* DataTable Customization */
#jenisTable tbody tr {
    background: transparent;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

#jenisTable.dataTable thead th {
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.8);
    font-weight: 600;
}

#jenisTable.dataTable tbody td {
    color: rgba(255, 255, 255, 0.9);
}

/* Responsive */
@media (max-width: 768px) {
    .page-header-pelanggaran { flex-direction: column; gap: 16px; align-items: flex-start; }
    .page-title-pelanggaran { font-size: 24px; }
    .btn-add-pelanggaran { width: 100%; justify-content: center; }
    .pelanggaran-table-wrapper { padding: 16px; }
    .liquid-modal { margin-top: 20px; width: 95%; border-radius: 20px; }
    .liquid-modal-header { padding: 18px 20px; }
    .liquid-modal-body { padding: 20px; }
    .liquid-modal-footer { padding: 16px 20px; flex-direction: column-reverse; }
    .btn-modal-cancel, .btn-modal-submit { width: 100%; justify-content: center; }
}
</style>

<div class="container-custom">
    <!-- HEADER -->
    <div class="page-header-pelanggaran">
        <div>
            <h1 class="page-title-pelanggaran">
                <i class="fas fa-exclamation-circle"></i>Jenis Pelanggaran
            </h1>
            <p class="page-subtitle">Kelola data jenis pelanggaran dan pointnya</p>
        </div>
        <button class="btn btn-add-pelanggaran" onclick="openModal('addModal')">
            <i class="fas fa-plus"></i>Tambah Jenis Pelanggaran
        </button>
    </div>

    <!-- TABLE -->
    <div class="table-card-pelanggaran">
        <div class="pelanggaran-table-wrapper">
            <table id="jenisTable" class="display responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th width="10%" class="text-center">No</th>
                        <th width="45%">Nama Pelanggaran</th>
                        <th width="20%" class="text-center">Point</th>
                        <th width="25%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- 
  MODALS - DITEMPATKAN DI SINI SEMENTARA, AKAN DIPINDAHKAN KE BODY VIA JAVASCRIPT
  Ini adalah trik PORTAL untuk menghindari stacking context issues
-->
<div id="modal-portal-source" style="display: none;">

    <!-- ADD MODAL -->
    <div class="liquid-modal-overlay" id="addModal" data-modal="true">
        <div class="liquid-modal">
            <div class="liquid-modal-header primary">
                <h5 class="liquid-modal-title">
                    <i class="fas fa-plus-circle"></i>Tambah Jenis Pelanggaran
                </h5>
                <button type="button" class="liquid-modal-close" onclick="closeModal('addModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="addForm">
                <div class="liquid-modal-body">
                    <div class="form-group-pelanggaran">
                        <label>Nama Pelanggaran <span class="required">*</span></label>
                        <input type="text" class="form-input-pelanggaran" id="addName" required placeholder="Contoh: Merokok di area sekolah">
                    </div>
                    <div class="form-group-pelanggaran">
                        <label>Point <span class="required">*</span></label>
                        <input type="number" class="form-input-pelanggaran" id="addPoint" min="1" required placeholder="Contoh: 10">
                    </div>
                </div>
                <div class="liquid-modal-footer">
                    <button type="button" class="btn-modal-cancel" onclick="closeModal('addModal')">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn-modal-submit">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- EDIT MODAL -->
    <div class="liquid-modal-overlay" id="editModal" data-modal="true">
        <div class="liquid-modal">
            <div class="liquid-modal-header warning">
                <h5 class="liquid-modal-title">
                    <i class="fas fa-edit"></i>Edit Jenis Pelanggaran
                </h5>
                <button type="button" class="liquid-modal-close" onclick="closeModal('editModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editForm">
                <div class="liquid-modal-body">
                    <input type="hidden" id="editId">
                    <div class="form-group-pelanggaran">
                        <label>Nama Pelanggaran <span class="required">*</span></label>
                        <input type="text" class="form-input-pelanggaran" id="editName" required placeholder="Contoh: Merokok di area sekolah">
                    </div>
                    <div class="form-group-pelanggaran">
                        <label>Point <span class="required">*</span></label>
                        <input type="number" class="form-input-pelanggaran" id="editPoint" min="1" required placeholder="Contoh: 10">
                    </div>
                </div>
                <div class="liquid-modal-footer">
                    <button type="button" class="btn-modal-cancel" onclick="closeModal('editModal')">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn-modal-submit warning">
                        <i class="fas fa-save me-2"></i>Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- DELETE MODAL -->
    <div class="liquid-modal-overlay" id="deleteModal" data-modal="true">
        <div class="liquid-modal" style="max-width: 400px;">
            <div class="liquid-modal-header danger">
                <h5 class="liquid-modal-title">
                    <i class="fas fa-exclamation-triangle"></i>Hapus Jenis Pelanggaran
                </h5>
                <button type="button" class="liquid-modal-close" onclick="closeModal('deleteModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="liquid-modal-body">
                <input type="hidden" id="deleteId">
                <div class="modal-warning-box">
                    <i class="fas fa-exclamation-triangle modal-warning-icon"></i>
                    <h4 class="modal-warning-title">Apakah Anda Yakin?</h4>
                    <p class="modal-warning-text">
                        Jenis pelanggaran <strong id="deleteName"></strong> akan dihapus permanen.
                        <br><small style="color: rgba(255,255,255,0.5); display: block; margin-top: 10px;">
                            <i class="fas fa-info-circle"></i> Data tidak dapat dikembalikan
                        </small>
                    </p>
                </div>
            </div>
            <div class="liquid-modal-footer" style="justify-content: center;">
                <button type="button" class="btn-modal-cancel" onclick="closeModal('deleteModal')">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <button type="button" class="btn-modal-submit danger" id="confirmDelete">
                    <i class="fas fa-trash me-2"></i>Hapus
                </button>
            </div>
        </div>
    </div>

</div><!-- END MODAL PORTAL SOURCE -->

<!-- Bootstrap + DataTables CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
// ═══════════════════════════════════════════════════════════════════════════
// MODAL PORTAL SYSTEM - MEMINDAHKAN MODAL KE BODY UNTUK AVOID STACKING CONTEXT
// ═══════════════════════════════════════════════════════════════════════════

// Global variable untuk track modal yang sudah dipindahkan
window.modalsPorted = window.modalsPorted || false;

function initModalPortal() {
    // Hindari double initialization
    if (window.modalsPorted) return;
    window.modalsPorted = true;

    // Cari container sumber
    var sourceContainer = document.getElementById('modal-portal-source');
    if (!sourceContainer) {
        console.error('Modal portal source not found');
        return;
    }

    // Buat container di body untuk modal
    var portalContainer = document.createElement('div');
    portalContainer.id = 'modal-portal-destination';
    portalContainer.className = 'modal-portal-container';
    // Pastikan container ini tidak membuat stacking context baru
    portalContainer.style.cssText = 'position: static; z-index: auto; transform: none; filter: none;';

    // Pindahkan semua modal ke body
    var modals = sourceContainer.querySelectorAll('[data-modal="true"]');
    modals.forEach(function(modal) {
        // Clone modal untuk memastikan event listeners tetap berfungsi
        var clonedModal = modal.cloneNode(true);
        portalContainer.appendChild(clonedModal);
    });

    // Append ke body (di luar semua container)
    document.body.appendChild(portalContainer);

    // Hapus source container
    sourceContainer.remove();

    console.log('Modal portal initialized: ' + modals.length + ' modals moved to body');

    // Re-attach event listeners untuk modal yang sudah dipindahkan
    reattachModalEventListeners();
}

function reattachModalEventListeners() {
    // Close button click
    document.querySelectorAll('.liquid-modal-close, .btn-modal-cancel').forEach(function(btn) {
        // Remove old listeners (if any) by cloning
        var newBtn = btn.cloneNode(true);
        btn.parentNode.replaceChild(newBtn, btn);

        // Add new listener
        newBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var modalOverlay = this.closest('.liquid-modal-overlay');
            if (modalOverlay) {
                closeModal(modalOverlay.id);
            }
        });
    });

    // Prevent modal content click from closing
    document.querySelectorAll('.liquid-modal').forEach(function(modal) {
        modal.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });

    // Close on overlay click
    document.querySelectorAll('.liquid-modal-overlay').forEach(function(overlay) {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal(this.id);
            }
        });
    });
}

// ═══════════════════════════════════════════════════════════════════════════
// MODAL FUNCTIONS
// ═══════════════════════════════════════════════════════════════════════════

function openModal(modalId) {
    // Pastikan portal sudah diinisialisasi
    if (!window.modalsPorted) {
        initModalPortal();
    }

    var overlay = document.getElementById(modalId);
    if (!overlay) {
        console.error('Modal not found: ' + modalId);
        return;
    }

    // Reset scroll
    overlay.scrollTop = 0;

    // Show modal
    overlay.classList.add('active');

    // Prevent body scroll
    document.body.style.overflow = 'hidden';

    // Focus trap (optional)
    setTimeout(function() {
        var firstInput = overlay.querySelector('input, select, textarea');
        if (firstInput) firstInput.focus();
    }, 100);
}

function closeModal(modalId) {
    var overlay = document.getElementById(modalId);
    if (!overlay) return;

    overlay.classList.remove('active');
    document.body.style.overflow = '';

    // Reset form jika add modal
    if (modalId === 'addModal') {
        var form = overlay.querySelector('form');
        if (form) {
            setTimeout(function() { form.reset(); }, 300);
        }
    }
}

// Escape key handler
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.liquid-modal-overlay.active').forEach(function(modal) {
            closeModal(modal.id);
        });
    }
});

// ════════════════════════════════════════════════════════
// TOAST NOTIFICATION
// ════════════════════════════════════════════════════════
function showToast(msg, type) {
    type = type || 'success';
    var bg   = type === 'success' ? 'success' : 'error';
    var icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
    var html =
        '<div class="toast toast-pelanggaran align-items-center ' + bg + ' border-0" role="alert">' +
            '<div class="d-flex">' +
                '<div class="toast-body">' +
                    '<i class="fas ' + icon + ' me-2"></i>' + msg +
                '</div>' +
                '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>' +
            '</div>' +
        '</div>';
    $('body').append(html);
    var el = $('.toast').last();
    new bootstrap.Toast(el[0], { delay: 4000 }).show();
    el.on('hidden.bs.toast', function() { $(this).remove(); });
}

// ════════════════════════════════════════════════════════
// DOCUMENT READY
// ════════════════════════════════════════════════════════
$(document).ready(function() {

    // Inisialisasi modal portal segera
    initModalPortal();

    // ── DataTable ──────────────────────────────────────
    let table = $('#jenisTable').DataTable({
        ajax: {
            url: 'action_jenis.php?action=read',
            dataSrc: ''
        },
        columns: [
            {
                data: null,
                orderable: false,
                className: 'text-center',
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { 
                data: 'name',
                className: 'align-middle'
            },
            { 
                data: 'point',
                className: 'text-center align-middle',
                render: function(data) {
                    return '<span class="point-badge">' + data + ' Point</span>';
                }
            },
            {
                data: null,
                orderable: false,
                className: 'text-center align-middle',
                render: function (data) {
                    return '<div class="d-flex justify-content-center gap-2 flex-wrap">' +
                        '<button class="btn btn-action-edit btn-sm" onclick="editData(' + data.id + ', \'' + data.name.replace(/'/g, "\\'") + '\', ' + data.point + ')" title="Edit">' +
                            '<i class="fas fa-edit"></i>' +
                        '</button>' +
                        '<button class="btn btn-action-delete btn-sm" onclick="deleteData(' + data.id + ', \'' + data.name.replace(/'/g, "\\'") + '\')" title="Hapus">' +
                            '<i class="fas fa-trash"></i>' +
                        '</button>' +
                    '</div>';
                }
            }
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
            paginate: {
                first: '<i class="fas fa-angle-double-left"></i>',
                previous: '<i class="fas fa-angle-left"></i>',
                next: '<i class="fas fa-angle-right"></i>',
                last: '<i class="fas fa-angle-double-right"></i>'
            }
        },
        pageLength: 25,
        order: [[1, 'asc']],
        responsive: true,
        autoWidth: false
    });

    // ── Form Submissions ─────────────────────────────
    
    // Add form
    $(document).on('submit', '#addForm', function(e) {
        e.preventDefault();
        var $btn = $(this).find('[type=submit]');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...');

        $.post('action_jenis.php', {
            action: 'add',
            name: $('#addName').val(),
            point: $('#addPoint').val()
        }).done(function(response) {
            if (response.success) {
                closeModal('addModal');
                table.ajax.reload();
                showToast('Jenis pelanggaran berhasil ditambahkan!', 'success');
            } else {
                showToast('Error: ' + response.message, 'error');
            }
        }).fail(function() {
            showToast('Koneksi gagal', 'error');
        }).always(function() {
            $btn.prop('disabled', false).html('<i class="fas fa-save me-2"></i>Simpan');
        });
    });

    // Edit form
    $(document).on('submit', '#editForm', function(e) {
        e.preventDefault();
        var $btn = $(this).find('[type=submit]');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...');

        $.post('action_jenis.php', {
            action: 'edit',
            id: $('#editId').val(),
            name: $('#editName').val(),
            point: $('#editPoint').val()
        }).done(function(response) {
            if (response.success) {
                closeModal('editModal');
                table.ajax.reload();
                showToast('Jenis pelanggaran berhasil diupdate!', 'success');
            } else {
                showToast('Error: ' + response.message, 'error');
            }
        }).fail(function() {
            showToast('Koneksi gagal', 'error');
        }).always(function() {
            $btn.prop('disabled', false).html('<i class="fas fa-save me-2"></i>Update');
        });
    });

    // Delete confirm
    $(document).on('click', '#confirmDelete', function() {
        var $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Menghapus...');

        $.post('action_jenis.php', {
            action: 'delete',
            id: $('#deleteId').val()
        }).done(function(response) {
            if (response.success) {
                closeModal('deleteModal');
                table.ajax.reload();
                showToast('Jenis pelanggaran berhasil dihapus!', 'success');
            } else {
                showToast('Error: ' + response.message, 'error');
            }
        }).fail(function() {
            showToast('Koneksi gagal', 'error');
        }).always(function() {
            $btn.prop('disabled', false).html('<i class="fas fa-trash me-2"></i>Hapus');
        });
    });

}); // END ready

// Edit function (global scope)
function editData(id, name, point) {
    $('#editId').val(id);
    $('#editName').val(name);
    $('#editPoint').val(point);
    openModal('editModal');
}

// Delete function (global scope)
function deleteData(id, name) {
    $('#deleteId').val(id);
    $('#deleteName').text(name);
    openModal('deleteModal');
}
</script>

<?php $this->stop() ?>
<?php $this->layout('layouts::app', ['title' => 'Data Kelas']) ?>

<?php $this->start('main') ?>

<style>
/* ============================================
   LIQUID GLASS THEME - KELAS PAGE (PORTAL VERSION)
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
   BASE STYLES (TANPA ISOLATION - KARENA MODAL DI BODY)
   ============================================ */

.container-custom {
    position: relative;
    z-index: 1;
}

/* ============================================
   PAGE HEADER
   ============================================ */

.page-header-kelas {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.page-title-kelas {
    font-size: 28px;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 12px;
}

.page-title-kelas i {
    color: var(--emerald-light);
    filter: drop-shadow(0 0 10px rgba(52, 211, 153, 0.5));
}

.page-subtitle {
    color: var(--text-muted);
    font-size: 14px;
    margin-top: 4px;
}

/* Add Button */
.btn-add-kelas {
    background: linear-gradient(135deg, var(--emerald), var(--gold)) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    color: white !important;
    padding: 12px 24px !important;
    font-weight: 600;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(5, 150, 105, 0.3);
    transition: all 0.3s ease;
}

.btn-add-kelas:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 40px rgba(5, 150, 105, 0.4);
}

/* Table Card */
.table-card-kelas {
    background: var(--liquid-bg);
    backdrop-filter: var(--liquid-blur);
    border: 1px solid var(--liquid-border);
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 8px 32px var(--liquid-shadow);
}

.kelas-table-wrapper {
    padding: 24px;
}

/* Badges & Buttons */
.tingkat-badge {
    display: inline-flex;
    padding: 8px 16px;
    border-radius: 24px;
    font-weight: 600;
    font-size: 12px;
    text-transform: uppercase;
    border: 1px solid;
    backdrop-filter: blur(10px);
}

.tingkat-x { background: rgba(59, 130, 246, 0.25); border-color: rgba(59, 130, 246, 0.4); color: #60a5fa; }
.tingkat-xi { background: rgba(34, 197, 94, 0.25); border-color: rgba(34, 197, 94, 0.4); color: var(--emerald-light); }
.tingkat-xii { background: rgba(234, 179, 8, 0.25); border-color: rgba(234, 179, 8, 0.4); color: #facc15; }

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
   MODAL STYLES - AKAN DIPINDAHKAN KE BODY
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
    border-bottom: 1px rgba(255, 255, 255, 0.32);
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
.form-group-kelas { margin-bottom: 20px; }
.form-group-kelas label {
    display: block;
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 8px;
    color: rgba(255, 255, 255, 0.9);
}
.form-group-kelas label .required { color: #ff6b6b; margin-left: 4px; }

.form-input-kelas, .form-select-kelas {
    width: 100%;
    padding: 14px 18px;
    background: rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 14px;
    color: white;
    font-size: 15px;
    transition: all 0.3s ease;
}

.form-input-kelas:focus, .form-select-kelas:focus {
    outline: none;
    border-color: var(--emerald-light);
    box-shadow: 0 0 0 3px rgba(52, 211, 153, 0.1);
}

.form-select-kelas option { background: #1e293b; color: white; }

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
.toast-kelas {
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
.toast-kelas.success { background: rgba(34, 197, 94, 0.9); border-color: rgba(34, 197, 94, 0.4); color: white; }
.toast-kelas.error { background: rgba(220, 38, 38, 0.9); border-color: rgba(220, 38, 38, 0.4); color: white; }

/* Responsive */
@media (max-width: 768px) {
    .page-header-kelas { flex-direction: column; gap: 16px; align-items: flex-start; }
    .page-title-kelas { font-size: 24px; }
    .btn-add-kelas { width: 100%; justify-content: center; }
    .kelas-table-wrapper { padding: 16px; }
    .liquid-modal { margin-top: 20px; width: 95%; border-radius: 20px; }
    .liquid-modal-header { padding: 18px 20px; }
    .liquid-modal-body { padding: 20px; }
    .liquid-modal-footer { padding: 16px 20px; flex-direction: column-reverse; }
    .btn-modal-cancel, .btn-modal-submit { width: 100%; justify-content: center; }
}
</style>

<div class="container-custom">
    <!-- HEADER -->
    <div class="page-header-kelas">
        <div>
            <h1 class="page-title-kelas">
                <i class="fas fa-school"></i>Data Kelas
            </h1>
            <p class="page-subtitle">Kelola data kelas (tingkat, jurusan, nama kelas)</p>
        </div>
        <button class="btn btn-add-kelas" onclick="openModal('addModal')">
            <i class="fas fa-plus"></i>Tambah Kelas
        </button>
    </div>

    <!-- TABLE -->
    <div class="table-card-kelas">
        <div class="kelas-table-wrapper">
            <table id="kelasTable" class="display responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th width="8%" class="text-center">No</th>
                        <th width="15%" class="text-center">Tingkat</th>
                        <th width="30%">Jurusan</th>
                        <th width="25%">Kelas</th>
                        <th width="22%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- 
  MODALS - DITEMPATKAN DI SINI SEMENTARA, AKAN DIPINDAHKAN KE BODY VIA JAVASCRIPT
-->


<div id="modal-portal-source" style="display: none;">

    <!-- ADD MODAL -->
    <div class="liquid-modal-overlay" id="addModal" data-modal="true">
        <div class="liquid-modal">
            <div class="liquid-modal-header primary">
                <h5 class="liquid-modal-title">
                    <i class="fas fa-plus-circle"></i>Tambah Kelas Baru
                </h5>
                <button type="button" class="liquid-modal-close" onclick="closeModal('addModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="addForm">
                <div class="liquid-modal-body">
                    <div class="form-group-kelas">
                        <label>Tingkat <span class="required">*</span></label>
                        <select class="form-select-kelas" id="addTingkat" required>
                            <option value="">-- Pilih Tingkat --</option>
                            <option value="X">X (Kelas 10)</option>
                            <option value="XI">XI (Kelas 11)</option>
                            <option value="XII">XII (Kelas 12)</option>
                        </select>
                    </div>
                    <div class="form-group-kelas">
                        <label>Jurusan <span class="required">*</span></label>
                        <input type="text" class="form-input-kelas" id="addJurusan" required placeholder="Contoh: RPL, TKJ, Multimedia">
                    </div>
                    <div class="form-group-kelas">
                        <label>Kelas <span class="required">*</span></label>
                        <input type="text" class="form-input-kelas" id="addKelas" required placeholder="Contoh: A, B, C atau 1, 2, 3">
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
                    <i class="fas fa-edit"></i>Edit Kelas
                </h5>
                <button type="button" class="liquid-modal-close" onclick="closeModal('editModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editForm">
                <div class="liquid-modal-body">
                    <input type="hidden" id="editId">
                    <div class="form-group-kelas">
                        <label>Tingkat <span class="required">*</span></label>
                        <select class="form-select-kelas" id="editTingkat" required>
                            <option value="X">X (Kelas 10)</option>
                            <option value="XI">XI (Kelas 11)</option>
                            <option value="XII">XII (Kelas 12)</option>
                        </select>
                    </div>
                    <div class="form-group-kelas">
                        <label>Jurusan <span class="required">*</span></label>
                        <input type="text" class="form-input-kelas" id="editJurusan" required placeholder="Contoh: RPL, TKJ, Multimedia">
                    </div>
                    <div class="form-group-kelas">
                        <label>Kelas <span class="required">*</span></label>
                        <input type="text" class="form-input-kelas" id="editKelas" required placeholder="Contoh: A, B, C atau 1, 2, 3">
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
                    <i class="fas fa-exclamation-triangle"></i>Hapus Kelas
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
                        Kelas <strong id="deleteName"></strong> akan dihapus permanen.
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

    <!-- DELETE MODAL -->
<div class="liquid-modal-overlay" id="deleteModal" data-modal="true">
    <div class="liquid-modal" style="max-width: 400px;">
        <div class="liquid-modal-header danger">
            <h5 class="liquid-modal-title">
                <i class="fas fa-exclamation-triangle"></i>Hapus Kelas
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
                    Kelas <strong id="deleteName"></strong> akan dihapus permanen.
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
// TINGKAT BADGE HELPER
// ════════════════════════════════════════════════════════
function tingkatBadge(tingkat) {
    var cls = { 'X': 'tingkat-x', 'XI': 'tingkat-xi', 'XII': 'tingkat-xii' }[tingkat] || 'tingkat-x';
    var label = { 'X': 'X', 'XI': 'XI', 'XII': 'XII' }[tingkat] || tingkat;
    return '<span class="tingkat-badge ' + cls + '">' + label + '</span>';
}

// ════════════════════════════════════════════════════════
// TOAST NOTIFICATION
// ════════════════════════════════════════════════════════
function showToast(msg, type) {
    type = type || 'success';
    var bg   = type === 'success' ? 'success' : 'error';
    var icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
    var html =
        '<div class="toast toast-kelas align-items-center ' + bg + ' border-0" role="alert">' +
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
    var table = $('#kelasTable').DataTable({
        ajax: {
            url: 'action_kelas.php?action=read',
            dataSrc: '',
            error: function() { showToast('Gagal load data kelas!', 'error'); }
        },
        columns: [
            {
                data: null, orderable: false, className: 'text-center',
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                data: 'tingkat', className: 'text-center align-middle',
                render: function(data) { return tingkatBadge(data); }
            },
            { data: 'jurusan', className: 'align-middle' },
            { data: 'kelas', className: 'align-middle' },
            {
                data: null, orderable: false, className: 'text-center align-middle',
                render: function(data, type, row) {
                    var id = row.id;
                    var name = $('<div>').text(row.tingkat + ' ' + row.jurusan + ' ' + row.kelas).html();
                    return '<div class="d-flex justify-content-center gap-2 flex-wrap">' +
                        '<button class="btn btn-action-edit btn-sm" onclick="editKelas(' + id + ')" title="Edit">' +
                            '<i class="fas fa-edit"></i></button>' +
                        '<button class="btn btn-action-delete btn-sm" onclick="confirmDeleteKelas(' + id + ', \'' + name + '\')" title="Hapus">' +
                            '<i class="fas fa-trash"></i></button>' +
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
        pageLength: 10,
        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Semua"]],
        responsive: true,
        autoWidth: false,
        order: [[1, 'asc'], [2, 'asc']]
    });

    // ── Form Submissions ─────────────────────────────
    
    // ADD FORM
    $('#addForm').on('submit', function(e) {
        e.preventDefault();
        var $btn = $(this).find('[type=submit]');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...');

        $.post('action_kelas.php', {
            action: 'add',
            tingkat: $('#addTingkat').val(),
            jurusan: $('#addJurusan').val().trim(),
            kelas: $('#addKelas').val().trim()
        }).done(function(res) {
            if (res.success) {
                closeModal('addModal');
                $('#addForm')[0].reset();
                table.ajax.reload(null, false);
                showToast('Kelas berhasil ditambahkan!', 'success');
            } else {
                showToast(res.message || 'Gagal menambah kelas', 'error');
            }
        }).fail(function() {
            showToast('Koneksi gagal', 'error');
        }).always(function() {
            $btn.prop('disabled', false).html('<i class="fas fa-save me-2"></i>Simpan');
        });
    });

    // EDIT FORM
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        var $btn = $(this).find('[type=submit]');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...');

        $.post('action_kelas.php', {
            action: 'edit',
            id: $('#editId').val(),
            tingkat: $('#editTingkat').val(),
            jurusan: $('#editJurusan').val().trim(),
            kelas: $('#editKelas').val().trim()
        }).done(function(res) {
            if (res.success) {
                closeModal('editModal');
                table.ajax.reload(null, false);
                showToast('Kelas berhasil diupdate!', 'success');
            } else {
                showToast(res.message || 'Gagal update kelas', 'error');
            }
        }).fail(function() {
            showToast('Koneksi gagal', 'error');
        }).always(function() {
            $btn.prop('disabled', false).html('<i class="fas fa-save me-2"></i>Update');
        });
    });

    // DELETE CONFIRM BUTTON
    $('#confirmDelete').on('click', function() {
        var id   = $('#deleteId').val();
        if (!id) {
            showToast('ID tidak valid', 'error');
            return;
        }
        
        var $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Menghapus...');

        $.post('action_kelas.php', { 
            action: 'delete', 
            id: id 
        }).done(function(res) {
            if (res.success) {
                closeModal('deleteModal');
                table.ajax.reload(null, false);
                showToast(res.message || 'Kelas berhasil dihapus!', 'success');
            } else {
                showToast(res.message || 'Gagal hapus kelas', 'error');
            }
        }).fail(function(xhr) {
            showToast('Koneksi gagal: ' + xhr.statusText, 'error');
        }).always(function() {
            $btn.prop('disabled', false).html('<i class="fas fa-trash me-2"></i>Hapus');
        });
    });

}); // END ready

// ════════════════════════════════════════════════════════
// GLOBAL FUNCTIONS (Outside document.ready)
// ════════════════════════════════════════════════════════

function tingkatBadge(tingkat) {
    var cls = { 'X': 'tingkat-x', 'XI': 'tingkat-xi', 'XII': 'tingkat-xii' }[tingkat] || 'tingkat-x';
    var label = { 'X': 'X', 'XI': 'XI', 'XII': 'XII' }[tingkat] || tingkat;
    return '<span class="tingkat-badge ' + cls + '">' + label + '</span>';
}

function editKelas(id) {
    $.get('action_kelas.php?action=get&id=' + id)
        .done(function(data) {
            if (!data || !data.id) {
                showToast('Data tidak ditemukan', 'error');
                return;
            }
            $('#editId').val(data.id);
            $('#editTingkat').val(data.tingkat || '');
            $('#editJurusan').val(data.jurusan || '');
            $('#editKelas').val(data.kelas || '');
            openModal('editModal');
        })
        .fail(function() { showToast('Gagal memuat data', 'error'); });
}

function confirmDeleteKelas(id, name) {
    $('#deleteId').val(id);
    $('#deleteName').text(name);
    openModal('deleteModal');
}// END ready
</script>

<?php $this->stop() ?>
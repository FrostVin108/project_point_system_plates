<?php $this->layout('layouts::app', ['title' => 'Alasan Pelanggaran']) ?>

<?php $this->start('main') ?>

<style>
/* ============================================
   LIQUID GLASS THEME - ALASAN PELANGGARAN PAGE
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
    --danger: #dc2626;
    --danger-light: #ef4444;
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

.page-header-alasan {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.page-title-alasan {
    font-size: 28px;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 12px;
    color: #ffffff !important;
}

.page-title-alasan i {
    color: var(--danger-light);
    filter: drop-shadow(0 0 10px rgba(239, 68, 68, 0.5));
}

.page-subtitle {
    color: var(--text-muted);
    font-size: 14px;
    margin-top: 4px;
}

/* Add Button */
.btn-add-alasan {
    background: linear-gradient(135deg, var(--danger), #f97316) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    color: white !important;
    padding: 12px 24px !important;
    font-weight: 600;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(220, 38, 38, 0.3);
    transition: all 0.3s ease;
}

.btn-add-alasan:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 40px rgba(220, 38, 38, 0.4);
}

/* Table Card */
.table-card-alasan {
    background: var(--liquid-bg);
    backdrop-filter: var(--liquid-blur);
    border: 1px solid var(--liquid-border);
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 8px 32px var(--liquid-shadow);
}

.alasan-table-wrapper {
    padding: 24px;
}

/* Jenis Badge */
.jenis-badge {
    display: inline-flex;
    padding: 8px 16px;
    border-radius: 24px;
    font-weight: 600;
    font-size: 12px;
    background: linear-gradient(135deg, rgba(220, 38, 38, 0.3), rgba(239, 68, 68, 0.2));
    border: 1px solid rgba(220, 38, 38, 0.4);
    color: #fca5a5;
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.2);
}

/* Detail Text */
.detail-text-alasan {
    background: rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    padding: 12px 16px;
    color: rgba(255, 255, 255, 0.9);
    font-size: 14px;
    line-height: 1.6;
    max-height: 80px;
    overflow-y: auto;
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

.modal-portal-container {
    position: relative;
    z-index: 1;
}

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

.liquid-modal.large {
    max-width: 800px;
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
    max-height: 60vh;
    overflow-y: auto;
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
.form-group-alasan { margin-bottom: 20px; }
.form-group-alasan label {
    display: block;
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 8px;
    color: rgba(255, 255, 255, 0.9);
}
.form-group-alasan label .required { color: #ff6b6b; margin-left: 4px; }

.form-input-alasan, .form-select-alasan, .form-textarea-alasan {
    width: 100%;
    padding: 14px 18px;
    background: rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 14px;
    color: white;
    font-size: 15px;
    transition: all 0.3s ease;
}

.form-input-alasan:focus, .form-select-alasan:focus, .form-textarea-alasan:focus {
    outline: none;
    border-color: var(--emerald-light);
    box-shadow: 0 0 0 3px rgba(52, 211, 153, 0.1);
}

.form-textarea-alasan {
    resize: vertical;
    min-height: 100px;
}

.form-select-alasan option { background: #1e293b; color: white; }

.form-hint {
    color: rgba(255, 255, 255, 0.5);
    font-size: 12px;
    margin-top: 6px;
}

/* Detail Container */
.detail-container {
    max-height: 300px;
    overflow-y: auto;
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    padding: 16px;
    background: rgba(0, 0, 0, 0.15);
}

.input-row {
    margin-bottom: 16px;
    padding: 16px;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    transition: all 0.3s ease;
}

.input-row.temporary {
    background: rgba(255, 255, 255, 0.05);
    border-color: rgba(255, 255, 255, 0.15);
}

.input-row-number {
    color: var(--emerald-light);
    font-weight: 700;
    margin-bottom: 8px;
    display: block;
}

.btn-remove-row {
    background: rgba(220, 38, 38, 0.2);
    border: 1px solid rgba(220, 38, 38, 0.4);
    color: #fca5a5;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-remove-row:hover:not(:disabled) {
    background: rgba(220, 38, 38, 0.4);
    transform: scale(1.1);
}

.btn-remove-row:disabled {
    opacity: 0.3;
    cursor: not-allowed;
}

.btn-add-row {
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(52, 211, 153, 0.1));
    border: 1px solid rgba(52, 211, 153, 0.4);
    color: var(--emerald-light);
    padding: 12px 24px;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
    margin-top: 12px;
}

.btn-add-row:hover {
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(52, 211, 153, 0.2));
    transform: translateY(-2px);
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
.toast-alasan {
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
.toast-alasan.success { background: rgba(34, 197, 94, 0.9); border-color: rgba(34, 197, 94, 0.4); color: white; }
.toast-alasan.error { background: rgba(220, 38, 38, 0.9); border-color: rgba(220, 38, 38, 0.4); color: white; }

/* DataTable Customization */
#alasanTable tbody tr {
    background: transparent;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

#alasanTable.dataTable thead th {
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.8);
    font-weight: 600;
}

#alasanTable.dataTable tbody td {
    color: rgba(255, 255, 255, 0.9);
}

/* Responsive */
@media (max-width: 768px) {
    .page-header-alasan { flex-direction: column; gap: 16px; align-items: flex-start; }
    .page-title-alasan { font-size: 24px; }
    .btn-add-alasan { width: 100%; justify-content: center; }
    .alasan-table-wrapper { padding: 16px; }
    .liquid-modal { margin-top: 20px; width: 95%; border-radius: 20px; }
    .liquid-modal.large { max-width: 95%; }
    .liquid-modal-header { padding: 18px 20px; }
    .liquid-modal-body { padding: 20px; max-height: 70vh; }
    .liquid-modal-footer { padding: 16px 20px; flex-direction: column-reverse; }
    .btn-modal-cancel, .btn-modal-submit { width: 100%; justify-content: center; }
    .detail-container { max-height: 250px; }
}
</style>

<div class="container-custom">
    <!-- HEADER -->
    <div class="page-header-alasan">
        <div>
            <h1 class="page-title-alasan">
                <i class="fas fa-list-alt"></i>Alasan Pelanggaran
            </h1>
            <p class="page-subtitle">Kelola data alasan pelanggaran siswa</p>
        </div>
        <button class="btn btn-add-alasan" onclick="openModal('addModal')">
            <i class="fas fa-plus"></i>Tambah Alasan
        </button>
    </div>

    <!-- TABLE -->
    <div class="table-card-alasan">
        <div class="alasan-table-wrapper">
            <table id="alasanTable" class="display responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th width="8%" class="text-center">No</th>
                        <th width="25%">Jenis Pelanggaran</th>
                        <th width="47%">Detail Alasan</th>
                        <th width="20%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODALS -->
<div id="modal-portal-source" style="display: none;">

    <!-- ADD MODAL -->
    <div class="liquid-modal-overlay" id="addModal" data-modal="true">
        <div class="liquid-modal large">
            <div class="liquid-modal-header danger">
                <h5 class="liquid-modal-title">
                    <i class="fas fa-plus-circle"></i>Tambah Alasan Pelanggaran
                </h5>
                <button type="button" class="liquid-modal-close" onclick="closeModal('addModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="multiForm">
                <div class="liquid-modal-body">
                    <div class="form-group-alasan">
                        <label>Jenis Pelanggaran <span class="required">*</span></label>
                        <select class="form-select-alasan" id="id_jenis_pelanggaran" required>
                            <option value="">-- Pilih Jenis Pelanggaran --</option>
                            <?php
                            try {
                                include 'database.php';
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

                    <div class="form-group-alasan">
                        <label>Detail Alasan <span class="required">*</span></label>
                        <div class="detail-container" id="detailContainer">
                            <div class="input-row temporary" id="row-1">
                                <span class="input-row-number">Alasan #1</span>
                                <div style="display: flex; gap: 12px;">
                                    <textarea class="form-textarea-alasan detail-input" name="detail[]" rows="3" 
                                        placeholder="Ketik alasan pelanggaran..." maxlength="500" required></textarea>
                                    <button type="button" class="btn-remove-row" disabled onclick="removeRow(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <div class="form-hint">Maks 500 karakter</div>
                            </div>
                        </div>
                        <button type="button" class="btn-add-row" id="addRowBtn" style="display: none;" onclick="addNewRow()">
                            <i class="fas fa-plus-circle me-2"></i>Tambah Detail Lagi
                        </button>
                    </div>
                </div>
                <div class="liquid-modal-footer">
                    <button type="button" class="btn-modal-cancel" onclick="closeModal('addModal')">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn-modal-submit danger" id="submitBtn" disabled>
                        <i class="fas fa-save me-2"></i>Simpan Semua
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- EDIT MODAL -->
    <div class="liquid-modal-overlay" id="editModal" data-modal="true">
        <div class="liquid-modal large">
            <div class="liquid-modal-header warning">
                <h5 class="liquid-modal-title">
                    <i class="fas fa-edit"></i>Edit Alasan Pelanggaran
                </h5>
                <button type="button" class="liquid-modal-close" onclick="closeModal('editModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editForm">
                <div class="liquid-modal-body">
                    <input type="hidden" id="editId">
                    
                    <div class="form-group-alasan">
                        <label>Jenis Pelanggaran <span class="required">*</span></label>
                        <select class="form-select-alasan" id="edit_jenis_pelanggaran" required>
                            <option value="">-- Pilih Jenis Pelanggaran --</option>
                            <?php
                            try {
                                include 'database.php';
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

                    <div class="form-group-alasan">
                        <label>Detail Alasan <span class="required">*</span></label>
                        <textarea class="form-textarea-alasan" id="edit_detail" rows="5" 
                            placeholder="Ketik alasan pelanggaran..." maxlength="500" required></textarea>
                        <div class="form-hint">Maks 500 karakter</div>
                    </div>
                </div>
                <div class="liquid-modal-footer">
                    <button type="button" class="btn-modal-cancel" onclick="closeModal('editModal')">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn-modal-submit warning" id="editSubmitBtn" disabled>
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
                    <i class="fas fa-exclamation-triangle"></i>Hapus Alasan
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
                        Alasan ini akan dihapus <strong>PERMANEN</strong>!
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

</div>

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
// GLOBAL VARIABLES - PERBAIKAN UTAMA
// ═══════════════════════════════════════════════════════════════════════════
window.modalsPorted = false;
window.deleteId = null;
window.table = null;
window.rowCount = 1;

// ═══════════════════════════════════════════════════════════════════════════
// MODAL PORTAL SYSTEM
// ═══════════════════════════════════════════════════════════════════════════

function initModalPortal() {
    if (window.modalsPorted) return;
    window.modalsPorted = true;

    var sourceContainer = document.getElementById('modal-portal-source');
    if (!sourceContainer) {
        console.error('Modal portal source not found');
        return;
    }

    var portalContainer = document.createElement('div');
    portalContainer.id = 'modal-portal-destination';
    portalContainer.className = 'modal-portal-container';
    portalContainer.style.cssText = 'position: static; z-index: auto; transform: none; filter: none;';

    var modals = sourceContainer.querySelectorAll('[data-modal="true"]');
    modals.forEach(function(modal) {
        var clonedModal = modal.cloneNode(true);
        portalContainer.appendChild(clonedModal);
    });

    document.body.appendChild(portalContainer);
    sourceContainer.remove();

    console.log('Modal portal initialized: ' + modals.length + ' modals moved to body');
}

// ═══════════════════════════════════════════════════════════════════════════
// MODAL FUNCTIONS
// ═══════════════════════════════════════════════════════════════════════════

function openModal(modalId) {
    if (!window.modalsPorted) {
        initModalPortal();
    }

    var overlay = document.getElementById(modalId);
    if (!overlay) {
        console.error('Modal not found: ' + modalId);
        return;
    }

    overlay.scrollTop = 0;
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';

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

    if (modalId === 'addModal') {
        resetForm();
    }
    if (modalId === 'editModal') {
        $('#editId').val('');
        $('#edit_jenis_pelanggaran').val('').trigger('change');
        $('#edit_detail').val('');
        updateEditSubmitButton();
    }
    if (modalId === 'deleteModal') {
        window.deleteId = null;
        $('#deleteId').val('');
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
        '<div class="toast toast-alasan align-items-center ' + bg + ' border-0" role="alert">' +
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
// FORM FUNCTIONS
// ════════════════════════════════════════════════════════

function addNewRow() {
    window.rowCount++;
    var newRow = document.createElement('div');
    newRow.className = 'input-row';
    newRow.id = 'row-' + window.rowCount;
    newRow.innerHTML = 
        '<span class="input-row-number">Alasan #' + window.rowCount + '</span>' +
        '<div style="display: flex; gap: 12px;">' +
            '<textarea class="form-textarea-alasan detail-input" name="detail[]" rows="3" ' +
                'placeholder="Ketik alasan pelanggaran..." maxlength="500"></textarea>' +
            '<button type="button" class="btn-remove-row" onclick="removeRow(this)">' +
                '<i class="fas fa-trash"></i>' +
            '</button>' +
        '</div>' +
        '<div class="form-hint">Maks 500 karakter</div>';
    
    document.getElementById('detailContainer').appendChild(newRow);
    scrollToBottom();
    updateAddSubmitButton();
}

function removeRow(btn) {
    var row = btn.closest('.input-row');
    if (document.querySelectorAll('#detailContainer .input-row').length > 1) {
        row.remove();
        document.querySelectorAll('#detailContainer .input-row').forEach(function(r, index) {
            r.querySelector('.input-row-number').textContent = 'Alasan #' + (index + 1);
        });
        window.rowCount--;
        updateAddSubmitButton();
    }
}

function scrollToBottom() {
    var container = document.getElementById('detailContainer');
    container.scrollTop = container.scrollHeight;
}

function getValidDetails() {
    var details = [];
    document.querySelectorAll('.detail-input').forEach(function(input) {
        var val = input.value.trim();
        if (val.length > 0) details.push(val);
    });
    return details;
}

function updateAddSubmitButton() {
    var jenisSelected = document.getElementById('id_jenis_pelanggaran').value;
    var hasDetails = getValidDetails().length > 0;
    document.getElementById('submitBtn').disabled = !(jenisSelected && hasDetails);
}

function updateEditSubmitButton() {
    var jenisSelected = document.getElementById('edit_jenis_pelanggaran').value;
    var hasDetail = document.getElementById('edit_detail').value.trim().length > 0;
    document.getElementById('editSubmitBtn').disabled = !(jenisSelected && hasDetail);
}

function resetForm() {
    document.getElementById('detailContainer').innerHTML = 
        '<div class="input-row temporary" id="row-1">' +
            '<span class="input-row-number">Alasan #1</span>' +
            '<div style="display: flex; gap: 12px;">' +
                '<textarea class="form-textarea-alasan detail-input" name="detail[]" rows="3" ' +
                    'placeholder="Ketik alasan pelanggaran..." maxlength="500" required></textarea>' +
                '<button type="button" class="btn-remove-row" disabled onclick="removeRow(this)">' +
                    '<i class="fas fa-trash"></i>' +
                '</button>' +
            '</div>' +
            '<div class="form-hint">Maks 500 karakter</div>' +
        '</div>';
    document.getElementById('addRowBtn').style.display = 'none';
    document.getElementById('id_jenis_pelanggaran').value = '';
    window.rowCount = 1;
    updateAddSubmitButton();
}

// ════════════════════════════════════════════════════════
// CRUD FUNCTIONS
// ════════════════════════════════════════════════════════

function confirmDeleteAlasan(id) {
    window.deleteId = id;
    $('#deleteId').val(id);
    openModal('deleteModal');
}

// ════════════════════════════════════════════════════════
// DOCUMENT READY - SEMUA EVENT HANDLER DI SINI
// ════════════════════════════════════════════════════════
$(document).ready(function() {

    // Inisialisasi modal portal
    initModalPortal();

    // ── DataTable ──────────────────────────────────────
    window.table = $('#alasanTable').DataTable({
        ajax: {
            url: 'action_alasan.php?action=read',
            dataSrc: '',
            error: function() { showToast('Gagal load data!', 'error'); }
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
                data: 'jenis_pelanggarans',
                render: function(data) {
                    return '<span class="jenis-badge">' + (data || '-') + '</span>';
                }
            },
            {
                data: 'detail',
                render: function(data) {
                    return '<div class="detail-text-alasan">' + data + '</div>';
                }
            },
            {
                data: null,
                orderable: false,
                className: 'text-center',
                render: function (data) {
                    return '<div class="d-flex justify-content-center gap-2 flex-wrap">' +
                        '<button class="btn btn-action-edit btn-sm btn-edit-tbl" data-id="' + data.id + '" title="Edit">' +
                            '<i class="fas fa-edit"></i>' +
                        '</button>' +
                        '<button class="btn btn-action-delete btn-sm" onclick="confirmDeleteAlasan(' + data.id + ')" title="Hapus">' +
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
        order: [[0, 'desc']],
        responsive: true,
        autoWidth: false
    });

    // ── Event Handlers untuk Form Inputs ───────────────
    
    $(document).on('input', '.detail-input', function() {
        var $row = $(this).closest('.input-row');
        var value = $(this).val().trim();
        
        if (value && $row.hasClass('temporary')) {
            $row.removeClass('temporary');
            $row.find('.btn-remove-row').prop('disabled', false);
            document.getElementById('addRowBtn').style.display = 'block';
        }
        updateAddSubmitButton();
    });

    $('#id_jenis_pelanggaran').on('change', updateAddSubmitButton);
    $('#edit_jenis_pelanggaran, #edit_detail').on('change input', updateEditSubmitButton);

    // ── Edit Button Handler ───────────────────────────
    
    $(document).on('click', '.btn-edit-tbl', function() {
        var id = $(this).data('id');
        $.get('action_alasan.php?action=get&id=' + id)
            .done(function(data) {
                if (data.success) {
                    $('#editId').val(data.id);
                    $('#edit_jenis_pelanggaran').val(data.id_jenis_pelanggaran);
                    $('#edit_detail').val(data.detail);
                    updateEditSubmitButton();
                    openModal('editModal');
                } else {
                    showToast('Gagal load data edit!', 'error');
                }
            })
            .fail(function() {
                showToast('Gagal memuat data', 'error');
            });
    });

    // ── Form Submissions ─────────────────────────────
    
    // Add form
    $(document).on('submit', '#multiForm', function(e) {
        e.preventDefault();
        var details = getValidDetails();
        if (details.length === 0) {
            showToast('Minimal 1 detail alasan!', 'error');
            return;
        }

        var $btn = $('#submitBtn');
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
            success: function(response) {
                if (response.success) {
                    closeModal('addModal');
                    window.table.ajax.reload(null, false);
                    showToast(response.inserted + ' alasan berhasil disimpan!', 'success');
                } else {
                    showToast(response.message || 'Gagal menyimpan', 'error');
                }
            },
            error: function() {
                showToast('Koneksi gagal', 'error');
            },
            complete: function() {
                $btn.prop('disabled', false).html('<i class="fas fa-save me-2"></i>Simpan Semua');
            }
        });
    });

    // Edit form
    $(document).on('submit', '#editForm', function(e) {
        e.preventDefault();
        var $btn = $('#editSubmitBtn');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...');

        $.post('action_alasan.php', {
            action: 'update',
            id: $('#editId').val(),
            id_jenis_pelanggaran: $('#edit_jenis_pelanggaran').val(),
            detail: $('#edit_detail').val().trim()
        }).done(function(response) {
            if (response.success) {
                closeModal('editModal');
                window.table.ajax.reload(null, false);
                showToast('Alasan berhasil diupdate!', 'success');
            } else {
                showToast(response.message || 'Gagal update', 'error');
            }
        }).fail(function() {
            showToast('Koneksi gagal', 'error');
        }).always(function() {
            $btn.prop('disabled', false).html('<i class="fas fa-save me-2"></i>Update');
        });
    });

    // ════════════════════════════════════════════════════════
    // DELETE HANDLER - HANYA SATU INI
    // ════════════════════════════════════════════════════════
    
    $(document).on('click', '#confirmDelete', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var id = window.deleteId;
        if (!id) {
            showToast('ID tidak valid', 'error');
            return;
        }
        
        var $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Menghapus...');

        $.post('action_alasan.php', { 
            action: 'delete', 
            id: id 
        })
        .done(function(response) {
            if (response.success) {
                closeModal('deleteModal');
                window.table.ajax.reload(null, false);
                showToast('Alasan berhasil dihapus!', 'success');
            } else {
                showToast(response.message || 'Gagal menghapus data', 'error');
            }
        })
        .fail(function(xhr) {
            showToast('Koneksi gagal: ' + xhr.statusText, 'error');
        })
        .always(function() {
            $btn.prop('disabled', false).html('<i class="fas fa-trash me-2"></i>Hapus');
        });
    });

}); // END ready
</script>

<?php $this->stop() ?>
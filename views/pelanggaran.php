<?php $this->layout('layouts::app', ['title' => 'Pelanggaran']) ?>

<?php $this->start('main') ?>

<style>
/* ============================================
   LIQUID GLASS THEME - PELANGGARAN PAGE
   ============================================ */

:root {
    --liquid-bg: rgba(255, 255, 255, 0.05);
    --liquid-border: rgba(255, 255, 255, 0.15);
    --liquid-shadow: rgba(0, 0, 0, 0.4);
    --liquid-blur: blur(20px) saturate(180%);
    
    --primary: #3b82f6;
    --primary-light: #60a5fa;
    --danger: #dc2626;
    --danger-light: #ef4444;
    --success: #059669;
    --warning: #eab308;
    --text-primary: #ffffff;
    --text-muted: rgba(255, 255, 255, 0.6);
}

/* Base */
.container-custom {
    position: relative;
    z-index: 1;
}

/* Header */
.page-header-pelanggaran {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 16px;
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
    color: var(--danger-light);
    filter: drop-shadow(0 0 10px rgba(239, 68, 68, 0.5));
}

/* Buttons */
.btn-export-word {
    background: linear-gradient(135deg, var(--success), #10b981) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    color: white !important;
    padding: 12px 24px !important;
    font-weight: 600;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(5, 150, 105, 0.3);
    transition: all 0.3s ease;
}

.btn-export-word:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 40px rgba(5, 150, 105, 0.4);
}

.btn-add-pelanggaran {
    background: linear-gradient(135deg, var(--danger), #f97316) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    color: white !important;
    padding: 12px 24px !important;
    font-weight: 600;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(220, 38, 38, 0.3);
    transition: all 0.3s ease;
}

.btn-add-pelanggaran:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 40px rgba(220, 38, 38, 0.4);
}

/* Table */
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

/* Badges */
.badge-siswa {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.3), rgba(96, 165, 250, 0.2));
    border: 1px solid rgba(59, 130, 246, 0.4);
    color: #93c5fd;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.badge-guru {
    background: linear-gradient(135deg, rgba(5, 150, 105, 0.3), rgba(52, 211, 153, 0.2));
    border: 1px solid rgba(5, 150, 105, 0.4);
    color: #6ee7b7;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.badge-jenis {
    background: linear-gradient(135deg, rgba(220, 38, 38, 0.3), rgba(239, 68, 68, 0.2));
    border: 1px solid rgba(220, 38, 38, 0.4);
    color: #fca5a5;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.badge-alasan {
    background: linear-gradient(135deg, rgba(234, 179, 8, 0.3), rgba(251, 191, 36, 0.2));
    border: 1px solid rgba(234, 179, 8, 0.4);
    color: #fcd34d;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.badge-point {
    background: linear-gradient(135deg, rgba(147, 51, 234, 0.3), rgba(168, 85, 247, 0.2));
    border: 1px solid rgba(147, 51, 234, 0.4);
    color: #d8b4fe;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
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
   MODAL STYLES - PORTAL SYSTEM
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
    max-width: 700px;
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

.liquid-modal-header.primary { background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(96, 165, 250, 0.05)); }
.liquid-modal-header.warning { background: linear-gradient(135deg, rgba(234, 179, 8, 0.2), rgba(251, 191, 36, 0.05)); }
.liquid-modal-header.danger { background: linear-gradient(135deg, rgba(220, 38, 38, 0.2), rgba(239, 68, 68, 0.05)); }
.liquid-modal-header.success { background: linear-gradient(135deg, rgba(5, 150, 105, 0.2), rgba(52, 211, 153, 0.05)); }

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

/* Form Styles */
.form-group-pelanggaran { margin-bottom: 20px; }
.form-group-pelanggaran label {
    display: block;
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 8px;
    color: rgba(255, 255, 255, 0.9);
}
.form-group-pelanggaran label .required { color: #ff6b6b; margin-left: 4px; }

.form-select-pelanggaran, .form-input-pelanggaran {
    width: 100%;
    padding: 14px 18px;
    background: rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 14px;
    color: white;
    font-size: 15px;
    transition: all 0.3s ease;
    appearance: auto;
}

.form-select-pelanggaran:focus, .form-input-pelanggaran:focus {
    outline: none;
    border-color: var(--primary-light);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-select-pelanggaran option { background: #1e293b; color: white; }

.form-input-pelanggaran[readonly] {
    background: rgba(255, 255, 255, 0.05);
    color: rgba(255, 255, 255, 0.6);
    cursor: not-allowed;
}

.form-hint {
    color: rgba(255, 255, 255, 0.5);
    font-size: 12px;
    margin-top: 6px;
    display: block;
}

/* Preview Box (Export) */
.preview-box-liquid {
    background: rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    padding: 16px;
    margin-top: 16px;
}

.preview-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px dashed rgba(255, 255, 255, 0.1);
}

.preview-row:last-child { border-bottom: none; }

.preview-label {
    color: rgba(255, 255, 255, 0.6);
    font-size: 14px;
}

.preview-value {
    color: white;
    font-weight: 600;
}

/* Shortcut Buttons */
.shortcut-container {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 8px;
}

.shortcut-btn {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.8);
    padding: 8px 16px;
    border-radius: 10px;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.shortcut-btn:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-2px);
}

.shortcut-btn.active {
    background: var(--success) !important;
    border-color: var(--success) !important;
    color: white !important;
    box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
}

/* Modal Buttons */
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
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.9), rgba(5, 150, 105, 0.9));
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    padding: 12px 26px;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 8px 24px rgba(59, 130, 246, 0.3);
}

.btn-modal-submit:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(59, 130, 246, 0.4);
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

.btn-modal-submit.success {
    background: linear-gradient(135deg, rgba(5, 150, 105, 0.9), rgba(52, 211, 153, 0.9));
    box-shadow: 0 8px 24px rgba(5, 150, 105, 0.3);
}

/* Delete Modal Warning */
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

/* DataTable Custom */
#pelanggaranTable tbody tr {
    background: transparent;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

#pelanggaranTable.dataTable thead th {
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.8);
    font-weight: 600;
}

#pelanggaranTable.dataTable tbody td {
    color: rgba(255, 255, 255, 0.9);
}

/* Responsive */
@media (max-width: 768px) {
    .page-header-pelanggaran { flex-direction: column; align-items: stretch; }
    .page-title-pelanggaran { font-size: 24px; }
    .btn-export-word, .btn-add-pelanggaran { width: 100%; justify-content: center; }
    .pelanggaran-table-wrapper { padding: 16px; }
    .liquid-modal { margin-top: 20px; width: 95%; border-radius: 20px; }
    .liquid-modal.large { max-width: 95%; }
    .liquid-modal-header { padding: 18px 20px; }
    .liquid-modal-body { padding: 20px; max-height: 70vh; }
    .liquid-modal-footer { padding: 16px 20px; flex-direction: column-reverse; }
    .btn-modal-cancel, .btn-modal-submit { width: 100%; justify-content: center; }
}
</style>

<div class="container-custom">
    <!-- HEADER -->
    <div class="page-header-pelanggaran">
        <div>
            <h1 class="page-title-pelanggaran">
                <i class="fas fa-user-slash"></i>Data Pelanggaran
            </h1>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-export-word" onclick="openModal('exportModal')">
                <i class="fas fa-file-word me-2"></i>Export Word
            </button>
            <button class="btn btn-add-pelanggaran" onclick="openModal('addModal')">
                <i class="fas fa-plus me-2"></i>Tambah Pelanggaran
            </button>
        </div>
    </div>

    <!-- TABLE -->
    <div class="table-card-pelanggaran">
        <div class="pelanggaran-table-wrapper">
            <table id="pelanggaranTable" class="display responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="14%">Siswa</th>
                        <th width="14%">Jenis</th>
                        <th width="17%">Alasan</th>
                        <th width="11%">Guru</th>
                        <th width="10%" class="text-center">Point</th>
                        <th width="12%" class="text-center">Tanggal</th>
                        <th width="10%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL PORTAL SOURCE -->
<div id="modal-portal-source" style="display: none;">

    <!-- EXPORT MODAL -->
    <div class="liquid-modal-overlay" id="exportModal" data-modal="true">
        <div class="liquid-modal">
            <div class="liquid-modal-header success">
                <h5 class="liquid-modal-title">
                    <i class="fas fa-file-word"></i>Export Laporan
                </h5>
                <button type="button" class="liquid-modal-close" onclick="closeModal('exportModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="liquid-modal-body">
                <!-- Date Range -->
                <div class="row" style="display: flex; gap: 16px; margin-bottom: 20px;">
                    <div style="flex: 1;">
                        <label class="form-group-pelanggaran" style="margin-bottom: 8px; display: block;">
                            Dari Tanggal <span class="required">*</span>
                        </label>
                        <input type="date" class="form-input-pelanggaran" id="exportDateStart">
                        <small class="form-hint">Ubah ini → akhir bulan otomatis</small>
                    </div>
                    <div style="flex: 1;">
                        <label class="form-group-pelanggaran" style="margin-bottom: 8px; display: block;">
                            Sampai Tanggal <span class="required">*</span>
                        </label>
                        <input type="date" class="form-input-pelanggaran" id="exportDateEnd">
                    </div>
                </div>

                <!-- Shortcuts -->
                <div class="form-group-pelanggaran">
                    <label>Shortcut Periode</label>
                    <div class="shortcut-container">
                        <button type="button" class="shortcut-btn active" data-months-ago="0" onclick="setShortcut(0)">Bulan Ini</button>
                        <button type="button" class="shortcut-btn" data-months-ago="1" onclick="setShortcut(1)">1 Bln Lalu</button>
                        <button type="button" class="shortcut-btn" data-months-ago="2" onclick="setShortcut(2)">2 Bln Lalu</button>
                        <button type="button" class="shortcut-btn" data-months-ago="3" onclick="setShortcut(3)">3 Bln Lalu</button>
                    </div>
                </div>

                <!-- Preview -->
                <div class="preview-box-liquid" id="exportPreview">
                    <div class="text-center" style="color: rgba(255,255,255,0.5); padding: 20px;">
                        <i class="fas fa-spinner fa-spin me-2"></i>Memuat preview...
                    </div>
                </div>
            </div>
            <div class="liquid-modal-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeModal('exportModal')">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <button type="button" class="btn-modal-submit success" id="btnExportDownload" disabled onclick="downloadExport()">
                    <i class="fas fa-download me-2"></i>Download Word
                </button>
            </div>
        </div>
    </div>

    <!-- ADD MODAL -->
    <div class="liquid-modal-overlay" id="addModal" data-modal="true">
        <div class="liquid-modal large">
            <div class="liquid-modal-header danger">
                <h5 class="liquid-modal-title">
                    <i class="fas fa-plus-circle"></i>Tambah Pelanggaran
                </h5>
                <button type="button" class="liquid-modal-close" onclick="closeModal('addModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="addForm">
                <div class="liquid-modal-body">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group-pelanggaran">
                            <label>Siswa <span class="required">*</span></label>
                            <select class="form-select-pelanggaran" id="add_id_siswa" required>
                                <option value="">Pilih Siswa</option>
                            </select>
                        </div>
                        <div class="form-group-pelanggaran">
                            <label>Guru <span class="required">*</span></label>
                            <select class="form-select-pelanggaran" id="add_id_guru" required>
                                <option value="">Pilih Guru</option>
                            </select>
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group-pelanggaran">
                            <label>Jenis Pelanggaran <span class="required">*</span></label>
                            <select class="form-select-pelanggaran" id="add_id_jenis_pelanggaran" required>
                                <option value="">Pilih Jenis</option>
                            </select>
                        </div>
                        <div class="form-group-pelanggaran">
                            <label>Alasan Pelanggaran <span class="required">*</span></label>
                            <select class="form-select-pelanggaran" id="add_id_alasan_pelanggaran" required disabled>
                                <option value="">Pilih Jenis Dulu</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group-pelanggaran" style="max-width: 50%;">
                        <label>Total Point</label>
                        <input type="number" class="form-input-pelanggaran" id="add_total_point" readonly value="0">
                        <small class="form-hint">Otomatis dari Jenis Pelanggaran</small>
                    </div>
                </div>
                <div class="liquid-modal-footer">
                    <button type="button" class="btn-modal-cancel" onclick="closeModal('addModal')">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn-modal-submit danger" id="addSubmitBtn" disabled>
                        <i class="fas fa-save me-2"></i>Simpan
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
                    <i class="fas fa-edit"></i>Edit Pelanggaran
                </h5>
                <button type="button" class="liquid-modal-close" onclick="closeModal('editModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editForm">
                <div class="liquid-modal-body">
                    <input type="hidden" id="editId">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group-pelanggaran">
                            <label>Siswa <span class="required">*</span></label>
                            <select class="form-select-pelanggaran" id="edit_id_siswa" required>
                                <option value="">Pilih Siswa</option>
                            </select>
                        </div>
                        <div class="form-group-pelanggaran">
                            <label>Guru <span class="required">*</span></label>
                            <select class="form-select-pelanggaran" id="edit_id_guru" required>
                                <option value="">Pilih Guru</option>
                            </select>
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group-pelanggaran">
                            <label>Jenis Pelanggaran <span class="required">*</span></label>
                            <select class="form-select-pelanggaran" id="edit_id_jenis_pelanggaran" required>
                                <option value="">Pilih Jenis</option>
                            </select>
                        </div>
                        <div class="form-group-pelanggaran">
                            <label>Alasan Pelanggaran <span class="required">*</span></label>
                            <select class="form-select-pelanggaran" id="edit_id_alasan_pelanggaran" required disabled>
                                <option value="">Pilih Jenis Dulu</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group-pelanggaran" style="max-width: 50%;">
                        <label>Total Point</label>
                        <input type="number" class="form-input-pelanggaran" id="edit_total_point" readonly value="0">
                        <small class="form-hint">Otomatis dari Jenis Pelanggaran</small>
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
                    <i class="fas fa-exclamation-triangle"></i>Hapus Pelanggaran
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
                        Data pelanggaran akan dihapus <strong>PERMANEN</strong>!
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

<!-- CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
// ═══════════════════════════════════════════════════════════════════════════
// MODAL PORTAL SYSTEM
// ═══════════════════════════════════════════════════════════════════════════

window.modalsPorted = window.modalsPorted || false;

function initModalPortal() {
    if (window.modalsPorted) return;
    window.modalsPorted = true;

    var sourceContainer = document.getElementById('modal-portal-source');
    if (!sourceContainer) return;

    var portalContainer = document.createElement('div');
    portalContainer.id = 'modal-portal-destination';
    portalContainer.className = 'modal-portal-container';
    portalContainer.style.cssText = 'position: static; z-index: auto; transform: none; filter: none;';

    var modals = sourceContainer.querySelectorAll('[data-modal="true"]');
    modals.forEach(function(modal) {
        portalContainer.appendChild(modal.cloneNode(true));
    });

    document.body.appendChild(portalContainer);
    sourceContainer.remove();
    
    reattachModalEventListeners();
}

function reattachModalEventListeners() {
    document.querySelectorAll('.liquid-modal-close, .btn-modal-cancel').forEach(function(btn) {
        var newBtn = btn.cloneNode(true);
        btn.parentNode.replaceChild(newBtn, btn);
        newBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var modalOverlay = this.closest('.liquid-modal-overlay');
            if (modalOverlay) closeModal(modalOverlay.id);
        });
    });

    document.querySelectorAll('.liquid-modal').forEach(function(modal) {
        modal.addEventListener('click', function(e) { e.stopPropagation(); });
    });

    document.querySelectorAll('.liquid-modal-overlay').forEach(function(overlay) {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) closeModal(this.id);
        });
    });
}

function openModal(modalId) {
    if (!window.modalsPorted) initModalPortal();
    var overlay = document.getElementById(modalId);
    if (!overlay) return;
    
    overlay.scrollTop = 0;
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
    
    // Init export preview if opening export modal
    if (modalId === 'exportModal') {
        setTimeout(function() {
            var def = getMonthRange(0);
            setExportPeriode(def.start, def.end);
        }, 100);
    }
    
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
        setTimeout(function() { 
            document.getElementById('addForm').reset();
            $('#add_id_alasan_pelanggaran').html('<option value="">Pilih Jenis Dulu</option>').prop('disabled', true);
            $('#add_total_point').val(0);
        }, 300);
    }
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.liquid-modal-overlay.active').forEach(function(modal) {
            closeModal(modal.id);
        });
    }
});

// ═══════════════════════════════════════════════════════════════════════════
// EXPORT FUNCTIONS
// ═══════════════════════════════════════════════════════════════════════════

function getMonthRange(monthsAgo) {
    var now = new Date();
    var year = now.getFullYear();
    var month = now.getMonth() - monthsAgo;
    while (month < 0) { month += 12; year--; }
    var firstDay = new Date(year, month, 1);
    var lastDay = new Date(year, month + 1, 0);
    
    function pad(n) { return String(n).padStart(2, '0'); }
    function fmt(d) { return d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate()); }
    
    return { start: fmt(firstDay), end: fmt(lastDay) };
}

function fmtDisplay(dateStr) {
    if (!dateStr) return '-';
    var bulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    var p = dateStr.split('-');
    return parseInt(p[2]) + ' ' + bulan[parseInt(p[1]) - 1] + ' ' + p[0];
}

function setShortcut(monthsAgo) {
    var range = getMonthRange(monthsAgo);
    setExportPeriode(range.start, range.end);
    
    document.querySelectorAll('.shortcut-btn').forEach(function(btn) {
        btn.classList.remove('active');
        if (parseInt(btn.dataset.monthsAgo) === monthsAgo) btn.classList.add('active');
    });
}

var previewTimer = null;

function setExportPeriode(start, end) {
    document.getElementById('exportDateStart').value = start;
    document.getElementById('exportDateEnd').value = end;
    loadExportPreview();
}

function loadExportPreview() {
    var start = document.getElementById('exportDateStart').value;
    var end = document.getElementById('exportDateEnd').value;
    var previewBox = document.getElementById('exportPreview');
    var downloadBtn = document.getElementById('btnExportDownload');

    if (!start || !end) {
        previewBox.innerHTML = '<div class="text-center" style="color: rgba(255,255,255,0.5); padding: 20px;">Pilih tanggal terlebih dahulu</div>';
        downloadBtn.disabled = true;
        return;
    }

    if (start > end) {
        previewBox.innerHTML = '<div class="text-center" style="color: #ff6b6b; padding: 20px;"><i class="fas fa-exclamation-triangle me-2"></i>Tanggal awal tidak valid</div>';
        downloadBtn.disabled = true;
        return;
    }

    previewBox.innerHTML = '<div class="text-center" style="color: rgba(255,255,255,0.5); padding: 20px;"><i class="fas fa-spinner fa-spin me-2"></i>Memuat...</div>';
    downloadBtn.disabled = true;

    $.get('action_pelanggaran.php', {
        action: 'count_range',
        date_start: start,
        date_end: end
    }).done(function(data) {
        var total = parseInt(data.total || 0);
        var poin = parseInt(data.total_poin || 0);
        var label = (start === end) ? fmtDisplay(start) : fmtDisplay(start) + ' – ' + fmtDisplay(end);

        var html = 
            '<div class="preview-row">' +
                '<span class="preview-label">Periode</span>' +
                '<span class="preview-value">' + label + '</span>' +
            '</div>' +
            '<div class="preview-row">' +
                '<span class="preview-label">Jumlah pelanggaran</span>' +
                '<span class="preview-value" style="color: #fca5a5;">' + total + ' data</span>' +
            '</div>';
            
        if (total === 0) {
            html += '<div style="margin-top: 12px; padding-top: 12px; border-top: 1px dashed rgba(255,255,255,0.1); color: rgba(255,255,255,0.5); font-size: 13px; text-align: center;"><i class="fas fa-info-circle me-1"></i>Tidak ada data pada periode ini</div>';
        }
        
        previewBox.innerHTML = html;
        downloadBtn.disabled = false;
    }).fail(function() {
        previewBox.innerHTML = '<div class="text-center" style="color: #ff6b6b; padding: 20px;">Gagal memuat preview</div>';
    });
}

function downloadExport() {
    var start = document.getElementById('exportDateStart').value;
    var end = document.getElementById('exportDateEnd').value;
    if (!start || !end) return;

    var btn = document.getElementById('btnExportDownload');
    var originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Membuat file...';

    window.open('export_pelanggaran.php?date_start=' + start + '&date_end=' + end, '_blank');

    setTimeout(function() {
        btn.disabled = false;
        btn.innerHTML = originalText;
    }, 2000);
}

// Event listeners for export dates
$(document).on('change', '#exportDateStart', function() {
    var val = $(this).val();
    if (val) {
        var p = val.split('-');
        var year = parseInt(p[0]);
        var month = parseInt(p[1]) - 1;
        var lastDay = new Date(year, month + 1, 0);
        function pad(n) { return String(n).padStart(2, '0'); }
        var endVal = year + '-' + pad(lastDay.getMonth() + 1) + '-' + pad(lastDay.getDate());
        $('#exportDateEnd').val(endVal);
    }
    document.querySelectorAll('.shortcut-btn').forEach(function(btn) { btn.classList.remove('active'); });
    clearTimeout(previewTimer);
    previewTimer = setTimeout(loadExportPreview, 400);
});

$(document).on('change', '#exportDateEnd', function() {
    document.querySelectorAll('.shortcut-btn').forEach(function(btn) { btn.classList.remove('active'); });
    clearTimeout(previewTimer);
    previewTimer = setTimeout(loadExportPreview, 400);
});

// ═══════════════════════════════════════════════════════════════════════════
// TOAST NOTIFICATION
// ═══════════════════════════════════════════════════════════════════════════

function showToast(msg, type) {
    type = type || 'success';
    var bg = type === 'success' ? 'success' : 'error';
    var icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
    var html = 
        '<div class="toast toast-pelanggaran align-items-center ' + bg + ' border-0" role="alert">' +
            '<div class="d-flex">' +
                '<div class="toast-body"><i class="fas ' + icon + ' me-2"></i>' + msg + '</div>' +
                '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>' +
            '</div>' +
        '</div>';
    $('body').append(html);
    var el = $('.toast').last();
    new bootstrap.Toast(el[0], { delay: 4000 }).show();
    el.on('hidden.bs.toast', function() { $(this).remove(); });
}

// ═══════════════════════════════════════════════════════════════════════════
// DATA & FORM FUNCTIONS
// ═══════════════════════════════════════════════════════════════════════════

let table;

function loadDropdowns() {
    $.get('action_pelanggaran.php?action=siswa', function(data) {
        var html = '<option value="">Pilih Siswa</option>';
        data.forEach(function(s) { html += '<option value="' + s.id + '">' + s.name + '</option>'; });
        $('#add_id_siswa, #edit_id_siswa').html(html);
    });

    $.get('action_pelanggaran.php?action=guru', function(data) {
        var html = '<option value="">Pilih Guru</option>';
        data.forEach(function(g) { html += '<option value="' + g.id + '">' + g.name + '</option>'; });
        $('#add_id_guru, #edit_id_guru').html(html);
    });

    $.get('action_pelanggaran.php?action=jenis', function(data) {
        var html = '<option value="">Pilih Jenis</option>';
        data.forEach(function(j) { html += '<option value="' + j.id + '">' + j.name + '</option>'; });
        $('#add_id_jenis_pelanggaran, #edit_id_jenis_pelanggaran').html(html);
    });
}

function handleJenisChange(modal) {
    var jenisId = $('#' + modal + '_id_jenis_pelanggaran').val();
    var alasanSelect = $('#' + modal + '_id_alasan_pelanggaran');
    var pointInput = $('#' + modal + '_total_point');

    if (!jenisId) {
        alasanSelect.html('<option value="">Pilih Jenis Dulu</option>').prop('disabled', true);
        pointInput.val(0);
        return;
    }

    $.get('action_pelanggaran.php?action=alasan&id_jenis=' + jenisId, function(data) {
        var html = '<option value="">Pilih Alasan</option>';
        data.forEach(function(a) { html += '<option value="' + a.id + '">' + a.detail + '</option>'; });
        alasanSelect.html(html).prop('disabled', false);
    });

    $.get('action_pelanggaran.php?action=jenis_point&id_jenis=' + jenisId, function(data) {
        pointInput.val(data.point);
        updateSubmit(modal);
    });
}

function updateSubmit(modal) {
    var valid = $('#' + modal + '_id_siswa').val() &&
                $('#' + modal + '_id_guru').val() &&
                $('#' + modal + '_id_jenis_pelanggaran').val() &&
                $('#' + modal + '_id_alasan_pelanggaran').val();
    $('#' + modal + 'SubmitBtn').prop('disabled', !valid);
}

function initDataTable() {
    table = $('#pelanggaranTable').DataTable({
        ajax: {
            url: 'action_pelanggaran.php?action=read',
            dataSrc: '',
            error: function() { showToast('Gagal load data!', 'error'); }
        },
        columns: [
            {
                data: null, orderable: false, className: 'text-center',
                render: function(data, type, row, meta) { return meta.row + 1; }
            },
            { data: null, render: function(d) { return '<span class="badge-siswa">' + (d.siswas || '-') + '</span>'; } },
            { data: null, render: function(d) { return '<span class="badge-jenis">' + (d.jenis_pelanggarans || '-') + '</span>'; } },
            { data: null, render: function(d) { return '<span class="badge-alasan">' + (d.alasan_pelanggaran || '-') + '</span>'; } },
            { data: null, render: function(d) { return '<span class="badge-guru">' + (d.gurus || '-') + '</span>'; } },
            { data: null, className: 'text-center', render: function(d) { return '<span class="badge-point">' + (d.total_point || 0) + ' pt</span>'; } },
            { data: null, className: 'text-center', render: function(d) { return new Date(d.date).toLocaleDateString('id-ID'); } },
            {
                data: null, orderable: false, className: 'text-center',
                render: function(d) {
                    return '<div class="d-flex justify-content-center gap-2">' +
                        '<button class="btn btn-action-edit btn-sm edit-btn" data-id="' + d.id + '" title="Edit"><i class="fas fa-edit"></i></button>' +
                        '<button class="btn btn-action-delete btn-sm delete-btn" data-id="' + d.id + '" title="Hapus"><i class="fas fa-trash"></i></button>' +
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
        responsive: true,
        order: [[0, 'desc']]
    });
}

// ═══════════════════════════════════════════════════════════════════════════
// EVENT HANDLERS
// ═══════════════════════════════════════════════════════════════════════════

$(document).ready(function() {
    initModalPortal();
    loadDropdowns();
    initDataTable();

    // Jenis change handlers
    $('#add_id_jenis_pelanggaran, #edit_id_jenis_pelanggaran').on('change', function() {
        handleJenisChange(this.id.includes('add') ? 'add' : 'edit');
    });

    // Validation handlers
    $('#add_id_siswa, #add_id_guru, #add_id_alasan_pelanggaran').on('change', function() { updateSubmit('add'); });
    $('#edit_id_siswa, #edit_id_guru, #edit_id_alasan_pelanggaran').on('change', function() { updateSubmit('edit'); });

    // Form submissions
    $('#addForm').submit(function(e) {
        e.preventDefault();
        var $btn = $('#addSubmitBtn');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...');
        
        $.post('action_pelanggaran.php', {
            action: 'add',
            id_siswa: $('#add_id_siswa').val(),
            id_guru: $('#add_id_guru').val(),
            id_jenis_pelanggaran: $('#add_id_jenis_pelanggaran').val(),
            id_alasan_pelanggaran: $('#add_id_alasan_pelanggaran').val(),
            total_point: $('#add_total_point').val()
        }).done(function(response) {
            if (response.success) {
                closeModal('addModal');
                loadDropdowns();
                table.ajax.reload(null, false);
                showToast('Pelanggaran berhasil disimpan!', 'success');
            } else {
                showToast(response.message || 'Gagal simpan!', 'error');
            }
        }).fail(function() {
            showToast('Server error!', 'error');
        }).always(function() {
            $btn.prop('disabled', false).html('<i class="fas fa-save me-2"></i>Simpan');
        });
    });

    $('#editForm').submit(function(e) {
        e.preventDefault();
        var $btn = $('#editSubmitBtn');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...');
        
        $.post('action_pelanggaran.php', {
            action: 'update',
            id: $('#editId').val(),
            id_siswa: $('#edit_id_siswa').val(),
            id_guru: $('#edit_id_guru').val(),
            id_jenis_pelanggaran: $('#edit_id_jenis_pelanggaran').val(),
            id_alasan_pelanggaran: $('#edit_id_alasan_pelanggaran').val(),
            total_point: $('#edit_total_point').val()
        }).done(function(response) {
            if (response.success) {
                closeModal('editModal');
                table.ajax.reload(null, false);
                showToast('Pelanggaran berhasil diupdate!', 'success');
            } else {
                showToast(response.message || 'Gagal update!', 'error');
            }
        }).fail(function() {
            showToast('Server error!', 'error');
        }).always(function() {
            $btn.prop('disabled', false).html('<i class="fas fa-save me-2"></i>Update');
        });
    });

    // Edit button handler
    $(document).on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        $('#editId').val(id);
        $.get('action_pelanggaran.php?action=get&id=' + id, function(response) {
            if (response.success && response.data) {
                var data = response.data;
                $('#edit_id_siswa').val(data.id_siswa);
                $('#edit_id_guru').val(data.id_guru);
                $('#edit_id_jenis_pelanggaran').val(data.id_jenis_pelanggaran).trigger('change');
                setTimeout(function() {
                    $('#edit_id_alasan_pelanggaran').val(data.id_alasan_pelanggaran);
                    $('#edit_total_point').val(data.total_point);
                    updateSubmit('edit');
                }, 300);
                openModal('editModal');
            }
        });
    });

    // Delete handlers
    $(document).on('click', '.delete-btn', function() {
        $('#deleteId').val($(this).data('id'));
        openModal('deleteModal');
    });

    $('#confirmDelete').click(function() {
        var $btn = $(this);
        var id = $('#deleteId').val();
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Menghapus...');
        
        $.post('action_pelanggaran.php', { action: 'delete', id: id })
            .done(function(response) {
                if (response.success) {
                    closeModal('deleteModal');
                    table.ajax.reload(null, false);
                    showToast('Pelanggaran berhasil dihapus!', 'success');
                } else {
                    showToast(response.message || 'Gagal hapus!', 'error');
                }
            }).fail(function() {
                showToast('Server error!', 'error');
            }).always(function() {
                $btn.prop('disabled', false).html('<i class="fas fa-trash me-2"></i>Hapus');
            });
    });
});
</script>

<?php $this->stop() ?>
<?php $this->layout('layouts::app', ['title' => 'Data Guru']) ?>
<?php $this->start('main') ?>

<style>
/* ============================================
   LIQUID GLASS THEME - GURU PAGE
   ============================================ */

:root {
    --liquid-bg: rgba(255, 255, 255, 0.05);
    --liquid-border: rgba(255, 255, 255, 0.15);
    --liquid-shadow: rgba(0, 0, 0, 0.4);
    --liquid-blur: blur(20px) saturate(180%);
    
    --primary: #3b82f6;
    --primary-light: #60a5fa;
    --success: #059669;
    --warning: #eab308;
    --danger: #dc2626;
    --info: #0891b2;
    --text-primary: #ffffff;
    --text-muted: rgba(255, 255, 255, 0.6);
}

/* Base */
.container-custom {
    position: relative;
    z-index: 1;
}

/* Header */
.page-header-guru {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 16px;
}

.page-title-guru {
    font-size: 28px;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 12px;
}

.page-title-guru i {
    color: var(--primary-light);
    filter: drop-shadow(0 0 10px rgba(59, 130, 246, 0.5));
}

.page-subtitle {
    color: var(--text-muted);
    font-size: 14px;
    margin-top: 4px;
}

/* Add Button */
.btn-add-guru {
    background: linear-gradient(135deg, var(--primary), #1d4ed8) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    color: white !important;
    padding: 12px 24px !important;
    font-weight: 600;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(59, 130, 246, 0.3);
    transition: all 0.3s ease;
}

.btn-add-guru:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 40px rgba(59, 130, 246, 0.4);
}

/* Table */
.table-card-guru {
    background: var(--liquid-bg);
    backdrop-filter: var(--liquid-blur);
    border: 1px solid var(--liquid-border);
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 8px 32px var(--liquid-shadow);
}

.guru-table-wrapper {
    padding: 24px;
}

/* Badges */
.badge-assigned {
    background: linear-gradient(135deg, rgba(5, 150, 105, 0.3), rgba(52, 211, 153, 0.2));
    border: 1px solid rgba(5, 150, 105, 0.4);
    color: #6ee7b7;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.badge-unassigned {
    background: linear-gradient(135deg, rgba(234, 179, 8, 0.3), rgba(251, 191, 36, 0.2));
    border: 1px solid rgba(234, 179, 8, 0.4);
    color: #fcd34d;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.badge-mapel {
    background: linear-gradient(135deg, rgba(8, 145, 178, 0.3), rgba(34, 211, 238, 0.2));
    border: 1px solid rgba(8, 145, 178, 0.4);
    color: #67e8f9;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

/* Action Buttons */
.btn-action-assign, .btn-action-detail, .btn-action-edit, .btn-action-delete {
    width: 36px;
    height: 36px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    color: white !important;
    border-radius: 10px !important;
    transition: all 0.3s ease;
    margin: 0 2px;
}

.btn-action-assign { background: linear-gradient(135deg, rgba(5, 150, 105, 0.8), rgba(52, 211, 153, 0.6)) !important; }
.btn-action-detail { background: linear-gradient(135deg, rgba(8, 145, 178, 0.8), rgba(34, 211, 238, 0.6)) !important; }
.btn-action-edit { background: linear-gradient(135deg, rgba(234, 179, 8, 0.8), rgba(251, 191, 36, 0.6)) !important; }
.btn-action-delete { background: linear-gradient(135deg, rgba(220, 38, 38, 0.8), rgba(239, 68, 68, 0.6)) !important; }

.btn-action-assign:hover, .btn-action-detail:hover, .btn-action-edit:hover, .btn-action-delete:hover {
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

.liquid-modal.xl {
    max-width: 900px;
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
.liquid-modal-header.success { background: linear-gradient(135deg, rgba(5, 150, 105, 0.2), rgba(52, 211, 153, 0.05)); }
.liquid-modal-header.warning { background: linear-gradient(135deg, rgba(234, 179, 8, 0.2), rgba(251, 191, 36, 0.05)); }
.liquid-modal-header.danger { background: linear-gradient(135deg, rgba(220, 38, 38, 0.2), rgba(239, 68, 68, 0.05)); }
.liquid-modal-header.info { background: linear-gradient(135deg, rgba(8, 145, 178, 0.2), rgba(34, 211, 238, 0.05)); }

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

.liquid-modal.xl .liquid-modal-body {
    max-height: 70vh;
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
.form-group-guru { margin-bottom: 20px; }
.form-group-guru label {
    display: block;
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 8px;
    color: rgba(255, 255, 255, 0.9);
}
.form-group-guru label .required { color: #ff6b6b; margin-left: 4px; }
.form-group-guru label .optional { color: rgba(255, 255, 255, 0.5); font-weight: 400; margin-left: 4px; font-size: 12px; }

.form-input-guru, .form-select-guru, .form-textarea-guru {
    width: 100%;
    padding: 14px 18px;
    background: rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 14px;
    color: white;
    font-size: 15px;
    transition: all 0.3s ease;
}

.form-input-guru:focus, .form-select-guru:focus, .form-textarea-guru:focus {
    outline: none;
    border-color: var(--primary-light);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-select-guru option { background: #1e293b; color: white; }

.form-textarea-guru {
    resize: vertical;
    min-height: 80px;
}

.form-hint {
    color: rgba(255, 255, 255, 0.5);
    font-size: 12px;
    margin-top: 6px;
    display: block;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.input-group-guru {
    display: flex;
    align-items: center;
    background: rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 14px;
    overflow: hidden;
}

.input-group-guru .input-icon {
    padding: 0 16px;
    color: rgba(255, 255, 255, 0.5);
}

.input-group-guru .form-input-guru {
    border: none;
    background: transparent;
    flex: 1;
}

/* Detail Card in Modal */
.detail-card-liquid {
    background: rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 20px;
}

.detail-card-liquid.user-card {
    border-left: 4px solid var(--success);
}

.detail-card-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
}

.detail-card-header i {
    font-size: 24px;
}

.detail-card-header h4 {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
}

.detail-row {
    display: grid;
    grid-template-columns: 120px 1fr;
    gap: 12px;
    padding: 8px 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-label {
    color: rgba(255, 255, 255, 0.6);
    font-size: 14px;
}

.detail-value {
    color: white;
    font-weight: 500;
    font-size: 14px;
}

.password-wrapper-liquid {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    background: rgba(0, 0, 0, 0.3);
    padding: 8px 16px;
    border-radius: 10px;
}

.password-text {
    font-family: 'JetBrains Mono', monospace;
    color: white;
    letter-spacing: 2px;
}

.btn-toggle-pass {
    background: none;
    border: none;
    color: rgba(255, 255, 255, 0.6);
    cursor: pointer;
    transition: color 0.2s;
}

.btn-toggle-pass:hover {
    color: white;
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

.btn-modal-submit.success {
    background: linear-gradient(135deg, rgba(5, 150, 105, 0.9), rgba(52, 211, 153, 0.9));
    box-shadow: 0 8px 24px rgba(5, 150, 105, 0.3);
}

.btn-modal-submit.warning {
    background: linear-gradient(135deg, rgba(234, 179, 8, 0.9), rgba(251, 191, 36, 0.9));
    box-shadow: 0 8px 24px rgba(234, 179, 8, 0.3);
}

.btn-modal-submit.danger {
    background: linear-gradient(135deg, rgba(220, 38, 38, 0.9), rgba(239, 68, 68, 0.9));
    box-shadow: 0 8px 24px rgba(220, 38, 38, 0.3);
}

.btn-modal-submit.info {
    background: linear-gradient(135deg, rgba(8, 145, 178, 0.9), rgba(34, 211, 238, 0.9));
    box-shadow: 0 8px 24px rgba(8, 145, 178, 0.3);
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

/* Select2 Customization for Dark Theme */
.select2-container--bootstrap-5 .select2-selection {
    background: rgba(0, 0, 0, 0.2) !important;
    border: 1px solid rgba(255, 255, 255, 0.1) !important;
    border-radius: 14px !important;
    color: white !important;
    min-height: 50px !important;
}

.select2-container--bootstrap-5 .select2-selection__rendered {
    color: white !important;
    padding: 10px 18px !important;
}

.select2-container--bootstrap-5 .select2-selection__placeholder {
    color: rgba(255, 255, 255, 0.5) !important;
}

.select2-dropdown {
    background: #1e293b !important;
    border: 1px solid rgba(255, 255, 255, 0.1) !important;
    border-radius: 14px !important;
    color: white !important;
}

.select2-container--bootstrap-5 .select2-results__option {
    color: white !important;
}

.select2-container--bootstrap-5 .select2-results__option--highlighted {
    background: rgba(59, 130, 246, 0.3) !important;
}

.select2-container--bootstrap-5 .select2-search__field {
    background: rgba(0, 0, 0, 0.2) !important;
    border: 1px solid rgba(255, 255, 255, 0.1) !important;
    color: white !important;
    border-radius: 8px !important;
}

/* Toast */
.toast-guru {
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
.toast-guru.success { background: rgba(34, 197, 94, 0.9); border-color: rgba(34, 197, 94, 0.4); color: white; }
.toast-guru.error { background: rgba(220, 38, 38, 0.9); border-color: rgba(220, 38, 38, 0.4); color: white; }

/* DataTable Customization */
#guruTable tbody tr {
    background: transparent;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

#guruTable.dataTable thead th {
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.8);
    font-weight: 600;
}

#guruTable.dataTable tbody td {
    color: rgba(255, 255, 255, 0.9);
}

/* Responsive */
@media (max-width: 768px) {
    .page-header-guru { flex-direction: column; align-items: stretch; }
    .page-title-guru { font-size: 24px; }
    .btn-add-guru { width: 100%; justify-content: center; }
    .guru-table-wrapper { padding: 16px; }
    .liquid-modal { margin-top: 20px; width: 95%; border-radius: 20px; }
    .liquid-modal.large, .liquid-modal.xl { max-width: 95%; }
    .liquid-modal-header { padding: 18px 20px; }
    .liquid-modal-body { padding: 20px; max-height: 70vh; }
    .liquid-modal-footer { padding: 16px 20px; flex-direction: column-reverse; }
    .btn-modal-cancel, .btn-modal-submit { width: 100%; justify-content: center; }
    .form-row { grid-template-columns: 1fr; }
    .detail-row { grid-template-columns: 1fr; gap: 4px; }
}
</style>

<div class="container-custom">
    <!-- HEADER -->
    <div class="page-header-guru">
        <div>
            <h1 class="page-title-guru">
                <i class="fas fa-chalkboard-teacher"></i>Data Guru
            </h1>
            <p class="page-subtitle">Kelola data guru & assign akun guru (role: guru)</p>
        </div>
        <button class="btn btn-add-guru" onclick="openModal('addModal')">
            <i class="fas fa-plus"></i>Tambah Guru
        </button>
    </div>

    <!-- TABLE -->
    <div class="table-card-guru">
        <div class="guru-table-wrapper">
            <table id="guruTable" class="display responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="20%">Nama Guru</th>
                        <th width="13%" class="text-center">No HP</th>
                        <th width="15%">Mapel</th>
                        <th width="12%" class="text-center">User</th>
                        <th width="18%">Alamat</th>
                        <th width="17%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL PORTAL SOURCE -->
<div id="modal-portal-source" style="display: none;">

    <!-- ADD MODAL -->
    <div class="liquid-modal-overlay" id="addModal" data-modal="true">
        <div class="liquid-modal large">
            <div class="liquid-modal-header primary">
                <h5 class="liquid-modal-title">
                    <i class="fas fa-plus-circle"></i>Tambah Guru Baru
                </h5>
                <button type="button" class="liquid-modal-close" onclick="closeModal('addModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="addForm">
                <div class="liquid-modal-body">
                    <div class="form-row">
                        <div class="form-group-guru">
                            <label>Nama Guru <span class="required">*</span></label>
                            <input type="text" class="form-input-guru" id="addName" required maxlength="255" placeholder="Masukkan nama lengkap guru">
                        </div>
                        <div class="form-group-guru">
                            <label>No Handphone <span class="required">*</span></label>
                            <div class="input-group-guru">
                                <span class="input-icon"><i class="fas fa-phone"></i></span>
                                <input type="tel" class="form-input-guru" id="addNoHp" required placeholder="08xx-xxxx-xxxx">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group-guru">
                            <label>Mata Pelajaran</label>
                            <select class="form-select-guru" id="addMapel">
                                <option value="">-- Pilih Mata Pelajaran --</option>
                            </select>
                        </div>
                        <div class="form-group-guru">
                            <label>Akun User <span class="optional">(opsional, ketik min. 1 huruf)</span></label>
                            <select class="form-select-guru user-select2" id="addUser" style="width:100%">
                                <option value="">-- Cari akun user guru --</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group-guru">
                        <label>Alamat</label>
                        <textarea class="form-textarea-guru" id="addAlamat" rows="3" maxlength="500" placeholder="Alamat lengkap guru"></textarea>
                    </div>
                </div>
                <div class="liquid-modal-footer">
                    <button type="button" class="btn-modal-cancel" onclick="closeModal('addModal')">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn-modal-submit">
                        <i class="fas fa-save me-2"></i>Simpan Guru
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
                    <i class="fas fa-edit"></i>Edit Data Guru
                </h5>
                <button type="button" class="liquid-modal-close" onclick="closeModal('editModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editForm">
                <div class="liquid-modal-body">
                    <input type="hidden" id="editId">
                    <input type="hidden" id="editCurrentUserId">
                    <input type="hidden" id="editCurrentUserName">
                    
                    <div class="form-row">
                        <div class="form-group-guru">
                            <label>Nama Guru <span class="required">*</span></label>
                            <input type="text" class="form-input-guru" id="editName" required maxlength="255">
                        </div>
                        <div class="form-group-guru">
                            <label>No Handphone <span class="required">*</span></label>
                            <div class="input-group-guru">
                                <span class="input-icon"><i class="fas fa-phone"></i></span>
                                <input type="tel" class="form-input-guru" id="editNoHp" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group-guru">
                            <label>Mata Pelajaran</label>
                            <select class="form-select-guru" id="editMapel">
                                <option value="">-- Pilih Mata Pelajaran --</option>
                            </select>
                        </div>
                        <div class="form-group-guru">
                            <label>Akun User <span class="optional">(ketik min. 1 huruf)</span></label>
                            <select class="form-select-guru user-select2" id="editUser" style="width:100%">
                                <option value="">-- Cari akun user guru --</option>
                            </select>
                            <small class="form-hint"><i class="fas fa-info-circle me-1"></i>Hanya akun dengan role <strong>guru</strong></small>
                        </div>
                    </div>
                    <div class="form-group-guru">
                        <label>Alamat</label>
                        <textarea class="form-textarea-guru" id="editAlamat" rows="3" maxlength="500"></textarea>
                    </div>
                </div>
                <div class="liquid-modal-footer">
                    <button type="button" class="btn-modal-cancel" onclick="closeModal('editModal')">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn-modal-submit warning">
                        <i class="fas fa-save me-2"></i>Update Guru
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- DETAIL MODAL -->
    <div class="liquid-modal-overlay" id="detailModal" data-modal="true">
        <div class="liquid-modal xl">
            <div class="liquid-modal-header info">
                <h5 class="liquid-modal-title">
                    <i class="fas fa-info-circle"></i>Detail Guru Lengkap
                </h5>
                <button type="button" class="liquid-modal-close" onclick="closeModal('detailModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="liquid-modal-body" id="detailContent">
                <div style="text-align: center; padding: 40px; color: rgba(255,255,255,0.5);">
                    <i class="fas fa-spinner fa-spin fa-2x mb-3"></i>
                    <p>Memuat detail guru...</p>
                </div>
            </div>
            <div class="liquid-modal-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeModal('detailModal')">
                    <i class="fas fa-times me-2"></i>Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- ASSIGN MODAL -->
    <div class="liquid-modal-overlay" id="assignModal" data-modal="true">
        <div class="liquid-modal">
            <div class="liquid-modal-header success">
                <h5 class="liquid-modal-title">
                    <i class="fas fa-user-plus"></i>Assign Akun Guru
                </h5>
                <button type="button" class="liquid-modal-close" onclick="closeModal('assignModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="assignForm">
                <div class="liquid-modal-body">
                    <input type="hidden" id="assignGuruId">
                    <div class="form-group-guru">
                        <label>Guru</label>
                        <input type="text" class="form-input-guru" id="assignGuruName" readonly style="background: rgba(255,255,255,0.05);">
                    </div>
                    <div class="form-group-guru">
                        <label>Pilih Akun Guru <span class="required">*</span></label>
                        <select class="form-select-guru" id="assignUserId" required>
                            <option value="">-- Loading akun guru tersedia --</option>
                        </select>
                        <small class="form-hint"><i class="fas fa-info-circle me-1"></i>Hanya menampilkan akun guru (role: guru) yang belum diassign</small>
                    </div>
                </div>
                <div class="liquid-modal-footer">
                    <button type="button" class="btn-modal-cancel" onclick="closeModal('assignModal')">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn-modal-submit success">
                        <i class="fas fa-user-plus me-2"></i>Assign Guru
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
                    <i class="fas fa-exclamation-triangle"></i>Hapus Guru
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
                        Guru <strong id="deleteName"></strong> akan dihapus <span style="color: #ff6b6b; font-weight: 700;">PERMANEN!</span>
                    </p>
                </div>
            </div>
            <div class="liquid-modal-footer" style="justify-content: center;">
                <button type="button" class="btn-modal-cancel" onclick="closeModal('deleteModal')">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <button type="button" class="btn-modal-submit danger" id="confirmDelete">
                    <i class="fas fa-trash me-2"></i>Hapus Guru
                </button>
            </div>
        </div>
    </div>

</div><!-- END MODAL PORTAL SOURCE -->

<!-- Scripts -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
    
    // Init Select2 for add/edit modal
    if (modalId === 'addModal' || modalId === 'editModal') {
        setTimeout(initSelect2, 100);
    }
    
    // Load available users for assign modal
    if (modalId === 'assignModal') {
        loadAvailableUsers();
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
            $('#addUser').val(null).trigger('change');
        }, 300);
    }
    if (modalId === 'editModal') {
        $('#editCurrentUserId, #editCurrentUserName').val('');
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
// SELECT2 INITIALIZATION
// ═══════════════════════════════════════════════════════════════════════════

function initSelect2() {
    $('.user-select2').each(function() {
        var $select = $(this);
        if (!$select.hasClass('select2-hidden-accessible')) {
            $select.select2({
                theme: 'bootstrap-5',
                placeholder: 'Ketik nama user min. 1 huruf...',
                allowClear: true,
                dropdownParent: $select.closest('.liquid-modal'),
                ajax: {
                    url: 'action_guru.php?action=users',
                    dataType: 'json',
                    delay: 300,
                    data: function(params) { return { search: params.term || '' }; },
                    processResults: function(res) {
                        return {
                            results: res.map(function(u) {
                                return { id: u.id, text: u.name };
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: 1
            });
        }
    });
}

// ═══════════════════════════════════════════════════════════════════════════
// DATA FUNCTIONS
// ═══════════════════════════════════════════════════════════════════════════

let table, mapels = [];

function loadAvailableUsers() {
    return $.get('action_guru.php?action=assign_users')
        .done(function(users) {
            var options = '<option value="">-- Pilih Akun Guru Tersedia --</option>';
            if (!users.length) {
                options += '<option disabled>Tidak ada akun guru tersedia</option>';
            } else {
                users.forEach(function(u) {
                    options += '<option value="' + u.id + '">' + u.name + '</option>';
                });
            }
            $('#assignUserId').html(options);
        })
        .fail(function() {
            $('#assignUserId').html('<option value="">Error loading users</option>');
            showToast('Gagal memuat akun guru', 'error');
        });
}

function populateMapelDropdowns() {
    var options = '<option value="">-- Pilih Mata Pelajaran --</option>';
    mapels.forEach(function(m) {
        options += '<option value="' + m.id + '">' + m.name + '</option>';
    });
    $('#addMapel, #editMapel').html(options);
}

function initDataTable() {
    table = $('#guruTable').DataTable({
        ajax: {
            url: 'action_guru.php?action=read',
            dataSrc: '',
            error: function() { showToast('Gagal load data guru!', 'error'); }
        },
        columns: [
            {
                data: null, orderable: false, className: 'text-center',
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { data: 'name', className: 'align-middle' },
            { data: 'no_handphone', className: 'text-center align-middle' },
            {
                data: null, className: 'align-middle',
                render: function(data) {
                    var mapelObj = mapels.find(function(m) { return m.id == data.id_mapel; });
                    return mapelObj ? '<span class="badge-mapel">' + mapelObj.name + '</span>' : '<span style="color: rgba(255,255,255,0.5);">—</span>';
                }
            },
            {
                data: 'user_status', className: 'text-center align-middle',
                render: function(data) {
                    return data === 'Assigned' ? '<span class="badge-assigned">✓ Assigned</span>' : '<span class="badge-unassigned">○ Unassigned</span>';
                }
            },
            {
                data: 'alamat', className: 'align-middle',
                render: function(data) {
                    if (!data) return '<span style="color: rgba(255,255,255,0.5);">—</span>';
                    var short = data.length > 40 ? data.substring(0, 40) + '…' : data;
                    return '<span title="' + $('<div>').text(data).html() + '">' + short + '</span>';
                }
            },
            {
                data: null, orderable: false, className: 'text-center align-middle',
                render: function(data, type, row) {
                    var safeId = row.id;
                    var safeName = $('<div>').text(row.name || '').html();
                    
                    var assignBtn = !row.id_user ? '<button class="btn-action-assign" onclick="assignGuru(' + safeId + ', \'' + safeName + '\')" title="Assign Akun"><i class="fas fa-user-plus"></i></button>' : '';
                    
                    return '<div style="display: flex; justify-content: center; gap: 4px;">' +
                        assignBtn +
                        '<button class="btn-action-detail" onclick="showDetail(' + safeId + ')" title="Detail"><i class="fas fa-eye"></i></button>' +
                        '<button class="btn-action-edit" onclick="editGuru(' + safeId + ')" title="Edit"><i class="fas fa-edit"></i></button>' +
                        '<button class="btn-action-delete" onclick="confirmDelete(' + safeId + ', \'' + safeName + '\')" title="Hapus"><i class="fas fa-trash"></i></button>' +
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
        order: [[1, 'asc']]
    });
}

// ═══════════════════════════════════════════════════════════════════════════
// ACTION FUNCTIONS
// ═══════════════════════════════════════════════════════════════════════════

function assignGuru(guruId, guruName) {
    $('#assignGuruId').val(guruId);
    $('#assignGuruName').val(guruName || 'Guru');
    openModal('assignModal');
}

function showDetail(id) {
    $('#detailContent').html(
        '<div style="text-align: center; padding: 40px; color: rgba(255,255,255,0.5);">' +
            '<i class="fas fa-spinner fa-spin fa-2x mb-3"></i><p>Memuat detail lengkap...</p>' +
        '</div>'
    );
    openModal('detailModal');

    $.get('action_guru.php?action=detail&id=' + id)
        .done(function(data) {
            if (!data || !data.id) {
                $('#detailContent').html('<div class="modal-warning-box" style="padding: 40px;"><i class="fas fa-exclamation-triangle modal-warning-icon"></i><h4>Data guru tidak ditemukan</h4></div>');
                return;
            }

            var passwordBlock = '';
            if (data.user_password) {
                var safePass = $('<div>').text(data.user_password).html();
                passwordBlock = '<div class="password-wrapper-liquid"><span class="password-text" id="pwdText">••••••••</span><button type="button" class="btn-toggle-pass" onclick="togglePasswordDetail(\'' + safePass + '\')"><i class="fas fa-eye"></i></button></div>';
            } else {
                passwordBlock = '<span style="color: rgba(255,255,255,0.5);">Tidak ada</span>';
            }

            var unassignBtn = '';
            if (data.user_id) {
                unassignBtn = '<div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid rgba(255,255,255,0.1);">' +
                    '<button type="button" class="btn-modal-submit danger" style="padding: 8px 16px; font-size: 13px;" onclick="unassignGuru(' + data.id + ')">' +
                        '<i class="fas fa-user-minus me-2"></i>Lepas Akun User Ini' +
                    '</button>' +
                    '<small style="color: rgba(255,255,255,0.5); margin-left: 12px;">Akun user tidak akan terhapus</small>' +
                '</div>';
            }

            var mapelHtml = data.mapel_name ? '<span class="badge-mapel">' + data.mapel_name + '</span>' : '<span style="color: rgba(255,255,255,0.5);">—</span>';

            var userInfo = '';
            if (data.user_id) {
                userInfo = '<div class="detail-card-liquid user-card">' +
                    '<div class="detail-card-header"><i class="fas fa-user-shield" style="color: var(--success);"></i><h4 style="color: var(--success);">Akun Guru Terassign</h4></div>' +
                    '<div class="detail-row"><span class="detail-label">ID User:</span><span class="detail-value"><code>' + data.user_id + '</code></span></div>' +
                    '<div class="detail-row"><span class="detail-label">Nama Akun:</span><span class="detail-value">' + (data.user_name || '—') + '</span></div>' +
                    '<div class="detail-row"><span class="detail-label">Password:</span><span class="detail-value">' + passwordBlock + '</span></div>' +
                    unassignBtn +
                '</div>';
            } else {
                userInfo = '<div style="background: rgba(234, 179, 8, 0.1); border: 1px solid rgba(234, 179, 8, 0.3); border-radius: 12px; padding: 16px; color: #fcd34d;"><i class="fas fa-exclamation-triangle me-2"></i>Belum ada akun guru yang diassign</div>';
            }

            $('#detailContent').html(
                '<div class="detail-card-liquid">' +
                    '<div class="detail-card-header"><i class="fas fa-chalkboard-teacher" style="color: var(--primary-light);"></i><h4>Data Guru</h4></div>' +
                    '<div class="detail-row"><span class="detail-label">Nama:</span><span class="detail-value" style="font-weight: 700;">' + (data.name || '—') + '</span></div>' +
                    '<div class="detail-row"><span class="detail-label">No HP:</span><span class="detail-value"><a href="tel:' + (data.no_handphone || '') + '" style="color: var(--primary-light); text-decoration: none;"><i class="fas fa-phone me-2"></i>' + (data.no_handphone || '—') + '</a></span></div>' +
                    '<div class="detail-row"><span class="detail-label">Mata Pelajaran:</span><span class="detail-value">' + mapelHtml + '</span></div>' +
                    '<div class="detail-row"><span class="detail-label">Alamat:</span><span class="detail-value">' + (data.alamat || '—') + '</span></div>' +
                '</div>' +
                userInfo
            );
        })
        .fail(function() {
            $('#detailContent').html('<div class="modal-warning-box" style="padding: 40px;"><i class="fas fa-database modal-warning-icon" style="animation: none;"></i><h4>Gagal memuat detail</h4><p>Coba lagi atau refresh halaman</p></div>');
        });
}

function togglePasswordDetail(realPass) {
    var pwdText = document.getElementById('pwdText');
    var btn = event.currentTarget;
    var icon = btn.querySelector('i');
    
    if (pwdText.textContent === '••••••••') {
        pwdText.textContent = realPass;
        icon.className = 'fas fa-eye-slash';
        btn.title = 'Sembunyikan password';
    } else {
        pwdText.textContent = '••••••••';
        icon.className = 'fas fa-eye';
        btn.title = 'Tampilkan password';
    }
}

function editGuru(id) {
    $.get('action_guru.php?action=get&id=' + id)
        .done(function(data) {
            if (!data || !data.length) {
                showToast('Data guru tidak ditemukan', 'error');
                return;
            }
            var guru = data[0];
            
            $('#editId').val(guru.id);
            $('#editName').val(guru.name || '');
            $('#editNoHp').val(guru.no_handphone || '');
            $('#editMapel').val(guru.id_mapel || '');
            $('#editAlamat').val(guru.alamat || '');
            $('#editCurrentUserId').val(guru.user_id || '');
            $('#editCurrentUserName').val(guru.user_name || '');
            
            openModal('editModal');
            
            // Inject current user to Select2 after modal opens
            setTimeout(function() {
                if (guru.user_id && guru.user_name) {
                    var newOption = new Option(guru.user_name, guru.user_id, true, true);
                    $('#editUser').append(newOption).trigger('change');
                } else {
                    $('#editUser').val('').trigger('change');
                }
            }, 200);
        })
        .fail(function() { showToast('Gagal memuat data edit', 'error'); });
}

function confirmDelete(id, name) {
    $('#deleteId').val(id);
    $('#deleteName').text(name || 'Guru');
    openModal('deleteModal');
}

function unassignGuru(guruId) {
    if (!confirm('Yakin ingin melepas akun user dari guru ini?')) return;
    
    $.post('action_guru.php', { action: 'unassign', guru_id: guruId })
        .done(function(response) {
            if (response.success) {
                showToast('Akun guru berhasil di-unassign!', 'success');
                closeModal('detailModal');
                if (table) table.ajax.reload(null, false);
                loadAvailableUsers();
            } else {
                showToast(response.message || 'Gagal unassign', 'error');
            }
        })
        .fail(function() { showToast('Koneksi gagal', 'error'); });
}

// ═══════════════════════════════════════════════════════════════════════════
// TOAST NOTIFICATION
// ═══════════════════════════════════════════════════════════════════════════

function showToast(msg, type) {
    type = type || 'success';
    var bg = type === 'success' ? 'success' : 'error';
    var icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
    var html = 
        '<div class="toast toast-guru align-items-center ' + bg + ' border-0" role="alert">' +
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
// DOCUMENT READY
// ═══════════════════════════════════════════════════════════════════════════

$(document).ready(function() {
    initModalPortal();
    loadAvailableUsers();
    
    $.get('action_mapel.php?action=read')
        .done(function(data) {
            mapels = data || [];
            populateMapelDropdowns();
            initDataTable();
        })
        .fail(function() { showToast('Gagal load mapel!', 'error'); });

    // Form submissions
    $('#addForm').submit(function(e) {
        e.preventDefault();
        var $btn = $(this).find('[type=submit]');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...');
        
        $.post('action_guru.php', {
            action: 'add',
            name: $('#addName').val().trim(),
            no_handphone: $('#addNoHp').val().trim(),
            id_mapel: $('#addMapel').val() || '',
            id_user: $('#addUser').val() || '',
            alamat: $('#addAlamat').val().trim()
        }).done(function(response) {
            if (response.success) {
                closeModal('addModal');
                $('#addForm')[0].reset();
                $('#addUser').val(null).trigger('change');
                table.ajax.reload(null, false);
                showToast('Guru berhasil ditambahkan!', 'success');
            } else {
                showToast(response.message || 'Gagal menambah guru', 'error');
            }
        }).fail(function() {
            showToast('Koneksi gagal', 'error');
        }).always(function() {
            $btn.prop('disabled', false).html('<i class="fas fa-save me-2"></i>Simpan Guru');
        });
    });

    $('#editForm').submit(function(e) {
        e.preventDefault();
        var $btn = $(this).find('[type=submit]');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...');
        
        $.post('action_guru.php', {
            action: 'edit',
            id: $('#editId').val(),
            name: $('#editName').val().trim(),
            no_handphone: $('#editNoHp').val().trim(),
            id_mapel: $('#editMapel').val() || '',
            id_user: $('#editUser').val() || '',
            alamat: $('#editAlamat').val().trim()
        }).done(function(response) {
            if (response.success) {
                closeModal('editModal');
                table.ajax.reload(null, false);
                showToast('Data guru berhasil diupdate!', 'success');
            } else {
                showToast(response.message || 'Gagal update', 'error');
            }
        }).fail(function() {
            showToast('Koneksi gagal', 'error');
        }).always(function() {
            $btn.prop('disabled', false).html('<i class="fas fa-save me-2"></i>Update Guru');
        });
    });

    $('#assignForm').submit(function(e) {
        e.preventDefault();
        var $btn = $(this).find('[type=submit]');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Assign...');
        
        $.post('action_guru.php', {
            action: 'assign',
            guru_id: $('#assignGuruId').val(),
            user_id: $('#assignUserId').val()
        }).done(function(response) {
            if (response.success) {
                closeModal('assignModal');
                table.ajax.reload(null, false);
                loadAvailableUsers();
                showToast('Akun guru berhasil diassign!', 'success');
            } else {
                showToast(response.message || 'Gagal assign', 'error');
            }
        }).fail(function() {
            showToast('Koneksi gagal', 'error');
        }).always(function() {
            $btn.prop('disabled', false).html('<i class="fas fa-user-plus me-2"></i>Assign Guru');
        });
    });

    $('#confirmDelete').click(function() {
        var id = $('#deleteId').val();
        var $btn = $(this);
        
        if (!id) {
            showToast('ID tidak ditemukan', 'error');
            return;
        }
        
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Menghapus...');
        
        $.post('action_guru.php', { action: 'delete', id: id })
            .done(function(response) {
                if (response.success) {
                    closeModal('deleteModal');
                    table.ajax.reload(null, false);
                    loadAvailableUsers();
                    showToast('Guru berhasil dihapus!', 'success');
                } else {
                    showToast(response.message || 'Gagal menghapus guru', 'error');
                }
            })
            .fail(function() {
                showToast('Koneksi gagal', 'error');
            })
            .always(function() {
                $btn.prop('disabled', false).html('<i class="fas fa-trash me-2"></i>Hapus Guru');
            });
    });
});
</script>

<?php $this->stop() ?>
<?php $this->layout('layouts::app', ['title' => 'Data Users']) ?>

<?php $this->start('main') ?>

<style>
/* ============================================
   LIQUID GLASS THEME - USERS PAGE (PORTAL VERSION)
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

.page-header-users {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.page-title-users {
    font-size: 28px;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 12px;
}

.page-title-users i {
    color: var(--emerald-light);
    filter: drop-shadow(0 0 10px rgba(52, 211, 153, 0.5));
}

.page-subtitle {
    color: var(--text-muted);
    font-size: 14px;
    margin-top: 4px;
}

/* Add Button */
.btn-add-users {
    background: linear-gradient(135deg, var(--emerald), var(--gold)) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    color: white !important;
    padding: 12px 24px !important;
    font-weight: 600;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(5, 150, 105, 0.3);
    transition: all 0.3s ease;
}

.btn-add-users:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 40px rgba(5, 150, 105, 0.4);
}

/* Table Card */
.table-card-users {
    background: var(--liquid-bg);
    backdrop-filter: var(--liquid-blur);
    border: 1px solid var(--liquid-border);
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 8px 32px var(--liquid-shadow);
}

.users-table-wrapper {
    padding: 24px;
}

/* Role Badges */
.role-badge-users {
    display: inline-flex;
    padding: 8px 16px;
    border-radius: 24px;
    font-weight: 600;
    font-size: 12px;
    text-transform: uppercase;
    border: 1px solid;
    backdrop-filter: blur(10px);
}

.role-admin { background: rgba(59, 130, 246, 0.25); border-color: rgba(59, 130, 246, 0.4); color: #60a5fa; }
.role-guru { background: rgba(34, 197, 94, 0.25); border-color: rgba(34, 197, 94, 0.4); color: var(--emerald-light); }
.role-siswa { background: rgba(234, 179, 8, 0.25); border-color: rgba(234, 179, 8, 0.4); color: #facc15; }
.role-guru_bk { background: rgba(168, 85, 247, 0.25); border-color: rgba(168, 85, 247, 0.4); color: #c084fc; }

/* Action Buttons */
.btn-action-word,
.btn-action-edit,
.btn-action-delete,
.btn-action-view {
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

.btn-action-word { background: linear-gradient(135deg, rgba(14, 165, 233, 0.8), rgba(56, 189, 248, 0.6)) !important; }
.btn-action-edit { background: linear-gradient(135deg, rgba(234, 179, 8, 0.8), rgba(251, 191, 36, 0.6)) !important; }
.btn-action-delete { background: linear-gradient(135deg, rgba(220, 38, 38, 0.8), rgba(239, 68, 68, 0.6)) !important; }
.btn-action-view { background: linear-gradient(135deg, rgba(139, 92, 246, 0.8), rgba(167, 139, 250, 0.6)) !important; }

.btn-action-word:hover,
.btn-action-edit:hover,
.btn-action-delete:hover,
.btn-action-view:hover {
    transform: translateY(-2px) scale(1.1);
}

/* ============================================
   MODAL STYLES - LIQUID GLASS PORTAL VERSION
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
    transition: opacity 0.4s ease;
    
    /* Efek Liquid Glass pada Background */
    background: rgba(0, 0, 0, 0.3);
    backdrop-filter: blur(8px) saturate(200%);
    -webkit-backdrop-filter: blur(40px) saturate(200%);
    
    /* Tambahan efek glass */
    box-shadow: 
        inset 0 0 0 1px rgba(0, 0, 0, 0.3),
        inset 0 0 100px rgba(255, 255, 255, 0.05);
    
    align-items: flex-start;
    justify-content: center;
    overflow-y: auto;
}

.liquid-modal-overlay.active {
    display: flex;
    opacity: 1;
}

/* Gradient overlay untuk kedalaman */
.liquid-modal-overlay::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: 
        radial-gradient(ellipse at top, rgba(52, 211, 153, 0.08) 0%, transparent 50%),
        radial-gradient(ellipse at bottom, rgba(234, 179, 8, 0.06) 0%, transparent 50%);
    pointer-events: none;
    z-index: -1;
}

.liquid-modal {
    margin-top: 80px;
    margin-bottom: 40px;
    background: rgba(20, 30, 48, 0.38);
    backdrop-filter: blur(60px) saturate(250%);
    -webkit-backdrop-filter: blur(60px) saturate(250%);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 28px;
    width: 90%;
    max-width: 480px;
    box-shadow: 
        0 32px 64px rgba(0, 0, 0, 0.17),
        0 0 0 1px rgba(255, 255, 255, 0.1),
        inset 0 1px 0 rgba(255, 255, 255, 0.1);
    transform: scale(0.9) translateY(-20px);
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    position: relative;
    flex-shrink: 0;
}

.liquid-modal-overlay.active .liquid-modal {
    transform: scale(1) translateY(0);
}

/* Efek shimmer pada modal */
.liquid-modal::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, 
        transparent 0%, 
        rgba(255, 255, 255, 0.3) 50%, 
        transparent 100%);
    border-radius: 28px 28px 0 0;
}

.liquid-modal-header {
    padding: 22px 26px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.liquid-modal-header.primary { 
    background: linear-gradient(135deg, rgba(5, 150, 105, 0.25), rgba(52, 211, 153, 0.08));
    border-bottom: 1px solid rgba(52, 211, 153, 0.2);
}
.liquid-modal-header.warning { 
    background: linear-gradient(135deg, rgba(234, 179, 8, 0.25), rgba(251, 191, 36, 0.08));
    border-bottom: 1px solid rgba(234, 179, 8, 0.2);
}
.liquid-modal-header.danger { 
    background: linear-gradient(135deg, rgba(220, 38, 38, 0.25), rgba(239, 68, 68, 0.08));
    border-bottom: 1px solid rgba(220, 38, 38, 0.2);
}
.liquid-modal-header.info { 
    background: linear-gradient(135deg, rgba(14, 165, 233, 0.25), rgba(56, 189, 248, 0.08));
    border-bottom: 1px solid rgba(14, 165, 233, 0.2);
}
.liquid-modal-header.purple { 
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.25), rgba(167, 139, 250, 0.08));
    border-bottom: 1px solid rgba(139, 92, 246, 0.2);
}

.liquid-modal-title {
    font-weight: 700;
    font-size: 18px;
    color: white;
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
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
    backdrop-filter: blur(10px);
}

.liquid-modal-close:hover {
    background: rgba(255, 255, 255, 0.15);
    transform: rotate(90deg);
    box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
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
    background: rgba(0, 0, 0, 0.15);
    backdrop-filter: blur(10px);
}

/* Form */
.form-group-users { margin-bottom: 20px; }
.form-group-users label {
    display: block;
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 8px;
    color: rgba(255, 255, 255, 0.9);
}
.form-group-users label .required { color: #ff6b6b; margin-left: 4px; }

.form-input-users,
.form-select-users {
    width: 100%;
    padding: 14px 18px;
    background: rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 14px;
    color: white;
    font-size: 15px;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.form-input-users:focus,
.form-select-users:focus {
    outline: none;
    border-color: var(--emerald-light);
    box-shadow: 
        0 0 0 3px rgba(52, 211, 153, 0.15),
        inset 0 1px 2px rgba(0, 0, 0, 0.1);
    background: rgba(0, 0, 0, 0.3);
}

.form-select-users option { background: #1e293b; color: white; }

/* Password Wrapper */
.pass-wrapper-users {
    position: relative;
    display: flex;
    align-items: center;
}

.pass-wrapper-users .form-input-users {
    padding-right: 50px;
}

.btn-eye-users {
    position: absolute;
    right: 12px;
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.15);
    color: rgba(255, 255, 255, 0.6);
    cursor: pointer;
    padding: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
    border-radius: 8px;
    backdrop-filter: blur(10px);
}

.btn-eye-users:hover {
    color: var(--emerald-light);
    background: rgba(52, 211, 153, 0.15);
    border-color: rgba(52, 211, 153, 0.3);
}

.form-text-users {
    font-size: 13px;
    color: rgba(255, 255, 255, 0.5);
    margin-top: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
}

/* Credential Display Box */
.credential-box {
    background: rgba(0, 0, 0, 0.25);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 16px;
    backdrop-filter: blur(10px);
    position: relative;
}

.credential-label {
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: rgba(255, 255, 255, 0.5);
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.credential-value {
    font-size: 18px;
    font-weight: 600;
    color: white;
    font-family: 'Courier New', monospace;
    word-break: break-all;
    text-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
    padding-right: 50px;
}

.credential-value.password {
    color: #fbbf24;
    letter-spacing: 2px;
}

.credential-value.password.hidden {
    letter-spacing: 4px;
}

/* Show/Hide Password Button in View Modal */
.btn-show-hide-password {
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(139, 92, 246, 0.2);
    border: 1px solid rgba(139, 92, 246, 0.4);
    color: rgba(255, 255, 255, 0.8);
    cursor: pointer;
    padding: 10px;
    font-size: 16px;
    transition: all 0.3s ease;
    border-radius: 10px;
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
}

.btn-show-hide-password:hover {
    background: rgba(139, 92, 246, 0.4);
    color: white;
    border-color: rgba(139, 92, 246, 0.6);
    box-shadow: 0 0 20px rgba(139, 92, 246, 0.3);
}

.btn-show-hide-password.active {
    background: rgba(52, 211, 153, 0.3);
    border-color: rgba(52, 211, 153, 0.5);
    color: var(--emerald-light);
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
    backdrop-filter: blur(10px);
}

.btn-modal-cancel:hover {
    background: rgba(255, 255, 255, 0.12);
    color: white;
    border-color: rgba(255, 255, 255, 0.25);
    box-shadow: 0 4px 15px rgba(255, 255, 255, 0.1);
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
    box-shadow: 
        0 8px 24px rgba(5, 150, 105, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    position: relative;
    overflow: hidden;
}

.btn-modal-submit:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 
        0 12px 32px rgba(5, 150, 105, 0.4),
        inset 0 1px 0 rgba(255, 255, 255, 0.3);
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

.btn-modal-submit.info {
    background: linear-gradient(135deg, rgba(14, 165, 233, 0.9), rgba(56, 189, 248, 0.9));
    box-shadow: 0 8px 24px rgba(14, 165, 233, 0.3);
}

.btn-modal-submit.purple {
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.9), rgba(167, 139, 250, 0.9));
    box-shadow: 0 8px 24px rgba(139, 92, 246, 0.3);
}

/* Delete Modal */
.modal-warning-box { text-align: center; padding: 20px 0; }
.modal-warning-icon {
    color: #ff6b6b;
    font-size: 64px;
    margin-bottom: 16px;
    animation: pulse-warning 2s ease-in-out infinite;
    filter: drop-shadow(0 0 20px rgba(255, 107, 107, 0.4));
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
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}
.modal-warning-text {
    color: rgba(255, 255, 255, 0.7);
    font-size: 15px;
    line-height: 1.6;
}
.modal-warning-text strong { 
    color: #ff6b6b; 
    text-shadow: 0 0 15px rgba(255, 107, 107, 0.4);
}

/* Toast */
.toast-users {
    position: fixed;
    top: 24px;
    right: 24px;
    min-width: 320px;
    z-index: 100000;
    border-radius: 16px;
    backdrop-filter: blur(30px) saturate(200%);
    border: 1px solid rgba(255, 255, 255, 0.15);
    animation: slideIn 0.4s ease;
    box-shadow: 
        0 20px 40px rgba(0, 0, 0, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.1);
    overflow: hidden;
}
@keyframes slideIn {
    from { opacity: 0; transform: translateX(100%); }
    to { opacity: 1; transform: translateX(0); }
}
.toast-users.success { 
    background: rgba(34, 197, 94, 0.9); 
    border-color: rgba(34, 197, 94, 0.4); 
    color: white; 
}
.toast-users.error { 
    background: rgba(220, 38, 38, 0.9); 
    border-color: rgba(220, 38, 38, 0.4); 
    color: white; 
}

/* Responsive */
@media (max-width: 768px) {
    .page-header-users { flex-direction: column; gap: 16px; align-items: flex-start; }
    .page-title-users { font-size: 24px; }
    .btn-add-users { width: 100%; justify-content: center; }
    .users-table-wrapper { padding: 16px; }
    .liquid-modal { margin-top: 20px; width: 95%; border-radius: 20px; }
    .liquid-modal-header { padding: 18px 20px; }
    .liquid-modal-body { padding: 20px; }
    .liquid-modal-footer { padding: 16px 20px; flex-direction: column-reverse; }
    .btn-modal-cancel, .btn-modal-submit { width: 100%; justify-content: center; }
    
    /* Mobile: kurangi blur untuk performa */
    .liquid-modal-overlay {
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
    }
    
    .btn-show-hide-password {
        right: 12px;
        width: 36px;
        height: 36px;
        padding: 8px;
    }
}
</style>

<div class="container-custom">
    <!-- HEADER -->
    <div class="page-header-users">
        <div>
            <h1 class="page-title-users">
                <i class="fas fa-users"></i>Data Users
            </h1>
            <p class="page-subtitle">Kelola akun user sistem (admin, guru, siswa)</p>
        </div>
        <button class="btn btn-add-users" onclick="openModal('addModal')">
            <i class="fas fa-plus"></i>Tambah User
        </button>
    </div>

    <!-- TABLE -->
    <div class="table-card-users">
        <div class="users-table-wrapper">
            <table id="usersTable" class="display responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th width="8%" class="text-center">No</th>
                        <th width="30%">Nama</th>
                        <th width="15%" class="text-center">Role</th>
                        <th width="27%" class="text-center">Aksi</th>
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
                    <i class="fas fa-user-plus"></i>Tambah User Baru
                </h5>
                <button type="button" class="liquid-modal-close" onclick="closeModal('addModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="addForm">
                <div class="liquid-modal-body">
                    <div class="form-group-users">
                        <label>Nama <span class="required">*</span></label>
                        <input type="text" class="form-input-users" id="addName" required maxlength="255"
                               placeholder="Nama lengkap user">
                    </div>
                    <div class="form-group-users">
                        <label>Password <span class="required">*</span></label>
                        <div class="pass-wrapper-users">
                            <input type="password" class="form-input-users" id="addPassword"
                                   required placeholder="Password user" autocomplete="new-password">
                            <button type="button" class="btn-eye-users" onclick="toggleEye(this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group-users">
                        <label>Role <span class="required">*</span></label>
                        <select class="form-select-users" id="addRole" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin">Admin</option>
                            <option value="guru">Guru</option>
                            <option value="guru_bk">Guru BK</option>
                            <option value="siswa">Siswa</option>
                        </select>
                    </div>
                </div>
                <div class="liquid-modal-footer">
                    <button type="button" class="btn-modal-cancel" onclick="closeModal('addModal')">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn-modal-submit">
                        <i class="fas fa-save me-2"></i>Simpan User
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
                    <i class="fas fa-user-edit"></i>Edit User
                </h5>
                <button type="button" class="liquid-modal-close" onclick="closeModal('editModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editForm">
                <div class="liquid-modal-body">
                    <input type="hidden" id="editId">
                    <div class="form-group-users">
                        <label>Nama <span class="required">*</span></label>
                        <input type="text" class="form-input-users" id="editName" required maxlength="255">
                    </div>
                    <div class="form-group-users">
                        <label>Password</label>
                        <div class="pass-wrapper-users">
                            <input type="password" class="form-input-users" id="editPassword"
                                   placeholder="Kosongkan jika tidak ingin ganti"
                                   autocomplete="new-password">
                            <button type="button" class="btn-eye-users" onclick="toggleEye(this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="form-text-users">
                            <i class="fas fa-info-circle"></i>
                            Biarkan kosong jika tidak ingin mengganti password
                        </div>
                    </div>
                    <div class="form-group-users">
                        <label>Role <span class="required">*</span></label>
                        <select class="form-select-users" id="editRole" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin">Admin</option>
                            <option value="guru">Guru</option>
                            <option value="guru_bk">Guru BK</option>
                            <option value="siswa">Siswa</option>
                        </select>
                    </div>
                </div>
                <div class="liquid-modal-footer">
                    <button type="button" class="btn-modal-cancel" onclick="closeModal('editModal')">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn-modal-submit warning">
                        <i class="fas fa-save me-2"></i>Update User
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- DELETE MODAL -->
    <div class="liquid-modal-overlay" id="deleteModal" data-modal="true">
        <div class="liquid-modal" style="max-width: 420px;">
            <div class="liquid-modal-header danger">
                <h5 class="liquid-modal-title">
                    <i class="fas fa-exclamation-triangle"></i>Hapus User
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
                        User <strong id="deleteName"></strong> akan dihapus permanen.
                        <br><small style="color: rgba(255,255,255,0.5); display: block; margin-top: 10px;">
                            <i class="fas fa-info-circle"></i> Relasi ke siswa/guru akan dilepas otomatis
                        </small>
                    </p>
                </div>
            </div>
            <div class="liquid-modal-footer" style="justify-content: center;">
                <button type="button" class="btn-modal-cancel" onclick="closeModal('deleteModal')">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <button type="button" class="btn-modal-submit danger" id="confirmDelete">
                    <i class="fas fa-trash me-2"></i>Hapus User
                </button>
            </div>
        </div>
    </div>

    <!-- VIEW CREDENTIALS MODAL - DENGAN TOMBOL SHOW/HIDE PASSWORD -->
    <div class="liquid-modal-overlay" id="viewModal" data-modal="true">
        <div class="liquid-modal" style="max-width: 450px;">
            <div class="liquid-modal-header purple">
                <h5 class="liquid-modal-title">
                    <i class="fas fa-key"></i>Username & Password
                </h5>
                <button type="button" class="liquid-modal-close" onclick="closeModal('viewModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="liquid-modal-body">
                <input type="hidden" id="viewId">
                <input type="hidden" id="viewPasswordReal" value="">
                
                <!-- Username Display -->
                <div class="credential-box">
                    <div class="credential-label">
                        <i class="fas fa-user"></i>Username
                    </div>
                    <div class="credential-value" id="viewUsername">-</div>
                </div>

                <!-- Password Display dengan Tombol Show/Hide -->
                <div class="credential-box" style="position: relative;">
                    <div class="credential-label">
                        <i class="fas fa-lock"></i>Password
                    </div>
                    <div class="credential-value password hidden" id="viewPassword">••••••••</div>
                    <!-- Tombol Show/Hide Password -->
                    <button type="button" class="btn-show-hide-password" id="btnTogglePassword" 
                            onclick="toggleViewPassword()" title="Tampilkan/Sembunyikan Password">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>

                <!-- Role Info -->
                <div class="form-text-users" style="text-align: center; justify-content: center; margin-top: 20px;">
                    <i class="fas fa-shield-alt"></i>
                    <span id="viewRoleBadge">Role: -</span>
                </div>
            </div>
            <div class="liquid-modal-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeModal('viewModal')">
                    <i class="fas fa-times me-2"></i>Tutup
                </button>
                <button type="button" class="btn-modal-submit purple" onclick="copyCredentials()">
                    <i class="fas fa-copy me-2"></i>Copy
                </button>
            </div>
        </div>
    </div>

    <!-- WORD EXPORT MODAL -->
    <div class="liquid-modal-overlay" id="dateModal" data-modal="true">
        <div class="liquid-modal">
            <div class="liquid-modal-header info">
                <h5 class="liquid-modal-title">
                    <i class="fas fa-file-word"></i>Export Laporan Word
                </h5>
                <button type="button" class="liquid-modal-close" onclick="closeModal('dateModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="liquid-modal-body">
                <input type="hidden" id="userId">
                <div class="form-group-users">
                    <label>User</label>
                    <input type="text" class="form-input-users" id="wordUserName" readonly 
                           style="background: rgba(0, 0, 0, 0.25); opacity: 0.7;">
                </div>
                <div class="form-group-users">
                    <label>Tanggal Laporan</label>
                    <input type="date" class="form-input-users" id="reportDate">
                </div>
            </div>
            <div class="liquid-modal-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeModal('dateModal')">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <button type="button" class="btn-modal-submit info" onclick="downloadWord()">
                    <i class="fas fa-download me-2"></i>Download Word
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
    
    // Reset password view state ketika menutup viewModal
    if (modalId === 'viewModal') {
        resetPasswordView();
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
// PASSWORD TOGGLE - FORM MODALS
// ════════════════════════════════════════════════════════
function toggleEye(btn) {
    var inp  = $(btn).closest('.pass-wrapper-users').find('input');
    var icon = $(btn).find('i');
    if (inp.attr('type') === 'password') {
        inp.attr('type', 'text');
        icon.removeClass('fa-eye').addClass('fa-eye-slash');
    } else {
        inp.attr('type', 'password');
        icon.removeClass('fa-eye-slash').addClass('fa-eye');
    }
}

// ════════════════════════════════════════════════════════
// VIEW CREDENTIALS MODAL - DENGAN SHOW/HIDE PASSWORD
// ════════════════════════════════════════════════════════

// Global variable untuk menyimpan password asli
var currentPassword = '';
var isPasswordVisible = false;

function openViewModal(userId, userName, role, password) {
    $('#viewId').val(userId);
    $('#viewUsername').text(userName);
    
    // Simpan password asli
    currentPassword = password || '••••••••';
    isPasswordVisible = false;
    
    // Reset tampilan password ke hidden
    $('#viewPassword').text('••••••••').addClass('hidden');
    $('#btnTogglePassword').removeClass('active').find('i').removeClass('fa-eye-slash').addClass('fa-eye');
    
    // Update role badge
    var roleLabel = { 
        admin: 'Admin', 
        guru: 'Guru', 
        siswa: 'Siswa', 
        guru_bk: 'Guru BK' 
    }[role] || role;
    $('#viewRoleBadge').html('Role: ' + roleLabel);
    
    openModal('viewModal');
}

function toggleViewPassword() {
    var passwordEl = $('#viewPassword');
    var btn = $('#btnTogglePassword');
    var icon = btn.find('i');
    
    if (isPasswordVisible) {
        // Hide password
        passwordEl.text('••••••••').addClass('hidden');
        icon.removeClass('fa-eye-slash').addClass('fa-eye');
        btn.removeClass('active');
        isPasswordVisible = false;
    } else {
        // Show password
        passwordEl.text(currentPassword).removeClass('hidden');
        icon.removeClass('fa-eye').addClass('fa-eye-slash');
        btn.addClass('active');
        isPasswordVisible = true;
    }
}

function resetPasswordView() {
    currentPassword = '';
    isPasswordVisible = false;
}

function copyCredentials() {
    var username = $('#viewUsername').text();
    var password = isPasswordVisible ? currentPassword : '•••••••• (hidden)';
    var text = 'Username: ' + username + '\nPassword: ' + password;
    
    navigator.clipboard.writeText(text).then(function() {
        showToast('Username & Password berhasil dicopy!', 'success');
    }).catch(function() {
        showToast('Gagal copy ke clipboard', 'error');
    });
}

// ════════════════════════════════════════════════════════
// WORD EXPORT MODAL
// ════════════════════════════════════════════════════════
function openWordModal(userId, userName) {
    $('#userId').val(userId);
    $('#wordUserName').val(userName);
    $('#reportDate').val(new Date().toISOString().split('T')[0]);
    openModal('dateModal');
}

function downloadWord() {
    var uid  = $('#userId').val();
    var date = $('#reportDate').val();
    window.location.href = 'export_user.php?id=' + uid + '&date=' + date;
}

// ════════════════════════════════════════════════════════
// ROLE BADGE HELPER
// ════════════════════════════════════════════════════════
function roleBadge(role) {
    var cls = { 
        admin: 'role-admin', 
        guru: 'role-guru', 
        siswa: 'role-siswa', 
        guru_bk: 'role-guru_bk' 
    }[role] || 'role-default';
    var label = { 
        admin: 'Admin', 
        guru: 'Guru', 
        siswa: 'Siswa', 
        guru_bk: 'Guru BK' 
    }[role] || role;
    return '<span class="role-badge-users ' + cls + '">' + label + '</span>';
}

// ════════════════════════════════════════════════════════
// TOAST NOTIFICATION
// ════════════════════════════════════════════════════════
function showToast(msg, type) {
    type = type || 'success';
    var bg   = type === 'success' ? 'success' : 'error';
    var icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
    var html =
        '<div class="toast toast-users align-items-center ' + bg + ' border-0" role="alert">' +
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
    var table = $('#usersTable').DataTable({
        ajax: {
            url: 'action_users.php?action=read',
            dataSrc: '',
            error: function() { showToast('Gagal load data user!', 'error'); }
        },
        columns: [
            {
                data: null, orderable: false, className: 'text-center',
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { data: 'name', className: 'align-middle' },
            {
                data: 'role', className: 'text-center align-middle',
                render: function(data) { return roleBadge(data); }
            },
            {
                data: null, orderable: false, className: 'text-center align-middle',
                render: function(data, type, row) {
                    var id   = row.id;
                    var name = $('<div>').text(row.name || '').html();
                    return '<div class="d-flex justify-content-center gap-2 flex-wrap">' +
                        '<button class="btn btn-action-view btn-sm btn-view-tbl"' +
                            ' data-id="' + id + '" data-name="' + name + '" data-role="' + row.role + '"' +
                            ' title="Lihat Username & Password">' +
                            '<i class="fas fa-key"></i></button>' +
                        '<button class="btn btn-action-edit btn-sm btn-edit-tbl"' +
                            ' data-id="' + id + '" title="Edit">' +
                            '<i class="fas fa-edit"></i></button>' +
                        '<button class="btn btn-action-delete btn-sm btn-delete-tbl"' +
                            ' data-id="' + id + '" data-name="' + name + '" title="Hapus">' +
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
        order: [[1, 'asc']]
    });

    // ── Event Handlers ────────────────────────────────
    $(document).on('click', '.btn-view-tbl', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var role = $(this).data('role');
        
        // Ambil data lengkap termasuk password dari server
        $.get('action_users.php?action=get&id=' + id)
            .done(function(data) {
                if (!data || !data.id) {
                    showToast('Data tidak ditemukan', 'error');
                    return;
                }
                // Gunakan password dari response (jika ada)
                openViewModal(data.id, data.name, data.role, data.password || '••••••••');
            })
            .fail(function() { 
                showToast('Gagal memuat data', 'error'); 
            });
    });

    $(document).on('click', '.btn-word-tbl', function() {
        openWordModal($(this).data('id'), $(this).data('name'));
    });

    $(document).on('click', '.btn-edit-tbl', function() {
        var id = $(this).data('id');
        $.get('action_users.php?action=get&id=' + id)
            .done(function(data) {
                if (!data || !data.id) {
                    showToast('Data tidak ditemukan', 'error');
                    return;
                }
                $('#editId').val(data.id);
                $('#editName').val(data.name || '');
                $('#editRole').val(data.role || '');
                $('#editPassword').val('').attr('type', 'password');
                $('#editModal .btn-eye-users i').removeClass('fa-eye-slash').addClass('fa-eye');
                openModal('editModal');
            })
            .fail(function() { showToast('Gagal memuat data', 'error'); });
    });

    $(document).on('click', '.btn-delete-tbl', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        $('#deleteId').val(id);
        $('#deleteName').text(name);
        openModal('deleteModal');
    });

    // ── ADD submit ─────────────────────────────────────
    $('#addForm').on('submit', function(e) {
        e.preventDefault();
        var $btn = $(this).find('[type=submit]');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...');

        $.post('action_users.php', {
            action:   'add',
            name:     $('#addName').val().trim(),
            password: $('#addPassword').val(),
            role:     $('#addRole').val()
        }).done(function(res) {
            if (res.success) {
                closeModal('addModal');
                $('#addForm')[0].reset();
                $('#addPassword').attr('type', 'password');
                $('#addModal .btn-eye-users i').removeClass('fa-eye-slash').addClass('fa-eye');
                table.ajax.reload(null, false);
                showToast('User berhasil ditambahkan!', 'success');
            } else {
                showToast(res.message || 'Gagal menambah user', 'error');
            }
        }).fail(function() {
            showToast('Koneksi gagal', 'error');
        }).always(function() {
            $btn.prop('disabled', false).html('<i class="fas fa-save me-2"></i>Simpan User');
        });
    });

    // ── EDIT submit ────────────────────────────────────
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        var $btn = $(this).find('[type=submit]');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...');

        $.post('action_users.php', {
            action:   'edit',
            id:       $('#editId').val(),
            name:     $('#editName').val().trim(),
            password: $('#editPassword').val(),
            role:     $('#editRole').val()
        }).done(function(res) {
            if (res.success) {
                closeModal('editModal');
                table.ajax.reload(null, false);
                showToast('User berhasil diupdate!', 'success');
            } else {
                showToast(res.message || 'Gagal update user', 'error');
            }
        }).fail(function() {
            showToast('Koneksi gagal', 'error');
        }).always(function() {
            $btn.prop('disabled', false).html('<i class="fas fa-save me-2"></i>Update User');
        });
    });

    // ── DELETE confirm ─────────────────────────────────
    $('#confirmDelete').on('click', function() {
        var id   = $('#deleteId').val();
        var $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Menghapus...');

        $.post('action_users.php', { action: 'delete', id: id })
            .done(function(res) {
                if (res.success) {
                    closeModal('deleteModal');
                    table.ajax.reload(null, false);
                    showToast('User berhasil dihapus!', 'success');
                } else {
                    showToast(res.message || 'Gagal hapus user', 'error');
                }
            }).fail(function() {
                showToast('Koneksi gagal', 'error');
            }).always(function() {
                $btn.prop('disabled', false).html('<i class="fas fa-trash me-2"></i>Hapus User');
            });
    });

}); // END ready
</script>

<?php $this->stop() ?>
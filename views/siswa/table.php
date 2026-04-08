<?php $this->layout('layouts::app', ['title' => 'Data Siswa - Management System']) ?>

<?php $this->start('main') ?>

<style>
    /* ============================================
   LIQUID GLASS THEME - SISWA PAGE (Sama dengan Guru)
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

    /* Header - Sama dengan Guru */
    .page-header-siswa {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-title-siswa {
        font-size: 28px;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-title-siswa i {
        color: var(--primary-light);
        filter: drop-shadow(0 0 10px rgba(59, 130, 246, 0.5));
    }

    .page-subtitle {
        color: var(--text-muted);
        font-size: 14px;
        margin-top: 4px;
    }

    /* Add Button - Sama dengan Guru */
    .btn-add-siswa {
        background: linear-gradient(135deg, var(--primary), #1d4ed8) !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        color: white !important;
        padding: 12px 24px !important;
        font-weight: 600;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(59, 130, 246, 0.3);
        transition: all 0.3s ease;
    }

    .btn-add-siswa:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 40px rgba(59, 130, 246, 0.4);
    }

    /* Table - Sama dengan Guru */
    .table-card-siswa {
        background: var(--liquid-bg);
        backdrop-filter: var(--liquid-blur);
        border: 1px solid var(--liquid-border);
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 8px 32px var(--liquid-shadow);
    }

    .siswa-table-wrapper {
        padding: 24px;
    }

    /* Badges - Sama dengan Guru */
    .badge-point {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.3), rgba(96, 165, 250, 0.2));
        border: 1px solid rgba(59, 130, 246, 0.4);
        color: #93c5fd;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-point-danger {
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.3), rgba(239, 68, 68, 0.2));
        border: 1px solid rgba(220, 38, 38, 0.4);
        color: #fca5a5;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        animation: pulse-red 1.4s infinite;
    }

    @keyframes pulse-red {

        0%,
        100% {
            box-shadow: 0 0 0 0 rgba(239, 68, 68, .5);
        }

        50% {
            box-shadow: 0 0 0 6px rgba(239, 68, 68, 0);
        }
    }

    .badge-aman {
        background: linear-gradient(135deg, rgba(5, 150, 105, 0.3), rgba(52, 211, 153, 0.2));
        border: 1px solid rgba(5, 150, 105, 0.4);
        color: #6ee7b7;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-warned {
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.3), rgba(239, 68, 68, 0.2));
        border: 1px solid rgba(220, 38, 38, 0.4);
        color: #fca5a5;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

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

    .badge-sp {
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.3), rgba(109, 40, 217, 0.2));
        border: 1px solid rgba(139, 92, 246, 0.4);
        color: #c4b5fd;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-sp-none {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: rgba(255, 255, 255, 0.5);
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-kelas {
        background: linear-gradient(135deg, rgba(8, 145, 178, 0.3), rgba(34, 211, 238, 0.2));
        border: 1px solid rgba(8, 145, 178, 0.4);
        color: #67e8f9;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    /* SP Button - Sama dengan Guru */
    .btn-sp {
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.8), rgba(109, 40, 217, 0.6));
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        font-size: .75rem;
        font-weight: 700;
        padding: .28rem .55rem;
        border-radius: .35rem;
        cursor: pointer;
        transition: all 0.3s ease;
        letter-spacing: .3px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-sp:hover {
        opacity: .88;
        transform: scale(1.06);
    }

    .btn-sp:active {
        transform: scale(.97);
    }

    /* Action Buttons - Sama dengan Guru */
    .btn-action-sp,
    .btn-action-assign,
    .btn-action-detail,
    .btn-action-edit,
    .btn-action-delete {
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
        font-size: 0.85rem;
    }

    .btn-action-sp {
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.8), rgba(109, 40, 217, 0.6)) !important;
        width: auto;
        padding: 0 12px;
        font-weight: 600;
        font-size: 0.75rem;
    }

    .btn-action-assign {
        background: linear-gradient(135deg, rgba(5, 150, 105, 0.8), rgba(52, 211, 153, 0.6)) !important;
    }

    .btn-action-detail {
        background: linear-gradient(135deg, rgba(8, 145, 178, 0.8), rgba(34, 211, 238, 0.6)) !important;
    }

    .btn-action-edit {
        background: linear-gradient(135deg, rgba(234, 179, 8, 0.8), rgba(251, 191, 36, 0.6)) !important;
    }

    .btn-action-delete {
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.8), rgba(239, 68, 68, 0.6)) !important;
    }

    .btn-action-sp:hover,
    .btn-action-assign:hover,
    .btn-action-detail:hover,
    .btn-action-edit:hover,
    .btn-action-delete:hover {
        transform: translateY(-2px) scale(1.1);
    }

    /* ============================================
   MODAL STYLES - PORTAL SYSTEM (Sama dengan Guru)
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

    .liquid-modal-header.primary {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(96, 165, 250, 0.05));
    }

    .liquid-modal-header.success {
        background: linear-gradient(135deg, rgba(5, 150, 105, 0.2), rgba(52, 211, 153, 0.05));
    }

    .liquid-modal-header.warning {
        background: linear-gradient(135deg, rgba(234, 179, 8, 0.2), rgba(251, 191, 36, 0.05));
    }

    .liquid-modal-header.danger {
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.2), rgba(239, 68, 68, 0.05));
    }

    .liquid-modal-header.info {
        background: linear-gradient(135deg, rgba(8, 145, 178, 0.2), rgba(34, 211, 238, 0.05));
    }

    .liquid-modal-header.sp {
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.2), rgba(109, 40, 217, 0.05));
    }

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

    /* Form Styles - Sama dengan Guru */
    .form-group-siswa {
        margin-bottom: 20px;
    }

    .form-group-siswa label {
        display: block;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 8px;
        color: rgba(255, 255, 255, 0.9);
    }

    .form-group-siswa label .required {
        color: #ff6b6b;
        margin-left: 4px;
    }

    .form-group-siswa label .optional {
        color: rgba(255, 255, 255, 0.5);
        font-weight: 400;
        margin-left: 4px;
        font-size: 12px;
    }

    .form-input-siswa,
    .form-select-siswa,
    .form-textarea-siswa {
        width: 100%;
        padding: 14px 18px;
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 14px;
        color: white;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    .form-input-siswa:focus,
    .form-select-siswa:focus,
    .form-textarea-siswa:focus {
        outline: none;
        border-color: var(--primary-light);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-select-siswa option {
        background: #1e293b;
        color: white;
    }

    .form-textarea-siswa {
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

    .input-group-siswa {
        display: flex;
        align-items: center;
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 14px;
        overflow: hidden;
    }

    .input-group-siswa .input-icon {
        padding: 0 16px;
        color: rgba(255, 255, 255, 0.5);
    }

    .input-group-siswa .form-input-siswa {
        border: none;
        background: transparent;
        flex: 1;
    }

    /* Detail Card in Modal - Sama dengan Guru */
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

    .detail-card-liquid.siswa-card {
        border-left: 4px solid var(--primary);
    }

    .detail-card-liquid.ortu-card {
        border-left: 4px solid var(--info);
    }

    .detail-card-liquid.alamat-card {
        border-left: 4px solid var(--danger);
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

    /* Modal Buttons - Sama dengan Guru */
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

    .btn-modal-submit.sp {
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.9), rgba(109, 40, 217, 0.9));
        box-shadow: 0 8px 24px rgba(139, 92, 246, 0.3);
    }

    /* Delete Modal Warning - Sama dengan Guru */
    .modal-warning-box {
        text-align: center;
        padding: 20px 0;
    }

    .modal-warning-icon {
        color: #ff6b6b;
        font-size: 64px;
        margin-bottom: 16px;
        animation: pulse-warning 2s ease-in-out infinite;
    }

    @keyframes pulse-warning {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }
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

    .modal-warning-text strong {
        color: #ff6b6b;
    }

    /* Toast - Sama dengan Guru */
    .toast-siswa {
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
        from {
            opacity: 0;
            transform: translateX(100%);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .toast-siswa.success {
        background: rgba(34, 197, 94, 0.9);
        border-color: rgba(34, 197, 94, 0.4);
        color: white;
    }

    .toast-siswa.error {
        background: rgba(220, 38, 38, 0.9);
        border-color: rgba(220, 38, 38, 0.4);
        color: white;
    }

    /* DataTable Customization - Sama dengan Guru */
    #siswaTable tbody tr {
        background: transparent;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    #siswaTable.dataTable thead th {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.8);
        font-weight: 600;
    }

    #siswaTable.dataTable tbody td {
        color: rgba(255, 255, 255, 0.9);
    }

    /* Responsive - Sama dengan Guru */
    @media (max-width: 768px) {
        .page-header-siswa {
            flex-direction: column;
            align-items: stretch;
        }

        .page-title-siswa {
            font-size: 24px;
        }

        .btn-add-siswa {
            width: 100%;
            justify-content: center;
        }

        .siswa-table-wrapper {
            padding: 16px;
        }

        .liquid-modal {
            margin-top: 20px;
            width: 95%;
            border-radius: 20px;
        }

        .liquid-modal.large,
        .liquid-modal.xl {
            max-width: 95%;
        }

        .liquid-modal-header {
            padding: 18px 20px;
        }

        .liquid-modal-body {
            padding: 20px;
            max-height: 70vh;
        }

        .liquid-modal-footer {
            padding: 16px 20px;
            flex-direction: column-reverse;
        }

        .btn-modal-cancel,
        .btn-modal-submit {
            width: 100%;
            justify-content: center;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .detail-row {
            grid-template-columns: 1fr;
            gap: 4px;
        }

        .btn-action-sp,
        .btn-action-assign,
        .btn-action-detail,
        .btn-action-edit,
        .btn-action-delete {
            width: 32px;
            height: 32px;
            font-size: 0.75rem;
        }

        /* DO Modal specific styles */
        #doModal .detail-card-liquid {
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 16px;
        }

        #doModal .detail-card-liquid .form-group-siswa {
            margin-bottom: 0;
        }

        #doModal .detail-card-liquid .form-group-siswa label {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 4px;
        }

        #doModal .detail-card-liquid .form-input-siswa {
            padding: 10px 14px;
            font-size: 14px;
        }

        /* Checkbox styling */
        #doConfirm {
            cursor: pointer;
        }

        #doConfirm:checked {
            accent-color: #dc2626;
        }
    }
</style>

<div class="container-custom">
    <!-- HEADER - Sama dengan Guru -->
    <div class="page-header-siswa">
        <div>
            <h1 class="page-title-siswa">
                <i class="fas fa-users"></i>Data Siswa
            </h1>
            <p class="page-subtitle">Kelola data siswa & assign akun siswa (role: siswa)</p>
        </div>
        <?php if ($_SESSION['role'] === 'admin'): ?>
            <button class="btn btn-add-siswa" onclick="openModal('addModal')">
                <i class="fas fa-plus me-2"></i>Tambah Siswa Baru
            </button>
        <?php endif; ?>
    </div>

    <!-- TABLE - Sama dengan Guru -->
    <div class="table-card-siswa">
        <div class="siswa-table-wrapper">
            <table id="siswaTable" class="display responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th width="4%" class="text-center">No</th>
                        <th width="14%">Nama Siswa</th>
                        <th width="9%" class="text-center">NIS</th>
                        <th width="11%">Kelas</th>
                        <th width="9%" class="text-center">Telp Siswa</th>
                        <th width="7%" class="text-center">Point</th>
                        <th width="7%" class="text-center">SP</th>
                        <th width="8%" class="text-center">Status</th>
                        <th width="9%" class="text-center">User</th>
                        <th width="16%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL PORTAL SOURCE -->
<div id="modal-portal-source" style="display: none;">

    <!-- ══════════════════════════════════════════════════════
         ADD SISWA MODAL
    ══════════════════════════════════════════════════════ -->
    <div class="liquid-modal-overlay" id="addModal" data-modal="true">
        <div class="liquid-modal large">
            <div class="liquid-modal-header primary">
                <h5 class="liquid-modal-title">
                    <i class="fas fa-user-plus"></i>Tambah Siswa Baru
                </h5>
                <button type="button" class="liquid-modal-close" onclick="closeModal('addModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="addForm">
                <div class="liquid-modal-body">
                    <input type="hidden" id="addDetail" value="">
                    <div class="form-row">
                        <div class="form-group-siswa">
                            <label>Nama Siswa <span class="required">*</span></label>
                            <input type="text" class="form-input-siswa" id="addName" required placeholder="Masukkan nama siswa">
                        </div>
                        <div class="form-group-siswa">
                            <label>NIS <span class="required">*</span></label>
                            <input type="number" class="form-input-siswa" id="addNis" required placeholder="Nomor Induk Siswa">
                        </div>
                    </div>
                    <div class="form-group-siswa">
                        <label>Kelas <span class="required">*</span></label>
                        <select class="form-select-siswa" id="addIdKelas" required>
                            <option value="">-- Pilih Kelas --</option>
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group-siswa">
                            <label>Nama Orang Tua <span class="required">*</span></label>
                            <input type="text" class="form-input-siswa" id="addNamaOrtu" required placeholder="Nama lengkap orang tua">
                        </div>
                        <div class="form-group-siswa">
                            <label>Pekerjaan Orang Tua</label>
                            <input type="text" class="form-input-siswa" id="addPekerjaanOrtu" placeholder="Pekerjaan (opsional)">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group-siswa">
                            <label>Telp Orang Tua</label>
                            <div class="input-group-siswa">
                                <span class="input-icon"><i class="fas fa-phone"></i></span>
                                <input type="tel" class="form-input-siswa" id="addTelpOrtu" placeholder="08xx-xxxx-xxxx">
                            </div>
                        </div>
                        <div class="form-group-siswa">
                            <label>Telp Siswa</label>
                            <div class="input-group-siswa">
                                <input type="tel" class="form-input-siswa" id="addTelp" placeholder="08xx-xxxx-xxxx">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group-siswa">
                            <label>Alamat Siswa <span class="required">*</span></label>
                            <textarea class="form-textarea-siswa" id="addAlamat" rows="3" required placeholder="Alamat lengkap siswa"></textarea>
                        </div>
                        <div class="form-group-siswa">
                            <label>Alamat Orang Tua</label>
                            <textarea class="form-textarea-siswa" id="addAlamatOrtu" rows="3" placeholder="Alamat orang tua (opsional)"></textarea>
                        </div>
                    </div>
                    <div class="form-group-siswa">
                        <label>Point Pelanggaran</label>
                        <input type="number" class="form-input-siswa" id="addPoint" value="0" readonly style="background: rgba(255,255,255,0.05);">
                        <small class="form-hint"><i class="fas fa-info-circle me-1"></i>Otomatis dari pelanggaran</small>
                    </div>
                </div>
                <div class="liquid-modal-footer">
                    <button type="button" class="btn-modal-cancel" onclick="closeModal('addModal')">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn-modal-submit">
                        <i class="fas fa-save me-2"></i>Simpan Siswa
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════════
         EDIT MODAL
    ══════════════════════════════════════════════════════ -->
    <div class="liquid-modal-overlay" id="editModal" data-modal="true">
        <div class="liquid-modal large">
            <div class="liquid-modal-header warning">
                <h5 class="liquid-modal-title">
                    <i class="fas fa-edit"></i>Edit Data Siswa
                </h5>
                <button type="button" class="liquid-modal-close" onclick="closeModal('editModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editForm">
                <div class="liquid-modal-body">
                    <input type="hidden" id="editId">
                    <div class="form-row">
                        <div class="form-group-siswa">
                            <label>Nama Siswa <span class="required">*</span></label>
                            <input type="text" class="form-input-siswa" id="editName" required>
                        </div>
                        <div class="form-group-siswa">
                            <label>NIS <span class="required">*</span></label>
                            <input type="number" class="form-input-siswa" id="editNis" required>
                        </div>
                    </div>
                    <div class="form-group-siswa">
                        <label>Kelas</label>
                        <select class="form-select-siswa" id="editIdKelas">
                            <option value="">-- Pilih Kelas --</option>
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group-siswa">
                            <label>Nama Orang Tua <span class="required">*</span></label>
                            <input type="text" class="form-input-siswa" id="editNamaOrtu" required>
                        </div>
                        <div class="form-group-siswa">
                            <label>Pekerjaan Orang Tua</label>
                            <input type="text" class="form-input-siswa" id="editPekerjaanOrtu">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group-siswa">
                            <label>Telp Orang Tua</label>
                            <div class="input-group-siswa">
                                <span class="input-icon"><i class="fas fa-phone"></i></span>
                                <input type="tel" class="form-input-siswa" id="editTelpOrtu">
                            </div>
                        </div>
                        <div class="form-group-siswa">
                            <label>Telp Siswa</label>
                            <div class="input-group-siswa">
                                <span class="input-icon"><i class="fas fa-mobile-alt"></i></span>
                                <input type="tel" class="form-input-siswa" id="editTelp">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group-siswa">
                            <label>Alamat Siswa <span class="required">*</span></label>
                            <textarea class="form-textarea-siswa" id="editAlamat" rows="3" required></textarea>
                        </div>
                        <div class="form-group-siswa">
                            <label>Alamat Orang Tua</label>
                            <textarea class="form-textarea-siswa" id="editAlamatOrtu" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group-siswa">
                            <label>ID User (Siswa) <span class="optional">(opsional)</span></label>
                            <input type="number" class="form-input-siswa" id="editIdUser" placeholder="Kosongkan jika tidak assign">
                            <small class="form-hint"><i class="fas fa-info-circle me-1"></i>Assign user role siswa ke siswa ini</small>
                        </div>
                        <div class="form-group-siswa">
                            <label>Point Pelanggaran</label>
                            <input type="number" class="form-input-siswa" id="editPoint" readonly style="background: rgba(255,255,255,0.05);">
                            <small class="form-hint"><i class="fas fa-info-circle me-1"></i>Otomatis dari pelanggaran</small>
                        </div>
                    </div>
                </div>
                <div class="liquid-modal-footer">
                    <button type="button" class="btn-modal-cancel" onclick="closeModal('editModal')">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn-modal-submit warning">
                        <i class="fas fa-save me-2"></i>Update Siswa
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════════
         DETAIL MODAL
    ══════════════════════════════════════════════════════ -->
    <div class="liquid-modal-overlay" id="detailModal" data-modal="true">
        <div class="liquid-modal xl">
            <div class="liquid-modal-header info">
                <h5 class="liquid-modal-title">
                    <i class="fas fa-info-circle"></i>Detail Siswa Lengkap
                </h5>
                <button type="button" class="liquid-modal-close" onclick="closeModal('detailModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="liquid-modal-body" id="detailContent">
                <div style="text-align: center; padding: 40px; color: rgba(255,255,255,0.5);">
                    <i class="fas fa-spinner fa-spin fa-2x mb-3"></i>
                    <p>Memuat detail siswa...</p>
                </div>
            </div>
            <div class="liquid-modal-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeModal('detailModal')">
                    <i class="fas fa-times me-2"></i>Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════════
         ASSIGN USER MODAL
    ══════════════════════════════════════════════════════ -->
    <div class="liquid-modal-overlay" id="assignModal" data-modal="true">
        <div class="liquid-modal">
            <div class="liquid-modal-header success">
                <h5 class="liquid-modal-title">
                    <i class="fas fa-user-plus"></i>Assign Akun Siswa
                </h5>
                <button type="button" class="liquid-modal-close" onclick="closeModal('assignModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="assignForm">
                <div class="liquid-modal-body">
                    <input type="hidden" id="assignSiswaId">
                    <div class="form-group-siswa">
                        <label>Siswa</label>
                        <input type="text" class="form-input-siswa" id="assignSiswaName" readonly style="background: rgba(255,255,255,0.05);">
                    </div>
                    <div class="form-group-siswa">
                        <label>Pilih Akun Siswa <span class="required">*</span></label>
                        <select class="form-select-siswa" id="assignUserId" required>
                            <option value="">-- Loading akun siswa tersedia --</option>
                        </select>
                        <small class="form-hint"><i class="fas fa-info-circle me-1"></i>Hanya menampilkan akun siswa (role: siswa) yang belum diassign</small>
                    </div>
                </div>
                <div class="liquid-modal-footer">
                    <button type="button" class="btn-modal-cancel" onclick="closeModal('assignModal')">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn-modal-submit success">
                        <i class="fas fa-user-plus me-2"></i>Assign Siswa
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════════
         SP CONFIRM MODAL
    ══════════════════════════════════════════════════════ -->
    <div class="liquid-modal-overlay" id="spModal" data-modal="true">
        <div class="liquid-modal" style="max-width: 400px;">
            <div class="liquid-modal-header sp">
                <h5 class="liquid-modal-title">
                    <i class="fas fa-file-signature"></i>Konfirmasi SP
                </h5>
                <button type="button" class="liquid-modal-close" onclick="closeModal('spModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="liquid-modal-body">
                <div class="modal-warning-box">
                    <i class="fas fa-triangle-exclamation modal-warning-icon" style="color: #8b5cf6; animation: none;"></i>
                    <h4 class="modal-warning-title" id="spMessage"></h4>
                    <p class="modal-warning-text">
                        Point siswa akan direset ke <strong>0</strong> dan SP akan bertambah
                    </p>
                </div>
            </div>
            <div class="liquid-modal-footer" style="justify-content: center;">
                <button type="button" class="btn-modal-cancel" onclick="closeModal('spModal')">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <button type="button" class="btn-modal-submit sp" id="confirmSp">
                    <i class="fas fa-file-signature me-2"></i>Terbitkan SP
                </button>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════════
        DELETE CONFIRM MODAL - DENGAN 2 OPSI
    ══════════════════════════════════════════════════════ -->
    <div class="liquid-modal-overlay" id="deleteModal" data-modal="true">
        <div class="liquid-modal" style="max-width: 450px;">
            <div class="liquid-modal-header danger">
                <h5 class="liquid-modal-title">
                    <i class="fas fa-trash"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="liquid-modal-close" onclick="closeModal('deleteModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="liquid-modal-body">
                <input type="hidden" id="deleteId">
                <div class="modal-warning-box" style="padding: 10px 0;">
                    <i class="fas fa-exclamation-triangle modal-warning-icon" style="font-size: 48px;"></i>
                    <p class="modal-warning-text" id="deleteMessage" style="margin-top: 12px;"></p>
                </div>
                
                <!-- Opsi untuk SP < 3 -->
                <div id="deleteOptions" style="display: none; margin-top: 20px;">
                    <div style="display: grid; gap: 12px;">
                        <!-- Opsi 1: Unassign User -->
                        <button type="button" class="btn-delete-option" id="btnUnassignUser" style="
                            background: linear-gradient(135deg, rgba(234, 179, 8, 0.2), rgba(251, 191, 36, 0.1));
                            border: 1px solid rgba(234, 179, 8, 0.4);
                            color: #fcd34d;
                            padding: 14px;
                            border-radius: 12px;
                            cursor: pointer;
                            transition: all 0.3s ease;
                            text-align: left;
                            display: flex;
                            align-items: center;
                            gap: 12px;
                        ">
                            <div style="background: rgba(234, 179, 8, 0.3); width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user-slash" style="color: #fcd34d; font-size: 18px;"></i>
                            </div>
                            <div>
                                <div style="font-weight: 600; font-size: 14px;">Unassign & Hapus User</div>
                                <div style="font-size: 12px; color: rgba(255,255,255,0.6);">Hapus akun login siswa dari sistem</div>
                            </div>
                        </button>
                        
                        <!-- Opsi 2: Hapus Riwayat Pelanggaran -->
                        <button type="button" class="btn-delete-option" id="btnClearPelanggaran" style="
                            background: linear-gradient(135deg, rgba(220, 38, 38, 0.2), rgba(239, 68, 68, 0.1));
                            border: 1px solid rgba(220, 38, 38, 0.4);
                            color: #fca5a5;
                            padding: 14px;
                            border-radius: 12px;
                            cursor: pointer;
                            transition: all 0.3s ease;
                            text-align: left;
                            display: flex;
                            align-items: center;
                            gap: 12px;
                        ">
                            <div style="background: rgba(220, 38, 38, 0.3); width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-history" style="color: #fca5a5; font-size: 18px;"></i>
                            </div>
                            <div>
                                <div style="font-weight: 600; font-size: 14px;">Hapus Riwayat Pelanggaran</div>
                                <div style="font-size: 12px; color: rgba(255,255,255,0.6);">Hapus semua data pelanggaran & reset point</div>
                            </div>
                        </button>
                        
                        <!-- Divider -->
                        <div style="text-align: center; color: rgba(255,255,255,0.4); font-size: 12px; margin: 8px 0;">
                            — atau —
                        </div>
                        
                        <!-- Opsi 3: Hapus Permanen (Full Delete) -->
                        <button type="button" class="btn-delete-option" id="btnFullDelete" style="
                            background: linear-gradient(135deg, rgba(220, 38, 38, 0.4), rgba(0, 0, 0, 0.2));
                            border: 2px solid rgba(220, 38, 38, 0.6);
                            color: #fca5a5;
                            padding: 14px;
                            border-radius: 12px;
                            cursor: pointer;
                            transition: all 0.3s ease;
                            text-align: left;
                            display: flex;
                            align-items: center;
                            gap: 12px;
                        ">
                            <div style="background: rgba(220, 38, 38, 0.4); width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-trash-alt" style="color: #fca5a5; font-size: 18px;"></i>
                            </div>
                            <div>
                                <div style="font-weight: 700; font-size: 14px;">HAPUS PERMANEN</div>
                                <div style="font-size: 12px; color: rgba(255,255,255,0.6);">Hapus siswa + user + pelanggaran</div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
            <div class="liquid-modal-footer" style="justify-content: center;">
                <button type="button" class="btn-modal-cancel" onclick="closeModal('deleteModal')">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <!-- Tombol ini hanya untuk SP >= 3 (DO) -->
                <button type="button" class="btn-modal-submit danger" id="confirmDelete" style="display: none;">
                    <i class="fas fa-trash me-2"></i>Hapus Permanen
                </button>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════════
     PANGGIL SISWA MODAL - Tanggal & Jam
══════════════════════════════════════════════════════ -->
    <div class="liquid-modal-overlay" id="panggilModal" data-modal="true">
        <div class="liquid-modal">
            <div class="liquid-modal-header warning">
                <h5 class="liquid-modal-title">
                    <i class="fas fa-envelope"></i>Surat Panggil Siswa / Orang Tua
                </h5>
                <button type="button" class="liquid-modal-close" onclick="closeModal('panggilModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="panggilForm">
                <div class="liquid-modal-body">
                    <input type="hidden" id="panggilSiswaId">

                    <!-- Info Siswa -->
                    <div class="form-group-siswa">
                        <label>Nama Siswa</label>
                        <input type="text" class="form-input-siswa" id="panggilSiswaName" readonly style="background: rgba(255,255,255,0.05);">
                    </div>

                    <!-- Tanggal -->
                    <div class="form-group-siswa">
                        <label>Tanggal Panggilan <span class="required">*</span></label>
                        <input type="date" class="form-input-siswa" id="panggilTanggal" required>
                    </div>

                    <!-- Jam -->
                    <div class="form-group-siswa">
                        <label>Jam Panggilan <span class="required">*</span></label>
                        <input type="time" class="form-input-siswa" id="panggilJam" required>
                        <small class="form-hint"><i class="fas fa-info-circle me-1"></i>Format 24 jam (contoh: 08:00)</small>
                    </div>

                    <!-- Keperluan -->
                    <div class="form-group-siswa">
                        <label>Keperluan <span class="required">*</span></label>
                        <select class="form-select-siswa" id="panggilKeperluan" required>
                            <option value="">-- Pilih Keperluan --</option>
                            <option value="Masalah Disiplin Siswa" selected>Masalah Disiplin Siswa</option>
                            <option value="Konseling Siswa">Konseling Siswa</option>
                            <option value="Pembahasan Akademik">Pembahasan Akademik</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <!-- Tempat -->
                    <div class="form-group-siswa">
                        <label>Tempat <span class="required">*</span></label>
                        <input type="text" class="form-input-siswa" id="panggilTempat" value="SMK TI Bali Global Denpasar" required>
                    </div>
                </div>
                <div class="liquid-modal-footer" style="justify-content: center;">
                    <button type="button" class="btn-modal-cancel" onclick="closeModal('panggilModal')">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn-modal-submit warning">
                        <i class="fas fa-envelope me-2"></i>Buat Surat Panggilan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════════
     DO/DROP OUT MODAL - Tanggal & Konfirmasi
══════════════════════════════════════════════════════ -->
    <div class="liquid-modal-overlay" id="doModal" data-modal="true">
        <div class="liquid-modal large">
            <div class="liquid-modal-header danger">
                <h5 class="liquid-modal-title">
                    <i class="fas fa-user-slash"></i>Surat Keputusan Drop Out (DO)
                </h5>
                <button type="button" class="liquid-modal-close" onclick="closeModal('doModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="doForm">
                <div class="liquid-modal-body">
                    <input type="hidden" id="doSiswaId">

                    <!-- Warning Box -->
                    <div class="modal-warning-box" style="padding: 20px; margin-bottom: 20px; background: rgba(220, 38, 38, 0.1); border-radius: 12px; border: 1px solid rgba(220, 38, 38, 0.3);">
                        <i class="fas fa-exclamation-triangle" style="color: #dc2626; font-size: 48px; margin-bottom: 12px;"></i>
                        <h4 style="color: #fca5a5; margin-bottom: 8px;">PERINGATAN: TINDAKAN PERMANEN</h4>
                        <p style="color: rgba(255,255,255,0.8); font-size: 14px;">
                            Keputusan DO akan mengakhiri status pendidikan siswa secara permanen.
                            Pastikan semua proses pembinaan sudah dilalui.
                        </p>
                    </div>

                    <!-- Info Siswa -->
                    <div class="detail-card-liquid" style="margin-bottom: 20px;">
                        <div class="detail-card-header">
                            <i class="fas fa-user-graduate" style="color: var(--danger);"></i>
                            <h4 style="color: var(--danger);">Data Siswa</h4>
                        </div>
                        <div class="form-row">
                            <div class="form-group-siswa">
                                <label>Nama Siswa</label>
                                <input type="text" class="form-input-siswa" id="doSiswaName" readonly style="background: rgba(255,255,255,0.05);">
                            </div>
                            <div class="form-group-siswa">
                                <label>Kelas</label>
                                <input type="text" class="form-input-siswa" id="doSiswaKelas" readonly style="background: rgba(255,255,255,0.05);">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group-siswa">
                                <label>NIS</label>
                                <input type="text" class="form-input-siswa" id="doSiswaNis" readonly style="background: rgba(255,255,255,0.05);">
                            </div>
                            <div class="form-group-siswa">
                                <label>Point Pelanggaran</label>
                                <input type="text" class="form-input-siswa" id="doSiswaPoint" readonly style="background: rgba(255,255,255,0.05); color: #fca5a5; font-weight: bold;">
                            </div>
                        </div>
                    </div>

                    <!-- Detail Orang Tua -->
                    <div class="detail-card-liquid" style="margin-bottom: 20px;">
                        <div class="detail-card-header">
                            <i class="fas fa-users" style="color: var(--info);"></i>
                            <h4 style="color: var(--info);">Data Orang Tua/Wali</h4>
                        </div>
                        <div class="form-row">
                            <div class="form-group-siswa">
                                <label>Nama Orang Tua</label>
                                <input type="text" class="form-input-siswa" id="doOrtuName" readonly style="background: rgba(255,255,255,0.05);">
                            </div>
                            <div class="form-group-siswa">
                                <label>No. Telepon</label>
                                <input type="text" class="form-input-siswa" id="doOrtuTelp" readonly style="background: rgba(255,255,255,0.05);">
                            </div>
                        </div>
                    </div>

                    <!-- Input Tanggal DO -->
                    <div class="form-group-siswa">
                        <label>Tanggal Efektif DO <span class="required">*</span></label>
                        <input type="date" class="form-input-siswa" id="doTanggal" required>
                        <small class="form-hint"><i class="fas fa-info-circle me-1"></i>Tanggal mulai berlakunya keputusan DO</small>
                    </div>

                    <!-- Alasan/Detail -->
                    <div class="form-group-siswa">
                        <label>Detail Keputusan <span class="optional">(opsional)</span></label>
                        <textarea class="form-textarea-siswa" id="doDetail" rows="3" placeholder="Tambahan detail keputusan jika diperlukan..."></textarea>
                    </div>

                    <!-- Checkbox Konfirmasi -->
                    <div class="form-group-siswa" style="margin-top: 20px;">
                        <label style="display: flex; align-items: flex-start; gap: 12px; cursor: pointer; font-weight: normal;">
                            <input type="checkbox" id="doConfirm" required style="margin-top: 3px; width: 18px; height: 18px; accent-color: #dc2626;">
                            <span style="color: rgba(255,255,255,0.9); font-size: 14px;">
                                Saya menyetujui dan memahami bahwa keputusan ini bersifat <strong style="color: #fca5a5;">PERMANEN</strong>
                                dan telah melalui proses pembinaan yang sesuai.
                            </span>
                        </label>
                    </div>
                </div>
                <div class="liquid-modal-footer" style="justify-content: center;">
                    <button type="button" class="btn-modal-cancel" onclick="closeModal('doModal')">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn-modal-submit danger" id="btnDoSubmit" disabled>
                        <i class="fas fa-user-slash me-2"></i>Terbitkan Surat DO
                    </button>
                </div>
            </form>
        </div>
    </div>

</div><!-- END MODAL PORTAL SOURCE -->


<!-- JAVASCRIPT -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
    var userRole = '<?= $_SESSION['role'] ?? '' ?>';

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
            modal.addEventListener('click', function(e) {
                e.stopPropagation();
            });
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

    // ============================================================
    // GLOBAL VARIABLES
    // ============================================================
    let kelasData = [];
    let siswaTable;
    let deleteSiswaId = null;
    let spSiswaId = null;
    let availableUsers = [];
    let panggilSiswaId = null;
    let doSiswaData = null;

    // ============================================================
    // Fungsi DO Student - Ganti yang lama
    // ============================================================
    function DOStudent(id, name) {
        // Ambil data lengkap siswa dari DataTable
        const rowData = $('#siswaTable').DataTable().rows().data().toArray().find(r => r.id == id);

        if (!rowData) {
            showToast('❌ Data siswa tidak ditemukan', 'error');
            return;
        }

        doSiswaData = rowData;

        // Isi form dengan data siswa
        $('#doSiswaId').val(id);
        $('#doSiswaName').val(rowData.name || '-');
        $('#doSiswaKelas').val(rowData.kelas_name || '-');
        $('#doSiswaNis').val(rowData.nis || '-');
        $('#doSiswaPoint').val((rowData.point || 0) + ' pt');
        $('#doOrtuName').val(rowData.name_orang_tua || '-');
        $('#doOrtuTelp').val(rowData.telphone_orang_tua || '-');

        // Set default tanggal hari ini
        const today = new Date().toISOString().split('T')[0];
        $('#doTanggal').val(today);
        $('#doDetail').val('');
        $('#doConfirm').prop('checked', false);
        $('#btnDoSubmit').prop('disabled', true);

        openModal('doModal');
    }
    // ============================================================
    // Enable/Disable button berdasarkan checkbox
    // ============================================================
    $(document).on('change', '#doConfirm', function() {
        $('#btnDoSubmit').prop('disabled', !this.checked);
    });

    // ============================================================
    // loadAvailableUsers
    // ============================================================
    function loadAvailableUsers() {
        return $.get('action_siswa.php?action=assign_users')
            .done(function(users) {
                availableUsers = users;
                let options = '<option value="">-- Pilih Akun Siswa Tersedia --</option>';
                if (users.length === 0) {
                    options += '<option disabled>Tidak ada akun siswa tersedia</option>';
                } else {
                    users.forEach(function(user) {
                        options += `<option value="${user.id}">${user.name}</option>`;
                    });
                }
                $('#assignUserId').html(options);
            })
            .fail(function() {
                $('#assignUserId').html('<option value="">Error loading users</option>');
                showToast('❌ Gagal memuat akun siswa', 'error');
            });
    }

    // ============================================================
    // togglePassword
    // ============================================================
    function togglePassword(btn) {
        const wrapper = $(btn).closest('.password-wrapper');
        const textEl = wrapper.find('.password-text');
        const icon = $(btn).find('i');
        const isHidden = textEl.data('hidden');
        if (isHidden) {
            textEl.text(textEl.data('real'));
            textEl.data('hidden', false);
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
            $(btn).attr('title', 'Sembunyikan password');
        } else {
            textEl.text('••••••••');
            textEl.data('hidden', true);
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
            $(btn).attr('title', 'Tampilkan password');
        }
    }

    // ============================================================
    // DOCUMENT READY
    // ============================================================
    $(document).ready(function() {

        // Initialize Modal Portal
        initModalPortal();

        // 1. LOAD KELAS
        $.get('action_kelas.php?action=read')
            .done(function(data) {
                kelasData = data || [];
                let options = '<option value="">-- Pilih Kelas --</option>';
                kelasData.forEach(function(kelas) {
                    options += `<option value="${kelas.id}">${kelas.tingkat||''} ${kelas.jurusan||''} ${kelas.kelas||''}</option>`;
                });
                $('#addIdKelas, #editIdKelas').html(options);
            })
            .fail(function() {
                showToast('❌ Gagal memuat kelas', 'error');
            });

        // 2. INIT AVAILABLE USERS
        loadAvailableUsers();

        // 3. DATATABLE
        siswaTable = $('#siswaTable').DataTable({
            ajax: {
                url: 'action_siswa.php?action=read',
                dataSrc: function(json) {
                    return json;
                },
                error: function(xhr) {
                    showToast(`❌ Gagal memuat data: ${xhr.status}`, 'error');
                }
            },
            columns: [
                // No
                {
                    data: null,
                    orderable: false,
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                // Nama
                {
                    data: 'name',
                    className: 'fw-semibold',
                    render: function(data) {
                        return data || '<i class="text-muted">—</i>';
                    }
                },
                // NIS
                {
                    data: 'nis',
                    className: 'text-center fw-semibold',
                    render: function(data) {
                        return data || '<span class="text-muted">—</span>';
                    }
                },
                // Kelas
                {
                    data: null,
                    render: function(data) {
                        return data.kelas_name ?
                            `<span class="badge bg-info">${data.kelas_name}</span>` :
                            '<span class="text-muted">Belum ada kelas</span>';
                    }
                },
                // Telp
                {
                    data: 'telphone',
                    className: 'text-center',
                    render: function(data) {
                        return data || '<i class="text-muted">—</i>';
                    }
                },
                // ── Point ── merah + animasi jika >= 100
                {
                    data: 'point',
                    className: 'text-center fw-bold',
                    render: function(data) {
                        const pt = parseInt(data) || 0;
                        const cls = pt >= 100 ? 'badge-point-danger' : 'badge-point';
                        const icon = pt >= 100 ? '🔴 ' : '';
                        return `<span class="badge ${cls}">${icon}${pt} pt</span>`;
                    }
                },
                // ── SP ── tampilkan SP1/SP2/... atau — jika 0
                {
                    data: 'sp',
                    className: 'text-center',
                    render: function(data) {
                        const sp = parseInt(data) || 0;
                        if (sp === 0) return '<span class="badge badge-sp-none">—</span>';
                        return `<span class="badge badge-sp">SP${sp}</span>`;
                    }
                },
                // ── Status ── berdasarkan nilai sp (0 = Aman, 1-2 = Warned, 3+ = DO/Drop Out)
                {
                    data: 'sp',
                    className: 'text-center',
                    render: function(data) {
                        const sp = parseInt(data) || 0;
                        if (sp === 0) {
                            return '<span class="badge badge-aman">✓ Aman</span>';
                        } else if (sp >= 3) {
                            // SP3 atau lebih = Drop Out (hanya admin yang lihat)
                            return '<span class="badge" style="background: linear-gradient(135deg, rgba(220, 38, 38, 0.5), rgba(0, 0, 0, 0.4)); border: 2px solid rgba(220, 38, 38, 0.8); color: #fca5a5; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">🚫 DROP OUT</span>';
                        } else {
                            return '<span class="badge badge-warned">⚠️ Warned</span>';
                        }
                    }
                },
                // User
                {
                    data: 'user_status',
                    className: 'text-center fw-semibold',
                    render: function(data) {
                        return data === 'Assigned' ?
                            '<span class="badge badge-assigned">✅ Assigned</span>' :
                            '<span class="badge badge-unassigned">⏳ Belum Assign</span>';
                    }
                },
                // ── Aksi ──
                {
                    data: null,
                    orderable: false,
                    className: 'text-center',
                    render: function(data, type, row) {
                        const pt = parseInt(row.point) || 0;
                        const sp = parseInt(row.sp) || 0;

                        // Jika sudah DO (SP >= 3), hanya admin yang lihat dan hanya tombol DELETE
                        if (sp >= 3) {
                            // Hanya untuk admin (karena non-admin tidak akan lihat data ini)
                            return `
                            <div class="d-flex align-items-center justify-content-center flex-wrap gap-1">
                                <span class="badge" style="background: rgba(220,38,38,0.3); color: #fca5a5; font-size: 11px; padding: 4px 8px; margin-right: 4px;">DO</span>
                                <button class="btn btn-danger btn-sm" onclick="confirmDelete(${row.id}, '${escapeHtml(row.name)}')" title="Hapus Data DO">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>`;
                        }

                        let actionBtn = '';

                        // Semua tombol hanya muncul jika point >= 100
                        if (pt >= 100) {
                            if (sp === 0) {
                                // SP = 0: Tombol Download Surat Pernyataan
                                actionBtn = `<a href="export_sp.php?id=${row.id}" target="_blank"
                                    class="btn btn-primary btn-sm me-1 text-decoration-none" title="Download Surat Pernyataan SP">
                                    <i class="fas fa-file-download me-1"></i>SP
                                </a>`;

                            } else if (sp === 1) {
                                // SP = 1: Tombol Surat Panggil Siswa
                                actionBtn = `<button class="btn btn-warning btn-sm me-1" onclick="callStudent(${row.id}, '${escapeHtml(row.name)}')" 
                                    title="Surat Panggil Siswa">
                                    <i class="fas fa-envelope me-1"></i>Panggil
                                </button>`;

                            } else if (sp === 2) {
                                // SP = 2: Tombol DO/Drop Out
                                actionBtn = `<button class="btn btn-dark btn-sm me-1" onclick="DOStudent(${row.id}, '${escapeHtml(row.name)}')" 
                                    title="Surat Keluar dari Sekolah (DO)">
                                    <i class="fas fa-user-slash me-1"></i>DO
                                </button>`;
                            }
                        }

                        const assignBtn = !row.id_user ?
                            `<button class="btn btn-success btn-sm me-1" onclick="assignUser(${row.id}, '${escapeHtml(row.name)}')" title="Assign Akun Siswa">
                            <i class="fas fa-user-plus"></i>
                        </button>` : '';

                        // Edit & Delete hanya untuk admin
                        const editBtn = userRole === 'admin' ?
                            `<button class="btn btn-warning btn-sm me-1" onclick="editData(${row.id})" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>` : '';

                        const deleteBtn = userRole === 'admin' ?
                            `<button class="btn btn-danger btn-sm" onclick="confirmDelete(${row.id}, '${escapeHtml(row.name)}', ${row.sp})" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>` : '';

                        return `
                        <div class="d-flex align-items-center justify-content-center flex-wrap gap-1">
                            ${actionBtn}
                            ${assignBtn}
                            <button class="btn btn-info btn-sm" onclick="showDetail(${row.id})" title="Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            ${editBtn}
                            ${deleteBtn}
                        </div>`;
                    }
                }
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
                emptyTable: "Belum ada data siswa"
            },
            pageLength: 25,
            responsive: true,
            order: [
                [1, 'asc']
            ],
            drawCallback: function() {
                $('[title]').tooltip({
                    trigger: 'hover',
                    placement: 'top'
                });
            }
        });

        // 4. ADD FORM
        $('#addForm').submit(function(e) {
            e.preventDefault();
            var $btn = $(this).find('[type=submit]');
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...');

            $.post('action_siswa.php', {
                action: 'add',
                name: $('#addName').val().trim(),
                nis: $('#addNis').val().trim(),
                id_kelas: $('#addIdKelas').val(),
                name_orang_tua: $('#addNamaOrtu').val().trim(),
                pekerjaan_orang_tua: $('#addPekerjaanOrtu').val().trim(),
                telphone_orang_tua: $('#addTelpOrtu').val().trim(),
                telphone: $('#addTelp').val().trim(),
                alamat: $('#addAlamat').val().trim(),
                alamat_orang_tua: $('#addAlamatOrtu').val().trim(),
                detail: $('#addDetail').val().trim()
            }).done(function(response) {
                if (response.success) {
                    closeModal('addModal');
                    $('#addForm')[0].reset();
                    siswaTable.ajax.reload();
                    showToast('✅ Siswa berhasil ditambahkan!', 'success');
                } else {
                    showToast(`❌ ${response.message || 'Gagal menambah siswa'}`, 'error');
                }
            }).fail(function() {
                showToast('❌ Koneksi gagal', 'error');
            }).always(function() {
                $btn.prop('disabled', false).html('<i class="fas fa-save me-2"></i>Simpan Siswa');
            });
        });

        // 5. EDIT FORM
        $('#editForm').submit(function(e) {
            e.preventDefault();
            var $btn = $(this).find('[type=submit]');
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...');

            $.post('action_siswa.php', {
                action: 'update',
                id: $('#editId').val(),
                name: $('#editName').val().trim(),
                nis: $('#editNis').val().trim(),
                id_kelas: $('#editIdKelas').val(),
                name_orang_tua: $('#editNamaOrtu').val().trim(),
                pekerjaan_orang_tua: $('#editPekerjaanOrtu').val().trim(),
                telphone_orang_tua: $('#editTelpOrtu').val().trim(),
                telphone: $('#editTelp').val().trim(),
                alamat: $('#editAlamat').val().trim(),
                alamat_orang_tua: $('#editAlamatOrtu').val().trim(),
                id_user: $('#editIdUser').val().trim() || null,
                point: parseInt($('#editPoint').val()) || 0
            }).done(function(response) {
                if (response.success) {
                    closeModal('editModal');
                    siswaTable.ajax.reload();
                    showToast('✅ Data siswa berhasil diupdate!', 'success');
                } else {
                    showToast(`❌ ${response.message || 'Gagal update'}`, 'error');
                }
            }).fail(function() {
                showToast('❌ Koneksi gagal', 'error');
            }).always(function() {
                $btn.prop('disabled', false).html('<i class="fas fa-save me-2"></i>Update Siswa');
            });
        });

        // 6. ASSIGN FORM
        $('#assignForm').submit(function(e) {
            e.preventDefault();
            var $btn = $(this).find('[type=submit]');
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Assign...');

            $.post('action_siswa.php', {
                action: 'assign',
                siswa_id: $('#assignSiswaId').val(),
                user_id: $('#assignUserId').val()
            }).done(function(response) {
                if (response.success) {
                    closeModal('assignModal');
                    siswaTable.ajax.reload();
                    loadAvailableUsers();
                    showToast('✅ Akun siswa berhasil diassign!', 'success');
                } else {
                    showToast(`❌ ${response.message || 'Gagal assign'}`, 'error');
                }
            }).fail(function() {
                showToast('❌ Koneksi gagal', 'error');
            }).always(function() {
                $btn.prop('disabled', false).html('<i class="fas fa-user-plus me-2"></i>Assign Siswa');
            });
        });

        // 7. CONFIRM SP
        $('#confirmSp').click(function() {
            if (!spSiswaId) return;
            var $btn = $(this);
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Memproses...');

            $.post('action_siswa.php', {
                    action: 'issue_sp',
                    id: spSiswaId
                })
                .done(function(response) {
                    if (response.success) {
                        closeModal('spModal');
                        siswaTable.ajax.reload();
                        showToast(`✅ ${response.message}`, 'success');
                    } else {
                        showToast(`❌ ${response.message || 'Gagal menerbitkan SP'}`, 'error');
                    }
                })
                .fail(function() {
                    showToast('❌ Koneksi gagal', 'error');
                })
                .always(function() {
                    $btn.prop('disabled', false).html('<i class="fas fa-file-signature me-2"></i>Terbitkan SP');
                });
        });

        // 8. CONFIRM DELETE
        $('#confirmDelete').click(function() {
            if (!deleteSiswaId) return;
            var $btn = $(this);
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Menghapus...');

            $.post('action_siswa.php', {
                    action: 'delete',
                    id: deleteSiswaId
                })
                .done(function(response) {
                    if (response.success) {
                        closeModal('deleteModal');
                        siswaTable.ajax.reload();
                        loadAvailableUsers();
                        showToast('✅ Siswa berhasil dihapus!', 'success');
                    } else {
                        showToast('❌ Gagal menghapus siswa', 'error');
                    }
                })
                .fail(function() {
                    showToast('❌ Koneksi gagal', 'error');
                })
                .always(function() {
                    $btn.prop('disabled', false).html('<i class="fas fa-trash me-2"></i>Hapus Permanen');
                });
        });

        // 9. PANGGIL FORM SUBMIT
        $('#panggilForm').submit(function(e) {
            e.preventDefault();

            const id = $('#panggilSiswaId').val();
            const tanggal = $('#panggilTanggal').val();
            const jam = $('#panggilJam').val();
            const keperluan = $('#panggilKeperluan').val();
            const tempat = $('#panggilTempat').val();

            const $btn = $(this).find('[type=submit]');
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Memproses...');

            // Step 1: Update SP dan Point via AJAX terlebih dahulu
            $.post('action_siswa.php', {
                action: 'issue_sp',
                id: id
            }).done(function(response) {
                if (response.success) {
                    // Step 2: Jika update SP berhasil, buka surat panggilan
                    const params = new URLSearchParams({
                        id: id,
                        tanggal: tanggal,
                        jam: jam,
                        keperluan: keperluan,
                        tempat: tempat
                    });

                    // Open in new tab untuk download surat
                    window.open(`export_panggil.php?${params.toString()}`, '_blank');

                    // Reload DataTable untuk menampilkan perubahan SP dan Point
                    siswaTable.ajax.reload();

                    closeModal('panggilModal');
                    showToast(`✅ ${response.message || 'Surat panggilan berhasil dibuat dan SP diterbitkan!'}`, 'success');
                } else {
                    showToast(`❌ ${response.message || 'Gagal menerbitkan SP'}`, 'error');
                }
            }).fail(function() {
                showToast('❌ Koneksi gagal saat update SP', 'error');
            }).always(function() {
                $btn.prop('disabled', false).html('<i class="fas fa-envelope me-2"></i>Buat Surat Panggilan');
            });
        });

        // 10. DO FORM SUBMIT - FIXED
        $('#doForm').submit(function(e) {
            e.preventDefault();

            if (!$('#doConfirm').is(':checked')) {
                showToast('❌ Anda harus menyetujui konfirmasi terlebih dahulu', 'error');
                return;
            }

            const id = $('#doSiswaId').val();
            const tanggal = $('#doTanggal').val();
            const detail = $('#doDetail').val();

            const $btn = $('#btnDoSubmit');
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Memproses...');

            // Langsung kirim ke do_student (sudah include issue_sp logic)
            $.post('action_siswa.php', {
                action: 'do_student',
                id: id,
                tanggal_do: tanggal,
                detail: detail
            }).done(function(response) {
                if (response.success) {
                    // Open surat DO di tab baru
                    const params = new URLSearchParams({
                        id: id,
                        tanggal: tanggal,
                        detail: detail
                    });
                    window.open(`export_do.php?${params.toString()}`, '_blank');

                    closeModal('doModal');
                    siswaTable.ajax.reload();
                    loadAvailableUsers(); // Refresh daftar user yang tersedia
                    showToast(`✅ ${response.message}`, 'success');
                } else {
                    showToast(`❌ ${response.message}`, 'error');
                }
            }).fail(function() {
                showToast('❌ Koneksi gagal saat proses DO', 'error');
            }).always(function() {
                $btn.prop('disabled', false).html('<i class="fas fa-user-slash me-2"></i>Terbitkan Surat DO');
            });
        });

        // Handler untuk tombol Unassign User
$(document).on('click', '#btnUnassignUser', function() {
    if (!deleteSiswaId) return;
    
    const $btn = $(this);
    $btn.prop('disabled', true).css('opacity', '0.5');
    
    $.post('action_siswa.php', {
        action: 'delete',
        id: deleteSiswaId,
        mode: 'unassign'
    }).done(function(response) {
        if (response.success) {
            closeModal('deleteModal');
            siswaTable.ajax.reload();
            loadAvailableUsers();
            showToast(`✅ ${response.message}`, 'success');
        } else {
            showToast(`❌ ${response.message}`, 'error');
            $btn.prop('disabled', false).css('opacity', '1');
        }
    }).fail(function() {
        showToast('❌ Koneksi gagal', 'error');
        $btn.prop('disabled', false).css('opacity', '1');
    });
});

// Handler untuk tombol Clear Pelanggaran
$(document).on('click', '#btnClearPelanggaran', function() {
    if (!deleteSiswaId) return;
    
    const $btn = $(this);
    $btn.prop('disabled', true).css('opacity', '0.5');
    
    $.post('action_siswa.php', {
        action: 'delete',
        id: deleteSiswaId,
        mode: 'clear_pelanggaran'
    }).done(function(response) {
        if (response.success) {
            closeModal('deleteModal');
            siswaTable.ajax.reload();
            showToast(`✅ ${response.message}`, 'success');
        } else {
            showToast(`❌ ${response.message}`, 'error');
            $btn.prop('disabled', false).css('opacity', '1');
        }
    }).fail(function() {
        showToast('❌ Koneksi gagal', 'error');
        $btn.prop('disabled', false).css('opacity', '1');
    });
});

// Handler untuk tombol Full Delete (SP < 3)
$(document).on('click', '#btnFullDelete', function() {
    if (!deleteSiswaId) return;
    
    const $btn = $(this);
    $btn.prop('disabled', true).css('opacity', '0.5').html('<i class="fas fa-spinner fa-spin me-2"></i>Menghapus...');
    
    $.post('action_siswa.php', {
        action: 'delete',
        id: deleteSiswaId,
        mode: 'full'
    }).done(function(response) {
        if (response.success) {
            closeModal('deleteModal');
            siswaTable.ajax.reload();
            loadAvailableUsers();
            showToast(`✅ Siswa berhasil dihapus permanen!`, 'success');
        } else {
            showToast(`❌ ${response.message}`, 'error');
            $btn.prop('disabled', false).css('opacity', '1').html(`
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="background: rgba(220, 38, 38, 0.4); width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-trash-alt" style="color: #fca5a5; font-size: 18px;"></i>
                    </div>
                    <div>
                        <div style="font-weight: 700; font-size: 14px;">HAPUS PERMANEN</div>
                        <div style="font-size: 12px; color: rgba(255,255,255,0.6);">Hapus siswa + user + pelanggaran</div>
                    </div>
                </div>
            `);
        }
    }).fail(function() {
        showToast('❌ Koneksi gagal', 'error');
        $btn.prop('disabled', false).css('opacity', '1').html(`
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="background: rgba(220, 38, 38, 0.4); width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-trash-alt" style="color: #fca5a5; font-size: 18px;"></i>
                </div>
                <div>
                    <div style="font-weight: 700; font-size: 14px;">HAPUS PERMANEN</div>
                    <div style="font-size: 12px; color: rgba(255,255,255,0.6);">Hapus siswa + user + pelanggaran</div>
                </div>
            </div>
        `);
    });
});

// Update handler untuk confirmDelete (SP >= 3)
$('#confirmDelete').click(function() {
    if (!deleteSiswaId) return;
    
    const $btn = $(this);
    $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Menghapus...');
    
    $.post('action_siswa.php', {
        action: 'delete',
        id: deleteSiswaId,
        mode: 'full'
    }).done(function(response) {
        if (response.success) {
            closeModal('deleteModal');
            siswaTable.ajax.reload();
            loadAvailableUsers();
            showToast(`✅ ${response.message}`, 'success');
        } else {
            showToast(`❌ ${response.message}`, 'error');
        }
    }).fail(function() {
        showToast('❌ Koneksi gagal', 'error');
    }).always(function() {
        $btn.prop('disabled', false).html('<i class="fas fa-trash me-2"></i>Hapus Permanen');
    });
});

    }); // END document.ready

    // ============================================================
    // GLOBAL FUNCTIONS
    // ============================================================

    function editData(id) {
        $.get(`action_siswa.php?action=edit&id=${id}`)
            .done(function(data) {
                if (data && data[0]) {
                    const s = data[0];
                    $('#editId').val(s.id);
                    $('#editName').val(s.name || '');
                    $('#editNis').val(s.nis || '');
                    $('#editIdKelas').val(s.id_kelas || '');
                    $('#editNamaOrtu').val(s.name_orang_tua || '');
                    $('#editPekerjaanOrtu').val(s.pekerjaan_orang_tua || '');
                    $('#editTelpOrtu').val(s.telphone_orang_tua || '');
                    $('#editTelp').val(s.telphone || '');
                    $('#editAlamat').val(s.alamat || '');
                    $('#editAlamatOrtu').val(s.alamat_orang_tua || '');
                    $('#editPoint').val(s.point || 0);
                    $('#editIdUser').val(s.id_user || '');
                    openModal('editModal');
                }
            })
            .fail(function() {
                showToast('❌ Gagal memuat data edit', 'error');
            });
    }

    function assignUser(siswaId, siswaName) {
        $('#assignSiswaId').val(siswaId);
        $('#assignSiswaName').val(siswaName || 'Siswa');
        $('#assignUserId').html('<option value="">-- Memuat akun siswa... --</option>');
        loadAvailableUsers().then(function() {
            openModal('assignModal');
        });
    }

    // ── Fungsi SP ── ─────────────────────────────────────────────
    function confirmSp(id, name) {
        spSiswaId = id;
        const sp = parseInt(
            $('#siswaTable').DataTable().rows().data().toArray()
            .find(r => r.id == id)?.sp || 0
        );
        const nextSp = sp + 1;
        $('#spMessage').html(
            `Terbitkan <span style="color:#a78bfa">SP${nextSp}</span> untuk siswa <strong>"${name}"</strong>?`
        );
        openModal('spModal');
    }
    // ─────────────────────────────────────────────────────────────

    // Fungsi Panggil Siswa - Ganti yang lama

    function callStudent(id, name) {
        panggilSiswaId = id;
        $('#panggilSiswaId').val(id);
        $('#panggilSiswaName').val(name || 'Siswa');

        // Set default tanggal hari ini
        const today = new Date().toISOString().split('T')[0];
        $('#panggilTanggal').val(today);
        $('#panggilJam').val('08:00');

        openModal('panggilModal');
    }

    // ============================================================
    function showDetail(id) {
        $('#detailContent').html(`
        <div style="text-align: center; padding: 40px; color: rgba(255,255,255,0.5);">
            <i class="fas fa-spinner fa-spin fa-2x mb-3"></i>
            <p>Memuat detail lengkap...</p>
        </div>`);
        openModal('detailModal');

        $.get(`action_siswa.php?action=detail&id=${id}`)
            .done(function(data) {
                if (data && data.id) {
                    let passwordBlock = '';
                    if (data.user_password) {
                        const safePass = $('<div>').text(data.user_password).html();
                        passwordBlock = `
                        <div class="password-wrapper-liquid">
                            <span class="password-text" id="pwdText">••••••••</span>
                            <button type="button" class="btn-toggle-pass" onclick="togglePasswordDetail('${safePass}')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>`;
                    } else {
                        passwordBlock = '<span style="color: rgba(255,255,255,0.5);">Tidak ada</span>';
                    }

                    const sp = parseInt(data.sp) || 0;
                    const spBadge = sp > 0 ?
                        `<span class="badge-sp">SP${sp}</span>` :
                        '<span class="badge-sp-none">—</span>';

                    const statusBadge = sp === 0 ?
                        '<span class="badge-aman">✓ Aman</span>' :
                        '<span class="badge-warned">⚠️ Warned</span>';

                    const userInfo = data.user_id ? `
                    <div class="detail-card-liquid user-card">
                        <div class="detail-card-header">
                            <i class="fas fa-user-shield" style="color: var(--success);"></i>
                            <h4 style="color: var(--success);">Akun Siswa Terassign</h4>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">ID User:</span>
                            <span class="detail-value"><code>${data.user_id}</code></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Nama Akun:</span>
                            <span class="detail-value">${data.user_name || '—'}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Password:</span>
                            <span class="detail-value">${passwordBlock}</span>
                        </div>
                    </div>` : `
                    <div style="background: rgba(234, 179, 8, 0.1); border: 1px solid rgba(234, 179, 8, 0.3); border-radius: 12px; padding: 16px; color: #fcd34d;">
                        <i class="fas fa-exclamation-triangle me-2"></i>Belum ada akun siswa yang diassign
                    </div>`;

                    $('#detailContent').html(`
                    <div class="detail-card-liquid">
                        <div class="detail-card-header">
                            <i class="fas fa-user-graduate" style="color: var(--primary-light);"></i>
                            <h4>Data Siswa</h4>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Nama:</span>
                            <span class="detail-value" style="font-weight: 700;">${data.name || '—'}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">NIS:</span>
                            <span class="detail-value">${data.nis || '—'}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Kelas:</span>
                            <span class="detail-value">${data.kelas_name || 'Belum ada'}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Telp:</span>
                            <span class="detail-value"><a href="tel:${data.telphone || ''}" style="color: var(--primary-light); text-decoration: none;"><i class="fas fa-phone me-2"></i>${data.telphone || '—'}</a></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Point:</span>
                            <span class="detail-value">
                                <span class="badge ${parseInt(data.point)>=100?'badge-point-danger':'badge-point'}">
                                    ${data.point || 0} pt
                                </span>
                            </span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">SP:</span>
                            <span class="detail-value">${spBadge}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Status:</span>
                            <span class="detail-value">${statusBadge}</span>
                        </div>
                    </div>

                    <div class="detail-card-liquid">
                        <div class="detail-card-header">
                            <i class="fas fa-users" style="color: var(--info);"></i>
                            <h4 style="color: var(--info);">Data Orang Tua</h4>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Nama:</span>
                            <span class="detail-value" style="font-weight: 600;">${data.name_orang_tua || '—'}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Pekerjaan:</span>
                            <span class="detail-value">${data.pekerjaan_orang_tua || '—'}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Telp:</span>
                            <span class="detail-value">${data.telphone_orang_tua || '—'}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Alamat:</span>
                            <span class="detail-value">${data.alamat_orang_tua || '—'}</span>
                        </div>
                    </div>

                    ${userInfo}

                    <div class="detail-card-liquid">
                        <div class="detail-card-header">
                            <i class="fas fa-map-marker-alt" style="color: var(--danger);"></i>
                            <h4 style="color: var(--danger);">Alamat & Catatan</h4>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Alamat Siswa:</span>
                            <span class="detail-value">${data.alamat || '—'}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Catatan:</span>
                            <span class="detail-value">${data.detail || '—'}</span>
                        </div>
                    </div>`);
                } else {
                    $('#detailContent').html(`
                    <div class="modal-warning-box" style="padding: 40px;">
                        <i class="fas fa-exclamation-triangle modal-warning-icon"></i>
                        <h4 class="modal-warning-title">Data siswa tidak ditemukan</h4>
                    </div>`);
                }
            })
            .fail(function() {
                $('#detailContent').html(`
                <div class="modal-warning-box" style="padding: 40px;">
                    <i class="fas fa-database modal-warning-icon" style="animation: none;"></i>
                    <h4 class="modal-warning-title">Gagal memuat detail</h4>
                    <p class="modal-warning-text">Coba lagi atau refresh halaman</p>
                </div>`);
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

    function confirmDelete(id, name, sp = null) {
        deleteSiswaId = id;
        
        // Jika SP tidak dikirim, ambil dari DataTable
        if (sp === null) {
            const rowData = $('#siswaTable').DataTable().rows().data().toArray().find(r => r.id == id);
            sp = rowData ? parseInt(rowData.sp) || 0 : 0;
        }
        
        // Simpan SP untuk digunakan saat confirm
        $('#deleteId').data('sp', sp);
        
        if (sp >= 3) {
            // Mode DO: Langsung hapus semua (pelanggaran + siswa)
            $('#deleteMessage').html(`
                <div style="background: rgba(220,38,38,0.2); border: 1px solid rgba(220,38,38,0.4); border-radius: 8px; padding: 12px; margin-bottom: 12px;">
                    <i class="fas fa-exclamation-triangle" style="color: #dc2626;"></i>
                    <strong style="color: #fca5a5;">SISWA DROP OUT (SP${sp})</strong>
                </div>
                Siswa <strong style="color: #ff6b6b;">"${name || 'Siswa'}"</strong> akan dihapus <span style="color: #ff6b6b; font-weight: 700;">PERMANEN!</span><br><br>
                <span style="color: #fca5a5; font-size: 13px;">
                    <i class="fas fa-info-circle"></i> Semua riwayat pelanggaran juga akan ikut terhapus otomatis.
                </span>
            `);
            // Sembunyikan tombol opsi, hanya tampilkan tombol hapus permanen
            $('#deleteOptions').hide();
            $('#confirmDelete').show().data('mode', 'full');
        } else {
            // Mode Normal: Tampilkan 2 opsi
            $('#deleteMessage').html(`
                Siswa <strong style="color: #ff6b6b;">"${name || 'Siswa'}"</strong> akan dihapus.<br>
                <span style="color: rgba(255,255,255,0.7); font-size: 13px;">Pilih opsi penghapusan:</span>
            `);
            // Tampilkan tombol opsi
            $('#deleteOptions').show();
            $('#confirmDelete').hide().data('mode', '');
        }
        
        openModal('deleteModal');
    }

    // Escape HTML sederhana untuk nama di dalam onclick
    function escapeHtml(str) {
        return String(str || '').replace(/'/g, "\\'").replace(/"/g, '&quot;');
    }

    function showToast(message, type = 'success') {
        // Remove existing toasts
        $('.toast-guru').remove();

        const bgClass = type === 'success' ? 'success' : 'error';
        const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
        const toastHtml = `
        <div class="toast toast-guru align-items-center ${bgClass} border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas ${iconClass} me-2"></i>${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="$(this).closest('.toast').remove()"></button>
            </div>
        </div>`;
        $('body').append(toastHtml);
        setTimeout(function() {
            $('.toast-guru').fadeOut(300, function() {
                $(this).remove();
            });
        }, 4000);
    }
</script>

<?php $this->stop() ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->e($title ?? 'Vin web') ?></title>

    <!-- PINDAHKAN JQUERY KE SINI (sebelum CSS lainnya juga gapapa) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* ============================================
   ALASAN PELANGGARAN PAGE STYLES
   ============================================ */

        /* Table Card Styling */
        .table-card-violation {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 0.125rem 0.25rem var(--glass-shadow);
            transition: all var(--transition-normal);
        }

        .table-card-violation:hover {
            box-shadow: 0 25px 50px -12px var(--glass-shadow), 0 0 40px rgba(52, 211, 153, 0.1);
        }

        /* DataTables Wrapper Customization */
        .violation-table-wrapper {
            padding: 20px;
        }

        .violation-table-wrapper .dataTables_length,
        .violation-table-wrapper .dataTables_filter {
            margin-bottom: 15px;
        }

        .violation-table-wrapper .dataTables_length select,
        .violation-table-wrapper .dataTables_filter input {
            background: var(--glass-bg) !important;
            border: 1px solid var(--glass-border) !important;
            border-radius: 8px !important;
            color: var(--text-primary) !important;
            padding: 8px 15px !important;
        }

        .violation-table-wrapper .dataTables_filter input:focus {
            border-color: var(--emerald-light) !important;
            box-shadow: 0 0 15px rgba(52, 211, 153, 0.2);
        }

        /* Detail Text Cell */
        .detail-text-violation {
            max-height: 60px;
            overflow-y: auto;
            font-size: 0.9em;
            padding: 8px 12px;
            background: var(--glass-hover);
            border: 1px solid var(--glass-border);
            border-radius: 8px;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        /* Action Buttons */
        .btn-action-edit {
            margin-right: 5px;
            background: linear-gradient(135deg, var(--warning), #f59e0b) !important;
            border: none !important;
            color: white !important;
            transition: all var(--transition-fast);
        }

        .btn-action-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(234, 179, 8, 0.3);
        }

        .btn-action-delete {
            background: linear-gradient(135deg, var(--danger), #ef4444) !important;
            border: none !important;
            color: white !important;
            transition: all var(--transition-fast);
        }

        .btn-action-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(220, 38, 38, 0.3);
        }

        /* Page Header */
        .page-header-violation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .page-title-violation {
            font-size: 28px;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-title-violation i {
            color: var(--danger);
        }

        /* Add Button */
        .btn-add-violation {
            background: linear-gradient(135deg, var(--danger), #ef4444) !important;
            border: none !important;
            color: white !important;
            padding: 12px 24px !important;
            font-weight: 600;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(220, 38, 38, 0.3);
            transition: all var(--transition-fast);
        }

        .btn-add-violation:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(220, 38, 38, 0.4);
        }

        .btn-add-violation i {
            margin-right: 8px;
        }

        /* ============================================
   MODAL STYLES - VIOLATION REASONS
   ============================================ */

        /* Modal Base */
        .modal-violation .modal-content {
            background: var(--glass-bg);
            backdrop-filter: blur(30px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px var(--glass-shadow);
        }

        /* Modal Header */
        .modal-violation .modal-header {
            border-bottom: 1px solid var(--glass-border);
            padding: 20px 24px;
        }

        .modal-violation .modal-header.bg-warning-custom {
            background: linear-gradient(135deg, rgba(234, 179, 8, 0.2), rgba(212, 165, 116, 0.1));
            color: var(--text-primary);
        }

        .modal-violation .modal-header.bg-danger-custom {
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.2), rgba(239, 68, 68, 0.1));
            color: white;
        }

        .modal-violation .modal-title {
            font-weight: 700;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modal-violation .btn-close {
            background: transparent;
            opacity: 0.7;
            transition: all var(--transition-fast);
        }

        .modal-violation .btn-close:hover {
            opacity: 1;
            transform: rotate(90deg);
        }

        .modal-violation .btn-close-white {
            filter: invert(1);
        }

        /* Modal Body */
        .modal-violation .modal-body {
            padding: 24px;
            max-height: 70vh;
            overflow-y: auto;
        }

        /* Form Sections */
        .form-section-violation {
            margin-bottom: 20px;
            padding: 20px;
            background: var(--glass-hover);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            transition: all var(--transition-fast);
        }

        .form-section-violation:hover {
            border-color: var(--emerald-light);
            box-shadow: 0 0 20px rgba(52, 211, 153, 0.1);
        }

        .form-section-violation label {
            display: block;
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 12px;
            color: var(--text-primary);
        }

        .form-section-violation label span.text-danger {
            color: var(--danger);
        }

        /* Select & Textarea Styling */
        .form-select-violation,
        .form-textarea-violation {
            width: 100%;
            padding: 14px 16px;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            color: var(--text-primary);
            font-family: inherit;
            font-size: 15px;
            transition: all var(--transition-fast);
        }

        .form-select-violation:focus,
        .form-textarea-violation:focus {
            outline: none;
            border-color: var(--emerald-light);
            box-shadow: 0 0 20px rgba(52, 211, 153, 0.2);
        }

        .form-textarea-violation {
            resize: vertical;
            min-height: 100px;
        }

        .form-text-violation {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 6px;
        }

        /* Dynamic Input Container */
        .detail-container-violation {
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            padding: 20px;
            background: var(--glass-bg);
        }

        /* Input Rows */
        .input-row-violation {
            margin-bottom: 16px;
            padding: 20px;
            background: var(--glass-hover);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            transition: all var(--transition-fast);
        }

        .input-row-violation.temporary-row {
            background: var(--glass-bg);
            border-style: dashed;
        }

        .input-row-violation:not(.temporary-row) {
            background: transparent;
            border-style: solid;
        }

        .input-row-violation:hover {
            border-color: var(--emerald-light);
            transform: translateX(4px);
        }

        .input-row-violation label {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 10px;
            display: block;
        }

        /* Remove Button */
        .btn-remove-row {
            width: 100%;
            height: 46px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            transition: all var(--transition-fast);
        }

        .btn-remove-row:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-remove-row:not(:disabled) {
            background: linear-gradient(135deg, var(--danger), #ef4444) !important;
            border: none !important;
            color: white !important;
        }

        .btn-remove-row:not(:disabled):hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(220, 38, 38, 0.3);
        }

        /* Add Row Button Section */
        .add-row-section-violation {
            text-align: center;
            margin: 24px 0;
        }

        .btn-add-row-violation {
            background: linear-gradient(135deg, var(--success), #22c55e) !important;
            border: none !important;
            color: white !important;
            padding: 12px 28px !important;
            font-weight: 600;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(34, 197, 94, 0.3);
            transition: all var(--transition-fast);
        }

        .btn-add-row-violation:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(34, 197, 94, 0.4);
        }

        /* Modal Footer */
        .modal-violation .modal-footer {
            border-top: 1px solid var(--glass-border);
            padding: 20px 24px;
            gap: 12px;
        }

        .btn-cancel-violation {
            background: var(--glass-bg) !important;
            border: 1px solid var(--glass-border) !important;
            color: var(--text-secondary) !important;
            padding: 12px 24px !important;
            border-radius: 12px;
            transition: all var(--transition-fast);
        }

        .btn-cancel-violation:hover {
            background: var(--glass-hover) !important;
            color: var(--text-primary) !important;
        }

        .btn-submit-violation {
            background: linear-gradient(135deg, var(--emerald), var(--gold)) !important;
            border: none !important;
            color: white !important;
            padding: 12px 32px !important;
            font-weight: 600;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(5, 150, 105, 0.3);
            transition: all var(--transition-fast);
        }

        .btn-submit-violation:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(5, 150, 105, 0.4);
        }

        .btn-submit-violation:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            filter: grayscale(0.5);
        }

        /* Warning/Delete Modal Specific */
        .modal-warning-icon {
            color: var(--danger);
            font-size: 48px;
            margin-bottom: 20px;
            animation: pulse-warning 2s ease-in-out infinite;
        }

        @keyframes pulse-warning {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
        }

        .modal-warning-text {
            font-weight: 700;
            font-size: 20px;
            margin-bottom: 12px;
            color: var(--text-primary);
        }

        .modal-warning-subtext {
            color: var(--text-muted);
            font-size: 15px;
        }

        .modal-warning-subtext strong {
            color: var(--danger);
        }

        /* Toast Notification */
        .toast-violation {
            position: fixed;
            top: 20px;
            right: 20px;
            min-width: 320px;
            z-index: 1099;
            border-radius: 12px;
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            animation: slideInToast 0.3s ease;
        }

        @keyframes slideInToast {
            from {
                opacity: 0;
                transform: translateX(100%);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .toast-violation.success {
            background: rgba(34, 197, 94, 0.15);
            border-color: rgba(34, 197, 94, 0.3);
            color: var(--success);
        }

        .toast-violation.error {
            background: rgba(220, 38, 38, 0.15);
            border-color: rgba(220, 38, 38, 0.3);
            color: #ff6b6b;
        }

        /* Badge Styling for Table */
        .badge-violation-type {
            display: inline-flex;
            align-items: center;
            padding: 6px 14px;
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.2), rgba(239, 68, 68, 0.1));
            border: 1px solid rgba(220, 38, 38, 0.3);
            border-radius: 20px;
            color: #ff6b6b;
            font-weight: 600;
            font-size: 13px;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .page-header-violation {
                flex-direction: column;
                gap: 16px;
                align-items: flex-start;
            }

            .page-title-violation {
                font-size: 22px;
            }

            .modal-violation .modal-dialog {
                margin: 10px;
            }

            .form-section-violation {
                padding: 16px;
            }

            .detail-container-violation {
                padding: 16px;
            }
        }

        /* ============================================
           CSS VARIABLES & BASE
        ============================================ */
        :root {
            --emerald: #059669;
            --emerald-light: #34d399;
            --gold: #d4a574;
            --gold-light: #e8c9a0;
            --amber: #b45309;
            --coral: #e07a5f;
            --slate: #475569;
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
            --glass-shadow: rgba(0, 0, 0, 0.3);
            --glass-hover: rgba(255, 255, 255, 0.08);
            --bg-dark: #0a0f0d;
            --bg-gradient-1: #0d1a14;
            --bg-gradient-2: #132419;
            --bg-gradient-3: #1a2e23;
            --text-primary: #f5f5f4;
            --text-secondary: rgba(245, 245, 244, 0.7);
            --text-muted: rgba(245, 245, 244, 0.4);
            --success: #22c55e;
            --warning: #eab308;
            --danger: #dc2626;
            --info: #0ea5e9;
            --sidebar-width: 280px;
            --border-radius: 20px;
            --card-padding: 24px;
            --transition-fast: 0.2s ease;
            --transition-normal: 0.3s ease;
        }

        [data-theme="light"] {
            --glass-bg: rgba(255, 255, 255, 0.6);
            --glass-border: rgba(0, 0, 0, 0.1);
            --glass-shadow: rgba(0, 0, 0, 0.1);
            --glass-hover: rgba(255, 255, 255, 0.8);
            --bg-dark: #f5f5f0;
            --bg-gradient-1: #e8f5e9;
            --bg-gradient-2: #f1f8e9;
            --bg-gradient-3: #fefefe;
            --text-primary: #1a1a1a;
            --text-secondary: rgba(26, 26, 26, 0.7);
            --text-muted: rgba(26, 26, 26, 0.5);
        }

        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg-dark);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* ============================================
           AUTH PAGES (LOGIN/REGISTER)
        ============================================ */
        body.auth-page {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        body.auth-page .dashboard {
            display: none;
        }

        body.auth-page .mobile-menu-toggle {
            display: none;
        }

        .auth-container {
            width: 100%;
            max-width: 440px;
            z-index: 10;
            animation: fadeInUp 0.6s ease-out;
        }

        .login-card {
            background: var(--glass-bg);
            backdrop-filter: blur(30px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 48px 40px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px var(--glass-shadow), 0 0 60px rgba(5, 150, 105, 0.1);
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        }

        .login-card::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(52, 211, 153, 0.1) 0%, transparent 70%);
            z-index: -1;
            pointer-events: none;
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--emerald), var(--gold));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            color: white;
            margin: 0 auto 24px;
            box-shadow: 0 12px 40px rgba(5, 150, 105, 0.3), 0 0 0 4px rgba(255, 255, 255, 0.1);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.02);
            }
        }

        .login-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
            background: linear-gradient(135deg, var(--text-primary), var(--emerald-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .login-subtitle {
            font-size: 15px;
            color: var(--text-muted);
            font-weight: 400;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-secondary);
            margin-bottom: 10px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 16px;
            transition: all var(--transition-fast);
        }

        .form-input {
            width: 100%;
            padding: 14px 16px 14px 48px;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            color: var(--text-primary);
            font-family: 'Outfit', sans-serif;
            font-size: 15px;
            transition: all var(--transition-fast);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--emerald-light);
            box-shadow: 0 0 20px rgba(52, 211, 153, 0.2);
        }

        .form-input:focus~.input-icon {
            color: var(--emerald-light);
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px;
            font-size: 16px;
            transition: all var(--transition-fast);
        }

        .password-toggle:hover {
            color: var(--emerald-light);
        }

        /* Checkbox */
        .form-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: var(--text-secondary);
            cursor: pointer;
            position: relative;
            padding-left: 28px;
        }

        .checkbox-label input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .checkmark {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 6px;
            transition: all var(--transition-fast);
        }

        .checkbox-label:hover .checkmark {
            border-color: var(--emerald-light);
        }

        .checkbox-label input:checked~.checkmark {
            background: linear-gradient(135deg, var(--emerald), var(--gold));
            border-color: transparent;
        }

        .checkmark::after {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            display: none;
            color: white;
            font-size: 12px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .checkbox-label input:checked~.checkmark::after {
            display: block;
        }

        /* Buttons */
        .btn-login {
            width: 100%;
            padding: 16px 28px;
            background: linear-gradient(135deg, var(--emerald), var(--gold));
            border: none;
            border-radius: 12px;
            color: white;
            font-family: 'Outfit', sans-serif;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-fast);
            box-shadow: 0 8px 24px rgba(5, 150, 105, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(5, 150, 105, 0.4);
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        /* Alerts */
        .message-container {
            margin-top: 20px;
        }

        .alert-glass {
            padding: 14px 18px;
            border-radius: 12px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideIn 0.3s ease;
            backdrop-filter: blur(10px);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success-glass {
            background: rgba(34, 197, 94, 0.15);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: var(--success);
        }

        .alert-error-glass {
            background: rgba(220, 38, 38, 0.15);
            border: 1px solid rgba(220, 38, 38, 0.3);
            color: #ff6b6b;
        }

        /* Footer */
        .auth-footer {
            text-align: center;
            font-size: 14px;
            color: var(--text-muted);
            margin-top: 20px;
        }

        .auth-footer a {
            color: var(--emerald-light);
            text-decoration: none;
            font-weight: 600;
            transition: all var(--transition-fast);
        }

        .auth-footer a:hover {
            color: var(--gold);
            text-decoration: underline;
        }

        .site-footer {
            text-align: center;
            padding: 30px 20px;
            color: var(--text-muted);
            font-size: 13px;
            margin-top: 30px;
        }

        /* ============================================
           BACKGROUND & ANIMATIONS
        ============================================ */
        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
            background: linear-gradient(135deg, var(--bg-gradient-1) 0%, var(--bg-gradient-2) 50%, var(--bg-gradient-3) 100%);
        }

        .background::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(ellipse 80% 50% at 20% 40%, rgba(120, 0, 255, 0.15) 0%, transparent 50%),
                radial-gradient(ellipse 60% 40% at 80% 60%, rgba(0, 200, 255, 0.12) 0%, transparent 50%),
                radial-gradient(ellipse 50% 30% at 50% 80%, rgba(255, 0, 200, 0.1) 0%, transparent 50%);
        }

        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            z-index: -1;
            animation: float 20s ease-in-out infinite;
        }

        .orb-1 {
            width: 400px;
            height: 400px;
            background: var(--emerald);
            top: 10%;
            left: 10%;
        }

        .orb-2 {
            width: 350px;
            height: 350px;
            background: var(--gold);
            top: 60%;
            right: 10%;
            animation-delay: -5s;
        }

        .orb-3 {
            width: 300px;
            height: 300px;
            background: var(--coral);
            bottom: 10%;
            left: 30%;
            animation-delay: -10s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            25% {
                transform: translate(30px, -30px) scale(1.05);
            }

            50% {
                transform: translate(-20px, 20px) scale(0.95);
            }

            75% {
                transform: translate(20px, 10px) scale(1.02);
            }
        }

        /* ============================================
           SIDEBAR & NAVIGATION
        ============================================ */
        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border-right: 1px solid var(--glass-border);
            padding: 24px;
            z-index: 100;
            transition: all var(--transition-normal);
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: var(--glass-border);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: var(--emerald-light);
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-bottom: 30px;
            border-bottom: 1px solid var(--glass-border);
            margin-bottom: 30px;
        }

        .logo {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--emerald), var(--gold));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 20px;
            color: white;
            box-shadow: 0 8px 32px rgba(5, 150, 105, 0.3);
        }

        .logo-text {
            font-size: 22px;
            font-weight: 600;
            background: linear-gradient(135deg, var(--emerald-light), var(--gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* ============================================
           NAVBAR USER INFO - NEW STYLE
        ============================================ */
        .navbar-user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px;
            background: var(--glass-hover);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            margin-bottom: 30px;
            transition: all var(--transition-fast);
        }

        .navbar-user-info:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--emerald-light);
            transform: translateY(-2px);
        }

        .navbar-avatar {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--emerald), var(--gold));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 18px;
            color: white;
            flex-shrink: 0;
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
        }

        .navbar-user-details {
            display: flex;
            flex-direction: column;
            gap: 2px;
            flex: 1;
            min-width: 0;
        }

        .navbar-username {
            font-weight: 600;
            font-size: 15px;
            color: var(--text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .navbar-role {
            font-size: 12px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 500;
        }

        /* Guest Box */
        .guest-box {
            background: var(--glass-hover);
            padding: 20px;
            border-radius: 16px;
            margin-bottom: 30px;
            border: 1px solid var(--glass-border);
            text-align: center;
        }

        .guest-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--warning), var(--gold));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            color: white;
            font-size: 24px;
        }

        /* ============================================
           NAVIGATION MENU - UNIFIED DROPDOWN STYLES
        ============================================ */
        .nav-menu {
            list-style: none;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .nav-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-section {
            margin-bottom: 20px;
        }

        .nav-section-title {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--text-muted);
            margin-bottom: 12px;
            padding-left: 15px;
            display: block;
        }

        /* Unified Dropdown Style for ALL menu items */
        .dropdown {
            position: relative;
            margin-bottom: 4px;
        }

        .dropdown-btn {
            background: none;
            border: none;
            color: var(--text-secondary);
            padding: 12px 18px;
            width: 100%;
            text-align: left;
            cursor: pointer;
            font-family: inherit;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 14px;
            border-radius: 12px;
            transition: all var(--transition-fast);
            font-weight: 500;
            position: relative;
        }

        .dropdown-btn:hover {
            background: var(--glass-hover);
            color: var(--text-primary);
        }

        .dropdown-btn.active {
            background: var(--glass-hover);
            color: var(--emerald-light);
            border: 1px solid var(--glass-border);
        }

        .dropdown-btn.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 50%;
            background: linear-gradient(180deg, var(--emerald), var(--gold));
            border-radius: 0 3px 3px 0;
        }

        .dropdown-content {
            display: none;
            padding-left: 20px;
            margin-top: 4px;
            animation: slideDown 0.3s ease;
        }

        .dropdown.open .dropdown-content {
            display: block;
        }

        .dropdown-content a {
            display: block;
            color: var(--text-secondary);
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 13px;
            transition: all var(--transition-fast);
            border-left: 2px solid var(--glass-border);
            margin-left: 10px;
        }

        .dropdown-content a:hover {
            background: var(--glass-hover);
            color: var(--text-primary);
            border-left-color: var(--emerald-light);
            padding-left: 22px;
        }

        .dropdown-content a.active {
            color: var(--emerald-light);
            border-left-color: var(--emerald-light);
            background: var(--glass-hover);
        }

        .dropdown-arrow {
            margin-left: auto;
            transition: transform 0.3s ease;
            font-size: 12px;
        }

        .dropdown.open .dropdown-arrow {
            transform: rotate(180deg);
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            opacity: 0.8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .dropdown-btn:hover .nav-icon,
        .dropdown-btn.active .nav-icon {
            opacity: 1;
            color: var(--emerald-light);
        }

        /* Special Admin Menu Item - Same dropdown style but not dropdown */
        .nav-item-special {
            margin-bottom: 4px;
        }

        .nav-link-special {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 18px;
            color: var(--warning);
            text-decoration: none;
            border-radius: 12px;
            transition: all var(--transition-fast);
            position: relative;
            overflow: hidden;
            font-size: 14px;
            font-weight: 600;
            background: linear-gradient(135deg, rgba(234, 179, 8, 0.1), rgba(212, 165, 116, 0.05));
            border: 1px solid rgba(234, 179, 8, 0.2);
        }

        .nav-link-special:hover {
            background: linear-gradient(135deg, rgba(234, 179, 8, 0.2), rgba(212, 165, 116, 0.1));
            border-color: var(--warning);
            color: var(--gold-light);
            transform: translateX(3px);
        }

        .nav-link-special.active {
            background: linear-gradient(135deg, rgba(234, 179, 8, 0.25), rgba(212, 165, 116, 0.15));
            border-color: var(--warning);
            box-shadow: 0 4px 15px rgba(234, 179, 8, 0.2);
        }

        .nav-link-special .nav-icon {
            color: var(--warning);
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ============================================
           LOGOUT BUTTON - BOTTOM NAVBAR
        ============================================ */
        .nav-logout-section {
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid var(--glass-border);
        }

        .nav-logout-btn {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 18px;
            background: rgba(220, 38, 38, 0.1);
            border: 1px solid rgba(220, 38, 38, 0.2);
            border-radius: 12px;
            color: var(--danger);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all var(--transition-fast);
            width: 100%;
        }

        .nav-logout-btn:hover {
            background: rgba(220, 38, 38, 0.2);
            border-color: var(--danger);
            color: #ff6b6b;
            transform: translateX(5px);
        }

        .nav-logout-btn i {
            font-size: 18px;
        }

        /* ============================================
           MAIN CONTENT & NAVBAR
        ============================================ */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 30px;
            min-height: 100vh;
        }

        .navbar-custom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
            gap: 20px;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            padding: 15px 25px;
            border-radius: 16px;
            border: 1px solid var(--glass-border);
        }

        .page-title {
            font-size: 28px;
            font-weight: 600;
            margin: 0;
            background: linear-gradient(135deg, var(--text-primary), var(--text-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .search-box {
            position: relative;
        }

        .search-input {
            width: 280px;
            padding: 12px 20px 12px 48px;
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            color: var(--text-primary);
            font-family: inherit;
            font-size: 14px;
            transition: all var(--transition-fast);
        }

        .search-input::placeholder {
            color: var(--text-muted);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--emerald-light);
            box-shadow: 0 0 20px rgba(52, 211, 153, 0.2);
        }

        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        .nav-btn {
            width: 45px;
            height: 45px;
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: relative;
            transition: all var(--transition-fast);
            color: var(--text-secondary);
        }

        .nav-btn:hover {
            background: var(--glass-hover);
            border-color: var(--emerald-light);
            color: var(--text-primary);
        }

        .notification-dot {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 8px;
            height: 8px;
            background: var(--coral);
            border-radius: 50%;
            box-shadow: 0 0 10px var(--coral);
        }

        /* ============================================
           GLASS CARDS & COMPONENTS
        ============================================ */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius);
            padding: var(--card-padding);
            position: relative;
            overflow: hidden;
            transition: all var(--transition-normal);
            margin-bottom: 24px;
        }

        .glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        }

        .glass-card:hover {
            background: var(--glass-hover);
            border-color: rgba(255, 255, 255, 0.15);
            box-shadow: 0 25px 50px -12px var(--glass-shadow), 0 0 40px rgba(52, 211, 153, 0.1);
        }

        .glass-card-3d {
            transition: transform 0.4s cubic-bezier(0.03, 0.98, 0.52, 0.99);
        }

        .glass-card-3d:hover {
            transform: rotateX(5deg) rotateY(-5deg) translateZ(10px);
        }

        .container-custom {
            isolation: isolate;
            /* Mencegah modal terjebak */
            position: relative;
            z-index: 1;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* ============================================
           DATATABLES STYLES
        ============================================ */
        .dataTables-wrapper {
            color: var(--text-primary);
            font-family: 'Outfit', sans-serif;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: var(--text-secondary) !important;
            margin-bottom: 15px;
        }

        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            background: var(--glass-bg) !important;
            border: 1px solid var(--glass-border) !important;
            border-radius: 8px !important;
            color: var(--text-primary) !important;
            padding: 8px 15px !important;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: var(--emerald-light) !important;
            box-shadow: 0 0 15px rgba(52, 211, 153, 0.2);
        }

        table.dataTable {
            background: transparent;
            border-collapse: separate;
            border-spacing: 0;
        }

        table.dataTable thead th {
            background: var(--glass-hover) !important;
            color: var(--text-primary) !important;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
            padding: 16px;
            border-bottom: 1px solid var(--glass-border) !important;
            border-top: none !important;
        }

        table.dataTable tbody td {
            background: transparent !important;
            color: var(--text-secondary) !important;
            padding: 16px;
            border-bottom: 1px solid var(--glass-border) !important;
        }

        table.dataTable tbody tr {
            transition: all var(--transition-fast);
        }

        table.dataTable tbody tr:hover {
            background: var(--glass-hover) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background: var(--glass-bg) !important;
            border: 1px solid var(--glass-border) !important;
            color: var(--text-secondary) !important;
            border-radius: 8px !important;
            margin: 0 3px;
            padding: 8px 14px !important;
            transition: all var(--transition-fast);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: var(--glass-hover) !important;
            border-color: var(--emerald-light) !important;
            color: var(--text-primary) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, var(--emerald), var(--gold)) !important;
            border-color: transparent !important;
            color: white !important;
            font-weight: 600;
        }

        /* ============================================
           UTILITY CLASSES
        ============================================ */
        .btn-glass {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            color: var(--text-primary);
            font-family: inherit;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all var(--transition-fast);
            text-decoration: none;
        }

        .btn-glass:hover {
            background: var(--glass-hover);
            border-color: var(--emerald-light);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px var(--glass-shadow);
        }

        .btn-primary-glass {
            background: linear-gradient(135deg, var(--emerald), var(--emerald-light)) !important;
            border: none !important;
            color: white !important;
            box-shadow: 0 8px 24px rgba(5, 150, 105, 0.3);
        }

        .btn-primary-glass:hover {
            box-shadow: 0 12px 32px rgba(5, 150, 105, 0.4);
        }

        .btn-danger-glass {
            background: linear-gradient(135deg, var(--danger), #ff6b6b) !important;
            border: none !important;
            color: white !important;
            box-shadow: 0 8px 24px rgba(220, 38, 38, 0.3);
        }

        .text-gradient {
            background: linear-gradient(135deg, var(--emerald-light), var(--gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .badge-glass {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            border: 1px solid var(--glass-border);
        }

        .badge-success {
            background: rgba(34, 197, 94, 0.15);
            color: var(--success);
        }

        .badge-warning {
            background: rgba(234, 179, 8, 0.15);
            color: var(--warning);
        }

        .badge-danger {
            background: rgba(220, 38, 38, 0.15);
            color: var(--danger);
        }

        .badge-info {
            background: rgba(14, 165, 233, 0.15);
            color: var(--info);
        }

        .table-user {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .table-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--emerald), var(--gold));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
            color: white;
        }

        .table-user-info {
            display: flex;
            flex-direction: column;
        }

        .table-user-name {
            color: var(--text-primary);
            font-weight: 500;
            font-size: 14px;
        }

        .table-user-email {
            font-size: 12px;
            color: var(--text-muted);
        }

        .mobile-menu-toggle {
            display: none;
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, var(--emerald), var(--gold));
            border: none;
            border-radius: 16px;
            cursor: pointer;
            z-index: 200;
            box-shadow: 0 8px 32px rgba(5, 150, 105, 0.3);
            color: white;
            font-size: 24px;
            align-items: center;
            justify-content: center;
        }

        .theme-toggle-float {
            position: fixed;
            top: 24px;
            right: 24px;
            width: 50px;
            height: 50px;
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 1000;
            transition: all var(--transition-fast);
            color: var(--text-secondary);
            font-size: 20px;
        }

        .theme-toggle-float:hover {
            background: var(--glass-hover);
            border-color: var(--emerald-light);
            color: var(--text-primary);
            transform: rotate(15deg);
        }

        /* ============================================
           ANIMATIONS
        ============================================ */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeInUp 0.6s ease-out backwards;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translateX(-5px);
            }

            20%,
            40%,
            60%,
            80% {
                transform: translateX(5px);
            }
        }

        .animate-shake {
            animation: shake 0.5s ease;
        }

        /* ============================================
           RESPONSIVE
        ============================================ */
        @media (max-width: 992px) {
            :root {
                --sidebar-width: 0px;
            }

            .sidebar {
                transform: translateX(-100%);
                width: 280px;
                z-index: 300;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-menu-toggle {
                display: flex;
            }

            .search-input {
                width: 200px;
            }
        }

        @media (max-width: 768px) {
            .navbar-custom {
                flex-wrap: wrap;
            }

            .search-box {
                order: 3;
                width: 100%;
            }

            .search-input {
                width: 100%;
            }

            .page-title {
                font-size: 22px;
            }

            .glass-card {
                padding: 18px;
            }
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 36px 24px;
            }

            .login-title {
                font-size: 26px;
            }

            .login-logo {
                width: 70px;
                height: 70px;
                font-size: 28px;
            }
        }

        /* Light Mode */
        [data-theme="light"] .orb {
            opacity: 0.15;
        }

        [data-theme="light"] .login-card::after {
            background: radial-gradient(circle, rgba(5, 150, 105, 0.05) 0%, transparent 70%);
        }

        [data-theme="light"] .checkmark {
            background: rgba(255, 255, 255, 0.8);
        }

        /* ============================================
   FLOATING THEME TOGGLE - ADAPTIVE LIQUID GLASS
   ============================================ */

        #theme-toggle {
            /* Fixed positioning pojok kanan bawah */
            position: fixed !important;
            bottom: 30px !important;
            right: 30px !important;
            left: auto !important;
            top: auto !important;

            /* Z-index tinggi */
            z-index: 99999 !important;

            /* Ukuran dan bentuk */
            width: 60px !important;
            height: 60px !important;
            border-radius: 50% !important;
            padding: 0 !important;

            /* Default: Light Mode - Semi transparan blur GELAP */
            background: rgba(15, 23, 42, 0.6) !important;
            backdrop-filter: blur(24px) saturate(180%) !important;
            -webkit-backdrop-filter: blur(24px) saturate(180%) !important;

            /* Border gelap subtle */
            border: 1px solid rgba(255, 255, 255, 0.15) !important;

            /* Shadow gelap */
            box-shadow:
                0 8px 32px rgba(0, 0, 0, 0.4),
                0 0 0 1px rgba(255, 255, 255, 0.05),
                inset 0 1px 0 rgba(255, 255, 255, 0.1) !important;

            /* Layout icon */
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;

            /* Interaksi */
            cursor: pointer !important;
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
            overflow: hidden !important;
        }

        /* ===== DARK MODE: Semi transparan blur PUTIH ===== */
        #theme-toggle.dark-mode {
            background: rgba(255, 255, 255, 0.75) !important;
            border: 1px solid rgba(255, 255, 255, 0.5) !important;
            box-shadow:
                0 8px 32px rgba(0, 0, 0, 0.2),
                0 0 0 1px rgba(255, 255, 255, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.5) !important;
        }

        /* Inner glow/shine effect */
        #theme-toggle::before {
            content: '' !important;
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            height: 50% !important;
            background: linear-gradient(180deg,
                    rgba(255, 255, 255, 0.2) 0%,
                    rgba(255, 255, 255, 0.05) 100%) !important;
            border-radius: 50% 50% 0 0 !important;
            pointer-events: none !important;
            transition: opacity 0.3s ease !important;
        }

        /* Dark mode: shine lebih terang */
        #theme-toggle.dark-mode::before {
            background: linear-gradient(180deg,
                    rgba(255, 255, 255, 0.4) 0%,
                    rgba(255, 255, 255, 0.1) 100%) !important;
        }

        /* Outer glow animasi saat hover */
        #theme-toggle::after {
            content: '' !important;
            position: absolute !important;
            inset: -3px !important;
            border-radius: 50% !important;
            background: conic-gradient(from 0deg,
                    transparent,
                    var(--emerald-light),
                    var(--gold),
                    var(--emerald-light),
                    transparent) !important;
            opacity: 0 !important;
            z-index: -1 !important;
            transition: all 0.3s ease !important;
            filter: blur(8px) !important;
            animation: none !important;
        }

        #theme-toggle:hover::after {
            opacity: 0.8 !important;
            animation: rotate-glow 4s linear infinite !important;
        }

        @keyframes rotate-glow {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* ===== HOVER EFFECTS ===== */

        /* Light Mode Hover: Glow emeralds + scale up */
        #theme-toggle:hover {
            transform: scale(1.12) translateY(-3px) !important;
            box-shadow:
                0 16px 48px rgba(0, 0, 0, 0.5),
                0 0 40px rgba(52, 211, 153, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2) !important;
            border-color: rgba(52, 211, 153, 0.4) !important;
        }

        /* Dark Mode Hover: Glow gold + scale up */
        #theme-toggle.dark-mode:hover {
            transform: scale(1.12) translateY(-3px) !important;
            box-shadow:
                0 16px 48px rgba(0, 0, 0, 0.3),
                0 0 40px rgba(251, 191, 36, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.5) !important;
            border-color: rgba(251, 191, 36, 0.5) !important;
            background: rgba(255, 255, 255, 0.85) !important;
        }

        /* Active/Click effect */
        #theme-toggle:active {
            transform: scale(0.92) !important;
            transition: transform 0.1s ease !important;
        }

        /* ===== ICON STYLING ===== */

        #theme-toggle i {
            position: absolute !important;
            font-size: 26px !important;
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2)) !important;
        }

        /* SUN ICON - Light Mode (default) */
        #theme-toggle .icon-sun {
            opacity: 1 !important;
            transform: rotate(0deg) scale(1) !important;
            color: #fbbf24 !important;
            /* Amber-400 */
            filter:
                drop-shadow(0 0 8px rgba(251, 191, 36, 0.6)) drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3)) !important;
        }

        /* Light Mode Hover: Sun jadi lebih terang + rotate */
        #theme-toggle:hover .icon-sun {
            color: #f59e0b !important;
            /* Amber-500 */
            transform: rotate(180deg) scale(1.15) !important;
            filter:
                drop-shadow(0 0 20px rgba(251, 191, 36, 0.9)) drop-shadow(0 0 40px rgba(251, 191, 36, 0.4)) !important;
        }

        /* MOON ICON - Hidden di Light Mode */
        #theme-toggle .icon-moon {
            opacity: 0 !important;
            transform: rotate(-90deg) scale(0.3) !important;
            color: #6366f1 !important;
            /* Indigo-500 */
            filter:
                drop-shadow(0 0 8px rgba(99, 102, 241, 0.4)) drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2)) !important;
        }

        /* ===== DARK MODE ICON STATES ===== */

        /* Dark Mode: Sun hide */
        #theme-toggle.dark-mode .icon-sun {
            opacity: 0 !important;
            transform: rotate(90deg) scale(0.3) !important;
        }

        /* Dark Mode: Moon show */
        #theme-toggle.dark-mode .icon-moon {
            opacity: 1 !important;
            transform: rotate(0deg) scale(1) !important;
            color: #4f46e5 !important;
            /* Indigo-600 */
            filter:
                drop-shadow(0 0 8px rgba(99, 102, 241, 0.5)) drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2)) !important;
        }

        /* Dark Mode Hover: Moon jadi lebih terang + rotate */
        #theme-toggle.dark-mode:hover .icon-moon {
            color: #4338ca !important;
            /* Indigo-700 */
            transform: rotate(-15deg) scale(1.15) !important;
            filter:
                drop-shadow(0 0 20px rgba(99, 102, 241, 0.9)) drop-shadow(0 0 40px rgba(99, 102, 241, 0.4)) !important;
        }

        /* ===== TOOLTIP ===== */

        #theme-toggle[title]::after {
            content: attr(title) !important;
            position: absolute !important;
            bottom: 75px !important;
            left: 50% !important;
            transform: translateX(-50%) translateY(10px) scale(0.9) !important;
            background: rgba(15, 23, 42, 0.9) !important;
            backdrop-filter: blur(12px) !important;
            color: white !important;
            padding: 8px 14px !important;
            border-radius: 10px !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            white-space: nowrap !important;
            opacity: 0 !important;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
            pointer-events: none !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3) !important;
        }

        #theme-toggle.dark-mode[title]::after {
            background: rgba(255, 255, 255, 0.9) !important;
            color: #1e293b !important;
            border-color: rgba(0, 0, 0, 0.1) !important;
        }

        #theme-toggle:hover[title]::after {
            opacity: 1 !important;
            transform: translateX(-50%) translateY(0) scale(1) !important;
        }

        /* ===== RIPPLE EFFECT ===== */

        #theme-toggle .ripple {
            position: absolute !important;
            border-radius: 50% !important;
            transform: scale(0) !important;
            animation: ripple-anim 0.6s ease-out !important;
            pointer-events: none !important;
        }

        /* Light mode ripple: putih */
        #theme-toggle:not(.dark-mode) .ripple {
            background: radial-gradient(circle, rgba(255, 255, 255, 0.4) 0%, rgba(255, 255, 255, 0.1) 100%) !important;
        }

        /* Dark mode ripple: gelap */
        #theme-toggle.dark-mode .ripple {
            background: radial-gradient(circle, rgba(15, 23, 42, 0.3) 0%, rgba(15, 23, 42, 0.1) 100%) !important;
        }

        @keyframes ripple-anim {
            to {
                transform: scale(4) !important;
                opacity: 0 !important;
            }
        }

        /* ===== INTRO ANIMATION ===== */

        @keyframes float-in {
            0% {
                transform: translateY(100px) scale(0.5);
                opacity: 0;
            }

            60% {
                transform: translateY(-10px) scale(1.05);
                opacity: 1;
            }

            100% {
                transform: translateY(0) scale(1);
                opacity: 1;
            }
        }

        #theme-toggle.intro-animate {
            animation: float-in 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) forwards !important;
        }

        /* Pulse attention */
        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
            }

            50% {
                box-shadow: 0 12px 40px rgba(52, 211, 153, 0.5);
            }
        }

        #theme-toggle.pulse-attention {
            animation: pulse-glow 2s ease-in-out infinite !important;
        }

        /* ===== RESPONSIVE ===== */

        @media (max-width: 768px) {
            #theme-toggle {
                width: 52px !important;
                height: 52px !important;
                bottom: 20px !important;
                right: 20px !important;
            }

            #theme-toggle i {
                font-size: 22px !important;
            }

            #theme-toggle[title]::after {
                bottom: 65px !important;
                font-size: 11px !important;
                padding: 6px 12px !important;
            }
        }

        /* Override semua style yang mungkin conflict */
        button#theme-toggle.nav-btn {
            position: fixed !important;
            float: none !important;
            margin: 0 !important;
            outline: none !important;
        }

        button#theme-toggle.nav-btn:focus {
            outline: none !important;
            box-shadow:
                0 8px 32px rgba(0, 0, 0, 0.4),
                0 0 0 3px rgba(52, 211, 153, 0.3) !important;
        }

        button#theme-toggle.nav-btn.dark-mode:focus {
            box-shadow:
                0 8px 32px rgba(0, 0, 0, 0.2),
                0 0 0 3px rgba(251, 191, 36, 0.4) !important;
        }
    </style>
</head>

<?php
$currentPage = $_GET['page'] ?? 'dashboard';
$isAuthPage = in_array($currentPage, ['login', 'register', 'forgot_password']);
?>

<body class="<?= $isAuthPage ? 'auth-page' : '' ?>" data-page="<?= $currentPage ?>">
    <button class="nav-btn" id="theme-toggle" title="Toggle Light/Dark Mode">
        <i class="fas fa-moon icon-moon"></i>
        <i class="fas fa-sun icon-sun"></i>
    </button>

    <!-- Background -->
    <div class="background"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <?php if ($isAuthPage): ?>
        <!-- AUTH LAYOUT -->
        <button class="nav-btn" id="theme-toggle" title="Toggle Light/Dark Mode">
            <i class="fas fa-moon icon-moon"></i>
            <i class="fas fa-sun icon-sun"></i>
        </button>
        <div class="auth-container">
            <?= $this->section('main') ?>
        </div>

        <footer class="site-footer">
            <p>&copy; 2026 Vin Web. All rights reserved.</p>
        </footer>

    <?php else: ?>
        <!-- DASHBOARD LAYOUT -->
        <div class="dashboard">
            <!-- Sidebar -->
            <aside class="sidebar" id="sidebar">
                <div class="sidebar-header">
                    <div class="logo"><i class="fas fa-school"></i></div>
                    <span class="logo-text">Vin Web</span>
                </div>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- NEW USER INFO LAYOUT -->
                    <div class="navbar-user-info">
                        <div class="navbar-avatar">
                            <?= substr($_SESSION['user_name'], 0, 2) ?>
                        </div>
                        <div class="navbar-user-details">
                            <div class="navbar-username"><?= $_SESSION['user_name'] ?></div>
                            <div class="navbar-role"><?= $_SESSION['role'] ?></div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="guest-box">
                        <div class="guest-icon"><i class="fas fa-user-slash"></i></div>
                        <div style="color: var(--text-secondary); font-size: 14px; margin-bottom: 12px;">Belum Login</div>
                        <a href="?page=login" class="btn-glass btn-primary-glass" style="width: 100%; justify-content: center;">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </div>
                <?php endif; ?>

                <!-- Navigation -->
                <ul class="nav-menu">
                    <!-- MANAJEMEN DATA - Semua menu menggunakan dropdown style -->
                    <?php if (isset($_SESSION['role']) && ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'guru')): ?>
                        <li class="nav-section">
                            <span class="nav-section-title">Manajemen Data</span>
                            <ul>
                                <!-- Dashboard - Dropdown style sama seperti Data Filler -->
                                <li class="dropdown">
                                    <button class="dropdown-btn <?= in_array($currentPage, ['dashboard']) ? 'active' : '' ?>" onclick="toggleDropdown(this)">
                                        <span class="nav-icon"><i class="fas fa-tachometer-alt"></i></span>
                                        Dashboard
                                        <span class="dropdown-arrow"><i class="fas fa-chevron-down"></i></span>
                                    </button>
                                    <div class="dropdown-content">
                                        <a href="?page=dashboard" class="<?= $currentPage == 'dashboard' ? 'active' : '' ?>">Overview</a>
                                    </div>
                                </li>

                                <!-- Pelanggaran - Dropdown style sama seperti Data Filler -->
                                <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'guru'): ?>
                                    <li class="dropdown">
                                        <button class="dropdown-btn <?= in_array($currentPage, ['pelanggaran']) ? 'active' : '' ?>" onclick="toggleDropdown(this)">
                                            <span class="nav-icon"><i class="fas fa-exclamation-triangle"></i></span>
                                            Pelanggaran
                                            <span class="dropdown-arrow"><i class="fas fa-chevron-down"></i></span>
                                        </button>
                                        <div class="dropdown-content">
                                            <a href="?page=pelanggaran" class="<?= $currentPage == 'pelanggaran' ? 'active' : '' ?>">Data Pelanggaran</a>
                                        </div>
                                    </li>
                                <?php endif; ?>

                                <?php if ($_SESSION['role'] === 'admin'): ?>
                                    <!-- Data Filler -->
                                    <li class="dropdown">
                                        <button class="dropdown-btn <?= in_array($currentPage, ['kelas', 'jenis_pelanggaran', 'alasan_pelanggaran', 'mapel']) ? 'active' : '' ?>" onclick="toggleDropdown(this)">
                                            <span class="nav-icon"><i class="fas fa-database"></i></span>
                                            Data Filler
                                            <span class="dropdown-arrow"><i class="fas fa-chevron-down"></i></span>
                                        </button>
                                        <div class="dropdown-content">
                                            <a href="?page=kelas" class="<?= $currentPage == 'kelas' ? 'active' : '' ?>">Kelas</a>
                                            <a href="?page=jenis_pelanggaran" class="<?= $currentPage == 'jenis_pelanggaran' ? 'active' : '' ?>">Jenis Pelanggaran</a>
                                            <a href="?page=alasan_pelanggaran" class="<?= $currentPage == 'alasan_pelanggaran' ? 'active' : '' ?>">Alasan Pelanggaran</a>
                                            <a href="?page=mapel" class="<?= $currentPage == 'mapel' ? 'active' : '' ?>">Mapel</a>
                                        </div>
                                    </li>

                                    <!-- Siswa -->
                                    <li class="dropdown">
                                        <button class="dropdown-btn <?= in_array($currentPage, ['siswa', 'siswa_table']) ? 'active' : '' ?>" onclick="toggleDropdown(this)">
                                            <span class="nav-icon"><i class="fas fa-users"></i></span>
                                            Siswa
                                            <span class="dropdown-arrow"><i class="fas fa-chevron-down"></i></span>
                                        </button>
                                        <div class="dropdown-content">
                                            <a href="?page=siswa" class="<?= $currentPage == 'siswa' ? 'active' : '' ?>">Dashboard</a>
                                            <a href="?page=siswa_table" class="<?= $currentPage == 'siswa_table' ? 'active' : '' ?>">Table</a>
                                        </div>
                                    </li>

                                    <!-- Guru -->
                                    <li class="dropdown">
                                        <button class="dropdown-btn <?= in_array($currentPage, ['guru', 'guru_table']) ? 'active' : '' ?>" onclick="toggleDropdown(this)">
                                            <span class="nav-icon"><i class="fas fa-chalkboard-teacher"></i></span>
                                            Guru
                                            <span class="dropdown-arrow"><i class="fas fa-chevron-down"></i></span>
                                        </button>
                                        <div class="dropdown-content">
                                            <a href="?page=guru" class="<?= $currentPage == 'guru' ? 'active' : '' ?>">Dashboard</a>
                                            <a href="?page=guru_table" class="<?= $currentPage == 'guru_table' ? 'active' : '' ?>">Table</a>
                                        </div>
                                    </li>

                                    <!-- Users Admin - Same dropdown style but not dropdown -->
                                    <li class="nav-item-special">
                                        <a href="?page=users" class="nav-link-special <?= $currentPage == 'users' ? 'active' : '' ?>">
                                            <span class="nav-icon"><i class="fas fa-user-shield"></i></span>
                                            Users (Admin)
                                        </a>
                                    </li>
                                <?php elseif ($_SESSION['role'] === 'guru'): ?>
                                    <!-- Siswa untuk Guru -->
                                    <li class="dropdown">
                                        <button class="dropdown-btn <?= in_array($currentPage, ['siswa', 'siswa_table']) ? 'active' : '' ?>" onclick="toggleDropdown(this)">
                                            <span class="nav-icon"><i class="fas fa-users"></i></span>
                                            Siswa
                                            <span class="dropdown-arrow"><i class="fas fa-chevron-down"></i></span>
                                        </button>
                                        <div class="dropdown-content">
                                            <a href="?page=siswa" class="<?= $currentPage == 'siswa' ? 'active' : '' ?>">Dashboard</a>
                                            <a href="?page=siswa_table" class="<?= $currentPage == 'siswa_table' ? 'active' : '' ?>">Table</a>
                                        </div>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php else: ?>
                        <!-- Untuk user yang belum login atau role lain -->
                        <li class="nav-section">
                            <span class="nav-section-title">Menu</span>
                            <ul>
                                <li class="dropdown">
                                    <button class="dropdown-btn <?= in_array($currentPage, ['dashboard']) ? 'active' : '' ?>" onclick="toggleDropdown(this)">
                                        <span class="nav-icon"><i class="fas fa-tachometer-alt"></i></span>
                                        Dashboard
                                        <span class="dropdown-arrow"><i class="fas fa-chevron-down"></i></span>
                                    </button>
                                    <div class="dropdown-content">
                                        <a href="?page=dashboard" class="<?= $currentPage == 'dashboard' ? 'active' : '' ?>">Overview</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>

                <!-- LOGOUT BUTTON - Paling Bawah -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="nav-logout-section">
                        <a href="?page=logout" class="nav-logout-btn">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                <?php endif; ?>
            </aside>

            <!-- Main Content -->
            <main class="main-content">
                <!-- <nav class="navbar-custom">
                    <h1 class="page-title">
                        <?php
                        $pageTitles = [
                            'dashboard' => 'Dashboard',
                            'pelanggaran' => 'Data Pelanggaran',
                            'kelas' => 'Manajemen Kelas',
                            'jenis_pelanggaran' => 'Jenis Pelanggaran',
                            'alasan_pelanggaran' => 'Alasan Pelanggaran',
                            'mapel' => 'Mata Pelajaran',
                            'siswa' => 'Dashboard Siswa',
                            'siswa_table' => 'Tabel Siswa',
                            'guru' => 'Dashboard Guru',
                            'guru_table' => 'Tabel Guru',
                            'users' => 'Manajemen Users',
                            'logout' => 'Logout'
                        ];
                        echo $pageTitles[$currentPage] ?? 'Dashboard';
                        ?>
                    </h1>

                    <div class="navbar-right">
                        <div class="search-box">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" class="search-input" placeholder="Cari data..." id="globalSearch">
                        </div>
                        <button class="nav-btn" title="Notifikasi">
                            <i class="fas fa-bell"></i>
                            <span class="notification-dot"></span>
                        </button>
                        <button class="nav-btn" id="theme-toggle" title="Toggle Light/Dark Mode">
                            <i class="fas fa-sun icon-sun"></i>
                            <i class="fas fa-moon icon-moon" style="display: none;"></i>
                        </button>
                    </div>
                </nav> -->

                <div class="container-custom">
                    <div class="glass-card animate-fade-in">
                        <?= $this->section('main') ?>
                    </div>
                </div>
            </main>
        </div>

        <button class="mobile-menu-toggle" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
    <?php endif; ?>

    <!-- Scripts: Hanya Animasi & UI, TIDAK ADA ACTION -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // ========== THEME TOGGLE ==========
        /**
         * Theme Toggle - Adaptive Liquid Glass
         */
        (function() {
            const toggleBtn = document.getElementById('theme-toggle');
            if (!toggleBtn) return;

            // State
            let isDarkMode = false;

            // Check saved theme or system preference
            const init = () => {
                const saved = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                isDarkMode = saved ? saved === 'dark' : prefersDark;
                applyTheme(isDarkMode, false);

                // Intro animation
                toggleBtn.classList.add('intro-animate');
                setTimeout(() => {
                    toggleBtn.classList.remove('intro-animate');
                    // Pulse attention setelah intro
                    toggleBtn.classList.add('pulse-attention');
                    setTimeout(() => toggleBtn.classList.remove('pulse-attention'), 3000);
                }, 800);
            };

            // Apply theme
            const applyTheme = (dark, animate = true) => {
                isDarkMode = dark;
                const body = document.body;

                if (dark) {
                    body.setAttribute('data-theme', 'dark');
                    body.classList.add('dark-mode');
                    body.classList.remove('light-mode');
                    toggleBtn.classList.add('dark-mode');
                    toggleBtn.setAttribute('title', 'Switch to Light Mode');
                } else {
                    body.setAttribute('data-theme', 'light');
                    body.classList.add('light-mode');
                    body.classList.remove('dark-mode');
                    toggleBtn.classList.remove('dark-mode');
                    toggleBtn.setAttribute('title', 'Switch to Dark Mode');
                }

                localStorage.setItem('theme', dark ? 'dark' : 'light');

                // Dispatch event
                window.dispatchEvent(new CustomEvent('themechange', {
                    detail: {
                        isDark: dark
                    }
                }));
            };

            // Ripple effect
            const createRipple = (e) => {
                const ripple = document.createElement('span');
                ripple.classList.add('ripple');

                const rect = toggleBtn.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.style.cssText = `
            width: ${size}px;
            height: ${size}px;
            left: ${x}px;
            top: ${y}px;
        `;

                toggleBtn.appendChild(ripple);
                setTimeout(() => ripple.remove(), 600);
            };

            // Click handler
            toggleBtn.addEventListener('click', (e) => {
                createRipple(e);

                // Click feedback
                toggleBtn.style.transform = 'scale(0.88)';
                setTimeout(() => {
                    toggleBtn.style.transform = '';
                }, 150);

                // Toggle theme
                applyTheme(!isDarkMode);
            });

            // Listen system theme changes
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                if (!localStorage.getItem('theme')) {
                    applyTheme(e.matches);
                }
            });

            // Initialize
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }
        })();

        // ========== DROPDOWN ==========
        function toggleDropdown(btn) {
            // Close other dropdowns
            document.querySelectorAll('.dropdown').forEach(dropdown => {
                if (dropdown !== btn.parentElement && dropdown.classList.contains('open')) {
                    dropdown.classList.remove('open');
                }
            });

            // Toggle current dropdown
            btn.parentElement.classList.toggle('open');
        }

        // Auto-open dropdown if child is active
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.dropdown-content a.active').forEach(activeLink => {
                const dropdown = activeLink.closest('.dropdown');
                if (dropdown) {
                    dropdown.classList.add('open');
                }
            });
        });

        // ========== SIDEBAR MOBILE ==========
        function toggleSidebar() {
            const sb = document.getElementById('sidebar');
            if (sb) sb.classList.toggle('open');
        }

        // ========== PASSWORD TOGGLE (Global Helper) ==========
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.querySelector('.password-toggle i');
            if (!input || !icon) return;

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        // ========== DATATABLES DEFAULTS ==========
        if ($.fn.DataTable) {
            $.extend(true, $.fn.dataTable.defaults, {
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
                lengthMenu: [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "Semua"]
                ],
                responsive: true,
                autoWidth: false
            });
        }

        // ========== 3D TILT EFFECT ==========
        document.querySelectorAll('.glass-card-3d').forEach(card => {
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                const rotateX = (y - rect.height / 2) / 20;
                const rotateY = (rect.width / 2 - x) / 20;
                card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateZ(10px)`;
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateZ(0)';
            });
        });

        // ========== COUNTER ANIMATION ==========
        function animateCounter(el, target, duration = 2000) {
            const start = performance.now();

            function update(now) {
                const elapsed = now - start;
                const progress = Math.min(elapsed / duration, 1);
                const ease = 1 - Math.pow(1 - progress, 3);
                el.textContent = Math.floor(target * ease).toLocaleString('id-ID');
                if (progress < 1) requestAnimationFrame(update);
            }
            requestAnimationFrame(update);
        }

        document.querySelectorAll('.counter').forEach(counter => {
            const target = parseInt(counter.dataset.target) || 0;
            if (target) animateCounter(counter, target);
        });

        // ========== SIDEBAR OUTSIDE CLICK ==========
        document.addEventListener('click', (e) => {
            const sb = document.getElementById('sidebar');
            const btn = document.querySelector('.mobile-menu-toggle');
            if (window.innerWidth <= 992 && sb?.classList.contains('open')) {
                if (!sb.contains(e.target) && !btn?.contains(e.target)) {
                    sb.classList.remove('open');
                }
            }
        });
    </script>
</body>

</html>
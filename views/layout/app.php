<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->e($title ?? 'Vin web') ?></title>

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
    </style>
</head>

<?php
$currentPage = $_GET['page'] ?? 'dashboard';
$isAuthPage = in_array($currentPage, ['login', 'register', 'forgot_password']);
?>

<body class="<?= $isAuthPage ? 'auth-page' : '' ?>" data-page="<?= $currentPage ?>">
    <!-- Background -->
    <div class="background"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <?php if ($isAuthPage): ?>
        <!-- AUTH LAYOUT -->
        <button class="theme-toggle-float" id="theme-toggle" title="Toggle Light/Dark Mode">
            <i class="fas fa-sun icon-sun"></i>
            <i class="fas fa-moon icon-moon" style="display: none;"></i>
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
                <nav class="navbar-custom">
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
                </nav>

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
        (function() {
            const toggle = document.getElementById('theme-toggle');
            if (!toggle) return;

            const sun = toggle.querySelector('.icon-sun');
            const moon = toggle.querySelector('.icon-moon');

            function setTheme(theme) {
                document.documentElement.setAttribute('data-theme', theme);
                localStorage.setItem('theme', theme);
                if (sun && moon) {
                    sun.style.display = theme === 'light' ? 'none' : 'inline-block';
                    moon.style.display = theme === 'light' ? 'inline-block' : 'none';
                }
            }

            setTheme(localStorage.getItem('theme') || 'dark');

            toggle.addEventListener('click', () => {
                const current = document.documentElement.getAttribute('data-theme');
                setTheme(current === 'dark' ? 'light' : 'dark');
            });
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
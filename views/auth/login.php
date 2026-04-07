<?php
use App\Helpers\Csrf;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - CDA PIZZA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container-fluid px-4 py-5 min-vh-100 d-flex align-items-center justify-content-center">
    <div class="card border-0 shadow-lg login-card" style="width: 100%; max-width: 420px;">
        <div class="card-body p-5">
            <?php
            if ($messages){
                foreach ($messages as $type => $message){
                    foreach($message as $messageValue){?>
                        <div class=" alert alert-<?=$type?>" role="alert">
                            <?= $messageValue ?>
                        </div>
                    <?php       }
                }
            }
            ?>
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="login-icon mb-4">
                    <i class="bi bi-door-open text-primary display-3"></i>
                </div>
                <h2 class="h3 fw-bold text-dark mb-2">Connexion</h2>
                <p class="text-muted mb-0">CDA PIZZA</p>
            </div>

            <form action="/login" method="POST">
                <?= Csrf::field() ?>

                <!-- Login -->
                <div class="mb-4">
                    <label for="login" class="form-label fw-semibold text-dark mb-2">Login</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-white border-0 shadow-sm">
                            <i class="bi bi-person text-muted"></i>
                        </span>
                        <input type="text"
                               class="form-control form-control-lg border-0 shadow-sm ps-0"
                               id="login" name="login"
                               placeholder="guichet1"
                               value="<?= escape($_POST['login'] ?? '') ?>"
                               required autofocus>
                    </div>
                </div>

                <!-- Mot de passe (FIX DEFINITIF) -->
                <div class="mb-5 position-relative">
                    <label for="password" class="form-label fw-semibold text-dark mb-2">Mot de passe</label>
                    <div class="position-relative">
                        <!-- Icône cadenas -->
                        <i class="bi bi-lock-fill text-muted position-absolute start-0 top-50 translate-middle-y ms-3 z-2"></i>

                        <!-- Input -->
                        <input type="password"
                               class="form-control form-control-lg shadow-sm ps-5 pe-5"
                               name="password" id="password"
                               placeholder="••••••••••••"
                               required>

                        <!-- Œil à droite -->
                        <button type="button" class="btn btn-link p-0 password-toggle position-absolute end-0 top-50 translate-middle-y me-3"
                                onclick="togglePassword()" tabindex="-1">
                            <i class="bi bi-eye fs-5 text-muted" id="eye-icon"></i>
                        </button>
                    </div>
                    <div id="password-help" class="form-text mt-1">Premier accès ? Changez votre mot de passe</div>
                </div>

                <!-- Bouton submit -->
                <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-bold shadow-sm login-btn">
                    <i class="bi bi-box-arrow-right me-2"></i>
                    SE CONNECTER
                </button>
            </form>

        </div>
    </div>
</div>

<!-- CSS intégré -->
<style>
    .login-card {
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(0,0,0,0.05);
    }

    .login-icon {
        width: 72px;
        height: 72px;
        background: rgba(13,110,253,0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }

    /* Input password parfait */
    input[name="password"] {
        padding-left: 50px !important;
        padding-right: 50px !important;
    }

    .password-toggle {
        z-index: 10;
        background: none;
        border: none;
        width: 40px;
        height: 40px;
    }

    input[type="password"]::-ms-reveal,
    input[type="password"]::-ms-clear,
    input[type="password"]::-webkit-credentials-auto-fill-button {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
        width: 0 !important;
        height: 0 !important;
        position: absolute !important;
    }

    .password-toggle:hover i {
        color: #0d6efd !important;
    }

    /* Bouton login */
    .login-btn {
        background: linear-gradient(135deg, #0d6efd, #0b5ed7);
        border-radius: 12px;
        font-size: 1.1rem;
        border: none;
        transition: all 0.3s ease;
        min-height: 56px;
    }

    .login-btn:hover {
        background: linear-gradient(135deg, #0b5ed7, #0a58ca);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(13,110,253,0.4);
        color: white !important;
    }

    /* Focus accessible */
    .login-btn:focus-visible,
    input:focus-visible {
        outline: 2px solid #0d6efd;
        outline-offset: 2px;
    }

    /* Responsive */
    @media (max-width: 576px) {
        .card-body { padding: 2rem 1.5rem !important; }
        .login-btn { font-size: 1rem; min-height: 52px; }
    }

    /* Reduced motion */
    @media (prefers-reduced-motion: reduce) {
        * { transition-duration: 0.1s !important; }
    }
</style>

<!-- Script toggle -->
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.className = 'bi bi-eye-slash';
        } else {
            passwordInput.type = 'password';
            eyeIcon.className = 'bi bi-eye';
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
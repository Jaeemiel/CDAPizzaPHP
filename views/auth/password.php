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

            <!-- Header -->
            <div class="text-center mb-5">
                <div class="login-icon mb-4">
                    <i class="bi bi-key text-warning display-3"></i>
                </div>
                <h2 class="h3 fw-bold text-dark mb-2">Nouveau mot de passe</h2>
                <p class="text-muted mb-0">Sécurisez votre compte</p>
            </div>

            <form action="/password/change" method="POST">
                <?= Csrf::field() ?>

                <!-- Mot de passe avec jauge de force -->
                <div class="mb-4">
                    <label for="password" class="form-label fw-semibold text-dark mb-2">Nouveau mot de passe</label>
                    <div class="position-relative">
                        <!-- Icône cadenas -->
                        <i class="bi bi-lock-fill text-muted position-absolute start-0 top-50 translate-middle-y ms-3 z-2"></i>

                        <!-- Input -->
                        <input type="password"
                               class="form-control form-control-lg shadow-sm ps-5 pe-5 nx-pr"
                               name="password" id="password"
                               placeholder="8 caractères minimum"
                               autocomplete="new-password"
                               oninput="nxStrength(this.value)"
                               required
                               aria-describedby="password-strength">

                        <!-- Œil toggle -->
                        <button type="button" class="btn btn-link p-0 password-toggle position-absolute end-0 top-50 translate-middle-y me-3"
                                onclick="nxTogglePw('password', 'nx-eye-pw1')" tabindex="-1">
                            <i class="bi bi-eye fs-5 text-muted" id="nx-eye-pw1"></i>
                        </button>
                    </div>

                    <!-- Jauge de force -->
                    <div class="nx-bar mt-2" id="password-strength" aria-label="Force du mot de passe">
                        <div class="nx-seg" id="nx-s1"></div>
                        <div class="nx-seg" id="nx-s2"></div>
                        <div class="nx-seg" id="nx-s3"></div>
                        <div class="nx-seg" id="nx-s4"></div>
                    </div>
                    <div class="form-text mt-1">Plus de 8 caractères, majuscule, chiffre, symbole</div>
                </div>

                <!-- Confirmation mot de passe -->
                <div class="mb-5">
                    <label for="password_confirmation" class="form-label fw-semibold text-dark mb-2">Confirmer</label>
                    <div class="position-relative">
                        <!-- Icône cadenas -->
                        <i class="bi bi-lock-fill text-muted position-absolute start-0 top-50 translate-middle-y ms-3 z-2"></i>

                        <!-- Input -->
                        <input type="password"
                               class="form-control form-control-lg shadow-sm ps-5 pe-5"
                               name="password_confirmation" id="password_confirmation"
                               autocomplete="new-password"
                               required>

                        <!-- Œil toggle -->
                        <button type="button" class="btn btn-link p-0 password-toggle position-absolute end-0 top-50 translate-middle-y me-3"
                                onclick="nxTogglePw('password_confirmation', 'nx-eye-pw2')" tabindex="-1">
                            <i class="bi bi-eye fs-5 text-muted" id="nx-eye-pw2"></i>
                        </button>
                    </div>
                </div>

                <!-- Bouton submit -->
                <button type="submit" class="btn btn-warning btn-lg w-100 py-3 fw-bold shadow-sm nx-btn">
                    <i class="bi bi-check-circle me-2"></i>
                    VALIDER LE CHANGEMENT
                </button>
            </form>
        </div>
    </div>
</div>

<!-- CSS identique à la page login + jauge -->
<style>
    .login-card {
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(0,0,0,0.05);
    }

    .login-icon {
        width: 72px;
        height: 72px;
        background: rgba(255,193,7,0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }

    /* Jauge de force mot de passe */
    .nx-bar {
        display: flex;
        gap: 2px;
        height: 6px;
        background: rgba(0,0,0,0.08);
        border-radius: 3px;
    }
    .nx-seg {
        height: 100%;
        border-radius: 2px;
        transition: all 0.3s ease;
        flex: 1;
    }
    .nx-pr { padding-right: 50px !important; }

    /* Anti-Edge yeux natifs */
    input[type="password"]::-ms-reveal,
    input[type="password"]::-ms-clear,
    input[type="password"]::-webkit-credentials-auto-fill-button {
        display: none !important;
    }

    /* Password toggle */
    .password-toggle {
        z-index: 10;
        background: none;
        border: none;
        width: 40px;
        height: 40px;
    }
    .password-toggle:hover i { color: #0d6efd !important; }

    /* Responsive + accessibilité */
    @media (max-width: 576px) {
        .card-body { padding: 2rem 1.5rem !important; }
    }
    @media (prefers-reduced-motion: reduce) {
        * { transition-duration: 0.1s !important; }
    }
</style>

<!-- Scripts identiques -->
<script>
    /* Toggle mot de passe */
    function nxTogglePw(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'bi bi-eye';
        }
    }

    /* Jauge force mot de passe */
    const nxColors = ['#FF4D6D', '#FF9A3C', '#7EB5D8', '#1AF3D9'];
    function nxStrength(val) {
        let score = 0;
        if (val.length >= 8) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        for (let i = 1; i <= 4; i++) {
            const seg = document.getElementById('nx-s' + i);
            seg.style.background = i <= score ? nxColors[score - 1] : 'rgba(0,0,0,0.08)';
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
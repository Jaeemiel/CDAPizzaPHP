<?php

use App\Helpers\Csrf;

?>
<div class="container py-5">
    <div class="card mx-auto shadow-lg" style="max-width: 500px; border-radius: 1rem; background: linear-gradient(145deg, #f8f9fa, #e9ecef);">
        <div class="card-body p-4">
            <h2 class="card-title text-center mb-4 fw-bold">Changer le mot de passe</h2>

            <form action="/password/change" method="POST">
                <?= Csrf::field() ?>

                <!-- Password -->

                <div class="form-floating mb-4 position-relative">
                    <input type="password" class="form-control rounded-3 shadow-sm" name="password" id="Password" placeholder="Password">
                    <label for="Password"><i class="bi bi-lock-fill me-2"></i>Password</label>
                    <span id="togglePassword" style="position:absolute; top:50%; right:1rem; transform:translateY(-50%); cursor:pointer; z-index:2;">
                        <i class="bi bi-eye-fill"></i>
                    </span>
                </div>

                <!-- Confirmation mot de passe -->
                <div class="mb-4">
                    <input type="password" class="form-control rounded-3 shadow-sm" name="password_confirmation" id="password_confirmation"
                           placeholder="Répétez votre mot de passe"/>
                    <label for="password_confirmation" class="nx-label">Confirmer le mot de passe</label>
                    <span id="togglePassword" style="position:absolute; top:50%; right:1rem; transform:translateY(-50%); cursor:pointer; z-index:2;">
                        <i class="bi bi-eye-fill"></i>
                    </span>
                </div>
        </div>

        <!-- Submit Button -->
        <div class="d-grid">
            <button class="btn btn-warning btn-lg fw-bold" type="submit">
                Valider
            </button>
        </div>

        </form>
    </div>
</div>
</div>

<div class="nx-root">

    <div class="nx-orb nx-orb-1"></div>
    <div class="nx-orb nx-orb-2"></div>
    <div class="nx-orb nx-orb-3"></div>
    <div class="nx-grid"></div>

    <div class="nx-card">
        <div class="nx-fade">
            <!-- ── Formulaire ── -->
            <form action="/password/change" method="POST">
                <?= Csrf::field(); ?>

                <!-- Mot de passe -->
                <div class="mb-3">
                    <label for="password" class="nx-label">Mot de passe</label>
                    <div class="nx-wrap">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="nx-input nx-pr"
                            placeholder="8 caractères minimum"
                            autocomplete="new-password"
                            oninput="nxStrength(this.value)"
                            required
                        />
                        <i class="bi bi-lock nx-ico"></i>
                        <button class="nx-eye" type="button" onclick="nxTogglePw('password','nx-eye-pw')">
                            <i class="bi bi-eye" id="nx-eye-pw"></i>
                        </button>
                    </div>
                    <div class="nx-bar">
                        <div class="nx-seg" id="nx-s1"></div>
                        <div class="nx-seg" id="nx-s2"></div>
                        <div class="nx-seg" id="nx-s3"></div>
                        <div class="nx-seg" id="nx-s4"></div>
                    </div>
                </div>

                <!-- Confirmation mot de passe -->
                <div class="mb-4">
                    <label for="password_confirmation" class="nx-label">Confirmer le mot de passe</label>
                    <div class="nx-wrap">
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="nx-input nx-pr"
                            placeholder="Répétez votre mot de passe"
                            autocomplete="new-password"
                            required
                        />
                        <i class="bi bi-lock-fill nx-ico"></i>
                        <button class="nx-eye" type="button" onclick="nxTogglePw('password_confirmation','nx-eye-pw2')">
                            <i class="bi bi-eye" id="nx-eye-pw2"></i>
                        </button>
                    </div>
                </div>



                <!-- Submit -->
                <button type="submit" class="nx-btn">
                    Valider &nbsp;→
                </button>

            </form>

        </div>
    </div>

</div>
<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('Password');

    togglePassword.addEventListener('click', () => {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        togglePassword.innerHTML = type === 'password' ? '<i class="bi bi-eye-fill"></i>' : '<i class="bi bi-eye-slash-fill"></i>';
    });
</script>
<script>
    /* Toggle affichage mot de passe */
    function nxTogglePw(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type     = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            input.type     = 'password';
            icon.className = 'bi bi-eye';
        }
    }

    /* Jauge de force du mot de passe */
    const nxColors = ['#FF4D6D', '#FF9A3C', '#7EB5D8', '#1AF3D9'];
    function nxStrength(val) {
        let score = 0;
        if (val.length >= 8)            score++;
        if (/[A-Z]/.test(val))          score++;
        if (/[0-9]/.test(val))          score++;
        if (/[^A-Za-z0-9]/.test(val))   score++;
        for (let i = 1; i <= 4; i++) {
            document.getElementById('nx-s' + i).style.background =
                i <= score ? nxColors[score - 1] : 'rgba(255,255,255,.08)';
        }
    }
</script>
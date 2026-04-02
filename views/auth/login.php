<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow" style="width: 100%; max-width: 400px;">
        <div class="card-body p-4">

            <h2 class="card-title text-center fw-bold mb-4">Connexion</h2>

            <form action="/login" method="POST">

                <!-- Login -->
                <div class="mb-3">
                    <label for="login" class="form-label">Login</label>
                    <input type="text" id="login" name="login" class="form-control"
                           placeholder="Votre login"
                           value="<?= escape($_POST['login'] ?? '') ?>"
                           required autofocus />
                </div>

                <!-- Mot de passe -->

                <div class="form-floating mb-4 position-relative">
                    <input type="password" class="form-control rounded-3 shadow-sm" name="password" id="Password" placeholder="Password" required>
                    <label for="Password"><i class="bi bi-lock-fill me-2"></i>Password</label>
                    <span id="togglePassword" style="position:absolute; top:50%; right:1rem; transform:translateY(-50%); cursor:pointer; z-index:2;">
                        <i class="bi bi-eye-fill"></i>
                    </span>
                </div>


                <!-- Submit -->
                <button type="submit" class="btn btn-primary w-100">
                    Se connecter &nbsp;→
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
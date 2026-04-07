<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CDA PIZZA - Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container-fluid px-4 py-5 min-vh-100 d-flex flex-column justify-content-center">

    <!-- Header simple -->
    <header class="text-center mb-5">
        <h1 class="display-4 fw-bold text-primary mb-3">
            <i class="bi bi-pizza-slice me-3"></i>
            CDA PIZZA
        </h1>
        <p class="lead text-muted mb-5">Application de gestion interne</p>
    </header>

    <main class="row g-4 justify-content-center">
        <!-- GUICHET -->
        <section class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm role-card">
                <div class="card-body p-4 text-center">
                    <div class="role-icon mb-3">
                        <i class="bi bi-cash-stack text-warning display-4"></i>
                    </div>
                    <h3 class="h4 fw-bold mb-3 text-dark">Guichet</h3>
                    <div class="badge bg-warning-subtle text-warning fs-6 px-3 py-2 mb-3">Commandes</div>
                    <ul class="list-unstyled small text-muted mb-0-0">
                        <li class="mb-2"><i class="bi bi-check-lg text-success me-2"></i>Création clients</li>
                        <li class="mb-2"><i class="bi bi-check-lg text-success me-2"></i>Gestion commandes</li>
                        <li class="mb-2"><i class="bi bi-check-lg text-success me-2"></i>PAYER → PRÉPARATION</li>
                        <li class="mb-2"><i class="bi bi-check-lg text-success me-2"></i>PRÊTE → LIVRER</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- CUISINE -->
        <section class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm role-card">
                <div class="card-body p-4 text-center">
                    <div class="role-icon mb-3">
                        <i class="bi bi-fire text-success display-4"></i>
                    </div>
                    <h3 class="h4 fw-bold mb-3 text-dark">Cuisine</h3>
                    <div class="badge bg-success-subtle text-success fs-6 px-3 py-2 mb-3">Production</div>
                    <ul class="list-unstyled small text-muted mb-0-0">
                        <li class="mb-2"><i class="bi bi-check-lg text-success me-2"></i>Consultation</li>
                        <li class="mb-2"><i class="bi bi-check-lg text-success me-2"></i>PRÉPARATION → PRÊTE</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- GÉRRANT -->
        <section class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm role-card">
                <div class="card-body p-4 text-center">
                    <div class="role-icon mb-3">
                        <i class="bi bi-person-gear text-primary display-4"></i>
                    </div>
                    <h3 class="h4 fw-bold mb-3 text-dark">Gérant</h3>
                    <div class="badge bg-primary-subtle text-primary fs-6 px-3 py-2 mb-3">Administration</div>
                    <ul class="list-unstyled small text-muted mb-0">
                        <li class="mb-2"><i class="bi bi-check-lg text-success me-2"></i>Pizzas/stocks</li>
                    </ul>
                </div>
            </div>
        </section>
    </main>

    <!-- Bouton central "Se connecter" -->
    <footer class="mt-auto text-center pt-5">
        <a href="/login" class="btn btn-primary btn-lg px-5 py-3 fw-bold shadow-sm login-btn"
           aria-label="Accéder au formulaire de connexion">
            <i class="bi bi-box-arrow-right me-3"></i>
            SE CONNECTER
        </a>
    </footer>
</div>

<style>
    /* Minimaliste et pro */
    .role-card {
        transition: box-shadow 0.3s ease, transform 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .role-card:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        transform: translateY(-4px);
    }

    .role-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(255,255,255,0.7);
    }

    /* Bouton login central */
    .login-btn {
        background: linear-gradient(135deg, #0d6efd, #0b5ed7);
        border: none;
        border-radius: 12px;
        font-size: 1.125rem;
        min-width: 220px;
        box-shadow: 0 4px 16px rgba(13,110,253,0.3);
        transition: all 0.3s ease;
    }

    .login-btn:hover {
        background: linear-gradient(135deg, #0b5ed7, #0a58ca);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(13,110,253,0.4);
        color: white !important;
        text-decoration: none;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .display-4 { font-size: 2.5rem !important; }
        .login-btn {
            font-size: 1rem;
            min-width: 200px;
            padding: 0.875rem 1.5rem;
        }
    }

    /* Accessibilité */
    @media (prefers-reduced-motion: reduce) {
        .role-card, .login-btn {
            transition: none;
        }
    }

    .login-btn:focus-visible {
        outline: 3px solid #0d6efd;
        outline-offset: 3px;
    }

    /* Contrastes parfaits */
    @media (prefers-color-scheme: dark) {
        body { background-color: #1a1a1a; color: #e0e0e0; }
        .card { background-color: #2a2a2a; border-color: #444; }
    }
</style>
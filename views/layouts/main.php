<?php
//
//use App\Core\Auth;
//
//?>
<!--<!doctype html>-->
<!--<html lang="fr">-->
<!--<head>-->
<!--    <meta charset="utf-8">-->
<!--    <meta name="viewport" content="width=device-width, initial-scale=1">-->
<!--    <title>--><?php //= escape($titre) ?? "CDAPizza" ?><!--</title>-->
<!--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">-->
<!--    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>-->
<!--    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>-->
<!--</head>-->
<!--<body>-->
<!---->
<!--<nav class="navbar navbar-expand-lg border-bottom px-3">-->
<!--    <div class="container-fluid">-->
<!---->
<!--        -->
<!--        <a class="navbar-brand fw-bold text-primary" href="/">-->
<!--            CDA PIZZA-->
<!--        </a>-->
<!---->
<!--        -->
<!--        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"-->
<!--                data-bs-target="#navbarContent">-->
<!--            <span class="navbar-toggler-icon"></span>-->
<!--        </button>-->
<!---->
<!--        <div class="collapse navbar-collapse" id="navbarContent">-->
<!---->
<!--            -->
<!--            <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-lg-2">-->
<!---->
<!--                --><?php //if (Auth::check()): ?>
<!--                    --><?php //$role = Auth::user()->role; ?>
<!--                    -->
<!--                    --><?php //if (in_array($role, ['GUICHET', 'CUISINE'])): ?>
<!--                        <li class="nav-item">-->
<!--                            <a class="nav-link fw-bold text-primary" href="/commandes">-->
<!--                                Liste des commandes-->
<!--                            </a>-->
<!--                        </li>-->
<!--                    --><?php //endif; ?>
<!---->
<!--                    --><?php //if ($role === 'GUICHET'): ?>
<!--                        <li class="nav-item">-->
<!--                            <a class="nav-link fw-bold text-primary" href="/commandes/create">-->
<!--                                Création Commande-->
<!--                            </a>-->
<!--                        </li>-->
<!---->
<!--                        -->
<!--                        <li class="nav-item"><a class="nav-link fw-bold text-primary" href="/clients/create">Création Client</a></li>-->
<!--                        <li class="nav-item"><a class="nav-link fw-bold text-primary" href="/clients">Liste des clients</a></li>-->
<!--                    --><?php //endif; ?>
<!---->
<!--                    -->
<!--                    --><?php //if (in_array($role, ['GERANT', 'CUISINE'])): ?>
<!--                        <li class="nav-item"><a class="nav-link fw-bold text-primary" href="/pizzas">Liste des pizzas</a></li>-->
<!--                        --><?php //if ($role === 'GERANT'): ?>
<!--                            <li class="nav-item"><a class="nav-link fw-bold text-primary" href="/pizzas/create">Création Pizza</a></li>-->
<!--                        --><?php //endif; ?>
<!--                    --><?php //endif; ?>
<!---->
<!--                --><?php //endif; ?>
<!---->
<!--            </ul>-->
<!--            -->
<!--            <div class="d-flex align-items-center gap-2">-->
<!--                <div class="d-flex gap-2">-->
<!--                    --><?php //if (Auth::check()): ?>
<!--                        <a href="/logout" class="btn btn-outline-c btn-sm px-3">Se déconnecter</a>-->
<!--                    --><?php //else: ?>
<!--                        <a href="/login" class="btn btn-outline-c btn-sm px-3">Se connecter</a>-->
<!--                    --><?php //endif; ?>
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</nav>-->
<!---->
<?php
//if ($messages){
//    foreach ($messages as $type => $message){
//        foreach($message as $messageValue){?>
<!--            <div class=" alert alert---><?php //=$type?><!--" role="alert">-->
<!--                --><?php //= $messageValue ?>
<!--            </div>-->
<!--        --><?php //      }
//    }
//}
//?>
<!---->
<?php //= $content ?>
<!---->
<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>-->
<!--</body>-->
<!--</html>-->

<?php use App\Core\Auth; ?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= escape($titre) ?? "CDAPizza" ?></title>

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- Styles app interne -->
    <style>
        :root {
            --primary-glow: rgba(13,110,253,0.3);
            --card-shadow: 0 8px 25px rgba(0,0,0,0.1);
            --card-hover: 0 12px 35px rgba(0,0,0,0.15);
        }

        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
        }

        /* Navbar moderne */
        .navbar {
            background: rgba(255,255,255,0.95) !important;
            backdrop-filter: blur(20px);
            box-shadow: var(--card-shadow);
            border-bottom: 1px solid rgba(0,0,0,0.05) !important;
        }

        .navbar-brand {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.5rem;
        }

        .nav-link {
            transition: all 0.3s ease;
            border-radius: 8px;
            padding: 0.5rem 1rem !important;
            margin: 0 0.25rem;
        }
        .nav-link:hover {
            background: rgba(13,110,253,0.1);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(13,110,253,0.2);
        }

        /* Cartes principales */
        .app-card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        .app-card:hover {
            box-shadow: var(--card-hover);
            transform: translateY(-4px);
        }

        /* Formulaires */
        .form-card {
            background: rgba(255,255,255,0.98);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            padding: 2.5rem;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .form-divider {
            border: none;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(0,0,0,0.1), transparent);
            margin: 2rem 0;
        }

        /* Boutons app */
        .btn-app {
            border-radius: 12px;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            min-height: 48px;
        }
        .btn-app:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        .btn-violet {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
            border-color: #8b5cf6;
            color: white;
        }
        .btn-violet:hover {
            background: linear-gradient(135deg, #7c3aed, #6d28d9);
            color: white;
        }

        .btn-outline-c {
            border-color: rgba(13,110,253,0.3);
            color: #0d6efd;
        }
        .btn-outline-c:hover {
            background: rgba(13,110,253,0.1);
            border-color: #0d6efd;
            color: #0d6efd;
        }

        /* Tables modernes */
        .table-container {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255,255,255,0.3);
        }

        .table-dark {
            background: linear-gradient(135deg, #1e3a8a, #1e40af);
        }

        .table-row-hover:hover {
            background: rgba(13,110,253,0.05);
            transform: scale(1.01);
        }

        /* Titres */
        .page-title {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            background: linear-gradient(135deg, #0d6efd, #fd7e14);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-card { padding: 1.5rem; margin: 1rem; }
            .nav-link { padding: 0.5rem !important; margin: 0 0.125rem; }
        }

        /* Accessibilité */
        @media (prefers-reduced-motion: reduce) {
            * { transition: none !important; }
        }

        /* Centre tous les formulaires */
        .form-container {
            max-width: 620px !important;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .form-container {
                max-width: 95vw !important;
                padding: 0 1rem;
            }
        }
    </style>
</head>
<body>
<!-- NAV -->
<nav class="navbar navbar-expand-lg px-3">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand fw-bold text-primary" href="/">
            <i class="bi bi-pizza-slice me-2"></i>CDA PIZZA
        </a>
        <!-- Mobile toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <!-- Left menu -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-lg-2">
                <!-- Gestion de la Navbar -->
                <?php if (Auth::check()): ?>
                    <?php $role = Auth::user()->role; ?>
                    <?php if (in_array($role, ['GUICHET', 'CUISINE'])): ?>
                        <li class="nav-item">
                            <a class="nav-link fw-bold" href="/commandes">
                                <i class="bi bi-list-ul me-1"></i>Commandes
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($role === 'GUICHET'): ?>
                        <li class="nav-item">
                            <a class="nav-link fw-bold" href="/commandes/create">
                                <i class="bi bi-plus-circle me-1"></i>Créer commande
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-bold" href="/clients/create">
                                <i class="bi bi-person-plus me-1"></i>Client
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-bold" href="/clients">
                                <i class="bi bi-list-ul me-1"></i>Client
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (in_array($role, ['GERANT', 'CUISINE'])): ?>
                        <li class="nav-item">
                            <a class="nav-link fw-bold" href="/pizzas">
                                <i class="bi bi-list-ul me-1"></i>Pizzas
                            </a>
                        </li>
                        <?php if ($role === 'GERANT'): ?>
                            <li class="nav-item">
                                <a class="nav-link fw-bold" href="/pizzas/create">
                                    <i class="bi bi-plus-circle me-1"></i>Créer pizza
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>

            <!-- Right actions -->
            <div class="d-flex align-items-center gap-2">
                <?php if (Auth::check()): ?>
                    <span class="navbar-text me-2">
                            <i class="bi bi-person-circle me-1"></i><?= ucfirst(Auth::user()->role) ?>
                        </span>
                    <a href="/logout" class="btn btn-outline-c btn-sm px-3 btn-app">
                        <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                    </a>
                <?php else: ?>
                    <a href="/login" class="btn btn-outline-c btn-sm px-3 btn-app">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Connexion
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<!-- Messages flash -->
<?php if (isset($messages) && $messages): ?>
    <div class="container mt-4">
        <?php foreach ($messages as $type => $message): ?>
            <?php foreach($message as $messageValue): ?>
                <div class="alert alert-<?= $type ?> alert-dismissible fade show app-card" role="alert">
                    <?= $messageValue ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- ICI CHARGEMENT DE LA VUE (CONTENT) -->
<main class="container py-5 d-flex justify-content-center">
    <?= $content ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
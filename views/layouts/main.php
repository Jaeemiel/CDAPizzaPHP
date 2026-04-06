<?php

use App\Core\Auth;

?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= strip_tags($titre) ?? "CDAPizza" ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
</head>
<body>
<!-- NAV -->
<nav class="navbar navbar-expand-lg border-bottom px-3">
    <div class="container-fluid">

        <!-- Brand -->
        <a class="navbar-brand fw-bold text-primary" href="/">
            CDA PIZZA
        </a>

        <!-- Mobile toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">

            <!-- Left menu -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-lg-2">

                <?php if (Auth::check()): ?>
                    <?php $role = Auth::user()->role; ?>
                    <!-- Commande -->
                    <?php if (in_array($role, ['GUICHET', 'CUISINE'])): ?>
                        <li class="nav-item">
                            <a class="nav-link fw-bold text-primary" href="/commandes">
                                Liste des commandes
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($role === 'GUICHET'): ?>
                        <li class="nav-item">
                            <a class="nav-link fw-bold text-primary" href="/commandes/create">
                                Création Commande
                            </a>
                        </li>

                        <!-- Client -->
                        <li class="nav-item"><a class="nav-link fw-bold text-primary" href="/clients/create">Création Client</a></li>
                        <li class="nav-item"><a class="nav-link fw-bold text-primary" href="/clients">Liste des clients</a></li>
                    <?php endif; ?>

                    <!-- Pizza -->
                    <?php if (in_array($role, ['GERANT', 'CUISINE'])): ?>
                        <li class="nav-item"><a class="nav-link fw-bold text-primary" href="/pizzas">Liste des pizzas</a></li>
                        <?php if ($role === 'GERANT'): ?>
                            <li class="nav-item"><a class="nav-link fw-bold text-primary" href="/pizzas/create">Création Pizza</a></li>
                        <?php endif; ?>
                    <?php endif; ?>

                <?php endif; ?>

            </ul>
            <!-- Right actions -->
            <div class="d-flex align-items-center gap-2">
                <div class="d-flex gap-2">
                    <?php if (Auth::check()): ?>
                        <a href="/logout" class="btn btn-outline-c btn-sm px-3">Se déconnecter</a>
                    <?php else: ?>
                        <a href="/login" class="btn btn-outline-c btn-sm px-3">Se connecter</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</nav>
<!-- Manque de cohérence avec les autres vues -->
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
<!-- ICI CHARGEMENT DE LA VUE (CONTENT) -->
<?= $content ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
<?php

use App\Helpers\Csrf;

if (isset($client->id)){
    $action = "update";
    $titres = "Modifier le ";
    $actionUri = "/clients/update/".$client->id;
    $titreBtn = "Modifier";
}else{
    $action = "create";
    $titres = "Créer un ";
    $actionUri = "/clients/create";
    $titreBtn = "Créer";
}
?>

<div class="container py-5" style="max-width: 620px;">

    <!-- En-tête -->
    <div class="text-center text-md-start mb-5">
        <a href="/commandes" class="btn btn-outline-c btn-sm mb-3 d-inline-flex align-items-center gap-2 btn-app">
            <i class="bi bi-arrow-left"></i>Retour
        </a>
        <h1 class="page-title mb-0"><?= $titres ?> client</h1>
    </div>

    <!-- Formulaire -->
    <div class="form-card app-card">
        <form action="<?= $actionUri ?>" method="POST">
            <?= Csrf::field()?>

            <!-- Nom -->
            <div class="mb-4">
                <label class="form-label fw-semibold">Nom</label>
                <input type="text" class="form-control form-control-lg shadow-sm"  name="nom"
                       value="<?= isset($client->nom) ? escape($client->nom): '' ?>"/>
            </div>
            <!-- Prénom -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Prénom</label>
                <input type="text" class="form-control form-control-lg shadow-sm"  name="prenom"
                       value="<?= isset($client->prenom) ? escape($client->prenom): '' ?>"/>
            </div>
            <hr class="form-divider" />
            <!-- Téléphone -->
            <div class="mb-4">
                <label class="form-label fw-semibold">Téléphone</label>
                <input type="tel" class="form-control shadow-sm" name="telephone"
                       value="<?= isset($client->telephone) ? escape($client->telephone): '' ?>"/>
            </div>
            <hr class="form-divider" />
            <!-- Rue -->
            <div class="mb-4">
                <label class="form-label fw-semibold">Rue</label>
                <input type="text" class="form-control form-control-lg shadow-sm"  name="rue"
                       value="<?= isset($client->rue) ? escape($client->rue): '' ?>"/>
            </div>
            <!-- Code Postal -->
            <div class="mb-4">
                <label class="form-label fw-semibold">Code postal</label>
                <input type="text" class="form-control form-control-lg shadow-sm"  name="code_postal"
                       value="<?= isset($client->code_postal) ? escape($client->code_postal): '' ?>"/>
            </div>
            <!-- Ville -->
            <div class="mb-4">
                <label class="form-label fw-semibold">Ville</label>
                <input type="text" class="form-control form-control-lg shadow-sm"  name="ville"
                       value="<?= isset($client->ville) ? escape($client->ville): '' ?>"/>
            </div>



            <!-- Boutons -->
            <div class="d-flex gap-3 mt-5">
                <button type="submit" class="btn btn-violet btn-lg px-5 flex-grow-1 btn-app">
                    <i class="bi bi-<?= $action === 'create' ? 'plus-circle' : 'pencil-fill' ?> me-2"></i>
                    <?= $titreBtn ?>
                </button>
                <?php if($action === 'create'):?>
                    <a href="/commandes/create" class="btn btn-outline-c btn-lg px-4 btn-app">Annuler</a>
                <?php else:?>
                    <a href="/clients" class="btn btn-outline-c btn-lg px-4 btn-app">Annuler</a>
                <?php endif; ?>
            </div>

        </form>
    </div>
</div>


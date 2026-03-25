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
    $titreBtn = "Créer le client";
}
?>

<div class="container py-5" style="max-width: 620px;">

    <!-- En-tête -->
    <div class="mb-4">
        <a href="/commandes" class="text-decoration-none d-inline-flex align-items-center gap-2 mb-3"
           style="color:rgba(200,197,255,.5);font-size:.85rem;">
            <i class="bi bi-arrow-left"></i> Retour aux commandes
        </a>
        <h1 class="fw-bold mb-1" style="font-size:1.8rem;"><?= $titres ?> client</h1>
    </div>

    <!-- Formulaire -->
    <div class="form-card">
        <form action="<?= $actionUri ?>" method="POST">
            <?= Csrf::field()?>

            <!-- Nom -->
            <div class="mb-3">
                <label class="form-label">Nom</label>
                <input type="text" class="form-control" name="nom"
                       value="<?= isset($client->nom) ? escape($client->nom): '' ?>"/>
            </div>
            <!-- Prénom -->
            <div class="mb-3">
                <label class="form-label">Prénom</label>
                <input type="text" class="form-control" name="prenom"
                       value="<?= isset($client->prenom) ? escape($client->prenom): '' ?>"/>
            </div>
            <hr class="form-divider" />
            <!-- Téléphone -->
            <div class="mb-3">
                <label class="form-label">Téléphone</label>
                <input type="tel" class="form-control" name="telephone"
                       value="<?= isset($client->telephone) ? escape($client->telephone): '' ?>"/>
            </div>
            <hr class="form-divider" />
            <!-- Rue -->
            <div class="mb-3">
                <label class="form-label">Rue</label>
                <input type="text" class="form-control" name="rue"
                       value="<?= isset($client->rue) ? escape($client->rue): '' ?>"/>
            </div>
            <!-- Code Postal -->
            <div class="mb-3">
                <label class="form-label">Code postal</label>
                <input type="text" class="form-control" name="code_postal"
                       value="<?= isset($client->code_postal) ? escape($client->code_postal): '' ?>"/>
            </div>
            <!-- Ville -->
            <div class="mb-3">
                <label class="form-label">Ville</label>
                <input type="text" class="form-control" name="ville"
                       value="<?= isset($client->ville) ? escape($client->ville): '' ?>"/>
            </div>



            <!-- Boutons -->
            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-violet px-4 flex-grow-1">
                    <i class="bi bi-<?= $action === 'create' ? 'plus-circle' : 'pencil-fill' ?> me-2"></i><?= $titreBtn ?>
                </button>
                <a href="/commandes/create" class="btn btn-outline-c px-4">Annuler</a>
            </div>

        </form>
    </div>
</div>


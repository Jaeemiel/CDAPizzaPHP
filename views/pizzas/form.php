<?php

use App\Helpers\Csrf;

if (isset($pizza->id)){
    $action = "update";
    $titres = "Modifier la ";
    $actionUri = "/pizzas/update/".$pizza->id;
    $titreBtn = "Modifier";
}else{
    $action = "create";
    $titres = "Créer une ";
    $actionUri = "/pizzas/create";
    $titreBtn = "Créer la pizza";
}
?>

<div class="container py-5" style="max-width: 620px;">

    <!-- En-tête -->
    <div class="mb-4">
        <h1 class="fw-bold mb-1" style="font-size:1.8rem;"><?= $titres ?> pizza</h1>
    </div>

    <!-- Formulaire -->
    <div class="form-card">
        <form action="<?= $actionUri ?>" method="POST">
            <?= Csrf::field()?>

            <!-- Libellé -->
            <div class="mb-3">
                <label class="form-label">Nom</label>
                <input type="text" class="form-control" name="libelle"
                       value="<?= isset($pizza->libelle) ? escape($pizza->libelle): '' ?>"/>
            </div>

            <!-- Ingrédients -->
            <div class="mb-3">
                <label class="form-label">Ingrédients</label>
                <textarea name="ingredients" class="form-control" rows="3"
                          placeholder="Ingrédients de la pizza"
                ><?= isset($pizza->ingredients) ? escape($pizza->ingredients) : '' ?></textarea>
            </div>
            <hr class="form-divider" />

            <!-- Prix -->
            <div class="mb-3">
                <label class="form-label">Prix</label>
                <input type="number" class="form-control" name="prix" step="any" min="0"
                       value="<?= isset($pizza->prix) ? escape((float)$pizza->prix): '' ?>"
                       />
            </div>
            <hr class="form-divider" />

            <!-- En stock -->
            <div class="form-check">
                <!-- Pour que le champ soit envoyé dans le $_POST -->
                <input type="hidden" name="en_stock" value="0" />
                <input type="checkbox" class="form-check-input" name="en_stock" value="1"
                    <?= isset($pizza->en_stock) && $pizza->en_stock ? 'checked' : '' ?>>
                <label class="form-check-label">En stock</label>
            </div>

            <!-- Boutons -->
            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-violet px-4 flex-grow-1">
                    <i class="bi bi-<?= $action === 'create' ? 'plus-circle' : 'pencil-fill' ?> me-2"></i><?= $titreBtn ?>
                </button>
                <a href="/pizzas" class="btn btn-outline-c px-4">Annuler</a>
            </div>

        </form>
    </div>
</div>


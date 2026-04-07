<?php
use App\Helpers\Csrf;

if (isset($pizza->id)){
    $action = "update";
    $titres = "Modifier";
    $actionUri = "/pizzas/update/".$pizza->id;
    $titreBtn = "Modifier";
} else {
    $action = "create";
    $titres = "Créer";
    $actionUri = "/pizzas/create";
    $titreBtn = "Créer";
}
?>

<div class="py-5" style="max-width: 620px;">
    <!-- En-tête -->
    <div class="text-center text-md-start mb-5">
        <a href="/pizzas" class="btn btn-outline-c btn-sm mb-3 d-inline-flex align-items-center gap-2 btn-app">
            <i class="bi bi-arrow-left"></i>Retour
        </a>
        <h1 class="page-title mb-0"><?= $titres ?> pizza</h1>
    </div>

    <!-- Formulaire -->
    <div class="form-card app-card">
        <form action="<?= $actionUri ?>" method="POST">
            <?= Csrf::field() ?>

            <!-- Libellé -->
            <div class="mb-4">
                <label class="form-label fw-semibold">Nom</label>
                <input type="text" class="form-control form-control-lg shadow-sm" name="libelle"
                       value="<?= isset($pizza->libelle) ? escape($pizza->libelle): '' ?>" required/>
            </div>

            <!-- Ingrédients -->
            <div class="mb-4">
                <label class="form-label fw-semibold">Ingrédients</label>
                <textarea name="ingredients" class="form-control shadow-sm" rows="4"
                          placeholder="Tomate, mozzarella, pepperoni..."
                ><?= isset($pizza->ingredients) ? escape($pizza->ingredients) : '' ?></textarea>
            </div>

            <hr class="form-divider">

            <!-- Prix -->
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Prix (€)</label>
                    <input type="number" class="form-control form-control-lg shadow-sm" name="prix" step="0.01" min="0"
                           value="<?= isset($pizza->prix) ? escape((float)$pizza->prix): '' ?>" required/>
                </div>
                <!-- En stock -->
                <div class="col-md-6 d-flex align-items-end">
                    <div class="form-check">
                        <!-- Pour que le champ soit envoyé dans le $_POST -->
                        <input type="hidden" name="en_stock" value="0">
                        <input type="checkbox" class="form-check-input" name="en_stock" value="1" id="en_stock"
                            <?= isset($pizza->en_stock) && $pizza->en_stock ? 'checked' : '' ?>>
                        <label class="form-check-label fw-semibold" for="en_stock">
                            En stock
                        </label>
                    </div>
                </div>
            </div>

            <!-- Boutons -->
            <div class="d-flex gap-3 mt-5">
                <button type="submit" class="btn btn-violet btn-lg px-5 flex-grow-1 btn-app">
                    <i class="bi bi-<?= $action === 'create' ? 'plus-circle' : 'pencil-fill' ?> me-2"></i>
                    <?= $titreBtn ?>
                </button>
                <a href="/pizzas" class="btn btn-outline-c btn-lg px-4 btn-app">Annuler</a>
            </div>
        </form>
    </div>
</div>

<div class="container py-5">
    <div class="card mx-auto shadow-lg" style="max-width: 1200px;">
        <div class="card-body p-4">

            <!-- En-tête -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Pizza #<?= $pizza->id ?></h2>
            </div>


            <!-- Infos pizza -->
            <p><strong>Nom :</strong> <?= htmlspecialchars($pizza->libelle) ?></p>
            <p><strong>Ingrédients :</strong> <?= htmlspecialchars($pizza->ingredients ?? 'Aucun') ?></p>
            <p><strong>Prix :</strong> <?= htmlspecialchars($pizza->prix) ?></p>
            <p><strong>En stock :</strong> <?= htmlspecialchars($pizza->en_stock? 'Oui' : 'Non') ?></p>


            <!-- Actions -->
            <div class="d-flex gap-2 mt-4">

                <!-- Bouton retour -->
                <a href="/pizzas" class="btn btn-secondary">Retour</a>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="card mx-auto shadow-lg" style="max-width: 1200px;">
        <div class="card-body p-4">

            <!-- En-tête -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Pizza #<?= $pizza->id ?></h2>
            </div>


            <!-- Infos pizza -->
            <p><strong>Nom :</strong> <?= escape($pizza->libelle) ?></p>
            <p><strong>Ingrédients :</strong> <?= escape($pizza->ingredients ?? 'Aucun') ?></p>
            <p><strong>Prix :</strong> <?= escape($pizza->prix) ?></p>
            <p><strong>En stock :</strong> <?= $pizza->en_stock? 'Oui' : 'Non' ?></p>


            <!-- Actions -->
            <div class="d-flex gap-2 mt-4">
                <!-- Bouton changement état -->
                <form action="/pizzas/<?= $pizza->id ?>/stock" method="POST">
                    <button type="submit" class="btn <?= $pizza->en_stock ? 'btn-success' : 'btn-danger' ?>">
                        <?= $pizza->en_stock ? 'En stock' : 'Hors stock' ?>
                    </button>
                </form>


                <!-- Bouton retour -->
                <a href="/pizzas" class="btn btn-secondary">Retour</a>
            </div>
        </div>
    </div>
</div>
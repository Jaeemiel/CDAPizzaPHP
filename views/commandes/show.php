
<div class="container py-5">
    <div class="card mx-auto shadow-lg" style="max-width: 1200px;">
        <div class="card-body p-4">

            <!-- En-tête -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Commande #<?= $commande->id ?></h2>
                    <span class="<?= $etat->badge() ?>">
                        <?= $etat->label() ?>
                    </span>
            </div>


            <!-- Infos commande -->
            <p><strong>Client :</strong> <?= htmlspecialchars($commande->client()->nom) ?> <?= htmlspecialchars($commande->client()->prenom) ?></p>
            <p><strong>Date :</strong> <?= htmlspecialchars($commande->created_at) ?></p>
            <?php foreach ($reductions as $reduction):?>
                <span class="badge bg-success"><?= $reduction->label() ?></span>
            <?php endforeach;?>
            <!-- Pizzas -->
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                <tr>
                    <th>Pizza</th>
                    <th>Prix unitaire</th>
                    <th>Quantité</th>
                    <th>Sous-total</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($commande->getCommandePizza() as $commande_pizza): ?>
                    <tr class="table-row-hover stagger">
                        <td><?= htmlspecialchars($commande_pizza->libelle)?></td>
                        <td><?= htmlspecialchars($commande_pizza->prix_unitaire)?></td>
                        <td><?= htmlspecialchars($commande_pizza->nb_pizza)?></td>
                        <td><?= htmlspecialchars(number_format($commande_pizza->nb_pizza * $commande_pizza->prix_unitaire,2))?> €</td>
                    </tr>
                <?php endforeach;?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan=3><strong>Total</strong></td>
                    <td><strong><?= htmlspecialchars(number_format($commande->montant,2))?> €</strong></td>
                </tr>
                </tfoot>
            </table>

            <p><strong>Commentaire :</strong> <?= $commande->commentaire ?? 'Aucun' ?></p>

            <!-- Actions -->
            <div class="d-flex gap-2 mt-4">
                <a href="/commandes/update/<?= $commande->id ?>" class="btn btn-warning">Modifier</a>

                <!-- Bouton changement état -->
                <?php if ($etatSuivant): ?>
                    <form action="/commandes/<?= $commande->id ?>/etat" method="POST">
                        <input type="hidden" name="etat" value="<?= $etatSuivant->value ?>">
                        <button type="submit" class="btn btn-warning">
                            <?= $etatSuivant->label() ?>
                        </button>
                    </form>
                <?php else: ?>
                    <span class="text-muted">Commande finalisée</span>
                <?php endif; ?>

                <!-- Bouton retour -->
                <a href="/commandes" class="btn btn-secondary">Retour</a>
            </div>
        </div>
    </div>
</div>
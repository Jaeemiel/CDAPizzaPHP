<div class="container py-5">
    <div class="card mx-auto shadow-lg animate-fade-in" style="max-width: 1200px; border-radius: 1rem; background: linear-gradient(145deg, #f8f9fa, #e9ecef);">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                    <tr>
                        <th colspan="2">Commande <?= $commande->id ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="col">Pizza</th>
                        <th scope="col">Quantité</th>
                    </tr>


                    <?php foreach ($commande->getQuantityPizza() as $pizza): ?>
                        <tr class="table-row-hover stagger">
                            <td><?= htmlspecialchars($pizza->libelle)?></td>
                            <td><?= htmlspecialchars($pizza->nb_pizza)?></td>
                        </tr>
                    <?php endforeach;?>

                    </tbody>
                </table>
                <h4>État :</h4>
                <?= htmlspecialchars($commande->etat) ?>
                <h4>Date et heure :</h4>
                <?= htmlspecialchars($commande->date_heure) ?>
                <h4>Commentaire :</h4>
                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea"><?= $commande->commentaire ?></textarea>


            </div>
        </div>
    </div>
</div>
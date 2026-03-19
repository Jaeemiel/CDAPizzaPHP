<div class="container py-5">
    <h1 class="text-center mb-4 fw-bold animate-fade-in">Liste des commandes</h1>

    <div class="card mx-auto shadow-lg animate-fade-in" style="max-width: 1200px; border-radius: 1rem; background: linear-gradient(145deg, #f8f9fa, #e9ecef);">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">État</th>
                        <th scope="col">Montant</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($commandes as $index => $commande) : ?>
                        <tr class="table-row-hover stagger" style="animation-delay: <?= $index * 0.08 ?>s;">
                            <th scope="row"><?= $commande->id ?></th>
                            <td><?= htmlspecialchars($commande->etat) ?></td>
                            <td><?= htmlspecialchars($commande->montant) ?></td>
                            <td>
                                <a href="/commandes/show/<?=$commande->id?>" class="btn btn-success btn-gradient btn-sm me-2">
                                    <i class="bi bi-eye-fill me-1"></i>Show
                                </a>
                                <a href="/commandes/update/<?=$commande->id?>" class="btn btn-warning btn-gradient-warning btn-sm me-2">
                                    <i class="bi bi-pencil-fill me-1"></i>Update
                                </a>
                                <a href="/commandes/delete/<?=$commande->id?>" class="btn btn-danger btn-gradient-danger btn-sm">
                                    <i class="bi bi-trash-fill me-1"></i>Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
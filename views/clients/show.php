
<div class="container py-5">
    <div class="card mx-auto shadow-lg" style="max-width: 1200px;">
        <div class="card-body p-4">

            <!-- En-tête -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Client #<?= $client->id ?></h2>
            </div>


            <!-- Infos client -->
            <p><strong>Nom :</strong> <?= htmlspecialchars($client->nom) ?> </p>
            <p><strong>Prénom :</strong> <?= htmlspecialchars($client->prenom) ?></p>
            <p><strong>Téléphone :</strong> <?= htmlspecialchars($client->telephone) ?></p>
            <p>
                <strong>Adresse :</strong>
                <?= htmlspecialchars($client->rue) ?>,
                <?= htmlspecialchars($client->code_postal) ?>,
                <?= htmlspecialchars($client->ville) ?>
            </p>



            <!-- Actions -->
            <div class="d-flex gap-2 mt-4">
                <!-- Bouton retour -->
                <a href="/clients" class="btn btn-secondary">Retour</a>
            </div>
        </div>
    </div>
</div>
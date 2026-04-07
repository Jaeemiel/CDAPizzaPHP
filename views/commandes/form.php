<?php

use App\Helpers\Csrf;

if (isset($commande->id)) {
    $action = "update";
    $titres = "Modifier la ";
    $actionUri = "/commandes/update/".$commande->id;
    $titreBtn = "Modifier";
} else{
    $action = "create";
    $titres = "Créer une ";
    $actionUri = "/commandes/create";
    $titreBtn = "Créer";
}
?>
<div class="w-100" style="max-width: 700px;">
    <div class="container py-5">

        <!-- En-tête -->
        <div class="mb-text-center text-md-start mb-5">
            <a href="/commandes" class="btn btn-outline-c btn-sm mb-4 d-inline-flex align-items-center gap-2 btn-app">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
            <h1 class="page-title mb-0"><?= $titres ?> commande</h1>
        </div>

        <!-- Formulaire -->
        <div class="form-card app-card">
            <form action="<?= $actionUri ?>" method="POST">
                <?= Csrf::field()?>

                <!-- Client -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">Client <span style="color:var(--cyan)">*</span></label>
                    <select name="client_id" class="form-select">
                        <option disabled <?= $commande->client_id === null ? 'selected' : '' ?>>
                            Choisir un client
                        </option>
                        <?php foreach ($clients as $client) :?>
                            <option value="<?= $client->id ?>"
                                <?= ($clientId !== null && $clientId == $client->id) ||
                                ($commande->client_id !== null && $commande->client_id == $client->id) ? 'selected' : '' ?>>
                                <?= escape($client->nom) ?> <?= escape($client->prenom) ?> Tel: <?= escape($client->telephone)?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Etat -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">Etat</label>
                    <?php if ($action === 'create'): ?>
                        <div class="statut-display">
                            <div class="statut-dot"></div>
                            <span>Défini automatiquement à la création</span>
                            <span class="<?= $etatDefaut->badge() ?>"><?= $etatDefaut->label() ?></span>
                        </div>
                        <div class="info-text"><i class="bi bi-info-circle me-1"></i>Le statut pourra être modifié après la création de la tâche.</div>
                    <?php else: ?>
                        <select name="etat" class="form-select d-inline w-auto">
                            <?php foreach ($etats as $etat): ?>
                                <option value="<?= $etat->value ?>"
                                    <?= $commande->etat === $etat->value ? 'selected' : '' ?>>
                                    <?= $etat->label() ?>
                                </option>
                            <?php endforeach;?>
                        </select>
                    <?php endif;?>
                </div>

                <hr class="form-divider" />

                <!-- Table Pizzas -->
                <table class="table table-hover align-middle mb-0">
                    <thead>
                    <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Quantité</th>
                        <th scope="col">Prix unitaire</th>
                        <th scope="col">Sous-total</th>
                    </tr>
                    </thead>
                    <tbody id="pizza-tbody"></tbody>
                </table>

                <!-- Template caché -->
                <template id="pizza-row-template">
                    <tr class="repeatLine">
                        <!-- Choix Pizza -->
                        <td>
                            <select name="pizzas[INDEX][pizza_id]" class="form-select pizza-select">
                                <option disabled selected>Choisir une pizza</option>
                            </select>
                        </td>

                        <!-- Quantité -->
                        <td>
                            <input type="number" name="pizzas[INDEX][nb_pizza]"
                                   class="form-control qte-input" min="1" value="1" style="width:80px"
                                   oninput="this.value = parseFloat(this.value) || ''"/>
                        </td>

                        <!-- Prix unitaire -->
                        <td class="prix-unitaire">-</td>

                        <!-- Sous-total -->
                        <td class="sous-total">-</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-row btn-app">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </td>
                    </tr>
                </template>

                <button type="button" class="btn btn-secondary mt-2 btn-app" id="add-pizza">
                    <i class="bi bi-plus-circle me-1"></i> Ajouter une pizza
                </button>

                <hr/>
                <!-- Montant aperçu -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">Montant estimé</label>
                    <input type="text"
                           class="form-control totalTTC"
                           value="0 €"
                           readonly/>
                    <div class="info-text">
                        <i class="bi bi-info-circle me-1"></i>
                        Aperçu — le montant final sera calculé automatiquement par le serveur.
                    </div>
                </div>

                <hr class="form-divider" />

                <!-- Commentaire -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">Commentaire</label>
                    <textarea name="commentaire" class="form-control shadow-sm" rows="4"
                              placeholder="Instructions spéciales, allergies..."
                    ><?= escape($commande->commentaire ?? '')?></textarea>
                </div>


                <!-- Boutons -->
                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-violet btn-lg px-5 flex-grow-1 btn-app">
                        <i class="bi bi-<?= $action === 'create' ? 'plus-circle' : 'pencil-fill' ?> me-2"></i><?= $titreBtn ?>
                    </button>
                    <a href="/commandes" class="btn btn-outline-c btn-lg px-4 btn-app">Annuler</a>
                </div>

            </form>
        </div>
    </div>
</div>
<!-- Données des pizzas disponibles sérialisées en JSON pour le script JS -->
<script id="pizzas-data" type="application/json">
    <?= json_encode(array_map(fn($p) => [
        'id'    => $p->id,
        'libelle' => $p->libelle,
        'prix'  => $p->prix,
    ], $pizzas)) ?>
</script>

<!-- Pizzas déjà associées à cette commande, pour pré-remplir le formulaire en mode modification -->
<script id="pizzas-commande" type="application/json">
    <?= json_encode(isset($pizzasCommande)?array_map(fn($p) => [
        'pizza_id' => $p->pizza_id,
        'libelle' => $p->libelle,
        'prix'  => $p->prix_unitaire,
        'nb_pizza' => $p->nb_pizza,
    ], $pizzasCommande):[]) ?>
</script>

<script src="/js/scriptFormCommande.js"></script>

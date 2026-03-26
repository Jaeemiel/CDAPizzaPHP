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
    $titreBtn = "Créer la commande";
}
?>

<div class="container py-5" style="max-width: 620px;">

    <!-- En-tête -->
    <div class="mb-4">
        <a href="/commandes" class="text-decoration-none d-inline-flex align-items-center gap-2 mb-3"
           style="color:rgba(200,197,255,.5);font-size:.85rem;">
            <i class="bi bi-arrow-left"></i> Retour aux commandes
        </a>
        <h1 class="fw-bold mb-1" style="font-size:1.8rem;"><?= $titres ?> commande</h1>
    </div>

    <!-- Formulaire -->
    <div class="form-card">
        <form action="<?= $actionUri ?>" method="POST">
            <?= Csrf::field()?>

            <!-- Client -->
            <label class="form-label">Client <span style="color:var(--cyan)">*</span></label>
            <select name="client_id" class="form-select">
                <option disabled <?= !isset($commande->client_id) ? 'selected' : '' ?>>
                    Choisir un client
                </option>
                <?php foreach ($clients as $client) :?>
                    <option value="<?= $client->id ?>"
                        <?= (isset($commande->client_id) && $commande->client_id == $client->id) ? 'selected' : '' ?>>
                        <?= escape($client->nom) ?> <?= escape($client->prenom) ?> Tel: <?= escape($client->telephone)?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Etat -->
            <div class="mb-3">
                <label class="form-label">Etat</label>
                <?php if ($action === 'create'): ?>
                    <div class="statut-display">
                        <div class="statut-dot"></div>
                        <span>Défini automatiquement à la création</span>
                        <span class="<?= $etatDefaut->badge() ?>"><?= $etatDefaut::PAYER->label() ?></span>
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
            <!-- TODO: Table de pizza-->
            <table class="table table-hover align-middle mb-0">
                <thead>
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Quantité</th>
                    <th scope="col">Sous-total</th>
                </tr>
                </thead>
                <tbody id="pizza-tbody">
<!--                    <tr class="repeatLine">-->
<!--                        <td>-->
<!--                            <select name="pizzas[0][pizza_id]" class="form-select pizza-select">-->
<!--                                <option disabled selected>Choisir une pizza</option>-->
<!--                                <option value="0">Reine</option>-->
<!--                                <option value="0">Landaise</option>-->
<!--                            </select>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <input type="number" name="pizzas[0][nb_pizza]"-->
<!--                                   class="form-control qte-input" min="1" value="1" style="width:80px"/>-->
<!--                        </td>-->
<!--                        <td class="prix-unitaire">-</td>-->
<!--                        <td class="sous-total">-</td>-->
<!--                        <td>-->
<!--                            <button type="button" class="btn btn-danger btn-sm remove-row">-->
<!--                                <i class="bi bi-trash-fill"></i>-->
<!--                            </button>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    <tr class="repeatLine">-->
<!--                        <td>-->
<!--                            <select name="pizzas[1][pizza_id]" class="form-select pizza-select">-->
<!--                                <option disabled selected>Choisir une pizza</option>-->
<!--                                <option>Reine</option>-->
<!--                                <option>Landaise</option>-->
<!--                            </select>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <input type="number" name="pizzas[1][nb_pizza]"-->
<!--                                   class="form-control qte-input" min="1" value="1" style="width:80px"/>-->
<!--                        </td>-->
<!--                        <td class="prix-unitaire">-</td>-->
<!---->
<!--                        <td class="sous-total">-</td>-->
<!--                        <td>-->
<!--                            <button type="button" class="btn btn-danger btn-sm remove-row">-->
<!--                                <i class="bi bi-trash-fill"></i>-->
<!--                            </button>-->
<!--                        </td>-->
<!--                    </tr>-->
                </tbody>
<!--                <tfoot>-->
<!--                <tr>-->
<!--                    <td colspan="3">Total : </td>-->
<!--                    <td><strong>--><?php //= htmlspecialchars(number_format($commande->montant,2))?><!-- €</strong></td>-->
<!--                </tr>-->
<!--                </tfoot>-->
            </table>

            <!-- Template caché -->
            <template id="pizza-row-template">
                <tr class="repeatLine">
                    <td>
                        <select name="pizzas[0][pizza_id]" class="form-select pizza-select">
                            <option disabled selected>Choisir une pizza</option>
                        </select>
                    </td>
                    <td class="prix-unitaire">-</td>
                    <td>
                        <input type="number" name="pizzas[INDEX][nb_pizza]"
                               class="form-control qte-input" min="1" value="1" style="width:80px"/>
                    </td>
                    <td class="sous-total">-</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-row">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </td>
                </tr>
            </template>



            <button type="button" class="btn btn-secondary mt-2" id="add-pizza">
                <i class="bi bi-plus-circle me-1"></i> Ajouter une pizza
            </button>

            <!-- Montant -->
            <div class="mb-3">
                <label class="form-label">Montant</label>
                <input type="text"
                       class="form-control"
                       value="<?= isset($commande->montant) ? escape($commande->montant) . ' €' : '0 €' ?>"
                       readonly/>
                <div class="info-text">
                    <i class="bi bi-info-circle me-1"></i>
                    Calculé automatiquement selon les pizzas commandées.
                </div>
            </div>



            <hr class="form-divider" />

            <!-- Commentaire -->
            <div class="mb-4">
                <label class="form-label">Commentaire</label>
                <textarea name="commentaire" class="form-control" rows="3"
                          placeholder="Instructions spéciales, allergies..."
                ><?= isset($commande->commentaire) ? escape($commande->commentaire) : '' ?></textarea>
            </div>


            <!-- Boutons -->
            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-violet px-4 flex-grow-1">
                    <i class="bi bi-<?= $action === 'create' ? 'plus-circle' : 'pencil-fill' ?> me-2"></i><?= $titreBtn ?>
                </button>
                <a href="/commandes" class="btn btn-outline-c px-4">Annuler</a>
            </div>

        </form>
    </div>
</div>

<script src="scriptForm.js"/>
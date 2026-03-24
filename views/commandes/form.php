<?php

use App\Helpers\Csrf;
use App\Enum\Etat_commande;

if (isset($commande->id)){
    $action = "update";
    $titres = "Modifier la ";
    $actionUri = "/commandes/update/".$commande->id;
    $titreBtn = "Modifier";
}else{
    $action = "create";
    $titres = "Créer une ";
    $actionUri = "/commandes/create";
    $titreBtn = "Créer la commande";
}
?>
<!--TODO: Penser a faire la partie table pizza -->
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
                        <?= escape($client->nom) ?> <?= escape($client->prenom) ?>
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
                        <span class="<?= Etat_commande::PAYER->badge() ?>"><?= Etat_commande::PAYER->label() ?></span>
                    </div>
                    <div class="info-text"><i class="bi bi-info-circle me-1"></i>Le statut pourra être modifié après la création de la tâche.</div>
                <?php else: ?>
                    <select name="etat" class="form-select d-inline w-auto">
                        <?php foreach (Etat_commande::cases() as $etat): ?>
                            <option value="<?= $etat->value ?>"
                                <?= $commande->etat === $etat->value ? 'selected' : '' ?>>
                                <?= $etat->label() ?>
                            </option>
                        <?php endforeach;?>
                    </select>
                <?php endif;?>
            </div>

            <hr class="form-divider" />



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
                <textarea name="commentaire"
                          class="form-control"
                          rows="3"
                          placeholder="Instructions spéciales, allergies..."
                ><?= isset($commande->commentaire) ? escape($commande->commentaire) : '' ?></textarea>
            </div>


            <!-- Boutons -->
            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-violet px-4 flex-grow-1">
                    <i class="bi bi-plus-circle me-2"></i><?= $titreBtn ?>
                </button>
                <a href="/commandes" class="btn btn-outline-c px-4">Annuler</a>
            </div>

        </form>
    </div>
</div>


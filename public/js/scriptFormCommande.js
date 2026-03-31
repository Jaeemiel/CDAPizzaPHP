"use strict"

/**
 * Représente la table de pizzas
 * @type {Array<{id: number, libelle: string, prix: number}>}
 */
const pizzas = JSON.parse(document.getElementById('pizzas-data').textContent);

/**
 * Représente la table de pizzasCommande
 * @type {Array<{pizza_id: number, libelle: string, prix: number, nb_pizza: number}>}
 */
const pizzasCommande = JSON.parse(document.getElementById('pizzas-commande').textContent);

/**
 * Compteur pour les index des lignes du tableau
 * @type {number}
 */
let index = 0;

//////////////////
// Add / Delete //
//////////////////

/**
 * Ajoute une nouvelle ligne de pizza dans le tableau.
 * Clone le template, peuple le select avec les pizzas disponibles,
 * attache les évènements et met à jour le total.
 */
function addLine(){
    const tbody = document.querySelector('tbody');
    const template = document.getElementById('pizza-row-template').content;
    const newRow = template.cloneNode(true).querySelector('tr');

    newRow.innerHTML = newRow.innerHTML.replaceAll('INDEX',index);

    const select = newRow.querySelector('.pizza-select');
    pizzas.forEach(p=>{
        const option = document.createElement('option');
        option.value = p.id;
        option.dataset.prix = p.prix;
        option.textContent = p.libelle;
        select.appendChild(option);
    })

    tbody.appendChild(newRow);
    attachRowEvents(newRow);  // Attach listeners for new row
    index++;
    updateTotal();
}

/**
 * Supprime une ligne du tableau et met à jour le total.
 *
 * @param {HTMLTableRowElement} row - La ligne à supprimer
 */
function deleteLine(row){
    row.remove();
    updateTotal();
}

////////////
// CALCUL //
////////////

/**
* Calcule et met à jour le prix unitaire et le sous-total d'une ligne
* en fonction de la pizza sélectionnée et de la quantité saisie.
* @param {HTMLTableRowElement} row - La ligne à calculer
*/
function calculateRow(row) {
    const select = row.querySelector('.pizza-select');
    const prix = parseFloat(select.selectedOptions[0]?.dataset.prix) || 0;
    const qte = parseInt(row.querySelector('.qte-input').value) || 0;

    row.querySelector('.prix-unitaire').textContent = prix.toFixed(2)+ ' €';
    row.querySelector('.sous-total').textContent = (prix*qte).toFixed(2)+ ' €';
}

/**
 * Calcule et met à jour le montant total estimé
 * en additionnant tous les sous-totaux des lignes.
 */
function updateTotal(){
    const sousTotaux = [...document.querySelectorAll('.sous-total')]
        .map(td=>parseFloat(td.textContent)||0);
    const total = sousTotaux.reduce((acc,val)=>acc+val,0); //acc = accumulator

    document.querySelector('.totalTTC').value = total.toFixed(2);
}

///////////////////
// EVENT BY LINE //
///////////////////

/**
 * Attache les écouteurs d'événements sur une ligne :
 * - Changement de pizza → recalcul
 * - Changement de quantité → recalcul
 * - Clic sur supprimer → suppression de la ligne
 *
 * @param {HTMLTableRowElement} row - La ligne sur laquelle attacher les événements
 */
function attachRowEvents(row) {

    row.querySelector('.pizza-select').addEventListener('change', () => {
        calculateRow(row);
        updateTotal();
    });


    row.querySelector('.qte-input').addEventListener('input', () => {
        calculateRow(row);
        updateTotal();
    });


    row.querySelector('.remove-row').addEventListener('click', () => {
        deleteLine(row);
    });
}


////////////////////////
// DOM CONTENT LOADED //
////////////////////////
document.addEventListener('DOMContentLoaded', () => {
    // Pour pré-remplir mode update
    if(pizzasCommande.length >0){
        pizzasCommande.forEach(p=>{
            addLine();
            const lastRow = document.querySelector('.repeatLine:last-child');
            lastRow.querySelector('.pizza-select').value = p.pizza_id;
            lastRow.querySelector('.qte-input').value = p.nb_pizza;
            calculateRow(lastRow);
        });
    }

    document.querySelector('#add-pizza').addEventListener('click', () => {
        addLine();
    });

    updateTotal();  // Initial total
});
    
    
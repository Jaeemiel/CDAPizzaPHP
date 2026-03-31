"use strict"
const pizzas = JSON.parse(document.getElementById('pizzas-data').textContent);
let index = 0;
////////////////////////////////
// Add / Delete / Clear Lines //
////////////////////////////////
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
        option.textContent =p.libelle;
        select.appendChild(option);
    })

    // clearLine(newRow, {showToast: false});

    tbody.appendChild(newRow);
    attachRowEvents(newRow);  // Attach listeners for new row
    index++;
    updateTotal();
}

function getDeleteType(nbAvant){
    return nbAvant === 1
        ? "danger"
        : "warning";
}

function getDeleteMessage(nbAvant) {
    return nbAvant === 1
        ? "La der des der ligne a été supprimée."
        : "La dernière ligne a été supprimée.";
}

function deleteLine(row){
    const rows = document.querySelectorAll('.repeatLine');
    const nbLignesAvant = rows.length;

    row.remove();
    updateTotal();

    const message = getDeleteMessage(nbLignesAvant);
    const type = getDeleteType(nbLignesAvant);
    showPopup(message,type);
}

function deleteLastLine(){
    const rows= document.querySelectorAll('.repeatLine');

    if(rows.length === 0){
        showPopup("Il n'y a plus de ligne à supprimer","info");
        return;
    }

    const lastRow = rows[rows.length-1];
    deleteLine(lastRow);
}

////////////
// CALCUL //
////////////
function calculateRow(row) {
    const select = row.querySelector('.pizza-select');
    const prix = parseFloat(select.selectedOptions[0]?.dataset.prix) || 0;
    const qte = parseInt(row.querySelector('.qte-input').value) || 0;

    row.querySelector('.prix-unitaire').textContent = prix.toFixed(2)+ ' €';
    row.querySelector('.sous-total').textContent = (prix*qte).toFixed(2)+ ' €';
}

function updateTotal(){
    const sousTotaux = [...document.querySelectorAll('.sous-total')]
        .map(td=>parseFloat(td.textContent)||0);
    const total = sousTotaux.reduce((acc,val)=>acc+val,0);

    document.querySelector('.totalTTC').value = total.toFixed(2);
}

///////////////////
// POPUP MESSAGE //
///////////////////
let popupTimeout;
function showPopup(message, type){
    const popupMessage =document.getElementById('popupMessage');
    const popup = document.getElementById('popup');

    popup.classList.remove('popup--success',
        'popup--warning',
        'popup--danger',
        'popup--info'
    );

    popup.classList.add(`popup--${type}`)


    popupMessage.textContent = message;
    popup.classList.add('active');

    clearTimeout(popupTimeout);
    popupTimeout = setTimeout(() => {
        popup.classList.remove('active');
    }, 1200);
}

///////////////////
// EVENT BY LINE //
///////////////////
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
    document.querySelector('#add-pizza').addEventListener('click', () => {
        addLine();
        showPopup("Une ligne a été ajouté.","success");
    });

    updateTotal();  // Initial total
});
    
    
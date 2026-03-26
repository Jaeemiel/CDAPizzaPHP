"use strict"

////////////////////////////////
// Add / Delete / Clear Lines //
////////////////////////////////
function addLine(){
    const tbody = document.querySelector('tbody');
    const template = document.getElementById('row-template').content;
    const newRow = template.cloneNode(true).querySelector('tr');

    clearLine(newRow, {showToast: false});

    tbody.appendChild(newRow);
    attachRowEvents(newRow);  // Attach listeners for new row
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

// Add for db
function updateRow(row) {
    const id = row.dataset.id
    // console.log('updateRow id=', id);
    if (!id) return
    fetch('api/update.php',{
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            id: id,
            libelle: row.querySelector('.libelle').value,
            prixHT: row.querySelector('.pHT').value,
            tva: row.querySelector('select[name="TVA"]').value,
            prixTTC: row.querySelector('.pTTC').value,
        })
    })
}

// Add for db
function deleteRow(row){
   //  Ligne locale seulement
        deleteLine(row);
}

function deleteLastLine(){
    const rows= document.querySelectorAll('.repeatLine');

    if(rows.length === 0){
        showPopup("Il n'y a plus de ligne à supprimer","info");
        return;
    }

    const lastRow = rows[rows.length-1];
    deleteRow(lastRow);
}

function clearLine(row, {showToast = true}= {}){
    let aChange = false;

    row.querySelectorAll('input').forEach(input => {
        if(input.value.trim() !== '')
            aChange = true;

        input.value = '';
    });

    updateTotal();
    if(!showToast) return aChange;

    if(!aChange)
        showPopup("La ligne était déjà vide.", "info");
    else
        showPopup("Les champs ont été effacé.","success");
}

function clearAll(){
    let aChange = false;
    const rows= document.querySelectorAll('.repeatLine');

    rows.forEach(row => {
        const lineChange = clearLine(row, {showToast : false});
        if(lineChange)
            aChange = true;
    });

    updateTotal();
    if(!aChange)
        showPopup("Toutes les lignes étaient déjà vides.", "info");
    else
        showPopup("Tous les champs ont été effacés.", "success");
}

////////////
// CALCUL //
////////////
function calculateRow(row) {
    const pHT = parseFloat(row.querySelector('.pHT').value) || 0;
    const tvaRate = parseFloat(row.querySelector('select[name="TVA"]').value) / 100;
    const pTTC = pHT * (1 + tvaRate);
    row.querySelector('.pTTC').value = pTTC.toFixed(2);
}

function updateTotal(){
    const pTTCInputs = document.querySelectorAll('.pTTC');
    let total = 0;

    pTTCInputs.forEach(input => {
        total += parseFloat(input.value) || 0;
    });

    document.querySelector('.totalTTC').value = total.toFixed(2);
}

const libelleRegex = /^[A-Za-zÀ-ÖØ-öøÿ '\-]+$/;

function isLibelleValide(value) {
    return libelleRegex.test(value.trim());
}

function isRowComplete(row) {
    const libelle = row.querySelector('.libelle').value.trim();
    const pHT = row.querySelector('.pHT').value;
    const tva = row.querySelector('select[name="TVA"]').value;

    if (!isLibelleValide(libelle)) {
        showPopup("Le libellé ne doit contenir que des mots.", "info");
        return false;
    }
    return libelle !== '' && pHT !== '' && tva !== '';
}

function checkAndCalculate(row){
    if(isRowComplete(row)){
        calculateRow(row);
        updateTotal();
    }
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
    // ou
    // if(type === "success")
    //     popup.classList.add("popup--success");
    // else if(type === "warning")
    //     popup.classList.add("popup--warning");
    // else if(type === "danger")
    //     popup.classList.add("popup--danger");
    // else if(type === "info")
    //     popup.classList.add("popup--info")

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
    // Listen inputs/select changes for auto-calc
    row.querySelector('.libelle').addEventListener('input', () => checkAndCalculate(row));
    row.querySelector('.pHT').addEventListener('input', () => checkAndCalculate(row));
    row.querySelector('select[name="TVA"]').addEventListener('change', () => checkAndCalculate(row));

    // Manual calculate button
    row.querySelector('.calc').addEventListener('click', () => {
        calculateRow(row);
        updateTotal();
        updateRow(row);
    });

    // Clear button without inline onclick
    row.querySelector('.clear').addEventListener('click', () => {
        clearLine(row);
    });

    // Delete button without inline onclick
    row.querySelector('.delete').addEventListener('click', () => {
        deleteRow(row);
    });
}


////////////////////////
// DOM CONTENT LOADED //
////////////////////////
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.repeatLine').forEach(attachRowEvents);
    document.querySelector('.js-add').addEventListener('click', () => {
        addLine();
        showPopup("Une ligne a été ajouté.","success");
    });
    document.querySelector('.js-deleteLastLine').addEventListener('click', () => {
        deleteLastLine();
    });
    document.querySelector('.js-clearAll').addEventListener('click', () => {
        clearAll();
    });

    //JSON
    document.querySelector('.js-storeJson').addEventListener('click', () => {
        downloadJson();
    });
    document.querySelector('.js-downloadJson').addEventListener('click', () => {
        loadJsonFile();
    });
    //LOCAL STORAGE
    document.querySelector('.js-saveLocal').addEventListener('click', () => {
        saveToLocalStorage();
    })
    document.querySelector('.js-loadLocal').addEventListener('click', () => {
        loadFromLocalStorage();
    })
    //DATA BASE
    document.querySelector('.js-saveDb').addEventListener('click', () => {
        saveToDatabase();
    })
    document.querySelector('.js-loadDb').addEventListener('click', () => {
        loadFromDatabase();
    })
    document.querySelector('.js-clearDb').addEventListener('click', () => {
        clearDatabase();
    })

    updateTotal();  // Initial total
});
    
    
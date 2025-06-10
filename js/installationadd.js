'use strict';

/*=============Appelle des évènements================*/
document.getElementById('ajout-inst').addEventListener('submit',addInsallation);

/*===============AJouter une installation==============*/
async function addInsallation(event){
    event.preventDefault();

    const url = '/back/request.php/add-installation'
    
    const installationData = {
        nb_panneau: document.getElementById("nb_panneau").value,
        modele_panneau: document.getElementById("select-modele-panneau").value,
        nb_onduleur: document.getElementById("nb_onduleur").value,
        modele_onduleur: document.getElementById("select-modele-onduleur").value,
        p_crete: document.getElementById("p_crete").value,
        pvgis: document.getElementById("pvgis").value,
        surface: document.getElementById("surface").value,
        pente: document.getElementById("pente").value,
        installateur: document.getElementById("select-installateur").value,
        mois_installation: document.getElementById("mois_installation").value,
        annee_installation: document.getElementById("annee_installation").value,
        longitude: document.getElementById("long").value,
        latitude: document.getElementById("lat").value,
        code_insee: document.getElementById("select-code-insee").value,

    };
    const formBody = new URLSearchParams(installationData).toString();

    const response = await fetch(url, {
        method : 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: formBody
    });
    if(!response.ok){
        console.error('Erreur lors de l\'ajout de l\'installation');
    } else {
         document.getElementById("ajout-inst").reset();
         alert('L\'installation a bien été ajoutée')
    }
}


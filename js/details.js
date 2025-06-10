'use strict';

/*==============Appelle des fonctions===================================*/
requestAllDetails();

/*==============Détails sur une installation=============*/
async function requestAllDetails (){
    const urlParams = new URLSearchParams(window.location.search); //cherche après le ?
    const idInstallation = urlParams.get('id');

    const url = '/back/request.php/all-details?id='+idInstallation;
    const response = await fetch(url);
    if(response.ok){
        displayAllDetails(await response.json());
    } else {
        console.log('Http error : ' + response.status);
    }
}

/*==========Afficher les détails=============*/
function displayAllDetails(data){
    document.getElementById('id-inst').textContent = "Installation n°"+data[0].id_installation+" :";
    document.getElementById('marque-onduleur').textContent = data[0].marque_ond;
    document.getElementById('modele-onduleur').textContent = data[0].modele_ond;
    document.getElementById('nb-onduleur').textContent = data[0].nb_onduleur;
    document.getElementById('marque-panneau').textContent = data[0].marque_panneau;
    document.getElementById('modele-panneau').textContent = data[0].modele_panneau;
    document.getElementById('nb-panneaux').textContent = data[0].nb_panneau;
    document.getElementById('puissance-crete').textContent = data[0].puissance_crete;
    document.getElementById('surface').textContent = data[0].surface;    
    document.getElementById('pente').textContent = data[0].pente+"°";  
    document.getElementById('production-pvgis').textContent = data[0].production_pvgis;
    document.getElementById('installateur').textContent = data[0].nom_inst;
    document.getElementById('nom-ville').textContent = data[0].nom_ville;
    document.getElementById('mois-installation').textContent = data[0].nom_inst;
    document.getElementById('annee-installation').textContent = data[0].annee_inst;    
}
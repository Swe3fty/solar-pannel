'use strict';

/*================Appelle des évènements============*/
document.getElementById('modify-inst').addEventListener('submit',modifyInstallation);


/*=============Modifier une installation=============*/
async function modifyInstallation(event){
    event.preventDefault();
    const urlParams = new URLSearchParams(window.location.search); //cherche après le ?
    const idInstallation = urlParams.get('id');

    const installationData = {
        id_installation: idInstallation,
        nb_panneau: document.getElementById("nb_panneau").value,
        modele_panneau: document.getElementById("select-modele-panneau").value,
        nb_onduleur: document.getElementById("nb_onduleur").value,
        modele_ond: document.getElementById("select-modele-onduleur").value, 
        production_pvgis: document.getElementById("pvgis").value,         
        surface: document.getElementById("surface").value,
        pente: document.getElementById("pente").value,
        nom_inst: document.getElementById("select-installateur").value,   
        mois_inst: document.getElementById("mois_installation").value,      
        annee_inst: document.getElementById("annee_installation").value,    
        longitude: document.getElementById("long").value,
        latitude: document.getElementById("lat").value,
        code_insee: document.getElementById("select-code-insee").value
    };

    const formBody = new URLSearchParams(installationData).toString();

    const url = '/back/request.php/modify-installation'
    const response = await fetch(url,{
        method: 'PUT',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: formBody
    });
    if(response.ok){
        console.log(await response.json());
    } else {
        console.log('Http error : ' + response.status);
    }
}

/*============Display n° of installation===========*/
const urlParams = new URLSearchParams(window.location.search); //cherche après le ?
const idInstallation = urlParams.get('id');
document.getElementById('id-inst').textContent = 'L\'installation n°'+idInstallation;
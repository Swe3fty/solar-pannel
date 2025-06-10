'use strict';

/*==============Appelle des fonctions===========*/
requestRandomPannel();
requestRandomOnduleur();
requestRandomInstallateurs();
requestRandomCodeInsee();

/*=============Selecteur des 40 panneaux aléatoire==============*/
async function requestRandomPannel(){
    const url = '/back/request.php/random-pannel';
    const response = await fetch(url);
    if(response.ok){
        displayRandomPannel(await response.json());
    } else {
        console.log('Http error :' + response.status);
    }
}

/*===========Afficher les panneaux aléatoire dans le select=================*/
function displayRandomPannel(data){
    for(let i=0;i<data.length;i++){
        document.getElementById('select-modele-panneau').innerHTML += '<option value="'+data[i].modele_panneau+'">'+data[i].modele_panneau+'</option>'
    }
}

/*=============Selecteur des 40 onduleurs aléatoires==============*/
async function requestRandomOnduleur(){
    const url = '/back/request.php/random-onduleur';
    const response = await fetch(url);
    if(response.ok){
        displayRandomOnduleur(await response.json());
    } else {
        console.log('Http error :' + response.status);
    }
}

/*===========Afficher les 40 onduleurs aléatoire=================*/
function displayRandomOnduleur(data){
    for(let i=0;i<data.length;i++){
        document.getElementById('select-modele-onduleur').innerHTML += '<option value="'+data[i].modele_ond+'">'+data[i].modele_ond+'</option>'
    }
}

/*=============Selecteur des 40 installateurs aléatoires==============*/
async function requestRandomInstallateurs(){
    const url = '/back/request.php/random-installateur';
    const response = await fetch(url);
    if(response.ok){
        displayRandomInstallateurs(await response.json());
    } else {
        console.log('Http error :' + response.status);
    }
}

/*===========Afficher les 40 installateurs aléatoires=================*/
function displayRandomInstallateurs(data){
    for(let i=0;i<data.length;i++){
        document.getElementById('select-installateur').innerHTML += '<option value="'+data[i].nom_inst+'">'+data[i].nom_inst+'</option>'
    }
}

/*=============Selecteur des 40 code insee aléatoires==============*/
async function requestRandomCodeInsee(){
    const url = '/back/request.php/random-code-insee';
    const response = await fetch(url);
    if(response.ok){
        displayRandomCodeInsee(await response.json());
    } else {
        console.log('Http error :' + response.status);
    }
}

/*===========Affichage des 40 code insee aléatoires=================*/
function displayRandomCodeInsee(data){
    for(let i=0;i<data.length;i++){
        document.getElementById('select-code-insee').innerHTML += '<option value="'+data[i].code_insee+'">'+data[i].code_insee+'</option>'
    }
}



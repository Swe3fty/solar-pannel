'use strict';

/*=====Apelle des fonctions======*/
requestSelectOnduleursInfos();
requestSelectPanneauxInfos();
requestSelectDepartementsInfos();


/*=====Apelle des évènements=========*/
document.getElementById('btn-rechercher').addEventListener("click", checkSelectsReady)

/*=====Verification that all select have a value rather than -======*/
function checkSelectsReady() {
  const onduleur = document.getElementById('select-marque-onduleur').value;
  const panneau = document.getElementById('select-marque-panneau').value;
  const dep = document.getElementById('select-departement').value;

  if (onduleur !== '-' && panneau !== '-' && dep !== '-') {
    requestAllResultsSelect(onduleur,panneau,dep);
  } else {
    alert('Veuillez selectionner les 3 champs !')
  }
}

/*=========Obtenir le tableau des recherches à partir des 3 selects========*/
async function requestAllResultsSelect(onduleur,panneau,dep){
    const url = '/back/request.php/results-select?' +
            'marque_ond=' + encodeURIComponent(onduleur) +
            '&marque_panneau=' + encodeURIComponent(panneau) +
            '&departement=' + encodeURIComponent(dep);
    const response = await fetch(url);
    if(response.ok){
        displayAllResultsSelect(await response.json())
    } else {
        displayAllResultsSelect('HTTP error : ' + response.status)
    }

}

/*========Afficher le tableau de recherche=====*/
function displayAllResultsSelect(data){
    const resultsContainer = document.getElementById('results');
    resultsContainer.innerHTML = '';
    if(data == 'HTTP error : 400'){
        alert('Aucune installations trouvées...');
    } else {
        for(let i=0;i<data.length;i++){
            document.getElementById('results').innerHTML += '<tr><th scope="row"><a href="details.html?id='+data[i].id_installation+'">'+data[i].id_installation+'</a></th><td>'+data[i].mois_inst+'/'+data[i].annee_inst+'</td><td>'+data[i].nb_panneau+'</td><td>'+data[i].surface+' m2 </td><td>'+data[i].puissance_crete+' W </td><td>'+data[i].longitude+' lon '+data[i].latitude+' lat </td></tr>'
        }
    }
    
}

/*=========Request 20 Onduleurs de la bdd=======*/
async function requestSelectOnduleursInfos(){
    const url = '/back/request.php/onduleurs-select'
    const response = await fetch(url);
    if(response.ok){
        displayOnduleursInfos(await response.json())
    } else {
        console.log('HTTP error :' + response.status)
    }
}

/*====Afficher une sélection d'onduleurs======*/
function displayOnduleursInfos(data){
    for(let i=0;i<data.length;i++){
        document.getElementById('select-marque-onduleur').innerHTML += '<option value="'+data[i].marque_ond+'">'+data[i].marque_ond+'</option>'
    }
}

/*=========Request 20 Panneaux de la bdd=======*/
async function requestSelectPanneauxInfos(){
    const url = '/back/request.php/panneaux-select'
    const response = await fetch(url);
    if(response.ok){
        displayPanneauxInfos(await response.json())
    } else {
        console.log('HTTP error :' + response.status)
    }
}

/*====Afficher une sélection de panneaux======*/
function displayPanneauxInfos(data){
    for(let i=0;i<data.length;i++){
        document.getElementById('select-marque-panneau').innerHTML += '<option value="'+data[i].marque_panneau+'">'+data[i].marque_panneau+'</option>'
    }
}

/*=========Request 20 Departements de la bdd=======*/
async function requestSelectDepartementsInfos(){
    const url = '/back/request.php/departements-select'
    const response = await fetch(url);
    if(response.ok){
        displayDepartementsInfos(await response.json())
    } else {
        console.log('HTTP error :' + response.status)
    }
}


/*====Afficher les 20 départements selectionnés======*/
function displayDepartementsInfos(data){
    for(let i=0;i<data.length;i++){
        document.getElementById('select-departement').innerHTML += '<option value="'+data[i].nom_dep+'">'+data[i].nom_dep+'</option>'
    }
}
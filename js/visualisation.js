'use strict';

/*=====Appelle des fonctions========*/
requestInstallationsVisualations();

/*=====Obtnier les 100 premières installations=======*/
async function requestInstallationsVisualations(){
    const url = '/back/request.php/installations-vis';
    const response = await fetch(url);
    if (response.ok){
        displayAllResults(await response.json());
    } else {
        console.log('Http error : ' +response.status)
    }
}

/*========Afficher les 100 premières installations=====*/
function displayAllResults(data){
    const resultsContainer = document.getElementById('results');
    resultsContainer.innerHTML = '';
    if(data == 'HTTP error : 400'){
        alert('Aucune installations trouvées...');
    } else {
        for(let i=0;i<data.length;i++){
            document.getElementById('results').innerHTML += '<tr><th scope="row">'+data[i].id_installation+'</th><td>'+data[i].mois_inst+'/'+data[i].annee_inst+'</td><td>'+data[i].nb_panneau+'</td><td>'+data[i].surface+' m2 </td><td>'+data[i].puissance_crete+' W </td><td>'+data[i].nom_ville+'</td><td><a href="/back/html/modify.html?id='+data[i].id_installation+'"><i class="bi bi-pencil-square"></i></a></td></tr>'
        }
    }
    
}



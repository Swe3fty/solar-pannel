'use strict';

requestStats();

/*========Obtenir l'information sur les données en général=========*/
async function requestStats(){
    const url = '/back/request.php/stats';
    let response = await fetch(url);
    if(response.ok){
      displayStats(await response.json())
    } else {
      console.log(response.status);
    }
}

/*========Afficher les données générales=========*/
function displayStats(data){
  document.getElementById('nb-installations').textContent = data[0].nb_installations;
  document.getElementById('nb-installateurs').textContent = data[0].nb_installateurs;
  document.getElementById('nb-marque-panneau').textContent = data[0].nb_marques_panneaux;
  document.getElementById('nb-marque-onduleur').textContent = data[0].nb_marques_onduleurs;

}
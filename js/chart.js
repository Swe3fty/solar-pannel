'use strict';

/*=====Apelle des fonctions=================*/
requestChartYearInfos();
requestChartRegionInfos();
requestChartRegionAndYearInfos();

const cst = document.getElementById('first-bar-chart').getContext('2d');
const ctx = document.getElementById('pie-chart').getContext('2d');
const kst = document.getElementById('second-bar-chart').getContext('2d');

/*========Request pour avoir l'informations installations par années=========*/
async function requestChartYearInfos(){
    const url = '/back/request.php/installationYearChart';
    let response = await fetch(url);
    if(response.ok){
      displayYearChartInfos(await response.json());
    } else {
      console.log(response.status);
    }
}

/*========Dessiner le grahpique par années==========*/
function displayYearChartInfos(infos){

  const labels = infos.map(item => item.annee);
  const totals = infos.map(item => Number(item.total));

  const myBarChart = new Chart(cst, {
  type: 'bar',
  data: {
      labels: labels,
      datasets: [{
      label: 'Nombre d\'installation',
      data: totals,
      backgroundColor: [
          'rgba(0, 17, 255, 0.6)',
          'rgba(0, 119, 198, 0.6)',
          'rgba(142, 148, 255, 0.6)'
      ],
      borderColor: [
          'rgba(0, 17, 255, 0.6)',
          'rgba(0, 119, 198, 0.6)',
          'rgba(142, 148, 255, 0.6)'
      ],
      borderWidth: 1
      }]
  },
  options: {
      responsive: true,
      plugins: {
      legend: {
          display: false 
      },
      title: {
          display: true,
          text: 'Installations par années'
      }
      },
      scales: {
        y: {
            beginAtZero: true,
            title: {
            display: true,
            text: 'Nombre d’installations'
            }
        },
      }
  }
  });
}

/*========Request informations sur les regions et installations=========*/
async function requestChartRegionInfos(){
    const url = '../back/request.php/installationRegionChart';
    let response = await fetch(url);
    if(response.ok){
      displayRegionChartInfos(await response.json());
    } else {
      console.log(response.status);
    }
}

/*========Dessiner le graphique régions==========*/
function displayRegionChartInfos(data){

  const labels = data.map(item => item.nom_reg);
  const totals = data.map(item => Number(item.nb_installations));

  const myDoughnutChart = new Chart(ctx, {
  type: 'pie',
  data: {
      labels: labels,
      datasets: [{
      label: 'Types d’installations',
      data: totals,
      backgroundColor: [
          'rgb(255, 0, 0)',
          'rgb(255, 94, 0)',
          'rgb(255, 204, 0)',
          'rgb(162, 255, 0)',
          'rgb(0, 255, 42)',
          'rgb(0, 255, 128)',
          'rgb(0, 221, 255)',
          'rgb(0, 76, 255)',
          'rgb(111, 0, 255)',
          'rgb(255, 0, 195)'

      ],
      borderColor: [
          'rgb(255, 0, 0)',
          'rgb(255, 94, 0)',
          'rgb(255, 204, 0)',
          'rgb(162, 255, 0)',
          'rgb(0, 255, 42)',
          'rgb(0, 255, 128)',
          'rgb(0, 221, 255)',
          'rgb(0, 76, 255)',
          'rgb(111, 0, 255)',
          'rgb(255, 0, 195)'
      ],
      borderWidth: 1
      }]
  },
  options: {
      responsive: false,
      plugins: {
      legend: {
          position: 'top',
      },
      title: {
          display: true,
          text: 'Installations par régions'
      }
      }
  }
  });
  
}


/*========Request Informations sur les installations par années et par régions=========*/
async function requestChartRegionAndYearInfos(){
    const url = '../back/request.php/installationRegionYear';
    let response = await fetch(url);
    if(response.ok){
      displayChartRegionAndYearInfos(await response.json());
    } else {
      console.log(response.status);
    }
}


/*=========Dessiner le graphique par années et par régions======*/
function displayChartRegionAndYearInfos(info){

  const years = info.map(item => item.annee_inst);
  const regions = info.map(item => item.nom_reg);
  const totals = info.map(item => Number(item.nb_installations));

  //Couleur unique par région
  const colorMap = {};
  let colorIndex = 0;
  regions.forEach(region => {
    if (!colorMap[region]) {
      colorMap[region] = `hsl(${(colorIndex * 40) % 360}, 70%, 60%)`;
      colorIndex++;
    }
  });
  const colors = regions.map(region => colorMap[region]);

  const myBarChart = new Chart(kst, {
    type: 'bar',
    data: {
      labels: years,
      datasets: [{
        label: 'Installations',
        data: totals,
        backgroundColor: colors
      }]
    },
    options: {
      indexAxis: 'y',
      responsive: true,
      plugins: {
        legend: {
          display: false
        },
        title: {
          display: true,
          text: 'Installations par année (couleur = région)'
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              const region = regions[context.dataIndex];
              const value = totals[context.dataIndex];
              return `${region}: ${value} installations`;
            }
          }
        }
      },
      scales: {
        x: {
          beginAtZero: true,
          title: {
            display: true,
            text: 'Nombre d’installations'
          }
        },
        y: {
          title: {
            display: true,
            text: 'Années'
          }
        }
      }
    }
  });



}












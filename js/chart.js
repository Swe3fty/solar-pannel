const cst = document.getElementById('myBarChart').getContext('2d');
const ctx = document.getElementById('myPieChart').getContext('2d');
const kst = document.getElementById('scatterChart').getContext('2d');

/*=======Graphique Histogramme=======*/
const myBarChart = new Chart(cst, {
type: 'bar',
data: {
    labels: ['Panneaux Solaires', 'Éoliennes', 'Hydroélectrique'],
    datasets: [{
    label: 'Types d’installations',
    data: [45, 25, 30],
    backgroundColor: [
        'rgba(255, 99, 132, 0.6)',
        'rgba(54, 162, 235, 0.6)',
        'rgba(255, 206, 86, 0.6)'
    ],
    borderColor: [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)'
    ],
    borderWidth: 1
    }]
},
options: {
    responsive: true,
    plugins: {
    legend: {
        display: false // Légende inutile pour un seul dataset
    },
    title: {
        display: true,
        text: 'Répartition des types d’installations'
    }
    },
    scales: {
    y: {
        beginAtZero: true,
        title: {
        display: true,
        text: 'Nombre d’installations par années'
        }
    }
    }
}
});

/*=======Graphique Camembert=======*/
const myDoughnutChart = new Chart(ctx, {
type: 'pie',
data: {
    labels: ['Panneaux Solaires', 'Éoliennes', 'Hydroélectrique'],
    datasets: [{
    label: 'Types d’installations',
    data: [45, 25, 30],
    backgroundColor: [
        'rgba(255, 99, 132, 0.6)',
        'rgba(54, 162, 235, 0.6)',
        'rgba(255, 206, 86, 0.6)'
    ],
    borderColor: [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)'
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

/*===========Graphique A point============*/
  const regions = ["Île-de-France", "Auvergne-Rhône-Alpes", "Occitanie", "Bretagne"];
  const colors = ["#FF6384", "#36A2EB", "#4BC0C0", "#FFCE56"];

  const data = {
    datasets: regions.map((region, index) => ({
      label: region,
      backgroundColor: colors[index],
      borderColor: colors[index],
      showLine: false,
      data: Array.from({ length: 15 }, (_, i) => ({
        x: 1990 + Math.floor(Math.random() * 33), // année entre 1990 et 2023
        y: Math.floor(Math.random() * 1000), // installations fictives
      }))
    }))
  };

  const config = {
    type: 'scatter',
    data: data,
    options: {
      responsive: false,
      plugins: {
        title: {
          display: true,
          text: "Nombre d'installations par région (1990 - 2023)"
        },
        tooltip: {
          mode: 'nearest'
        }
      },
      scales: {
        x: {
          type: 'linear',
          position: 'bottom',
          title: {
            display: true,
            text: 'Année'
          },
          min: 1990,
          max: 2023
        },
        y: {
          title: {
            display: true,
            text: "Nombre d'installations"
          }
        }
      }
    }
  };
  new Chart(kst, config);
'use strict';

// Charge les installations au chargement de la page
requestInstallationsMap();

// Récupère les installations depuis le serveur
async function requestInstallationsMap() {
    let response = await fetch('../back/request.php/?action=installationsMap&annee-installation=${encodeURIComponent(annee-installation)}&departementSelect=${encodeURIComponent(departementSelect)};');

    if (response.ok)
        displayInstallationsMap(await response.json()) // Affiche les installations
}


async function requestInstallationMap(event) { 
    let id = document.getElementById(event.target.id).getAttribute('installationid');
    const response = await fetch('back/request.php/installationsMap/'+id);
    
    if (response.ok) {
        //displayStats(await response.json()); // Affiche les détails de l'installation
    }
}

// Affiche toutes les installations sur la carte
function displayInstallationsMap(installations) {
    for (let i=0;i<installations.length;i++) {
        L.marker([installations[i].latitude, installations[i].longitude]).addTo(map)
            .bindPopup(installations[i].title);
    }

    // Ajoute un écouteur pour le clic sur les miniatures
    L.addEventListener('click', requestInstallationMap);
}



/*===========Map en elle même================*/
var map = L.map('map').setView([48.390394, -4.486076],   13);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

L.marker([48.390394, -4.486076]).addTo(map)
    .bindPopup('A pretty CSS popup.<br> Easily customizable.')
    .openPopup();

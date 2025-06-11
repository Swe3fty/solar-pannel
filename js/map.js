'use strict';



var map = L.map('map').setView([47, 2],   6);
var markersGroup = L.layerGroup().addTo(map); // Groupe pour gérer les marqueurs

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

let annee_installation = null;
let departement = null;

// Attendre que le DOM soit chargé
document.addEventListener('DOMContentLoaded', function() {
    // Écouteur pour le formulaire
    document.getElementById('formMap').addEventListener('submit', checkChange);
    
    // Écouteur pour le bouton envoyer
    document.getElementById('envoyer').addEventListener('click', checkChange);
    
    // Charge toutes les installations au démarrage
    requestInstallationsMap();
});


async function checkChange(event) {
    event.preventDefault();
    //document.getElementById('formMap').clear();
    annee_installation = document.getElementById('annee_installation').value;
    departement = document.getElementById('departementSelect').value;
    requestInstallationsMap();
}


// Récupère les installations depuis le serveur
async function requestInstallationsMap() {
    let response = await fetch('/back/request.php/installationsMap');
    if (response.ok) {
        //console.log("rentre dans la condition")
        const data = await response.json()
        displayInstallationsMap(await data,annee_installation,departement) // Affiche les installations
    }
}

// Affiche toutes les installations sur la carte
function displayInstallationsMap(installations,annee_inst,departement) {
    markersGroup.clearLayers(); //nettoyage des anciens marqueurs
    for (let i=0;i<installations.length;i++) {
        if (installations[i].annee_inst==annee_inst && installations[i].nom_dep==departement) {
        console.log(installations[i]);
        const marker = L.marker([installations[i].latitude, installations[i].longitude]);
            markersGroup.addLayer(marker);
            
            marker.bindPopup(installations[i].title);
            marker.on('click', function() {
                const installation = installations[i];
                const data = 'Installations n°'+installation.id_installation+'                                                      Année d\'installation : '+installation.annee_inst+'                                                     Département : '+installation.nom_dep+'                                                      Puissance crête : '+installation.puissance_crete+'                                                      Coordonnées : '+installation.latitude+' '+installation.longitude;
                document.getElementById('zone-de-texte').textContent = data;
                /*=====Rediriger vers les détails de l'installation=====*/
                const redirectDiv = document.getElementById('details-redirect');
                redirectDiv.innerHTML = `<a href="/html/details?id=${installation.id_installation}" class="btn btn-primary mt-2">Voir les détails de l'installation</a>`;
            });

        }
    }
}




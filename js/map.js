'use stric';



var map = L.map('map').setView([48.390394, -4.486076],   13);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

L.marker([48.390394, -4.486076]).addTo(map)
    .bindPopup('A pretty CSS popup.<br> Easily customizable.')
    .openPopup();


// Charge les installations au chargement de la page
requestInstallationsMap();

// Récupère les miniatures depuis le serveur
async function requestInstallationsMap() {
    let response = await fetch('back/request.php/installationsMap'); // à faire

    if (response.ok)
        displayInstallationsMap(await response.json()) // Affiche les installations
    else
        displayErrors(response.status); // Affiche les erreurs
}


// Affiche toutes les installations sur la carte
function displayInstallationsMap(installations) {
    for (let i=0;i<installations.length;i++) {
        L.marker([installations[i].latitude, installations[i].longitude]).addTo(map)
            .bindPopup(installations[i].title);
    }

    // Ajoute un écouteur pour le clic sur les miniatures
    //document.getElementById('thumbnails').addEventListener('click', requestPhoto);
}
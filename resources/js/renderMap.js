let map;
let mapInitialized = false;

const modalMapa = document.getElementById('modalMapa');
let currentLat = -7.053875;
let currentLng = -34.847009;
let currentNome = "Localização";

modalMapa.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget; // botão que abriu o modal
    currentLat = button.getAttribute('data-lat');
    currentLng = button.getAttribute('data-lng');
    currentNome = button.getAttribute('data-nome');
});

modalMapa.addEventListener('shown.bs.modal', function () {
    if (!mapInitialized) {
        map = L.map('mapa').setView([currentLat, currentLng], 16);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker([currentLat, currentLng]).addTo(map)
            .bindPopup(currentNome)
            .openPopup();

        mapInitialized = true;
    } else {
        map.setView([currentLat, currentLng], 16);

        // Remove todos os marcadores antigos
        map.eachLayer(function (layer) {
            if (layer instanceof L.Marker) {
                map.removeLayer(layer);
            }
        });

        // Adiciona o novo marcador
        L.marker([currentLat, currentLng]).addTo(map)
            .bindPopup(currentNome)
            .openPopup();

        setTimeout(() => {
            map.invalidateSize();
        }, 300);
    }
});
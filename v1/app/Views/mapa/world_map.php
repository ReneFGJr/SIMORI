<link rel="stylesheet" href="<?php echo base_url('css/leaflet.css'); ?>">
<style>
    #map {
        height: 90vh;
        width: 100%;
        border-radius: 10px;
    }
</style>


<div class="container container_simori mt-5 p-4">

    <h2 style="text-align:center; margin:20px;">🗺️ Mapa dos Repositórios</h2>
    <div id="map"></div>

    <script src="<?php echo base_url('js/leaflet.js'); ?>"
        crossorigin=""></script>
    <script>
        // Inicializa o mapa centralizado no Brasil
        const map = L.map('map').setView([-15.78, -47.93], 5);

        // Camada base do OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contribuidores'
        }).addTo(map);

        // Dados dos repositórios vindos do PHP
        const repos = <?= json_encode($repos) ?>;

        // Adiciona marcadores
        repos.forEach(r => {
            const marker = L.marker([r.latitude, r.longitude]).addTo(map);
            marker.bindPopup(`<b>${r.p_name}</b><br>${r.city_name}`);
        });
    </script>

</div>


<div class="container py-4">
    <h4 class="text-primary"><i class="bi bi-calendar3"></i> Total de Publicações por Ano</h4>
    <canvas id="graficoPublicacoes" height="200"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('graficoPublicacoes').getContext('2d');

    const labels = <?= json_encode(array_column($publicacoes, 'period')) ?>;
    const data = <?= json_encode(array_column($publicacoes, 'total')) ?>;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total de Publicações',
                data: data,
                borderWidth: 1,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgb(54, 162, 235)'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true, title: { display: true, text: 'Total' }},
                x: { title: { display: true, text: 'Ano' }}
            }
        }
    });
</script>



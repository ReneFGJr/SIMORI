<div class="container py-4">
    <h4 class="text-primary"><i class="bi bi-calendar3"></i> <?= lang('App.' . $title) ?></h4>
    <canvas id="<?= $title; ?>" height="200"></canvas>
</div>

<script>
    const ctx_<?= $title; ?> = document.getElementById('<?= $title; ?>').getContext('2d');
    const labels_<?= $title; ?> = <?= json_encode(array_column($publicacoes, 'period')) ?>;
    const data_<?= $title; ?> = <?= json_encode(array_column($publicacoes, 'total')) ?>;

    new Chart(ctx_<?= $title; ?>, {
        type: 'line',
        data: {
            labels: labels_<?= $title; ?>,
            datasets: [{
                label: 'Total de Publicações',
                data: data_<?= $title; ?>,
                borderWidth: 2,
                backgroundColor: 'rgba(54, 162, 235, 0.3)',
                borderColor: 'rgb(54, 162, 235)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                },
                title: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Total'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Ano/Mês'
                    }
                }
            }
        }
    });
</script>

<?php
// Inclui o Chart.js apenas uma vez
global $chartjs_included;
if (empty($chartjs_included)) {
    $chartjs_included = true;
    echo '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';
}
?>
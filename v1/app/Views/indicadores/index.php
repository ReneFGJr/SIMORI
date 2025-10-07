<div class="container container_simori mt-5 p-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 text-primary">
                <i class="bi bi-bar-chart-fill"></i> Indicadores dos Repositórios
            </h2>
        </div>
        <!-- 🔵 Gráfico de pizza dos status -->

        <div class="col-lg-4 col-12 card-body text-center">
            <div class="card-header bg-info text-white">
                <strong>Status dos Repositórios</strong>
            </div>
            <canvas id="statusChart" width="400" height="200"></canvas>
        </div>

        <div class="col-lg-8 col-12 card-body text-center">
            Repositórios cadastrados: <strong><?= count($repos) ?></strong>
            <br>
            Repositorios ativos: <strong><?= $status_values[0] ?? 0 ?></strong>

        </div>

        <!-- 🔹 Indicadores individuais -->
        <?php foreach ($repos as $r): ?>
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <strong><?= esc($r['name']) ?></strong>
                    <small class="text-light"> — <?= esc($r['inst']) ?></small>
                </div>
                <div class="card-body">
                    <?php if (count($r['inds']) > 0): ?>
                        <table class="table table-sm table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Indicador</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($r['inds'] as $ind): ?>
                                    <tr>
                                        <td><?= esc($ind['d_indicator']) ?></td>
                                        <td><?= esc($ind['d_valor']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <canvas id="chart<?= $r['id'] ?>" height="100"></canvas>
                        <script>
                            const ctx<?= $r['id'] ?> = document.getElementById('chart<?= $r['id'] ?>').getContext('2d');
                            new Chart(ctx<?= $r['id'] ?>, {
                                type: 'bar',
                                data: {
                                    labels: <?= json_encode(array_column($r['inds'], 'd_indicator')) ?>,
                                    datasets: [{
                                        label: 'Valores',
                                        data: <?= json_encode(array_column($r['inds'], 'd_valor')) ?>,
                                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                        borderColor: 'rgba(54, 162, 235, 1)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        </script>
                    <?php else: ?>
                        <p class="text-muted">Nenhum indicador registrado.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // 🔵 Gráfico de pizza de status
    const ctxStatus = document.getElementById('statusChart').getContext('2d');
    new Chart(ctxStatus, {
        type: 'pie',
        data: {
            labels: <?= $status_labels ?>,
            datasets: [{
                data: <?= $status_values ?>,
                backgroundColor: [
                    'rgba(75, 192, 192, 0.7)', // Ativo
                    'rgba(255, 99, 132, 0.7)', // Inativo
                    'rgba(255, 205, 86, 0.7)', // Erro
                    'rgba(153, 102, 255, 0.7)' // Em teste
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 205, 86, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: {
                    position: 'bottom'
                },
                title: {
                    display: true,
                    text: 'Distribuição dos Repositórios por Status'
                }
            }
        }
    });
</script>
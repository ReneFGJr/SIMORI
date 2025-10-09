
    <h3>Produção mensal de registros coletados</h3>
    <canvas id="grafico"></canvas>

    <script>
        const ctx = document.getElementById('grafico').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= $labels ?>,
                datasets: [{
                    label: 'Registros coletados por mês',
                    data: <?= $valores ?>,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Quantidade de Registros'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Ano-Mês'
                        }
                    }
                }
            }
        });
    </script>

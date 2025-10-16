<div class="container container_simori mt-5 p-4">
    <!-- Título -->
    <div class="mb-4">
        <h2 class="text-primary">
            <i class="bi bi-bar-chart-line"></i> Estatísticas do Repositório
        </h2>
        <p class="text-muted">Resumo das informações coletadas do repositório selecionado.</p>
    </div>

    <!-- Cards estatísticos -->
    <div class="row g-4">
        <!-- Total de Sets -->
        <div class="col-md-6 col-lg-4 col-xl-2">
            <div class="card shadow-sm h-100 border-0 text-center">
                <div class="card-body">
                    <i class="bi bi-diagram-3-fill text-primary" style="font-size:2rem;"></i>
                    <h6 class="mt-2 text-muted">Total de Sets</h6>
                    <h3 class="fw-bold"><?= esc(number_format($stats['total_sets'] ?? 0, 0, ',', '.')) ?></h3>
                </div>
            </div>
        </div>

        <!-- Total de Registros -->
        <div class="col-md-6 col-lg-4 col-xl-2">
            <div class="card shadow-sm h-100 border-0 text-center">
                <div class="card-body">
                    <i class="bi bi-collection-fill text-primary" style="font-size:2rem;"></i>
                    <h6 class="mt-2 text-muted">Total de Registros</h6>
                    <h3 class="fw-bold"><?= esc(number_format($stats['total_records'] ?? 0, 0, ',', '.')) ?></h3>
                </div>
            </div>
        </div>

        <!-- Total de Registros -->
        <div class="col-md-6 col-lg-4 col-xl-2">
            <div class="card shadow-sm h-100 border-0 text-center">
                <div class="card-body">
                    <i class="bi bi-collection-fill text-success" style="font-size:2rem;"></i>
                    <h6 class="mt-2 text-muted">Registros Coletados</h6>
                    <h3 class="fw-bold"><?= esc(number_format($stats['total_records_coletados'] ?? 0, 0, ',', '.')) ?></h3>
                </div>
            </div>
        </div>

        <!-- Total de Registros -->
        <div class="col-md-6 col-lg-4 col-xl-2">
            <div class="card shadow-sm h-100 border-0 text-center">
                <div class="card-body">
                    <i class="bi bi-collection-fill text-danger" style="font-size:2rem;"></i>
                    <h6 class="mt-2 text-muted">Registros Excluídos</h6>
                    <h3 class="fw-bold"><?= esc(number_format($stats['total_records_deleted'] ?? 0, 0, ',', '.')) ?></h3>
                </div>
            </div>
        </div>

        <!-- Total de Formatos -->
        <div class="col-md-6 col-lg-4 col-xl-2">
            <div class="card shadow-sm h-100 border-0 text-center">
                <div class="card-body">
                    <a href="<?=base_url("/repository/formats/");?><?=$r['repository_id'];?>" class="link2">
                    <i class="bi bi-diagram-2 text-warning" style="font-size:2rem;"></i>
                    <h6 class="mt-2 text-muted">Formatos OAI</h6>
                    <h3 class="fw-bold"><?= esc($stats['formats_oai'] ?? '—') ?></h3>
                    </a>
                </div>
            </div>
        </div>        

        <!-- Última Coleta -->
        <div class="col-md-6 col-lg-4 col-xl-2">
            <div class="card shadow-sm h-100 border-0 text-center">
                <div class="card-body">
                    <a href="#" class="link">
                    <i class="bi bi-clock-history text-warning" style="font-size:2rem;"></i>
                    <h6 class="mt-2 text-muted">Última Coleta</h6>
                    <h6 class="fw-bold"><?= esc($stats['ultima_coleta'] ?? '—') ?></h6>
                    </a>
                </div>
            </div>
        </div>

        <!-- Total de Autores -->
        <div class="col-md-6 col-lg-4 col-xl-2">
            <div class="card shadow-sm h-100 border-0 text-center">
                <div class="card-body">
                    <i class="bi bi-people-fill text-info" style="font-size:2rem;"></i>
                    <h6 class="mt-2 text-muted">Autores</h6>
                    <h3 class="fw-bold"><?= esc($stats['total_autores'] ?? 0) ?></h3>
                </div>
            </div>
        </div>

        <!-- Total de Keywords -->
        <div class="col-md-6 col-lg-4 col-xl-2">
            <div class="card shadow-sm h-100 border-0 text-center">
                <div class="card-body">
                    <i class="bi bi-tags-fill text-danger" style="font-size:2rem;"></i>
                    <h6 class="mt-2 text-muted">Keywords</h6>
                    <h3 class="fw-bold"><?= esc($stats['total_keywords'] ?? 0) ?></h3>
                </div>
            </div>
        </div>

        <!-- Total de Keywords -->
        <div class="col-md-6 col-lg-4 col-xl-2">
            <div class="card shadow-sm h-100 border-0 text-center">
                <div class="card-body">
                    <i class="bi bi-trophy-fill text-success" style="font-size:2rem;"></i>
                    <h6 class="mt-2 text-muted">Avaliação</h6>
                    <h3 class="fw-bold"><?= esc($stats['total_keywords'] ?? 0) ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>
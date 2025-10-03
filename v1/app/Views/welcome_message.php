<div class="container container_simori mt-5">

    <!-- Cards principais -->
    <div class="row g-4">
        <!-- Card 1 -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body text-center">
                    <i class="bi bi-database-fill text-success" style="font-size:3rem;"></i>
                    <h5 class="card-title mt-3">Repositórios Monitorados</h5>
                    <p class="card-text text-muted">Visualize os repositórios integrados e suas estatísticas de atualização.</p>
                    <a href="<?= base_url('/repository') ?>" class="btn btn-outline-success">Acessar</a>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body text-center">
                    <i class="bi bi-graph-up-arrow text-primary" style="font-size:3rem;"></i>
                    <h5 class="card-title mt-3">Indicadores</h5>
                    <p class="card-text text-muted">Consulte relatórios de qualidade, precisão e revocação dos metadados.</p>
                    <a href="<?= base_url('/indicadores') ?>" class="btn btn-outline-primary">Acessar</a>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body text-center">
                    <i class="bi bi-gear-fill text-danger" style="font-size:3rem;"></i>
                    <h5 class="card-title mt-3">Administração</h5>
                    <p class="card-text text-muted">Gerencie configurações, cadastros de repositórios e parâmetros do sistema.</p>
                    <a href="<?= base_url('/admin') ?>" class="btn btn-outline-danger">Acessar</a>
                </div>
            </div>
        </div>
    </div>
</div>
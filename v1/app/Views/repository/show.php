<div class="container container_simori mt-5 p-4">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4">
            <h2 class="mb-0"><i class="bi bi-database-gear"></i> Detalhes do Repositório</h2>
        </div>

        <div class="card-body p-4">
            <div class="row g-4">
                <!-- COLUNA ESQUERDA -->
                <div class="col-md-6">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <i class="bi bi-building text-secondary"></i> <strong>Nome:</strong> <?= esc($repo['rp_name']) ?>
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-link-45deg text-secondary"></i>
                            <strong>URL:</strong>
                            <a href="<?= esc($repo['rp_url']) ?>" target="_blank" class="text-decoration-none">
                                <?= esc($repo['rp_url']) ?>
                                <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                            <?php if (($repo['rp_url'] != $repo['rp_url_oai']) and ($repo['rp_url_oai'] != '')): ?>
                                <br>
                                <i class="bi bi-link-45deg text-secondary"></i>
                                <strong>OAI:</strong>
                                <a href="<?= esc($repo['rp_url_oai']) ?>" target="_blank" class="text-decoration-none">
                                    <?= esc($repo['rp_url_oai']) ?>
                                    <i class="bi bi-box-arrow-up-right"></i>
                                </a>
                            <?php endif; ?>

                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-circle-fill <?= $repo['rp_status'] == 1 ? 'text-success' : 'text-danger' ?>"></i>
                            <strong>Status:</strong> <?= $repo['rp_status'] == 1 ? 'Ativo' : 'Inativo' ?>
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-hash text-secondary"></i> <strong>ID:</strong> <?= $repo['id_rp'] ?>
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-clock-history text-secondary"></i>
                            <strong>Última Atualização:</strong> <?= $repo['rp_update'] ?>
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-calendar-check text-secondary"></i>
                            <strong>Criado em:</strong> <?= $repo['created_at'] ?>
                        </li>

                        <li class="list-group-item">
                            <i class="bi bi-cpu text-secondary"></i> <strong>Tipo:</strong>
                            <?= esc($repo['rp_plataforma']) ?>
                            <?= esc($repo['rp_versao']) ?>
                        </li>

                    </ul>

                    <!-- BOTÕES -->
                    <div class="mt-4 d-flex flex-wrap gap-2">
                        <a href="<?= base_url('/repository') ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>

                        <?php if ($repo['rp_status'] == 0): ?>
                            <a href="<?= base_url('/repository/analyse/' . $repo['id_rp']) ?>" class="btn btn-outline-primary">
                                <i class="bi bi-search"></i> Analisar
                            </a>
                            <a href="<?= base_url('/repository/edit/' . $repo['id_rp']) ?>" class="btn btn-outline-warning">
                                <i class="bi bi-pencil-square"></i> Editar
                            </a>
                        <?php else: ?>
                            <a href="<?= base_url('/repository/analyse/' . $repo['id_rp']) ?>" class="btn btn-outline-primary">
                                <i class="bi bi-search"></i> Analisar
                            </a>
                            <a href="<?= base_url('/repository/harvesting/' . $repo['id_rp']) ?>" class="btn btn-outline-success">
                                <i class="bi bi-arrow-repeat"></i> Coletar OAI
                            </a>
                            <a href="<?= base_url('/repository/stat_make/' . $repo['id_rp']) ?>" class="btn btn-outline-success">
                                <i class="bi bi-bar-chart"></i> Gerar Estatísticas
                            </a>
                            <a href="<?= base_url('/repository/edit/' . $repo['id_rp']) ?>" class="btn btn-outline-warning">
                                <i class="bi bi-pencil-square"></i> Editar
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- COLUNA DIREITA -->
                <div class="col-md-6">
                    <div class="card border-0 bg-light mb-3 shadow-sm">
                        <div class="card-body">
                            <h4 class="card-title text-primary"><i class="bi bi-info-circle"></i> Descrição</h4>
                            <p class="card-text"><?= esc($repo['rp_description']) ?: '<span class="text-muted">Sem descrição disponível.</span>' ?></p>
                        </div>
                    </div>

                    <div class="card border-0 bg-light shadow-sm">
                        <div class="card-body">
                            <h4 class="card-title text-primary"><i class="bi bi-file-text"></i> Resumo</h4>
                            <p class="card-text"><?= esc($repo['rp_summary']) ?: '<span class="text-muted">Sem resumo disponível.</span>' ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- card -->
</div>
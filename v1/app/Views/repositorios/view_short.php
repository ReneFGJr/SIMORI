<div class="container container_simori mt-5 p-4">
    <!-- Lista de repositórios -->
    <div class="row g-4">
        <?php if (!empty($r)): ?>
            <div class="col-12">
                <div class="card shadow border-0 rounded-3">

                    <!-- Cabeçalho -->
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-hdd-stack"></i> <?= esc($r['repository_name']) ?>
                        </h5>
                    </div>

                    <!-- Corpo com grid -->
                    <div class="card-body">
                        <div class="row">
                            <!-- Coluna 1 -->
                            <div class="col-md-6 col-lg-4 mb-3">
                                <p class="mb-1"><strong>ID:</strong> <?= esc($r['id']) ?></p>
                                <p class="mb-1"><strong>Versão:</strong> <?= esc($r['protocol_version']) ?></p>
                            </div>

                            <!-- Coluna 2 -->
                            <div class="col-md-6 col-lg-4 mb-3">
                                <p class="mb-1"><strong>Admin:</strong>
                                    <a href="mailto:<?= esc($r['admin_email']) ?>" class="text-decoration-none">
                                        <?= esc($r['admin_email']) ?>
                                    </a>
                                </p>
                                <p class="mb-1"><strong>Granularity:</strong> <?= esc($r['granularity']) ?></p>
                            </div>

                            <!-- Coluna 3 -->
                            <div class="col-md-12 col-lg-4 mb-3">
                                <p class="mb-1"><strong>Base URL:</strong><br>
                                    <a href="<?= esc($r['base_url']) ?>" target="_blank" class="text-decoration-none">
                                        <?= esc($r['base_url']) ?>
                                    </a>
                                </p>
                                <p class="mb-1"><strong>Data Inicial:</strong> <?= esc($r['earliest_datestamp']) ?></p>
                                <p class="mb-1"><strong>Deleted Record:</strong> <?= esc($r['deleted_record']) ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Rodapé -->
                    <div class="card-footer bg-light d-flex justify-content-end gap-2">

                        <a href="<?= base_url('/oai/register/' . $r['id']) ?>" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i> Coletar Register
                        </a>

                        <a href="<?= base_url('/oai/sets/' . $r['id']) ?>" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i> Coletar Sets
                        </a>

                        <a href="<?= base_url('/repositorios/view/' . $r['id']) ?>" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i> Acessar
                        </a>
                        <!--
                        <a href="<?= base_url('/repositorios/copy/' . $r['id']) ?>" class="btn btn-sm btn-outline-info">
                            <i class="bi bi-files"></i> Copiar
                        </a>
                        <a href="<?= base_url('/repositorios/delete/' . $r['id']) ?>"
                           class="btn btn-sm btn-outline-danger"
                           onclick="return confirm('Tem certeza que deseja excluir este repositório?')">
                            <i class="bi bi-trash"></i> Excluir
                        </a>
                        -->
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-secondary text-center">
                    Nenhum repositório encontrado.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2 class="mb-4 text-primary">
        <i class="bi bi-database-fill"></i> Repositórios Cadastrados
    </h2>

    <!-- Botão Novo -->
    <div class="mb-3">
        <a href="<?= base_url('/repositorios/create') ?>" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Novo Repositório
        </a>
    </div>

    <!-- Lista de repositórios -->
    <div class="row g-4">
        <?php if (!empty($repositorios)): ?>
            <?php foreach ($repositorios as $r): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100 border-0">
                        <div class="card-body">
                            <h5 class="card-title text-primary fw-bold">
                                <?= esc($r['repository_name']) ?>
                            </h5>
                            <p class="card-text small text-muted mb-2">
                                <i class="bi bi-link-45deg"></i>
                                <a href="<?= esc($r['base_url']) ?>" target="_blank">
                                    <?= esc($r['base_url']) ?>
                                </a>
                            </p>
                            <ul class="list-unstyled small">
                                <li><strong>ID:</strong> <?= esc($r['id']) ?></li>
                                <li><strong>Versão:</strong> <?= esc($r['protocol_version']) ?></li>
                                <li><strong>Email:</strong> <a href="mailto:<?= esc($r['admin_email']) ?>"><?= esc($r['admin_email']) ?></a></li>
                                <li><strong>Data Inicial:</strong> <?= esc($r['earliest_datestamp']) ?></li>
                                <li><strong>Deleted Record:</strong> <?= esc($r['deleted_record']) ?></li>
                                <li><strong>Granularity:</strong> <?= esc($r['granularity']) ?></li>
                            </ul>
                        </div>
                        <div class="card-footer bg-light d-flex justify-content-between">
                            <a href="<?= base_url('/repositorios/view/' . $r['id']) ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> Acessar
                            </a>

                            <!--
                            <a href="<?= base_url('/repositorios/copy/' . $r['id']) ?>" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-files"></i> Copy
                            </a>
                            <a href="<?= base_url('/repositorios/delete/' . $r['id']) ?>"
                                class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Tem certeza que deseja excluir este repositório?')">
                                <i class="bi bi-trash"></i> Delete
                            </a>
                            -->
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-secondary text-center">
                    Nenhum repositório cadastrado.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
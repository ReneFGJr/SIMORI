<div class="container container_simori mt-4">
    <h2 class="mb-4 text-success">
        <i class="bi bi-diagram-3"></i> Sets do Repositório #<?= esc($identify_id) ?>
    </h2>

    <?php if (!empty($sets)): ?>
        <div class="row g-4">
            <?php foreach ($sets as $s): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100 border-0">
                        <div class="card-body">
                            <h5 class="card-title text-primary"><?= esc($s['set_name']) ?></h5>
                            <p class="card-text small text-muted mb-1">
                                <i class="bi bi-tag"></i> <strong>Spec:</strong> <code><?= esc($s['set_spec']) ?></code>
                            </p>
                            <?php if (!empty($s['set_description'])): ?>
                                <p class="card-text"><?= esc($s['set_description']) ?></p>
                            <?php else: ?>
                                <p class="card-text text-muted"><em>Sem descrição</em></p>
                            <?php endif; ?>
                        </div>
                        <div class="card-footer bg-light d-flex justify-content-between">
                            <a href="<?= base_url('/repositorios/sets/show/' . $s['id']) ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> Ver
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-secondary text-center">
            Nenhum SET cadastrado para este repositório.
        </div>
    <?php endif; ?>
</div>
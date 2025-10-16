<div class="container container_simori mt-5 p-4">
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="text-primary">
            <i class="bi bi-diagram-3"></i> Formatos de Metadados OAI-PMH
        </h4>
        <span class="badge bg-secondary">
            Total: <?= count($formats ?? []) ?>
        </span>
    </div>

    <?php if (isset($formats) && count($formats) > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th><i class="bi bi-code-slash"></i> Prefixo</th>
                        <th><i class="bi bi-link-45deg"></i> Schema (XSD)</th>
                        <th><i class="bi bi-diagram-3"></i> Namespace</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($formats as $f): ?>
                        <tr>
                            <td class="text-muted"><?= esc($f['id']) ?></td>
                            <td>
                                <span class="fw-bold text-primary">
                                    <i class="bi bi-braces"></i> <?= esc($f['metadata_prefix']) ?>
                                </span>
                            </td>
                            <td>
                                <?php if (!empty($f['schema_url'])): ?>
                                    <a href="<?= esc($f['schema_url']) ?>" target="_blank" class="text-decoration-none">
                                        <?= esc($f['schema_url']) ?>
                                        <i class="bi bi-box-arrow-up-right small text-muted"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($f['metadata_namespace'])): ?>
                                    <a href="<?= esc($f['metadata_namespace']) ?>" target="_blank" class="text-decoration-none">
                                        <?= esc($f['metadata_namespace']) ?>
                                        <i class="bi bi-box-arrow-up-right small text-muted"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center">
            <i class="bi bi-exclamation-triangle"></i> Nenhum formato encontrado para este repositório.
        </div>
    <?php endif; ?>
</div>
</div>
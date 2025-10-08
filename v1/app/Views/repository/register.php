<div class="container container_simori mt-5 p-4">
    <h2 class="mb-4 text-success">
        <i class="bi bi-database"></i> Registros OAI-PMH do Repositório
    </h2>

    <?php if (!empty($regs)) : ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Identificador</th>
                        <th scope="col">Datestamp</th>
                        <th scope="col">SetSpec</th>
                        <th scope="col">Status</th>
                        <th scope="col">Deleted</th>
                        <th scope="col" class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($regs as $r) : ?>
                        <tr>
                            <td><?= esc($r['id']) ?></td>
                            <td class="text-break"><code><?= esc($r['oai_identifier']) ?></code></td>
                            <td><?= esc($r['datestamp']) ?></td>
                            <td><?= esc($r['setSpec']) ?></td>
                            <td>
                                <?php if ($r['status'] == 0) : ?>
                                    <span class="badge bg-secondary">Pendente</span>
                                <?php else : ?>
                                    <span class="badge bg-success">Coletado</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= $r['deleted'] ? '<span class="badge bg-danger">Sim</span>' : '<span class="badge bg-success">Não</span>' ?>
                            </td>
                            <td class="text-center">
                                <?php if ($r['status'] == 0) : ?>
                                    <a href="<?= base_url('repository/record_harvest/' . $r['id']) ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-cloud-download"></i> Colher
                                    </a>
                                <?php else : ?>
                                    <a href="<?= base_url('repository/record_view/' . $r['id']) ?>" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-eye"></i> Ver
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <div class="alert alert-secondary text-center mt-4">
            <i class="bi bi-info-circle"></i> Nenhum registro encontrado para este repositório.
        </div>
    <?php endif; ?>
</div>
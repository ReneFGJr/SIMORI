<div class="container container_simori mt-5 p-4">
    <h2 class="mb-3">📚 Repositórios</h2>
    <a href="<?= base_url('/repository/create') ?>" class="btn btn-success mb-3">
        <i class="bi bi-plus-circle"></i> Novo Repositório
    </a>

    <a href="<?= base_url('/repository/url_check') ?>" class="btn btn-success mb-3">
        <i class="bi bi-check-circle"></i> Check URLs
    </a>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th width="40%">Nome</th>
                <th width="10%">URL</th>
                <th width="10%">Software</th>
                <th>Status</th>
                <th>Última Atualização</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($repos as $repo): ?>
                <tr>
                    <td><?= $repo['id_rp'] ?></td>
                    <td><?= esc($repo['rp_name']) ?></td>
                    <td><?= esc($repo['rp_instituicao']) ?> <a href="<?= esc($repo['rp_url']) ?>" target="_blank"><i class="bi bi-link-45deg"></i></a></td>
                    <td><?= esc($repo['rp_plataforma']) ?>
                        <?php if ($repo['rp_versao'] != ''): echo 'v. ' . esc($repo['rp_versao']);
                        endif; ?>
                    </td>
                    <td>
                        <?php if ($repo['rp_status'] == 1): ?>
                            <span class="badge bg-success">Ativo</span>
                        <?php elseif ($repo['rp_status'] == 0): ?>
                            <span class="badge bg-secondary">Inativo</span>
                        <?php elseif ($repo['rp_status'] == 404): ?>
                            <span class="badge bg-danger">Erro 404</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark">Desconhecido</span>
                        <?php endif; ?>
                    </td>

                    <td><?= $repo['rp_update'] ?></td>
                    <td>
                        <nobr>
                            <a href="<?= base_url('/repository/show/' . $repo['id_rp']) ?>" class="btn btn-info btn-sm">Ver</a>
                            <a href="<?= base_url('/repository/edit/' . $repo['id_rp']) ?>" class="btn btn-warning btn-sm">Editar</a>
                            <!--
                        <a href="<?= base_url('/repository/delete/' . $repo['id_rp']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Deseja realmente excluir?')">Excluir</a>
                        -->
                        </nobr>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
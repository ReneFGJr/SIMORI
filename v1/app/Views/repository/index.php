<div class="container container_simori mt-5">
    <h2 class="mb-3 pt-2">📚 Repositórios</h2>
    <a href="<?= base_url('/repository/create') ?>" class="btn btn-success mb-3">
        <i class="bi bi-plus-circle"></i> Novo Repositório
    </a>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>URL</th>
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
                    <td><a href="<?= esc($repo['rp_url']) ?>" target="_blank"><?= esc($repo['rp_url']) ?></a></td>
                    <td><?= $repo['rp_status'] == 1 ? 'Ativo' : 'Inativo' ?></td>
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
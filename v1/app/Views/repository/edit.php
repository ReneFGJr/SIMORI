<div class="container container_simori mt-5 p-4">
    <h2>Editar Repositório</h2>
    <form action="<?= base_url('/repository/update/' . $repo['id_rp']) ?>" method="post">
        <div class="mb-3">
            <label>Nome</label>
            <input type="text" name="rp_name" class="form-control" value="<?= esc($repo['rp_name']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Instituição</label>
            <input type="text" name="rp_instituicao" class="form-control" value="<?= esc($repo['rp_instituicao']) ?>" required>
        </div>

        <div class="mb-3">
            <label>URL</label>
            <input type="url" name="rp_url" class="form-control" value="<?= esc($repo['rp_url']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Software</label>
            <select name="rp_plataforma" class="form-control">
                <option value="">Selecione</option>
                <option value="DSpace" <?= $repo['rp_plataforma'] == 'DSpace' ? 'selected' : '' ?>>DSpace</option>
                <option value="Dataverse" <?= $repo['rp_plataforma'] == 'Dataverse' ? 'selected' : '' ?>>Dataverse</option>
                <option value="EPrints" <?= $repo['rp_plataforma'] == 'EPrints' ? 'selected' : '' ?>>EPrints</option>
                <option value="Omeka" <?= $repo['rp_plataforma'] == 'Omeka' ? 'selected' : '' ?>>Omeka</option>
                <option value="Outros" <?= $repo['rp_plataforma'] == 'Outros' ? 'selected' : '' ?>>Outros</option>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="rp_status" class="form-control">
                <option value="1" <?= $repo['rp_status'] == 1 ? 'selected' : '' ?>>Ativo</option>
                <option value="0" <?= $repo['rp_status'] == 0 ? 'selected' : '' ?>>Inativo</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Última Atualização</label>
            <input type="date" name="rp_update" class="form-control" value="<?= $repo['rp_update'] ?>">
        </div>
        <button type="submit" class="btn btn-warning">Atualizar</button>
        <a href="<?= base_url('/repository') ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
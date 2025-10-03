<div class="container mt-4">
    <h2>Editar Repositório</h2>
    <form action="<?= base_url('/repository/update/' . $repo['id_rp']) ?>" method="post">
        <div class="mb-3">
            <label>Nome</label>
            <input type="text" name="rp_name" class="form-control" value="<?= esc($repo['rp_name']) ?>" required>
        </div>
        <div class="mb-3">
            <label>URL</label>
            <input type="url" name="rp_url" class="form-control" value="<?= esc($repo['rp_url']) ?>" required>
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
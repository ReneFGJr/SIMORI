<div class="container container_simori mt-5 p-4">
    <h2>Novo Repositório</h2>
    <form action="<?= base_url('/repository/store') ?>" method="post">
        <div class="mb-3">
            <label>Nome</label>
            <input type="text" name="rp_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>URL</label>
            <input type="url" name="rp_url" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="rp_status" class="form-control">
                <option value="1">Ativo</option>
                <option value="0">Inativo</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Última Atualização</label>
            <input type="date" name="rp_update" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="<?= base_url('/repository') ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
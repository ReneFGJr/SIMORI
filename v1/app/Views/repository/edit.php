<div class="container container_simori mt-5 p-4">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-warning text-dark rounded-top-4 d-flex align-items-center">
            <i class="bi bi-pencil-square me-2 fs-4"></i>
            <h2 class="mb-0">Editar Repositório</h2>
        </div>

        <div class="card-body p-4">
            <form action="<?= base_url('/repository/update/' . $repo['id_rp']) ?>" method="post" class="needs-validation" novalidate>
                <div class="row g-4">

                    <!-- NOME -->
                    <div class="col-12">
                        <label class="form-label fw-bold"><i class="bi bi-building"></i> Nome</label>
                        <input type="text" name="rp_name" class="form-control form-control-lg"
                            value="<?= esc($repo['rp_name']) ?>" required>
                        <div class="invalid-feedback">Informe o nome do repositório.</div>
                    </div>

                    <!-- INSTITUIÇÃO -->
                    <div class="col-lg-6 col-12">
                        <label class="form-label fw-bold"><i class="bi bi-mortarboard"></i> Instituição</label>
                        <input type="text" name="rp_instituicao" class="form-control"
                            value="<?= esc($repo['rp_instituicao']) ?>" required>
                        <div class="invalid-feedback">Informe a instituição.</div>
                    </div>

                    <!-- SOFTWARE -->
                    <div class="col-lg-6 col-12">
                        <label class="form-label fw-bold"><i class="bi bi-cpu"></i> Software</label>
                        <select name="rp_plataforma" class="form-select">
                            <option value="">Selecione...</option>
                            <option value="DSpace" <?= $repo['rp_plataforma'] == 'DSpace' ? 'selected' : '' ?>>DSpace</option>
                            <option value="DSpace 7+" <?= $repo['rp_plataforma'] == 'DSpace 7+' ? 'selected' : '' ?>>DSpace 7+</option>
                            <option value="Dataverse" <?= $repo['rp_plataforma'] == 'Dataverse' ? 'selected' : '' ?>>Dataverse</option>
                            <option value="EPrints" <?= $repo['rp_plataforma'] == 'EPrints' ? 'selected' : '' ?>>EPrints</option>
                            <option value="Omeka" <?= $repo['rp_plataforma'] == 'Omeka' ? 'selected' : '' ?>>Omeka</option>
                            <option value="Outros" <?= $repo['rp_plataforma'] == 'Outros' ? 'selected' : '' ?>>Outros</option>
                        </select>
                    </div>

                    <!-- URL PRINCIPAL -->
                    <div class="col-lg-6 col-12">
                        <label class="form-label fw-bold"><i class="bi bi-link-45deg"></i> URL</label>
                        <input type="url" name="rp_url" class="form-control"
                            value="<?= esc($repo['rp_url']) ?>" required placeholder="https://repositorio.exemplo.br/">
                        <div class="form-text text-muted">Endereço principal do repositório.</div>
                    </div>

                    <!-- URL OAI-PMH -->
                    <div class="col-lg-6 col-12">
                        <label class="form-label fw-bold"><i class="bi bi-diagram-3"></i> URL OAI-PMH</label>
                        <input type="url" name="rp_url_oai" class="form-control"
                            value="<?= esc($repo['rp_url_oai']) ?>" required placeholder="https://repositorio.exemplo.br/oai/request">
                        <div class="form-text text-muted">Endpoint do provedor OAI-PMH.</div>
                    </div>

                    <!-- STATUS -->
                    <div class="col-lg-4 col-12">
                        <label class="form-label fw-bold"><i class="bi bi-toggle2-on"></i> Status</label>
                        <select name="rp_status" class="form-select">
                            <option value="1" <?= $repo['rp_status'] == 1 ? 'selected' : '' ?>>Ativo</option>
                            <option value="0" <?= $repo['rp_status'] == 0 ? 'selected' : '' ?>>Inativo</option>
                        </select>
                    </div>

                    <!-- Cidade -->
                    <div class="col-lg-4 col-12">
                        <label class="form-label fw-bold"><i class="bi bi-geo-alt"></i> Cidade</label>

                        <select name="rp_cidade" class="form-select">
                            <option value="">Selecione...</option>
                            <?php foreach ($cities as $city): ?>
                                <option value="<?= esc($city['id_city']) ?>" <?= $repo['rp_cidade'] == $city['id_city'] ? 'selected' : '' ?>>
                                    <?= esc($city['city_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    </select>
                </div>

                <!-- BOTÕES -->
                <div class="col-12 mt-3 d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-check-circle"></i> Atualizar
                    </button>
                    <a href="<?= base_url('/repository') ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Cancelar
                    </a>
                </div>
        </div>
        </form>
    </div>
</div>
</div>
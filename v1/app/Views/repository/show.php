<div class="container container_simori mt-5 p-4">
    <h2>Detalhes do Repositório</h2>
    <ul class="list-group">
        <li class="list-group-item"><b>ID:</b> <?= $repo['id_rp'] ?></li>
        <li class="list-group-item"><b>Nome:</b> <?= esc($repo['rp_name']) ?></li>
        <li class="list-group-item"><b>URL:</b> <a href="<?= esc($repo['rp_url']) ?>" target="_blank"><?= esc($repo['rp_url']) ?></a></li>
        <li class="list-group-item"><b>Status:</b> <?= $repo['rp_status'] == 1 ? 'Ativo' : 'Inativo' ?></li>
        <li class="list-group-item"><b>Última Atualização:</b> <?= $repo['rp_update'] ?></li>
        <li class="list-group-item"><b>Criado em:</b> <?= $repo['created_at'] ?></li>
    </ul>
    <br>
    <a href="<?= base_url('/repository') ?>" class="btn btn-secondary">Voltar</a>

    <?php
    if ($repo['rp_status'] == 0) {
        echo '<a href="'.base_url('/repository/analyse/'.$repo['id_rp']).'" class="btn btn-outline-primary">Analisar</a>';
    } else {
        echo '<a href="' . base_url('/repository/analyse/' . $repo['id_rp']) . '" class="btn btn-outline-primary">Analisar</a>';
    }
    ?>
</div>
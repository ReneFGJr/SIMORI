<div class="container container_simori mt-5 p-4">
        <h3>Análise do Repositório: <?= esc($repository['rp_name']) ?></h3>
        <ul class="list-group mt-3">
            <?php foreach ($steps as $s): ?>
                <li class="list-group-item"><?= esc($s) ?></li>
            <?php endforeach ?>
        </ul>
</div>
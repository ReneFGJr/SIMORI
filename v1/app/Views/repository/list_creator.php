<div class="container container_simori mt-5 p-4">
    <div class="row">
        <div class="col-lg-6 col-12">
            <h2 class="mb-4 text-success">
                <i class="bi bi-list"></i> Autores/Criadores (Frequencia)
            </h2>

            <ul class="">
                <?php
                foreach ($triplesA as $obj) { ?>
                    <li class=""><?= esc($obj['concept']) ?> (<?= $obj['total'] ?>)</li>
                <?php } ?>
            </ul>
        </div>
        <div class="col-lg-6 col-12">
            <h2 class="mb-4 text-success">
                <i class="bi bi-list"></i> Autores/Criadores (Alfabética)
            </h2>

            <ul class="">
                <?php
                foreach ($triplesB as $obj) { ?>
                    <li class=""><?= esc($obj['concept']) ?> (<?= $obj['total'] ?>)</li>
                <?php } ?>
            </ul>
        </div>
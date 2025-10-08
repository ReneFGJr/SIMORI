<div class="container container_simori mt-5 p-4">
    <h2 class="mb-4 text-success">
        <i class="bi bi-file-earmark-text"></i> Registro OAI-PMH
    </h2>

    <!-- 📄 Dados básicos -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-light">
            <strong>Informações do Registro</strong>
        </div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9"><?= esc($reg['id']) ?></dd>

                <dt class="col-sm-3">Repositório</dt>
                <dd class="col-sm-9"><?= esc($reg['repository']) ?></dd>

                <dt class="col-sm-3">Identificador OAI</dt>
                <dd class="col-sm-9"><code><?= esc($reg['oai_identifier']) ?></code></dd>

                <dt class="col-sm-3">Datestamp</dt>
                <dd class="col-sm-9"><?= esc($reg['datestamp']) ?></dd>

                <dt class="col-sm-3">SetSpec</dt>
                <dd class="col-sm-9"><?= esc($reg['setSpec']) ?></dd>

                <dt class="col-sm-3">Status</dt>
                <dd class="col-sm-9">
                    <?= $reg['status'] == 1
                        ? '<span class="badge bg-success">Coletado</span>'
                        : '<span class="badge bg-secondary">Pendente</span>' ?>
                </dd>

                <dt class="col-sm-3">Deleted</dt>
                <dd class="col-sm-9">
                    <?= $reg['deleted'] ? '<span class="badge bg-danger">Sim</span>' : '<span class="badge bg-success">Não</span>' ?>
                </dd>
            </dl>
        </div>
    </div>

    <!-- 🧠 Extração dos metadados DC -->
    <?php
    // Faz o parse do XML OAI-PMH
    $xml = simplexml_load_string($reg['xml']);
    $xml->registerXPathNamespace('oai_dc', 'http://www.openarchives.org/OAI/2.0/oai_dc/');
    $xml->registerXPathNamespace('dc', 'http://purl.org/dc/elements/1.1/');

    // Faz o parse do XML OAI-PMH
    $xml = simplexml_load_string($reg['xml']);

    if ($xml) {
        // Registra todos os namespaces usados no documento
        $namespaces = $xml->getNamespaces(true);

        // Caminho correto até o nó metadata
        $record = $xml->children($namespaces[''])->GetRecord->record ?? null;

        if ($record && isset($namespaces['oai_dc'])) {
            // Vai até o bloco <metadata><oai_dc:dc>
            $metadata = $record->metadata->children($namespaces['oai_dc']);
            $dc = $metadata->dc ?? null;
        } else {
            $dc = null;
        }
    } else {
        $dc = null;
    }
    ?>

    <?php if ($dc): ?>
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-light">
                <strong>Metadados Dublin Core</strong>
            </div>
            <div class="card-body">
                <?php
                // Define lista de campos DC
                $fields = [
                    'title' => 'Título',
                    'creator' => 'Autor(es)',
                    'contributor' => 'Contribuinte(s)',
                    'subject' => 'Assunto(s)',
                    'description' => 'Descrição',
                    'date' => 'Data(s)',
                    'type' => 'Tipo',
                    'identifier' => 'Identificador',
                    'language' => 'Idioma',
                    'format' => 'Formato',
                ];

                foreach ($fields as $tag => $label) {
                    $values = $dc->xpath("dc:$tag");

                    if (!empty($values)) {
                        echo "<div class='mb-2'><strong>$label:</strong><br>";
                        foreach ($values as $v) {
                            echo esc((string)$v) . "<br>";
                        }
                        echo "</div>";
                    }
                }
                ?>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle"></i> Nenhum metadado Dublin Core encontrado no XML.
        </div>
    <?php endif; ?>

    <!-- 🧩 XML bruto -->
    <div class="accordion mt-4" id="xmlAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingXML">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseXML" aria-expanded="false" aria-controls="collapseXML">
                    <i class="bi bi-code-slash me-2"></i> Ver XML bruto
                </button>
            </h2>
            <div id="collapseXML" class="accordion-collapse collapse" aria-labelledby="headingXML" data-bs-parent="#xmlAccordion">
                <div class="accordion-body">
                    <pre style="white-space: pre-wrap; font-size: 0.9rem; background-color: #f8f9fa; padding: 1rem; border-radius: 6px; border: 1px solid #ddd;">
<?= htmlspecialchars($reg['xml']) ?>
                    </pre>
                </div>
            </div>
        </div>
    </div>
</div>
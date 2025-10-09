<?php

namespace App\Models;

use CodeIgniter\Model;

class OaiTriplesModel extends Model
{
    protected $table            = 'oai_triples';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'record_id',
        'property',
        'value'
    ];

    // Validação opcional
    protected $validationRules = [
        'record_id' => 'required|integer',
        'property'  => 'required|string|max_length[100]',
        'value'     => 'permit_empty|string'
    ];

    protected $validationMessages = [
        'record_id' => [
            'required' => 'O campo record_id é obrigatório.'
        ],
        'property' => [
            'required' => 'A propriedade é obrigatória.'
        ]
    ];

    protected $skipValidation = false;

    /**
     * 🔍 Retorna todos os triples de um registro específico
     */
    public function getByRecord(int $record_id): array
    {
        return $this->where('record_id', $record_id)
            ->orderBy('property', 'ASC')
            ->findAll();
    }

    function clean_oai_xml(string $xmlString): array
    {
        $result = [];

        if (trim($xmlString) == '') {
            return $result;
        }

        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($xmlString);
        if (!$xml) {
            return $result;
        }

        // Coleta namespaces
        $namespaces = $xml->getNamespaces(true);

        // Navega até o bloco <record><metadata><oai_dc:dc>
        $record = $xml->children($namespaces[''])->GetRecord->record ?? null;
        if (!$record || !isset($namespaces['oai_dc'])) {
            return $result;
        }

        $metadata = $record->metadata->children($namespaces['oai_dc']);
        $dc = $metadata->dc ?? null;

        if ($dc) {
            $dcChildren = $dc->children($namespaces['dc']);

            foreach ($dcChildren as $child) {
                $name = $child->getName();
                $value = trim((string)$child);


                if (!isset($result[$name])) {
                    $result[$name] = [];
                }

                $result[$name][] = $value;
            }
        }

        return $result;
    }


    /**
     * 🧩 Extrai e armazena triples a partir do XML Dublin Core de um registro OAI-PMH
     */
    public function extract_triples(array $record): void
    {
        $data = $this->clean_oai_xml($record['xml']);

        foreach($data as $property => $values) {
            echo "Propriedade: $property<br>";
            if (($property == 'creator') or ($property == 'contributor') or ($property == 'subject')) {
                foreach($values as $v) {
                    echo "- Valor: $v<br>";
                    $this->setTriple($record['id'], $property, $v);
                }
            }
        }
    }

    /**
     * 🧩 Insere ou atualiza uma propriedade de um registro
     */
    public function setTriple(int $record_id, string $property, string $value): bool
    {
        $existing = $this->where('record_id', $record_id)
            ->where('property', $property)
            ->where('value', $value)
            ->first();

        $data = [
            'record_id' => $record_id,
            'property'  => $property,
            'value'     => $value
        ];

        if ($existing) {
            return $this->update($existing['id'], $data);
        }

        return $this->insert($data) ? true : false;
    }
}

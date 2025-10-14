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
        'value',
        'setspec',
        'repository_id'
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

    function get_property_group($prop, $repo, $type='total', $order='DESC')
    {
        $RSP = '';
        $OAItriples = new \App\Models\OaiTriplesModel();
        $sets = $OAItriples->select('count(*) as total, value as concept')
            ->where('repository_id', $repo)
            ->where('property', $prop)
            ->groupBy('value')
            ->orderBy($type, $order)
            ->findAll();


        return $sets;
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
    public function extract_triples(array $record, $setSpec, $repository): void
    {
        $data = $this->clean_oai_xml($record['xml']);
        $date = 0;

        foreach ($data as $property => $values) {
            if (($property == 'creator') 
                    or ($property == 'contributor') 
                    or ($property == 'subject')
                    or ($property == 'date')) {
                foreach ($values as $v) {                   
                    if (($property == 'date') and ($date == 1)) { continue; }
                    $this->setTriple($record['id'], $property, $v, $setSpec, $repository);                    
                    if ($property == 'date') { $date = 1; }
                }                
            }
        }
    }

    /**
     * 🧩 Insere ou atualiza uma propriedade de um registro
     */
    public function setTriple(int $record_id, string $property, string $value, string $setSpec, int $repository): bool
    {
        $existing = $this->where('record_id', $record_id)
            ->where('property', $property)
            ->where('value', $value)
            ->first();

        $data = [
            'record_id' => $record_id,
            'property'  => $property,
            'value'     => $value,
            'setspec'  => $setSpec,
            'repository_id' => $repository
        ];

        if ($existing) {
            return $this->update($existing['id'], $data);
        }

        return $this->insert($data) ? true : false;
    }
}

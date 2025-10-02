<?php

namespace App\Models;

use CodeIgniter\Model;

class OaiRecordModel extends Model
{
    protected $table            = 'oai_records';
    protected $primaryKey       = 'id';

    protected $allowedFields    = [
        'repository',
        'oai_identifier',
        'datestamp',
        'setSpec',
        'deleted',
        'harvesting'
    ];

    // Caso queira timestamps automáticos (created_at / updated_at)
    protected $useTimestamps = false;

    // Tipos de retorno
    protected $returnType = 'array';

    // Regras de validação (opcional)
    protected $validationRules = [
        'repository'     => 'required|integer',
        'oai_identifier' => 'permit_empty|string|max_length[255]',
        'datestamp'      => 'permit_empty|string|max_length[50]',
        'setSpec'        => 'permit_empty|string|max_length[255]',
        'deleted'        => 'permit_empty|in_list[0,1]',
        'harvesting'     => 'required|integer'
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class OaiSetModel extends Model
{
    protected $table            = 'oai_sets';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'identify_id',
        'set_spec',
        'set_name',
        'set_description'
    ];

    protected $useTimestamps = false;

    function register(int $identify_id, string $set_spec, string $set_name, ?string $set_description = null): bool
    {
        $data = [
            'identify_id'    => $identify_id,
            'set_spec'       => $set_spec,
            'set_name'       => $set_name,
            'set_description'=> $set_description
        ];

        // Verifica se já existe
        $existing = $this->where('identify_id', $identify_id)
                         ->where('set_spec', $set_spec)
                         ->first();
        if ($existing) {
            return false; // Já existe
        }

        return $this->insert($data) !== false;
    }
}

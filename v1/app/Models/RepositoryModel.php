<?php

namespace App\Models;

use CodeIgniter\Model;

class RepositoryModel extends Model
{
    protected $table            = 'repository';       // nome da tabela
    protected $primaryKey       = 'id_rp';            // chave primária
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';            // pode ser 'object' se preferir
    protected $useSoftDeletes   = false;

    // Campos permitidos para insert/update
    protected $allowedFields = [
        'rp_name',
        'rp_url',
        'rp_status',
        'rp_update',
        'created_at'
    ];

    // Proteção de dados
    protected $useTimestamps = true; // se quiser que o CI4 cuide do created_at/updated_at
    protected $createdField  = 'created_at';
    protected $updatedField  = '';   // sua tabela não tem updated_at
    protected $deletedField  = '';

    // Validações opcionais
    protected $validationRules = [
        'rp_name'   => 'required|min_length[3]|max_length[200]',
        'rp_url'    => 'required|valid_url|max_length[100]',
        'rp_status' => 'integer',
        'rp_update' => 'valid_date'
    ];

    protected $validationMessages = [
        'rp_name' => [
            'required' => 'O nome do repositório é obrigatório.',
            'min_length' => 'O nome deve ter pelo menos 3 caracteres.'
        ],
        'rp_url' => [
            'required' => 'A URL do repositório é obrigatória.',
            'valid_url' => 'Informe uma URL válida.'
        ]
    ];

    protected $skipValidation = false;
}

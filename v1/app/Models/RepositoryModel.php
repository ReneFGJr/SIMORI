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
        'rp_instituicao',
        'rp_plataforma',
        'rp_versao',
        'rp_update',
        'rp_url_oai',
        'created_at'
    ];

    // Proteção de dados
    protected $useTimestamps = true; // se quiser que o CI4 cuide do created_at/updated_at
    protected $createdField  = 'created_at';
    protected $updatedField  = '';   // sua tabela não tem updated_at
    protected $deletedField  = '';

    // Validações opcionais
    protected $validationRules = [ ];

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

    function check_url()
        {
            echo "Em implementação";
        }

    function get_summary($id=0)
        {
            $RSP = 'Summary';
            return $RSP;
        }

    function updateStatus($id, $status)
    {
        $data = [];
        $data['rp_status'] = $status;
        $data['rp_update'] = date('Y-m-d H:i:s');
        return $this->set($data)->where('id_rp', $id)->update();
    }
}

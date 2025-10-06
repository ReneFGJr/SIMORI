<?php

namespace App\Models;

use CodeIgniter\Model;

class SummaryModel extends Model
{
    protected $table            = 'summarize';
    protected $primaryKey       = 'id_d';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'd_created',
        'd_indicator',
        'd_valor',
        'd_repository',
        'd_created'
    ];

    // timestamps automáticos do CI4
    protected $useTimestamps = false; // pois já existe d_created
    protected $createdField  = 'd_created';

    // Validações
    protected $validationRules = [
        'd_indicator' => 'required|min_length[2]|max_length[10]',
        'd_valor'     => 'required|integer'
    ];

    protected $validationMessages = [
        'd_indicator' => [
            'required' => 'O campo indicador é obrigatório.',
            'max_length' => 'O indicador deve ter no máximo 10 caracteres.'
        ],
        'd_valor' => [
            'required' => 'O valor do indicador é obrigatório.',
            'integer'  => 'O valor deve ser um número inteiro.'
        ]
    ];

    function getIndicator(string $indicator, int $repository): ?array
    {
        return $this
            ->where('d_indicator', $indicator)
            ->where('d_repository', $repository)
        ->first();
    }

    function register(string $indicator, int $value, int $repository): bool
    {
        $data = [
            'd_indicator' => $indicator,
            'd_valor'     => $value,
            'd_repository'=> $repository,
            'd_created'   => date('Y-m-d H:i:s')
        ];

        $dt = $this->where('d_indicator', $indicator)->first();
        if ($dt) {
            $data['d_created'] = $dt['d_created']; // mantém a data original
            $this->where('d_indicator', $indicator);
            return $this->set($data)->update();
        } else {
            return $this->insert($data);
        }
    }
}

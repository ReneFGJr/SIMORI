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
        'd_indicator' => 'required|min_length[2]|max_length[30]',
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

    public function register(string $indicator, int $value, int $repository): bool
    {
        echo "<br>Registrando estatística: $indicator = $value para o repositório $repository<br>";
        $data = [
            'd_indicator'  => $indicator,
            'd_valor'      => $value,
            'd_repository' => $repository,
            'd_created'    => date('Y-m-d H:i:s')
        ];

        // Verifica se já existe o indicador para este repositório
        $dt = $this->where('d_indicator', $indicator)
            ->where('d_repository', $repository)
            ->first();

        if ($dt) {
            // Mantém a data original
            $data['d_created'] = $dt['d_created'];

            // Atualiza o valor existente
            return (bool) $this->where('d_indicator', $indicator)
                ->where('d_repository', $repository)
                ->set($data)
                ->update();
        } else {
            // Insere novo registro
            echo "Inserindo novo registro<br>";
            return (bool) $this->insert($data);
        }
    }
}

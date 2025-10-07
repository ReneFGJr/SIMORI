<?php

namespace App\Models;

use CodeIgniter\Model;

class IndicatorModel extends Model
{
    protected $table = 'summarize';
    protected $primaryKey = 'id_d';
    protected $allowedFields = [
        'd_created',
        'd_indicator',
        'd_valor',
        'd_repository'
    ];

    public function getByRepository($repoId = null)
    {
        if ($repoId) {
            return $this->where('d_repository', $repoId)->findAll();
        }
        return $this->findAll();
    }

    public function getSummary()
    {
        return $this->select('d_repository, d_indicator, d_valor')
            ->orderBy('d_repository')
            ->findAll();
    }
}

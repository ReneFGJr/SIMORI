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

    public function productionYear($jid)
        {

            $Triples = new \App\Models\OaiTriplesModel();
            $dt = $Triples->select("DATE_FORMAT(value, '%Y') AS period, COUNT(*) AS total, repository_id")
                ->where('property', 'date')
                ->where('repository_id',$jid)
                ->groupBy('period')
                ->orderBy('period', 'ASC')
                ->findAll();
            pre($dt);
            return $dt;
        }

    public function getDataMaps()
    {
        $db = \Config\Database::connect();
        $query = $db->query("
            SELECT `rp_name` as p_name, city_name, latitude, longitude
            FROM `repository`
            inner join geo_city ON rp_cidade = id_city
            WHERE 1;
        ");
        $repos = $query->getResultArray();
        return ['repos' => $repos];
    }

    public function resumo($id)
    {
        $RepoModel = new RepositoryModel();
        $SumModel  = new SummaryModel();


        $indicators = $SumModel
            ->select('d_indicator, d_valor')
            ->where('d_repository', $id)
            ->findAll();
        foreach ($indicators as $key => $ind) {
            $indicators[$key]['label'] = lang('App.'.$ind['d_indicator']);
        }

        $data['repos'][] = [
            'id'    => $id,
            'name'  => $RepoModel->find($id)['rp_name'],
            'inst'  => $id,
            'inds'  => $indicators
        ];
        return $data;
    }

    public function grafico_producao()
    {
        $model = new \App\Models\OaiRecordModel();

        // Recupera os dados agregados
        $query = $model->select("DATE_FORMAT(datestamp, '%Y-%m') as ano_mes, COUNT(*) as total")
                       ->groupBy('ano_mes')
                       ->orderBy('ano_mes')
                       ->findAll();

        // Organiza os dados em array associativo
        $dados = [];
        foreach ($query as $row) {
            $dados[$row['ano_mes']] = (int) $row['total'];
        }

        // 🔹 Gera sequência completa de meses (inclusos meses sem produção)
        $inicio = new \DateTime(array_key_first($dados));
        $fim    = new \DateTime(array_key_last($dados));
        $intervalo = new \DateInterval('P1M');
        $periodo = new \DatePeriod($inicio, $intervalo, $fim->modify('+1 month'));

        $labels = [];
        $valores = [];

        foreach ($periodo as $mes) {
            $am = $mes->format('Y-m');
            $labels[] = $am;
            $valores[] = $dados[$am] ?? 0;
        }

        $data = [
            'labels' => json_encode($labels),
            'valores' => json_encode($valores),
        ];
        return $data;
    }

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

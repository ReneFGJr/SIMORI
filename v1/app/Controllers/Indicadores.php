<?php

namespace App\Controllers;

use App\Models\RepositoryModel;
use App\Models\SummaryModel; // ou IndicatorModel
use CodeIgniter\Controller;

helper(['url', 'sisdoc']);

class Indicadores extends BaseController
{
    public function index()
    {
        $RepoModel = new RepositoryModel();
        $SumModel  = new SummaryModel();

        /**********************************************
         * 1️⃣ Gráfico de status dos repositórios
         **********************************************/
        $statusData = $RepoModel->select('rp_status, COUNT(*) as total')
            ->groupBy('rp_status')
            ->findAll();

        $statusLabels = [];
        $statusValues = [];
        foreach ($statusData as $s) {
            switch ($s['rp_status']) {
                case 1:
                    $label = 'Ativo';
                    break;
                case 2:
                    $label = 'Erro';
                    break;
                case 3:
                    $label = 'Em teste';
                    break;
                default:
                    $label = 'Inativo '.$s['rp_status'];
            }
            $statusLabels[] = $label;
            $statusValues[] = (int)$s['total'];
        }

        $data['status_labels'] = json_encode($statusLabels);
        $data['status_values'] = json_encode($statusValues);

        /**********************************************
         * 2️⃣ Indicadores por repositório
         **********************************************/
        $repos = $RepoModel->findAll();
        $data['repos'] = [];

        foreach ($repos as $r) {
            $indicators = $SumModel
                ->select('d_indicator, d_valor')
                ->where('d_repository', $r['id_rp'])
                ->findAll();

            $data['repos'][] = [
                'id'    => $r['id_rp'],
                'name'  => $r['rp_name'],
                'inst'  => $r['rp_instituicao'],
                'inds'  => $indicators
            ];
        }

        /**********************************************
         * 3️⃣ Renderização
         **********************************************/
        $html  = view('layout/header');
        $html .= view('layout/navbar');
        $html .= view('indicadores/index', $data);
        $html .= view('layout/footer');
        return $html;
    }
}

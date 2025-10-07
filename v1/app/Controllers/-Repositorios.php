<?php

namespace App\Controllers;

use App\Models\RepositorioModel;
use App\Models\OaiRepositoryModel;

helper('urls');
helper('sisdoc');

ini_set('memory_limit', '512M'); // ou até '1G' se necessário
set_time_limit(0);

class repository extends BaseController
{
    public function index()
    {
        $model = new RepositorioModel();
        $data['repository'] = $model->findAll();

        $html = view('layout/header', $data);
        $html .= view('layout/navbar', $data);
        $html .= view('repository/index', $data);
        $html .= view('layout/footer', $data);
        return $html;

    }








    public function create()
    {
        return view('repository/create');
    }

    public function edit($id)
    {
        $model = new RepositorioModel();
        $data['repo'] = $model->find($id);
        return view('repository/edit', $data);
    }

    public function copy($id)
    {
        $model = new RepositorioModel();
        $repo = $model->find($id);

        if ($repo) {
            unset($repo['id']); // remove ID para evitar conflito
            $model->insert($repo);
        }

        return redirect()->to('/repository');
    }

    public function delete($id)
    {
        $model = new RepositorioModel();
        $model->delete($id);
        return redirect()->to('/repository');
    }

    public function views($id)
    {
        $SummaeryModel = new \App\Models\SummaryModel();

        $repositorioModel = new \App\Models\RepositorioModel();
        $data['r'] = $repositorioModel->find($id);

        $ind = ['sets', 'records'];

        foreach ($ind as $i) {
            $dt = $SummaeryModel->getIndicator($i,$id);
            if (!$dt) {
                // se não existir, cria com valor zero
                $SummaeryModel->register($i, 0, $id);
                $dt = $SummaeryModel->getIndicator($i,$id);
            }
            $data['stats'][$i] = $dt['d_valor'] ?? 0;
        }

        $total = $SummaeryModel->getIndicator($ind[0],$id);
        $data['stats']['total_sets'] = $total['d_valor'] ?? 0;
        $total = $SummaeryModel->getIndicator($ind[1],$id);
        $data['stats']['total_records'] = $total['d_valor'] ?? 0;
        //$data['stats']['ultima_coleta'] = max(array_column($data['sets'], 'last_collected'));
        //$data['stats']['total_autores'] = count(array_unique(array_column($data['sets'], 'author')));
        //$data['stats']['total_keywords'] = count(array_unique(array_column($data['sets'], 'keywords')));

        // envia o ID do repositório para referência
        $data['identify_id'] = $id;
        $html = view('layout/header', $data);
        $html .= view('layout/navbar', $data);
        $html .= view('repository/view_short', $data);
        $html .= view('repository/view_summary', $data);
        return $html.view('repository/setspec/sets', $data);
    }
}

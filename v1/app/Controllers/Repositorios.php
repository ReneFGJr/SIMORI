<?php

namespace App\Controllers;

use App\Models\RepositorioModel;

class Repositorios extends BaseController
{
    public function index()
    {
        $model = new RepositorioModel();
        $data['repositorios'] = $model->findAll();
        return view('repositorios/index', $data);
    }

    public function create()
    {
        return view('repositorios/create');
    }

    public function edit($id)
    {
        $model = new RepositorioModel();
        $data['repo'] = $model->find($id);
        return view('repositorios/edit', $data);
    }

    public function copy($id)
    {
        $model = new RepositorioModel();
        $repo = $model->find($id);

        if ($repo) {
            unset($repo['id']); // remove ID para evitar conflito
            $model->insert($repo);
        }

        return redirect()->to('/repositorios');
    }

    public function delete($id)
    {
        $model = new RepositorioModel();
        $model->delete($id);
        return redirect()->to('/repositorios');
    }

    public function views($id)
    {

        $repositorioModel = new \App\Models\RepositorioModel();
        $data['r'] = $repositorioModel->find($id);
        $setModel = new \App\Models\OaiSetModel();



        // pega todos os sets do repositório
        $data['sets'] = $setModel->where('identify_id', $id)->orderby('set_name')->findAll();

        $OaiRecordModel = new \App\Models\OaiRecordModel();
        $data['stats']['total_records'] = $OaiRecordModel->where('repository', $id)->countAllResults();

        $data['stats']['total_sets'] = count($data['sets']);
        //$data['stats']['ultima_coleta'] = max(array_column($data['sets'], 'last_collected'));
        //$data['stats']['total_autores'] = count(array_unique(array_column($data['sets'], 'author')));
        //$data['stats']['total_keywords'] = count(array_unique(array_column($data['sets'], 'keywords')));

        // envia o ID do repositório para referência
        $data['identify_id'] = $id;
        $html = view('layout/main', $data);
        $html .= view('repositorios/view_short', $data);
        $html .= view('repositorios/view_summary', $data);
        return $html.view('repositorios/setspec/sets', $data);
    }
}

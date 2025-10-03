<?php

namespace App\Controllers;

use App\Models\RepositoryModel;
use CodeIgniter\Controller;

class Repository extends BaseController
{
    protected $repoModel;

    public function __construct()
    {
        $this->repoModel = new RepositoryModel();
    }

    // 📍 Listar
    public function index()
    {
        $data['repos'] = $this->repoModel->findAll();

        $RSP = view('layout/header');
        $RSP .= view('layout/navbar');
        $RSP .= view('repository/index', $data);
        $RSP .= view('layout/footer');
        return $RSP;
    }

    // 📍 Formulário novo
    public function create()
    {
        return view('repository/create');
    }

    // 📍 Salvar novo
    public function store()
    {
        $this->repoModel->save([
            'rp_name'   => $this->request->getPost('rp_name'),
            'rp_url'    => $this->request->getPost('rp_url'),
            'rp_status' => $this->request->getPost('rp_status'),
            'rp_update' => $this->request->getPost('rp_update')
        ]);

        return redirect()->to('/repository')->with('success', 'Repositório adicionado!');
    }

    // 📍 Editar form
    public function edit($id)
    {
        $data['repo'] = $this->repoModel->find($id);
        return view('repository/edit', $data);
    }

    // 📍 Atualizar
    public function update($id)
    {
        $this->repoModel->update($id, [
            'rp_name'   => $this->request->getPost('rp_name'),
            'rp_url'    => $this->request->getPost('rp_url'),
            'rp_status' => $this->request->getPost('rp_status'),
            'rp_update' => $this->request->getPost('rp_update')
        ]);

        return redirect()->to('/repository')->with('success', 'Repositório atualizado!');
    }

    // 📍 Excluir
    public function delete($id)
    {
        $this->repoModel->delete($id);
        return redirect()->to('/repository')->with('success', 'Repositório excluído!');
    }

    // 📍 Visualizar
    public function show($id)
    {
        $data['repo'] = $this->repoModel->find($id);
        return view('repository/show', $data);
    }
}

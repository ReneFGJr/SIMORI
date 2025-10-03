<?php

namespace App\Controllers;

use App\Models\RepositoryModel;
use CodeIgniter\Controller;

helper('urls');

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

    public function analyse($id)
    {
        $Repository = $this->repoModel->find($id);
        if (!$Repository) {
            return redirect()->to('/repository')->with('error', 'Repositório não encontrado.');
        }

        // Forçar saída imediata (desabilitar buffer do CI4)
        while (ob_get_level() > 0) {
            ob_end_flush();
        }
        ob_implicit_flush(true);

        header('Content-Type: text/html; charset=utf-8');
        header('Cache-Control: no-cache');
        header('X-Accel-Buffering: no'); // nginx não bufferizar

        echo view('layout/header');
        echo view('layout/navbar');
        echo view('layout/footer');
        echo '<div class="container container_simori mt-5 p-4">';
        echo "<h3>Analisando repositório: " . esc($Repository['rp_name']) . "</h3>";
        echo "<div id='log'>";
        flush();

        // simulação de passos
        $steps = [
            ["action" => "CONNECTION", "message" => "🔎 Verificando conexão..."],
            ["action" => "OAI",        "message" => "🌐 Conexão OK!"],
            ["action" => "METADATA",   "message" => "⚙️ Extraindo metadados..."],
            ["action" => "CHECK",      "message" => "🔍 Checando integridade..."],
            ["action" => "FINAL",      "message" => "Finalizando análise..."],
            ["action" => "DONE",       "message" => "✅ Análise concluída!"]
        ];

        $Rpos = new RepositoryModel();

        foreach ($steps as $s) {
            echo "<p>{$s['message']}</p>";
            echo $s['action'];
            flush();
            switch($s['action']) {
                case 'CONNECTION':
                    echo " - Iniciando conexão...";
                    $connection = url_exists($Repository['rp_url']);
                    echo $connection
                        ? '<span class="badge bg-success">✅ Conexão bem-sucedida!</span>'
                        : '<span class="badge bg-danger">❌ Falha na conexão '. $Repository['rp_url'].'.</span>';
                    flush();

                    if (!$connection) {
                        $dd = [];
                        $Rpos->updateStatus($id, 404);
                        echo "<p>🔴 Não foi possível conectar ao repositório. Verifique a URL e tente novamente.</p>";
                        echo '<p>'.$GLOBALS['url_exists_error'].'</p>';
                        echo "</div></div>";
                        flush();
                        exit;
                    } else {
                        $Rpos->updateStatus($id, 1);
                    }
                    break;
                case 'OAI':
                    // Simular verificação OAI-PMH
                    sleep(2); // tempo para simular execução
                    // Aqui você pode adicionar a lógica real de verificação OAI-PMH
                    break;
                case 'METADATA':
                    // Simular extração de metadados
                    sleep(3); // tempo para simular execução
                    // Aqui você pode adicionar a lógica real de extração de metadados
                    break;
                case 'CHECK':
                    // Simular checagem de integridade
                    sleep(2); // tempo para simular execução
                    // Aqui você pode adicionar a lógica real de checagem de integridade
                    break;
                case 'FINAL':
                    // Simular finalização
                    sleep(1); // tempo para simular execução
                    // Aqui você pode adicionar a lógica real de finalização
                    break;
                case 'DONE':
                    // Análise concluída
                    sleep(1); // tempo para simular execução
                    // Aqui você pode adicionar a lógica real após conclusão
                    break;
            }
            sleep(2); // tempo para simular execução

        }

        echo "</div></div>";
        echo view('layout/footer');
        flush();
        exit;
    }




    // 📍 Formulário novo
    public function create()
    {
        $RSP = view('layout/header');
        $RSP .= view('layout/navbar');
        $RSP .= view('repository/create');
        $RSP .= view('layout/footer');
        return $RSP;
    }

    // 📍 Salvar novo
    public function store()
    {
        $this->repoModel->save([
            'rp_name'   => $this->request->getPost('rp_name'),
            'rp_url'    => $this->request->getPost('rp_url'),
            'rp_status' => $this->request->getPost('rp_status'),
            'rp_update' => $this->request->getPost('rp_update'),
            'rp_plataforma' => $this->request->getPost('rp_plataforma'),
            'rp_instituicao' => $this->request->getPost('rp_instituicao')
        ]);

        return redirect()->to('/repository')->with('success', 'Repositório adicionado!');
    }

    // 📍 Editar form
    public function edit($id)
    {

        $data['repo'] = $this->repoModel->find($id);
        $RSP = view('layout/header');
        $RSP .= view('layout/navbar');
        $RSP .= view('repository/edit', $data);
        $RSP .= view('layout/footer');

        return $RSP;
    }

    // 📍 Atualizar
    public function update($id)
    {
        $dt = [
            'rp_name'   => $this->request->getPost('rp_name'),
            'rp_url'    => $this->request->getPost('rp_url'),
            'rp_status' => $this->request->getPost('rp_status'),
            'rp_update' => $this->request->getPost('rp_update'),
            'rp_instituicao' => $this->request->getPost('rp_instituicao'),
            'rp_plataforma' => $this->request->getPost('rp_plataforma')
        ];
        $this->repoModel->set($dt)->where('id_rp', $id)->update();

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
        $RSP = view('layout/header');
        $RSP .= view('layout/navbar');
        $RSP .= view('repository/show', $data);
        $RSP .= view('layout/footer');
        return $RSP;
    }
}

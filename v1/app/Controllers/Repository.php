<?php

namespace App\Controllers;

use App\Models\RepositoryModel;
use CodeIgniter\Controller;

helper('urls');
helper('sisdoc');

class Repository extends BaseController
{

    // 📍 Listar
    public function index()
    {
        $Repo = new \App\Models\RepositoryModel();
        $data['repos'] = $Repo->findAll();

        $RSP = view('layout/header');
        $RSP .= view('layout/navbar');
        $RSP .= view('repository/index', $data);
        $RSP .= view('layout/footer');
        return $RSP;
    }

    public function harvesting($id)
    {
        $Repo = new \App\Models\RepositoryModel();
        $Data = $Repo->find($id);
        if (!$Data) {
            return redirect()->to('/repository')->with('error', 'Repositório não encontrado.');
        }

        $url = $Data['rp_url'];
        $type = $Data['rp_plataforma'];

        switch ($type) {
            case 'DSpace':
                $url .= (str_ends_with($url, '/') ? '' : '/') . 'oai/request';
                break;
            case 'DSpace7+':
                $url .= (str_ends_with($url, '/') ? '' : '/') . 'server/oai/request';
                break;
            case 'DSpace-CRIS':
                $url .= (str_ends_with($url, '/') ? '' : '/') . 'oai/request';
                break;
            case 'DSpace-XMLUI':
                $url .= (str_ends_with($url, '/') ? '' : '/') . 'oai/request';
                break;
            case 'EPrints':
                $url .= (str_ends_with($url, '/') ? '' : '/') . 'cgi/oai2';
                break;
            case 'Dataverse':
                $url .= (str_ends_with($url, '/') ? '' : '/') . 'oai';
                break;
            case 'Omeka-S':
                $url .= (str_ends_with($url, '/') ? '' : '/') . 'oai';
                break;
            case 'Fedora':
                // Exemplo: https://example.com/fedora/oai?verb=Identify
                $url .= (str_ends_with($url, '/') ? '' : '/') . 'fedora/oai';
                break;
            case 'Outros':
                // Manter a URL como está
                break;
            default:
                return redirect()->to('/repository')->with('error', 'Plataforma desconhecida.');
        }

        if (url_exists($url) === false) {
            echo "ERRO " . $GLOBALS['url_exists_error'];
            exit;
        }

        $Repositorio = new \App\Models\RepositorioModel();
        $data = $Repositorio->where('base_url', $url)->first();

        if ($data == []) {
            $dt = [];
            $dt['base_url'] = $url;
            $idR = $Repositorio->insert($dt);
            return redirect()->to('/oai/identify/' . $idR)->with('error', 'Plataforma desconhecida.');
        } else {
            $idR = $data['id'];
            return redirect()->to('/oai/identify/' . $idR)->with('error', 'Plataforma desconhecida.');
        }
    }

    public function analyse($id)
    {
        $Repo = new \App\Models\RepositoryModel();
        $Repository = $Repo->find($id);
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
            ["action" => "TYPE",       "message" => "🔧 Detectando tipo de repositório..."],
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
            switch ($s['action']) {
                case 'CONNECTION':
                    echo " - Iniciando conexão...";
                    $connection = url_exists($Repository['rp_url']);
                    echo $connection
                        ? '<span class="badge bg-success">✅ Conexão bem-sucedida!</span>'
                        : '<span class="badge bg-danger">❌ Falha na conexão ' . $Repository['rp_url'] . '.</span>';
                    flush();

                    if (!$connection) {
                        $dd = [];
                        $Rpos->updateStatus($id, 404);
                        echo "<p>🔴 Não foi possível conectar ao repositório. Verifique a URL e tente novamente.</p>";
                        echo '<p>' . $GLOBALS['url_exists_error'] . '</p>';
                        echo "</div></div>";
                        flush();
                        exit;
                    } else {
                        $Rpos->updateStatus($id, 1);
                    }
                    break;
                case 'TYPE':
                    if (isset($Repository['rp_url'])) {
                        $url = $Repository['rp_url'];
                        $type = '';
                        if (strpos($url, 'jspui') !== false) {
                            $url = substr($url, 0, strpos($url, '/jspui'));
                            $type = 'DSpace';
                        } elseif (strpos($url, 'xmlui') !== false) {
                            $url = substr($url, 0, strpos($url, '/xmlui'));
                            $type = 'DSpace';
                        } elseif (strpos($url, 'xmlui') !== false) {
                            $type = 'DSpace';
                        } elseif (strpos($url, 'xmlui') !== false) {
                            $type = 'DSpace';
                        } else {
                            $type = 'Outros';
                        }
                    }

                    if ($type != '') {
                        $Repository['rp_plataforma'] = $type;
                        $Repository['rp_url'] = $url;
                        $Rpos->set($Repository)->where('id_rp', $id)->update();
                        echo ' Tipo: <span class="badge bg-success">✅ '.$type.'!</span>';
                    }
                case 'OAI':
                    // Aqui você pode adicionar a lógica real de verificação OAI-PMH
                    break;
                case 'METADATA':
                    // Simular extração de metadados
                    sleep(0.2); // tempo para simular execução
                    // Aqui você pode adicionar a lógica real de extração de metadados
                    break;
                case 'CHECK':
                    // Simular checagem de integridade
                    sleep(2); // tempo para simular execução
                    // Aqui você pode adicionar a lógica real de checagem de integridade
                    break;
                case 'FINAL':
                    // Simular finalização
                    sleep(0.2); // tempo para simular execução
                    // Aqui você pode adicionar a lógica real de finalização
                    break;
                case 'DONE':
                    // Análise concluída
                    sleep(0.2); // tempo para simular execução
                    // Aqui você pode adicionar a lógica real após conclusão
                    break;
            }

        }
        echo '<br><br>';
        echo '<a href="' . base_url('/repository/show/' . $id) . '" class="btn btn-primary mt-2 mb-3">Ver detalhes do repositório</a>';

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
        $Repo = new \App\Models\RepositoryModel();

        $Repo->save([
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
        $Repo = new \App\Models\RepositoryModel();
        $data['repo'] = $Repo->find($id);
        $RSP = view('layout/header');
        $RSP .= view('layout/navbar');
        $RSP .= view('repository/edit', $data);
        $RSP .= view('layout/footer');

        return $RSP;
    }

    // 📍 Atualizar
    public function update($id)
    {
        $Repo = new \App\Models\RepositoryModel();
        $dt = [
            'rp_name'   => $this->request->getPost('rp_name'),
            'rp_url'    => $this->request->getPost('rp_url'),
            'rp_status' => $this->request->getPost('rp_status'),
            'rp_update' => $this->request->getPost('rp_update'),
            'rp_instituicao' => $this->request->getPost('rp_instituicao'),
            'rp_plataforma' => $this->request->getPost('rp_plataforma')
        ];
        $Repo->set($dt)->where('id_rp', $id)->update();
        return redirect()->to('/repository/show/' . $id)->with('success', 'Repositório atualizado!');
    }

    // 📍 Excluir
    public function delete($id)
    {
        $Repo = new \App\Models\RepositoryModel();
        $Repo->delete($id);
        return redirect()->to('/repository')->with('success', 'Repositório excluído!');
    }

    // 📍 Visualizar
    public function show($id)
    {
        $Repo = new \App\Models\RepositoryModel();
        $data['repo'] = $Repo->find($id);
        $RSP = view('layout/header');
        $RSP .= view('layout/navbar');
        $RSP .= view('repository/show', $data);
        $RSP .= view('layout/footer');
        return $RSP;
    }
}

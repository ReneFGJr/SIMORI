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

    public function records_extract($id) : string
    {
        set_time_limit(0); //

        $model = new \App\Models\RepositorioModel();
        $data = $model->where('repository_id', $id)->first();

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
        echo "<h3>Analisando repositório: " . esc($data['repository_name']) . "</h3>";
        echo "<div id='log'>";
        flush();

        $OaiRecordModel = new \App\Models\OaiRecordModel();

        $OaiIdentify = new \App\Libraries\OaiService();
        $sets = $OaiIdentify->listIdentifiers($data['base_url'], $id, '');
        $token = 'inicio';
        echo '<div id="log">Iniciando processo de extração de records</div>';
        echo '<script>let logDiv = document.getElementById("log");</script>' . chr(13);
        $OaiRecordModel = new \App\Models\OaiRecordModel();
        $OaiRecordModel->collect_extract($id);
        exit;
    }

    public function sets_show($id) : string
    {
        $SetModel = new \App\Models\OaiSetModel();
        $Repository = new \App\Models\RepositoryModel();
        $RepositoryOAI = new \App\Models\RepositorioModel();

        $sets = $SetModel->where('id', $id)->first();
        $setSpec = $sets['set_spec'];
        $Repo = $Repository->where('id_rp',$sets['identify_id'])->first();
        $id_repo = $Repo['id_rp'];
        $RepoOAI = $RepositoryOAI->where('repository_id',$id_repo)->first();

        $Register = new \App\Models\OaiRecordModel();
        $regs = $Register->where('setSpec', $setSpec)
                         ->where('repository', $id_repo)
                         ->findAll();
        $data = [];
        $data['identify_id'] = $id;
        $data['r'] = $RepoOAI;
        $data['regs'] = $regs;
        //pre($RepoOAI);
        //pre($data);
        $RSP = view('layout/header');
        $RSP .= view('layout/navbar');
        $RSP .= view('repository/view_short', $data);
        $RSP .= view('repository/register', $data);
        $RSP .= view('layout/footer');
        return $RSP;
    }

    public function record_harvest($id)
        {
            $RecordModel = new \App\Models\OaiRecordModel();
            $data['reg'] = $RecordModel->where('id',$id)->first();
            $url_oai = (new \App\Models\RepositorioModel())->where('repository_id',$data['reg']['repository'])->first()['base_url'];

            if (!$data['reg']) {
                return redirect()->to('/repository')->with('error', 'Registro não encontrado.');
            }

            /* Coletar */
            $RecordModel->getRegister($url_oai, $data['reg']['oai_identifier'], $data['reg']);

            return redirect()->to('/repository/record_view/'.$id)->with('success', 'Iniciando coleta do registro...');
        }

    public function record_view($id)
        {
            $RecordModel = new \App\Models\OaiRecordModel();
            $data['reg'] = $RecordModel->where('id',$id)->first();
            $RSP = view('layout/header');
            $RSP .= view('layout/navbar');
            $RSP .= view('repository/record_view', $data);
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
            $dt['repository_id'] = $id;
            $idR = $Repositorio->insert($dt);
            return redirect()->to('/oai/identify/' . $id)->with('error', 'Plataforma desconhecida.');
        } else {
            $idR = $data['repository_id'];
            return redirect()->to('/oai/identify/' . $id)->with('error', 'Plataforma desconhecida.');
        }
    }

    public function url_check()
    {
        $Repo = new \App\Models\RepositoryModel();
        $Repo->check_url();
    }
        // simulação de passos}

    public function analyse($id)
    {
        $RepoAnalyse = new \App\Models\RepositoryAnalyseModel();
        $RepoAnalyse->analyse($id);
    }

    public function record_extract_harvest($id)
    {
        $OaiRecordModel = new \App\Models\OaiRecordModel();
        $data = $OaiRecordModel->where('id',$id)->first();

        $id_repository = $data['repository'];
        $setSpecName = $data['setSpec'];

        $OaiSetModel = new \App\Models\OaiSetModel();
        $setSpec = $OaiSetModel->where('identify_id',$id_repository)
                               ->where('set_spec',$setSpecName)
                               ->first()['id'] ?? '';

        $OaiTriplesModel = new \App\Models\OaiTriplesModel();
        $OaiTriplesModel->extract_triples($data,$setSpec,$id_repository);

        return redirect()->to('/repository/record_view/'.$id)->with('success', 'Extração concluída!');
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
            'rp_url_oai'=> $this->request->getPost('rp_url_oai'),
            'rp_status' => 0,
            'rp_update' => $this->request->getPost('rp_update'),
            'rp_instituicao' => $this->request->getPost('rp_instituicao'),
            'rp_plataforma' => $this->request->getPost('rp_plataforma')
        ];
        $Repo->set($dt)->where('id_rp', $id)->update();
        return redirect()->to('/repository/show/' . $id)->with('success', 'Repositório atualizado!');
    }

    function list_subject($id)
        {
            $OaiTriplesModel = new \App\Models\OaiTriplesModel();
            $data['triplesA'] = $OaiTriplesModel->get_property_group('subject', $id);
            $data['triplesB'] = $OaiTriplesModel->get_property_group('subject', $id, 'value','ASC');
            $data['id_rp'] = $id;
            $RSP = view('layout/header');
            $RSP .= view('layout/navbar');
            $RSP .= view('repository/list_subject', $data);
            $RSP .= view('layout/footer');
            return $RSP;
        }

    function list_creator($id)
    {
        $OaiTriplesModel = new \App\Models\OaiTriplesModel();
        $data['triplesA'] = $OaiTriplesModel->get_property_group('creator', $id);
        $data['triplesB'] = $OaiTriplesModel->get_property_group('creator', $id, 'value', 'ASC');
        $data['id_rp'] = $id;
        $RSP = view('layout/header');
        $RSP .= view('layout/navbar');
        $RSP .= view('repository/list_creator', $data);
        $RSP .= view('layout/footer');
        return $RSP;
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
        $data['repo']['rp_summary'] = $Repo->get_summary($id);
        $RSP = view('layout/header');
        $RSP .= view('layout/navbar');
        $RSP .= view('repository/show', $data);
        $RSP .= view('layout/footer');
        return $RSP;
    }

    /*********** OAI */
    /* Identify */

    public function harvestingOAIrecords($id)
    {
        set_time_limit(0); //

        $model = new \App\Models\RepositorioModel();
        $data = $model->where('repository_id', $id)->first();

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
        echo "<h3>Analisando repositório: " . esc($data['repository_name']) . "</h3>";
        echo "<div id='log'>";
        flush();

        $OaiRecordModel = new \App\Models\OaiRecordModel();

        $OaiIdentify = new \App\Libraries\OaiService();
        $sets = $OaiIdentify->listIdentifiers($data['base_url'], $id, '');
        $token = 'inicio';
        echo '<div id="log">Iniciando processo de coleta de records</div>';
        echo '<script>let logDiv = document.getElementById("log");</script>' . chr(13);
        $OaiRecordModel = new \App\Models\OaiRecordModel();
        $OaiRecordModel->collect($id);
        exit;
    }

    /*********** OAI */
    /* Identify */

    public function harvestingOAI($id)
    {
        $model = new \App\Models\RepositoryModel();
        $model2 = new \App\Models\RepositorioModel();
        $data = $model->where('id_rp', $id)->first();

        $OaiIdentify = new \App\Libraries\OaiService();
        $identify = $OaiIdentify->identify($data['rp_url_oai']);

        if (isset($identify['base_url'])) {
            if (!isset($identify['repositoryName'])) {
                $identify['repositoryName'] = $identify['base_url'];
            }
            $model2->set($identify)->where('repository_id', $id)->update();
            return redirect()->to('/repository/view/' . $id);
        } else {
            echo '<h3>Erro ao conectar com o repositório</h3>';
            echo '<pre>';
            pre($data);
            echo '</pre>';
            echo "Problemas na coleta. Verifique a URL e se o repositório suporta OAI-PMH.";
            echo '<br><a href="' . base_url('/repository/view/' . $id) . '" class="btn btn-primary mt-2 mb-3">Voltar</a>';
        }
    }

    public function views($id)
    {
        $SummaeryModel = new \App\Models\SummaryModel();

        $repositorioModel = new \App\Models\RepositorioModel();
        $data['r'] = $repositorioModel->where('repository_id', $id)->first();

        $ind = ['sets', 'records', 'regs_1_0', 'regs_0_1'];

        foreach ($ind as $i) {
            $dt = $SummaeryModel->getIndicator($i, $id);
            if (!$dt) {
                // se não existir, cria com valor zero
                $SummaeryModel->register($i, 0, $id);
                $dt = $SummaeryModel->getIndicator($i, $id);
            }
            $data['stats'][$i] = $dt['d_valor'] ?? 0;
        }

        $OaiSetModel = new \App\Models\OaiSetModel();
        $data['sets'] = $OaiSetModel->where('identify_id', $id)->findAll();

        $total = $SummaeryModel->getIndicator($ind[0], $id);
        $data['stats']['total_sets'] = $total['d_valor'] ?? 0;
        $total = $SummaeryModel->getIndicator($ind[1], $id);
        $data['stats']['total_records'] = $total['d_valor'] ?? 0;
        $total = $SummaeryModel->getIndicator($ind[2], $id);
        $data['stats']['total_records_coletados'] = $total['d_valor'] ?? 0;
        $total = $SummaeryModel->getIndicator($ind[3], $id);
        $data['stats']['total_records_deleted'] = $total['d_valor'] ?? 0;
        //$data['stats']['ultima_coleta'] = max(array_column($data['sets'], 'last_collected'));
        //$data['stats']['total_autores'] = count(array_unique(array_column($data['sets'], 'author')));
        //$data['stats']['total_keywords'] = count(array_unique(array_column($data['sets'], 'keywords')));

        // envia o ID do repositório para referência
        $data['identify_id'] = $id;
        $html = view('layout/header', $data);
        $html .= view('layout/navbar', $data);
        $html .= view('repository/view_short', $data);
        $html .= view('repository/view_summary', $data);
        return $html . view('repository/setspec/sets', $data);
    }

    public function harvesting_sets($id)
    {
        $SetModel = new \App\Models\OaiSetModel();
        $model = new \App\Models\RepositorioModel();
        $data = $model->where('repository_id', $id)->first();

        $OaiIdentify = new \App\Libraries\OaiService();
        $sets = $OaiIdentify->listSets($data['base_url'], $id);

        if (isset($sets['sets'])) {
            foreach ($sets['sets'] as $s) {
                $s['identify_id'] = $id;
                $s['set_description'] = '';
                // verifica se já existe

                $existing = $SetModel->where('set_spec', $s['set_spec'])->where('identify_id', $id)->first();
                if (!$existing) {
                    $SetModel->insert($s);
                }
            }
        } else {
            $s['identify_id'] = $id;
            $s['set_description'] = '';
            $s['set_spec'] = '';
            $s['set_name'] = 'Padrão';

            // verifica se já existe
            $existing = $SetModel->where('set_spec', $s['set_spec'])->where('identify_id', $id)->first();
            if (!$existing) {
                $SetModel->insert($s);
            }
        }

        /*********************** Update */
        $SummaeryModel = new \App\Models\SummaryModel();
        $dt = $SetModel->select('COUNT(*) AS totals')->where('identify_id', $id)->first();
        $SummaeryModel->register('sets', $dt['totals'] ?? 0, $id);
        return redirect()->to('/repository/view/' . $id);
    }

    public function stat_make($id)
    {
        $OaiRecordModel = new \App\Models\OaiRecordModel();
        $OaiRecordModel->make_stats($id);
        return redirect()->to('/repository/view/' . $id)->with('success', 'Estatísticas atualizadas!');
    }

    public function harvesting_register($id)
    {
        // No início da função ou do script
        set_time_limit(0); //

        $model = new \App\Models\RepositorioModel();
        $data = $model->where('repository_id', $id)->first();

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
        echo "<h3>Analisando repositório: " . esc($data['repository_name']) . "</h3>";
        echo "<div id='log'>";
        flush();

        $OaiRecordModel = new \App\Models\OaiRecordModel();

        $OaiIdentify = new \App\Libraries\OaiService();
        $sets = $OaiIdentify->listIdentifiers($data['base_url'], $id, '');
        $token = 'inicio';
        echo '<div id="log">Iniciando processo de coleta</div>';
        echo '<script>let logDiv = document.getElementById("log");</script>' . chr(13);
        while ($token != '') {
            //echo "Coletados ".count($sets[0])." registros...(".$token.") ";
            flush();
            $token = $sets[1];
            //echo "Novos: " . $OaiRecordModel->registers($sets[0]);
            //echo '<br>';

            flush();
            $sets = $OaiIdentify->listIdentifiers($data['base_url'], $id, $token);
            if (isset($sets[0])) {
                $OaiRecordModel->registers($sets[0]);
                echo '<script>';
                echo 'logDiv.innerHTML = "Coletados ' . count($sets[0]) . ' registros...(' . $token . ')";  ';
                echo '</script>';
            } else {
                echo '<script>';
                echo 'logDiv.innerHTML = "Sem registros";  ';
                echo '</script>';
                $token = '';
            }
            flush();
        }
        echo '<br><br><br>';
        echo '<br><br><br>';
        /*********** Atualizar */

        echo '<script>';
        echo 'logDiv.innerHTML = "Atualizando estatística";  ';
        echo '</script>';
        flush();
        $tot = $OaiRecordModel->select("count(*) as total")->where('repository', $id)->first();

        $SummaeryModel = new \App\Models\SummaryModel();
        $SummaeryModel->register('records', $tot['total'] ?? 0, $id);

        echo '<script>';
        echo 'logDiv.innerHTML = "Fim da Coleta";  ';
        echo '</script>';
        echo '<br>';
        echo '<a href="' . base_url('/repository/view/' . $id) . '" class="btn btn-primary mt-2 mb-3">Voltar</a>';
        echo "</div></div>";
        flush();
    }
}

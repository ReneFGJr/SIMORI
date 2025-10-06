<?php

namespace App\Controllers;

use App\Models\RepositorioModel;
use App\Models\OaiRepositoryModel;

helper('urls');
helper('sisdoc');

ini_set('memory_limit', '512M'); // ou até '1G' se necessário
set_time_limit(0);

class Repositorios extends BaseController
{
    public function index()
    {
        $model = new RepositorioModel();
        $data['repositorios'] = $model->findAll();

        $html = view('layout/header', $data);
        $html .= view('layout/navbar', $data);
        $html .= view('repositorios/index', $data);
        $html .= view('layout/footer', $data);
        return $html;

    }

    public function harvesting($id)
    {
        $model = new RepositorioModel();
        $data = $model->find($id);

        $OaiIdentify = new \App\Libraries\OaiService();
        $identify = $OaiIdentify->identify($data['base_url']);


        if (isset($identify['base_url'])) {
            if (!isset($identify['repositoryName'])) {
                $identify['repositoryName'] = $identify['base_url'];
            }
            $model->set($identify)->where('id', $id)->update();
            return redirect()->to('/repositorios/view/' . $id);
        } else {
            echo '<h3>Erro ao conectar com o repositório</h3>';
            echo '<pre>';
            pre($data);
            echo '</pre>';
            echo "Problemas na coleta. Verifique a URL e se o repositório suporta OAI-PMH.";
            echo '<br><a href="' . base_url('/repositorios/view/' . $id) . '" class="btn btn-primary mt-2 mb-3">Voltar</a>';
        }

    }


    public function harvesting_register($id)
    {
        // No início da função ou do script
        set_time_limit(0); //

        $model = new RepositorioModel();
        $data = $model->find($id);

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
        while ($token != '')
            {
                //echo "Coletados ".count($sets[0])." registros...(".$token.") ";
                flush();
                $token = $sets[1];
                //echo "Novos: " . $OaiRecordModel->registers($sets[0]);
                //echo '<br>';

                flush();
                $sets = $OaiIdentify->listIdentifiers($data['base_url'], $id, $token);
                if (isset($sets[0]))
                    {
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
        $SummaeryModel->register('records_' . $id, $tot['total'] ?? 0);

        echo '<script>';
        echo 'logDiv.innerHTML = "Fim da Coleta";  ';
        echo '</script>';
        echo '<br>';
        echo '<a href="' . base_url('/repositorios/view/' . $id) . '" class="btn btn-primary mt-2 mb-3">Voltar</a>';
        echo "</div></div>";
        flush();
    }

    public function harvesting_sets($id)
    {

        $model = new RepositorioModel();
        $data = $model->find($id);

        $OaiIdentify = new \App\Libraries\OaiService();
        $sets = $OaiIdentify->listSets($data['base_url'],$id);

        if (isset($sets['sets'])) {
            $SetModel = new \App\Models\OaiSetModel();
            foreach ($sets['sets'] as $s) {
                $s['identify_id'] = $id;
                $s['set_description'] = '';
                // verifica se já existe

                $existing = $SetModel->where('set_spec', $s['set_spec'])->where('identify_id', $id)->first();
                if (!$existing) {
                    $SetModel->insert($s);
                }
            }
        }

        /*********************** Update */
        $SummaeryModel = new \App\Models\SummaryModel();
        $dt = $SetModel->select('COUNT(*) AS totals')->where('identify_id', $id)->first();
        $SummaeryModel->register('sets_' . $id, $dt['totals'] ?? 0);
        return redirect()->to('/repositorios/view/' . $id);
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
        $SummaeryModel = new \App\Models\SummaryModel();

        $repositorioModel = new \App\Models\RepositorioModel();
        $data['r'] = $repositorioModel->find($id);

        $ind = ['sets_' . $id, 'records_' . $id];

        foreach ($ind as $i) {
            $dt = $SummaeryModel->getIndicator($i);
            if (!$dt) {
                // se não existir, cria com valor zero
                $SummaeryModel->register($i, 0);
                $dt = $SummaeryModel->getIndicator($i);
            }
            $data['stats'][$i] = $dt['d_valor'] ?? 0;
        }

        $total = $SummaeryModel->getIndicator($ind[0]);
        $data['stats']['total_sets'] = $total['d_valor'] ?? 0;
        $total = $SummaeryModel->getIndicator($ind[1]);
        $data['stats']['total_records'] = $total['d_valor'] ?? 0;
        //$data['stats']['ultima_coleta'] = max(array_column($data['sets'], 'last_collected'));
        //$data['stats']['total_autores'] = count(array_unique(array_column($data['sets'], 'author')));
        //$data['stats']['total_keywords'] = count(array_unique(array_column($data['sets'], 'keywords')));

        // envia o ID do repositório para referência
        $data['identify_id'] = $id;
        $html = view('layout/header', $data);
        $html .= view('layout/navbar', $data);
        $html .= view('repositorios/view_short', $data);
        $html .= view('repositorios/view_summary', $data);
        return $html.view('repositorios/setspec/sets', $data);
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class RepositoryAnalyseModel extends Model
{
    protected $table            = 'repository';       // nome da tabela
    protected $primaryKey       = 'id_rp';            // chave primária
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';            // pode ser 'object' se preferir
    protected $useSoftDeletes   = false;

    // Campos permitidos para insert/update
    protected $allowedFields = [
        'rp_name',
        'rp_url',
        'rp_status',
        'rp_instituicao',
        'rp_plataforma',
        'rp_versao',
        'rp_update',
        'rp_url_oai',
        'created_at'
    ];

    // Proteção de dados
    protected $useTimestamps = true; // se quiser que o CI4 cuide do created_at/updated_at
    protected $createdField  = 'created_at';
    protected $updatedField  = '';   // sua tabela não tem updated_at
    protected $deletedField  = '';

    // Validações opcionais
    protected $validationRules = [];

    protected $validationMessages = [];
    protected $skipValidation = false;

    public $status = [];
    public $type = '';
    public $version = '';

    public function analyse($id = 0)
    {
        $action = ['URL', 'TYPE', 'OAI-PMH', 'Identify'];

        $Repo = new \App\Models\RepositoryModel();
        $Repository = $Repo->find($id);
        if (!$Repository) {
            return redirect()->to('/repository')->with('error', 'Repositório não encontrado.');
        }

        // Forçar saída imediata (sem buffering)
        while (ob_get_level() > 0) {
            ob_end_flush();
        }
        ob_implicit_flush(true);

        header('Content-Type: text/html; charset=utf-8');
        header('Cache-Control: no-cache');
        header('X-Accel-Buffering: no');

        echo view('layout/header');
        echo view('layout/navbar');

        echo '<div class="container container_simori mt-5 p-4">';
        echo '<h3><i class="bi bi-gear"></i> Analisando repositório: ';
        echo '<br><span class="text-primary">' . esc($Repository['rp_name']) . '</span></h3>';
        echo '<div class="row mt-4">';

        // Renderização inicial das etapas
        foreach ($action as $step) {
            echo '
        <div class="col-lg-2 col-6 mb-3">
            <div id="' . $step . '"
                class="progress text-center border rounded shadow-sm"
                style="height: 50px; display: flex; align-items: center; justify-content: center; font-weight: bold; transition: background-color 0.5s ease;">
                ' . $step . '
            </div>
        </div>';
        }

        echo '</div><hr>';
        echo "<div id='log' class='small text-muted'></div>";
        echo '<a href="' . base_url('/repository') . '" class="btn btn-outline-secondary mt-3"><i class="bi bi-arrow-left"></i> Voltar</a>';
        echo '<a href="' . base_url('/repository/show/' . $Repository['id_rp']) . '" class="btn btn-outline-primary mt-3 ms-2"><i class="bi bi-database-gear"></i> Detalhes</a>';
        echo '<a href="' . base_url('/repository/harvesting/' . $Repository['id_rp']) . '" class="btn btn-outline-success mt-3 ms-2"><i class="bi bi-arrow-repeat"></i> Coletar OAI</a>';
        echo '<a href="' . base_url('/repository/edit/' . $Repository['id_rp']) . '" class="btn btn-outline-warning mt-3 ms-2"><i class="bi bi-pencil-square"></i> Editar</a>';
        echo '</div>';
        echo view('layout/footer');

        flush();

        /****************************************** PROCESSO SIMULADO ******************************************/
        foreach ($action as $step) {
            // Etapa iniciada: amarelo
            echo "<script>
            document.getElementById('$step').style.backgroundColor = '#ffc107';
            document.getElementById('$step').style.color = '#000';
            document.getElementById('log').innerHTML += '🟡 Iniciando etapa: <strong>$step</strong>...<br>';
        </script>";
            flush();

            /* Recarrega dados */
            $Repository = $Repo->find($id);
            $result = $this->proccess($step, $Repository);
            $this->status[$step] = $result;

            if ($result == 1) {
                // Etapa concluída: verde
                echo "<script>
                document.getElementById('$step').style.backgroundColor = '#28a745';
                document.getElementById('$step').style.color = '#fff';
                document.getElementById('log').innerHTML += '<p style=\"color:green;\">🟢 Etapa <strong>$step</strong> concluída com sucesso.<br>';
                </script>";
            } else {
                echo "<script>
                document.getElementById('$step').style.backgroundColor = '#a72828';
                document.getElementById('$step').style.color = '#fff';
                document.getElementById('log').innerHTML += '<p style=\"color:red;\">🔴 Etapa <strong>$step</strong> falhou.<br>';
                </script>";
            }
            flush();
            sleep(1);
        }

        // Finalização
        echo "<script>
        document.getElementById('log').innerHTML += '<hr><strong style=\"color:#28a745;\">✅ Análise finalizada com sucesso!</strong><br>';
        </script>";
    }

    function message($msg)
    {
        return "<script>
            document.getElementById('log').innerHTML += '" . addslashes($msg) . "<br>';
        </script>";
    }

    function proccess($step, $repo)
    {
        $RepositoryModel = new \App\Models\RepositoryModel();

        // Simulação de sucesso ou falha
        $success = 0; // 50% de chance de sucesso
        $mesg = '';
        switch ($step) {
            case 'URL':
                // Simulação de verificação de URL
                $mesg = 'Verificando URL: <a href="' . esc($repo['rp_url']) . '" target="_blank">' . esc($repo['rp_url']) . '</a>...';
                $success = url_exists($repo['rp_url']);
                if ($success == 1) {
                    $RepositoryModel->set(['rp_status' => 1, 'rp_update' => date('Y-m-d H:i:s')])->where('id_rp', $repo['id_rp'])->update();
                }
                break;
            case 'OAI-PMH':
                $url = trim($repo['rp_url_oai']);
                if ($url == '') {
                    $mesg = "URL OAI-PMH não fornecida. Pulando etapa...<br>";
                    $success = 0;
                } else {
                    // Simulação de verificação de URL
                    $mesg = 'Verificando URL-OAI: <a href="' . esc($url) . '?verb=Identify" target="_blank">' . esc($repo['rp_url_oai']) . '</a>...';
                    $success = url_exists($repo['rp_url_oai']);
                    if ($success == 0) {
                        $RepositoryModel->updateStatus($repo['id_rp'], 500);
                    }
                }
                $this->status[$step] = $success ? 1 : 0;
                break;
            /********************************************************************* TYPE */
            case 'TYPE':
                if ($this->status['URL'] == 1) {
                    $RepositoryType = new \App\Models\RepositoryTypeModel();
                    $type = $RepositoryType->identify_type($repo['rp_url']);
                    $mesg = "Tipo de repositório identificado como: <strong>$type</strong>.";
                    if ($type == '') {
                        $success = 0;
                        $mesg = "Tipo de repositório não identificado.<br>";
                    } else {
                        $type = explode(',', $type);
                        $this->type = $type[0];
                        $this->version = $type[1];
                        $success = 1;
                        $dt = [];
                        $dt['rp_plataforma'] = $type[0];
                        $dt['rp_versao'] = $type[1];
                        if (trim($repo['rp_url_oai']) == '')
                            { $dt['rp_url_oai'] = $RepositoryType->suggest_oai($type, $repo['rp_url']);
                            $mesg .= '<br>URL OAI sugerida: ' . esc($dt['rp_url_oai']);
                            $repo['rp_url_oai'] = $dt['rp_url_oai'];
                            }
                        $RepositoryModel->set($dt)->where('id_rp', $repo['id_rp'])->update();
                    }

                } else {
                    $mesg = "URL principal inacessível. Não foi possível determinar o tipo do repositório.<br>";
                    $success = 0;
                }
                break;
            case 'Identify':
                if ($this->status['OAI-PMH'] == 1) {
                    $url = trim($repo['rp_url_oai']) . '?verb=Identify';
                    $mesg = 'Verificando URL-OAI: <a href="' . esc($url) . '?verb=Identify" target="_blank">' . esc($repo['rp_url_oai']) . '</a>...';
                    $RepositoryType = new \App\Models\RepositoryTypeModel();
                    $type = $RepositoryType->identify_oai($url);

                    if ($GLOBALS['oai_error'] == '') {
                        $success = 1;
                    } else {
                        $success = 0;
                        $mesg .= '<br>-->' . $GLOBALS['oai_error'];
                    }
                } else {
                    $mesg = "URL OAI inacessível. Não foi possível determinar o tipo do repositório.<br>";
                    $success = 0;
                }
                break;
            case 'ListMetadataFormats':
                // Simulação de chamada ListMetadataFormats
                break;
            case 'ListSets':
                // Simulação de chamada ListSets
                break;
            case 'ListRecords':
                // Simulação de chamada ListRecords
                foreach ($this->status as $k => $v) {
                    echo '<script>
                            document.getElementById("log").innerHTML += "Status da etapa ' . $k . ': ' . ($v == 1 ? '<span style=\"color:green;\">Sucesso</span>' : '<span style=\"color:red;\">Falha</span>') . '<br>";
                        </script>';
                    flush();
                }
                flush();
                break;
        }
        echo $this->message($mesg);
        flush();
        $this->status[$step] = $success ? 1 : 0;
        return $success;
    }
}

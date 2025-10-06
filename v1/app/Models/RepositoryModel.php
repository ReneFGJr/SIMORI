<?php

namespace App\Models;

use CodeIgniter\Model;

class RepositoryModel extends Model
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
        'created_at'
    ];

    // Proteção de dados
    protected $useTimestamps = true; // se quiser que o CI4 cuide do created_at/updated_at
    protected $createdField  = 'created_at';
    protected $updatedField  = '';   // sua tabela não tem updated_at
    protected $deletedField  = '';

    // Validações opcionais
    protected $validationRules = [ ];

    protected $validationMessages = [
        'rp_name' => [
            'required' => 'O nome do repositório é obrigatório.',
            'min_length' => 'O nome deve ter pelo menos 3 caracteres.'
        ],
        'rp_url' => [
            'required' => 'A URL do repositório é obrigatória.',
            'valid_url' => 'Informe uma URL válida.'
        ]
    ];

    protected $skipValidation = false;

    function updateStatus($id, $status)
    {
        $data = [];
        $data['rp_status'] = $status;
        $data['rp_update'] = date('Y-m-d H:i:s');
        return $this->set($data)->where('id_rp', $id)->update();
    }

    function check_url()
        {
            $Repo = new \App\Models\RepositoryModel();
            $Repository = $Repo->findAll();
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
            echo '<div class="container container_simori mt-5 p-4" id="log">';

            echo '<div id="log">Iniciando processo de coleta</div>';
            echo '<script>let logDiv = document.getElementById("log");</script>' . chr(13);

            echo'</div>';
            echo "<br><br><br><br><br>";
            echo "XXX";

            flush();

            $mess = '';

            foreach ($Repository as $repo) {
                $connection = url_exists($repo['rp_url']);
                $message = 'Coletando ' . esc($repo['rp_name']) . ' - ' . esc($repo['rp_url']) . '... ';
                $message .= $connection
                    ? '✅ Conexão bem-sucedida!'
                    : '❌ Falha na conexão ' . $repo['rp_url'];
                flush();

                if ($connection == 1) {
                    $connection = 200;
                }

                $mess = $message.'<br>'.$mess;

                echo '<script>';
                echo 'logDiv.innerHTML = "'.$mess.'";  ';
                echo '</script>';
                flush();

                $status = $connection ? 1 : 404;
                $Repo->updateStatus($repo['id_rp'], $status);
                flush();
            }
        }
}

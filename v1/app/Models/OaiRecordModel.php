<?php

namespace App\Models;

use CodeIgniter\Model;

class OaiRecordModel extends Model
{
    protected $table            = 'oai_records';
    protected $primaryKey       = 'id';

    protected $allowedFields    = [
        'repository',
        'oai_identifier',
        'datestamp',
        'setSpec',
        'deleted',
        'harvesting',
        'xml',
        'status'
    ];

    // Caso queira timestamps automáticos (created_at / updated_at)
    protected $useTimestamps = false;

    // Tipos de retorno
    protected $returnType = 'array';

    // Regras de validação (opcional)
    protected $validationRules = [ ];

    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getRegister($oaiUrl, $identifier, $r)
    {
        $Record = new \App\Models\OaiRecordModel();

        $url = $oaiUrl . '?verb=GetRecord&metadataPrefix=oai_dc&identifier=' . urlencode($identifier);

        $xml = $this->get_xml($url);


        if (!$xml) {
            echo "⚠️ Falha ao coletar $identifier<br>";
            return '';
        }

        // Verifica se é XML válido e contém <GetRecord>
        if (strpos($xml, '<GetRecord') === false) {
            echo "⚠️ Resposta inválida para $identifier<br>";
            return '';
        }

        // 🔹 Atualiza no banco
        $dt = [
            'xml' => $xml,
            'status' => 1,
            'harvesting' => 1
        ];
        $Record->set($dt)->where('id', $r['id'])->update();
        return '';
    }
    public function collect($repo_id)
    {
        $Repo = new RepositorioModel();
        $Record = new \App\Models\OaiRecordModel();

        // Recupera informações do repositório
        $repo = $Repo->where('repository_id', $repo_id)->first();

        if (!$repo) {
            return "Repositório não encontrado.";
        }

        $records = $Record
            ->where('repository', $repo_id)
            ->where('status',0)
            ->where('deleted',0)
            ->findAll();

        $oaiUrl = rtrim($repo['base_url'], '/');
        flush();
        // 🔹 3. Para cada registro, baixa o XML via GetRecord
        foreach ($records as $r) {
            $identifier = trim($r['oai_identifier']);
            if ($identifier == '') continue;


            echo "🔹 Coletando: <code>{$identifier}</code><br>";
            flush();

            $this->getRegister($oaiUrl, $identifier, $r);

            echo '<script>';
            echo 'logDiv.innerHTML = "✅ XML salvo para <b>'.$identifier.'</b><br><br>";  ';
            echo '</script>';
            echo "";
            flush();
            // Delay opcional para não sobrecarregar servidor remoto
            usleep(500000); // 0.5 segundos
        }

        echo "<hr>🏁 Coleta finalizada para o repositório.";
        flush();
    }

    /**
     * Função auxiliar para obter o XML do servidor remoto
     */
    private function get_xml($url)
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT => 60
        ]);
        $output = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            echo "Erro CURL: $err";
            return null;
        }
        return $output;
    }

    function make_stats($id)
        {
            $SummaryModel = new \App\Models\SummaryModel();
            $SummaryModel->where('d_repository',$id)->delete();

            $OAIset = new \App\Models\OaiSetModel();
            $sets = $OAIset->select('count(*) as total')->where('identify_id', $id)->first();

            $SummaryModel->register('sets',$sets['total'], $id);


            $OAIrecord = new \App\Models\OaiRecordModel();
            $sets = $OAIrecord->select('count(*) as total')->where('repository', $id)->first();
            $SummaryModel->register('records', $sets['total'], $id);

            $sets = $OAIrecord->select('count(*) as total, status, deleted')
                    ->where('repository', $id)
                    ->groupBy('status,deleted')
                    ->findAll();
            foreach($sets as $s)
                {
                    $SummaryModel->register('regs_'.$s['status'].'_'.$s['deleted'], $s['total'], $id);
                }
            return 0;
        }
    function register($s)
    {
        if (!isset($s['repository_id']) || !isset($s['identifier'])) {
            return 0; // dados insuficientes
        }
        $exists = $this
            ->where('oai_identifier', $s['identifier'])
            ->where('repository', $s['repository_id'])
            ->first();
        if (!$exists) {
            // Se não existe, insere
            $dt = [
                'repository'     => $s['repository_id'],
                'oai_identifier' => $s['identifier'],
                'datestamp'      => $s['datestamp'],
                'setSpec'        => $s['setSpec'],
                'deleted'        => $s['deleted'],
                'harvesting'     => 0
            ];
            //pre($dt);


            $this->insert($dt);
            return 1;
        }
        return 0;
    }

    function registers($set)
    {
        $total = 0;
        foreach ($set as $s) {
            $total = $total + $this->register($s);
        }
        return $total;
    }
}

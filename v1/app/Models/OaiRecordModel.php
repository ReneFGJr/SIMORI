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

    public function collect_extract($repo_id)
    {
        $Repo = new RepositorioModel();
        $Record = new \App\Models\OaiRecordModel();
        $OaiTriplesModel = new \App\Models\OaiTriplesModel();
        $OaiSetModel = new \App\Models\OaiSetModel();

        // Recupera informações do repositório
        $repo = $Repo->where('repository_id', $repo_id)->first();

        if (!$repo) {
            return "Repositório não encontrado.";
        }

        $records = $Record
            ->where('repository', $repo_id)
            ->where('status',1)
            ->where('deleted',0)
            ->where('harvesting',1)
            ->where('xml IS NOT NULL', null, false)
            ->findAll();

       // 🔹 3. Para cada registro, baixa o XML via GetRecord
        $tot = 0;
        foreach ($records as $r) {
            $tot++;
            $msg = 'Processando registro ID '.$tot.'/'.count($records).'<br>';
            echo '<script>logDiv.innerHTML = "'.$msg.'";</script>' . chr(13);
            flush();

            $identifier = trim($r['oai_identifier']);
            $setSpecName = $r['setSpec'];

            $setSpec = $OaiSetModel->where('identify_id', $repo_id)
                ->where('set_spec', $setSpecName)
                ->first()['id'] ?? '';
            if ($identifier == '') continue;
            $msg.= "🔹 Processando: <code>{$identifier}</code><br>";
            $msg .= "setSpec: <code>{$setSpecName}</code> (ID: {$setSpec})<br>";
            $OaiTriplesModel->extract_triples($r, $setSpec, $repo_id);

            $Record->set(['harvesting' => 2])->where('id', $r['id'])->update();
            $msg .= "✅ Extração concluída para <b>{$identifier}</b><br><br>";
            echo '<script>logDiv.innerHTML = "'.$msg.'";</script>' . chr(13);
            flush();
        }

        $msg = "<hr>🏁 Extração finalizada para o repositório.";
        $msg .= '<br><a href="' . base_url('repository/show/' . $repo_id) . '" class="btn btn-sm btn-outline-primary mt-3"><i class="bi bi-arrow-left"></i> Voltar ao Repositório</a>';
        echo $msg;
        flush();

        $this->make_stats($repo_id);
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
        echo '<br><a href="'.base_url('repository/show/'.$repo_id).'" class="btn btn-sm btn-outline-primary mt-3"><i class="bi bi-arrow-left"></i> Voltar ao Repositório</a>';
        flush();

        // Atualiza estatísticas
        $this->make_stats($repo_id);
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
            /* Dados estatísticos dos triples */
            $OAItriples = new \App\Models\OaiTriplesModel();
            $sets = $OAItriples->select('count(*) as total, property, value')
                    ->where('repository_id', $id)
                    ->groupBy('property, value')
                    ->findAll();
            $setsR = [];
            foreach($sets as $s)
                {
                    if (!isset($setsR[$s['property']]))
                        {
                            $setsR[$s['property']] = 0;
                        }
                    $setsR[$s['property']]++;
                }
            foreach($setsR as $k=>$v)
                {
                    $SummaryModel->register('triples_'.$k, $v, $id);
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
            if ($s['setSpec'] === null) {
                $setSpec = '';
            } else {
                $setSpec = $s['setSpec'];
            }
            $dt = [
                'repository'     => $s['repository_id'],
                'oai_identifier' => $s['identifier'],
                'datestamp'      => $s['datestamp'],
                'setSpec'        => $setSpec,
                'deleted'        => $s['deleted'],
                'harvesting'     => 0
            ];

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

<?php

namespace App\Models;

use CodeIgniter\Model;

class RepositoryTypeModel extends Model
{
    protected $table            = 'repository';       // nome da tabela
    protected $primaryKey       = 'id_rp';            // chave primária
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';            // pode ser 'object' se preferir
    protected $useSoftDeletes   = false;

    // Campos permitidos para insert/update
    protected $allowedFields = [];

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

    function get_types()
    {
        $types = [
            'DSpace',
            'DSpace7+',
            'DSpace-CRIS',
            'DSpace-XMLUI',
            'EPrints',
            'Omeka-S',
            'Dataverse',
            'Fedora',
            'Outros'
        ];
        return $types;
    }

    function identify_type($url)
    {
        $html = get_url_content($url);
        if (stripos($html, 'dspace') !== false) {
            $version = $this->dspace_version($html);
            return 'DSpace,' . $version;
        } elseif (stripos($html, 'eprints') !== false) {
            return 'EPrints';
        } elseif (stripos($html, 'dataverse') !== false) {
            $version = $this->dataverse_version($html);
            return 'Dataverse,' . $version;
        } elseif (stripos($html, 'omeka') !== false) {
            return 'Omeka-S';
        } elseif (stripos($html, 'fedora') !== false) {
            return 'Fedora';
        } else {
            return '';
        }
    }

    function suggest_oai($type,$url)
        {
            if (strpos($url,'?')!==false) {
                $url = substr($url,0,strpos($url,'?'));
            }
            if (strpos($url,'/jspui/')!==false) {
                $url = str_replace('/jspui/','',$url);
            }
            if (strpos($url, '/home/') !== false) {
                $url = str_replace('/home/', '', $url);
            }
            if (strpos($url,'/xmlui/')!==false) {
                $url = str_replace('/xmlui/','',$url);
            }

            if ($type[0] == 'DSpace') {
                if (isset($type[1]) and ($type[1] >= '7')) {
                    return trim($url, '/') . '/server/oai/request';
                } else {
                    return trim($url, '/') . '/oai/request';
                }
            } elseif ($type[0] == 'EPrints') {
                return trim($url, '/') . '/cgi/oai2';
            } elseif ($type[0] == 'Omeka-S') {
                return trim($url, '/') . '/oai';
            } elseif ($type[0] == 'Dataverse') {
                return trim($url, '/') . '/dvn/oai/request';
            } else {
                return '';
            }
        }

    /**
     * Verifica se o endpoint OAI-PMH é válido e retorna 1 (válido) ou 0 (inválido).
     * Também define $GLOBALS['oai_error'] em caso de erro.
     */
    function identify_oai(string $url): int
    {
        $GLOBALS['oai_error'] = null;

        if (empty($url)) {
            $GLOBALS['oai_error'] = "URL vazia.";
            return 0;
        }

        // Adiciona o parâmetro verb=Identify se ainda não estiver presente
        if (!str_contains($url, 'verb=')) {
            $url .= (str_contains($url, '?') ? '&' : '?') . 'verb=Identify';
        }

        // Faz a requisição usando a função anterior
        $xml = get_url_content($url);

        if ($xml === false || empty($xml)) {
            $GLOBALS['oai_error'] = $GLOBALS['url_exists_error'] ?? 'Sem resposta do servidor.';
            return 0;
        }

        // Normaliza o conteúdo (remove BOM e espaços)
        $xml = trim(preg_replace('/\xEF\xBB\xBF/', '', $xml));

        // Verifica se contém tags esperadas do OAI-PMH
        if (
            str_contains($xml, '<Identify>') ||
            str_contains($xml, '<repositoryName>') ||
            str_contains($xml, '<protocolVersion>') ||
            str_contains($xml, 'OAI-PMH')
        ) {
            return 1; // sucesso
        }

        // Caso não tenha formato esperado
        $GLOBALS['oai_error'] = "Resposta não parece ser um OAI-PMH válido.";
        return 0;
    }

    function dataverse_version($txt)
    {
        $version = '';

        if (strpos($txt, '?version=') !== false) {
            $pos = strpos($txt, '?version=') + strlen('?version=');
            $version = substr($txt, $pos, 8);
            $version = substr($version, 0, strcspn($version, '"\'&<> '));
        }
        return $version;
    }

    function dspace_version($txt)
    {
        $version = '';
        if (preg_match('/DSpace\s+(\d+\.\d+(\.\d+)?)/i', $txt, $matches)) {
            $version = $matches[1];
        } elseif (preg_match('/DSpace-CRIS\s+(\d+\.\d+(\.\d+)?)/i', $txt, $matches)) {
            $version = $matches[1];
        } elseif (preg_match('/DSpace-XMLUI\s+(\d+\.\d+(\.\d+)?)/i', $txt, $matches)) {
            $version = $matches[1];
        }
        return $version;
    }
}

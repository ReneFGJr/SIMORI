<?php

namespace App\Libraries;

class OaiService
{
    /**
     * Realiza a requisição OAI-PMH Identify e retorna os dados do repositório.
     *
     * @param string $baseUrl A URL base do repositório OAI-PMH.
     * @return array|null Retorna um array associativo com os dados do repositório ou null em caso de erro.
     */

    public function listIdentifiers(string $baseUrl, int $identifyId, $resumptionToken = ''): ?array
    {
        $allResults = [];
        $url = rtrim($baseUrl, '/');


            if (!empty($resumptionToken)) {
                // Quando há token, a requisição muda
                $requestUrl = $url . '?verb=ListIdentifiers&resumptionToken=' . urlencode($resumptionToken);
            } else {
                // Primeira chamada
                $requestUrl = $url . '?verb=ListIdentifiers&metadataPrefix=oai_dc';
            }

            $ch = curl_init($requestUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

            $response = curl_exec($ch);
            if (!$response) {
                return null;
            }

            $xml = @simplexml_load_string($response);
            if ($xml === false) {
                return null;
            }

            $xml->registerXPathNamespace('oai', 'http://www.openarchives.org/OAI/2.0/');

            // Headers = identificadores
            $headers = $xml->xpath('//oai:ListIdentifiers/oai:header');
            if ($headers) {
                foreach ($headers as $h) {
                    $allResults[] = [
                        'repository_id'   => $identifyId,
                        'identifier'      => (string) $h->identifier,
                        'datestamp'       => (string) $h->datestamp,
                        'setSpec'         => isset($h->setSpec) ? (string) $h->setSpec : null,
                        'deleted'         => (isset($h['status']) && (string)$h['status'] === 'deleted') ? 1 : 0
                    ];
                }
            }

            // Procura resumptionToken para continuar
            $tokens = $xml->xpath('//oai:ListIdentifiers/oai:resumptionToken');
            $resumptionToken = (!empty($tokens) && (string)$tokens[0] !== '') ? (string)$tokens[0] : null;

        return [$allResults,$resumptionToken];
    }


    public function listSets(string $baseUrl): ?array
    {
        $baseUrl = rtrim($baseUrl, '/');
        $allSets = [];
        $resumptionToken = null;
        $attempt = 0;

        do {
            $attempt++;
            // Monta a URL — muda se houver token
            $url = $resumptionToken
                ? "{$baseUrl}?verb=ListSets&resumptionToken=" . urlencode($resumptionToken)
                : "{$baseUrl}?verb=ListSets";

            // Inicializa CURL
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 20,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
            ]);

            $response = curl_exec($ch);
            curl_close($ch);

            if (!$response) {
                log_message('error', "Erro ao acessar {$url}");
                break;
            }

            // Carrega XML
            $xml = @simplexml_load_string($response);
            if ($xml === false) {
                log_message('error', "Erro ao parsear XML de {$url}");
                break;
            }

            $xml->registerXPathNamespace('oai', 'http://www.openarchives.org/OAI/2.0/');
            $sets = $xml->xpath('//oai:ListSets/oai:set');

            if ($sets) {
                foreach ($sets as $set) {
                    $allSets[] = [
                        'set_spec' => (string) $set->setSpec,
                        'set_name' => (string) $set->setName,
                    ];
                }
            }

            // Busca o token (se houver)
            $tokenNode = $xml->xpath('//oai:ListSets/oai:resumptionToken');
            $resumptionToken = !empty($tokenNode) ? trim((string) $tokenNode[0]) : null;

            // Segurança para evitar loop infinito
            if ($attempt > 50) {
                log_message('error', "Loop interrompido em {$baseUrl} após 50 tentativas");
                break;
            }

            // Dá uma pequena pausa entre requisições
            if ($resumptionToken) {
                sleep(1);
            }
        } while (!empty($resumptionToken));

        if (empty($allSets)) {
            return null;
        }

        return ['sets' => $allSets];
    }


    public function identify(string $baseUrl): ?array
    {
        $url = rtrim($baseUrl, '/') . '?verb=Identify';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // caso SSL inválido
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);

        if (!$response) {
            return null;
        }

        // Carrega XML
        $xml = @simplexml_load_string($response);
        if ($xml === false) {
            return null;
        }

        // Namespace do OAI
        $xml->registerXPathNamespace('oai', 'http://www.openarchives.org/OAI/2.0/');

        $identify = $xml->xpath('//oai:Identify');
        if (!$identify || empty($identify[0])) {
            return null;
        }

        $id = $identify[0];

        return [
            'repository_name'   => (string) $id->repositoryName,
            'base_url'          => $baseUrl,
            'protocol_version'  => (string) $id->protocolVersion,
            'admin_email'       => (string) $id->adminEmail,
            'earliest_datestamp' => (string) $id->earliestDatestamp,
            'deleted_record'    => (string) $id->deletedRecord,
            'granularity'       => (string) $id->granularity,
        ];
    }
}
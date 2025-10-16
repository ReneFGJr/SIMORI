<?php

namespace App\Models;

use CodeIgniter\Model;

class OaiMetadataFormatModel extends Model
{
    protected $group = '';
    protected $table      = 'oai_metadata_formats';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'repository_id', 'metadata_prefix', 'schema_url', 'metadata_namespace'
    ];
    protected $useTimestamps = true;

    function tags($id)
        {
            $dt = $this->where('repository_id',$id)->findAll();
            return $dt;
        }

    public function harvestingDataFormat($id)
        {
            $Repository = new \App\Models\RepositoryModel();
            $data = $Repository->where("id_rp",$id)->first();

            $RSP = $this->listMetadataFormats($data['rp_url_oai']);

            foreach($RSP as $format)
                    {
                        $format['repository_id'] = $data['id_rp'];
                        $format['metadata_prefix'] = $format['metadataPrefix'];
                        $format['schema_url'] = $format['schema'];
                        $format['metadata_namespace'] = $format['metadataNamespace'];
                        $dtx = $this
                            ->where("metadata_prefix",$format['metadataPrefix'])
                            ->where('repository_id',$data['id_rp'])
                            ->first();

                        if (!$dtx)
                            {
                                $this->set($format)->insert();
                            }
                    }
            return True;            
        }

    public function listMetadataFormats(string $baseUrl): array
    {
        $url = rtrim($baseUrl, '/') . '?verb=ListMetadataFormats';
        $xml = @simplexml_load_file($url);

        if (!$xml) {
            return ['error' => 'Não foi possível carregar o XML de ' . $url];
        }

        $xml->registerXPathNamespace('oai', 'http://www.openarchives.org/OAI/2.0/');
        $formats = [];

        foreach ($xml->xpath('//oai:metadataFormat') as $format) {
            $formats[] = [
                'metadataPrefix'    => (string)$format->metadataPrefix,
                'schema'            => trim((string)$format->schema),
                'metadataNamespace' => trim((string)$format->metadataNamespace),
            ];
        }

        return $formats;
    }    
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class RepositorioModel extends Model
{
    protected $table      = 'oai_identify';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'repository_name',
        'base_url',
        'protocol_version',
        'admin_email',
        'earliest_datestamp',
        'deleted_record',
        'granularity'
    ];
}

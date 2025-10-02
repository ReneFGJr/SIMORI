<?php

namespace App\Models;

use CodeIgniter\Model;

class OaiSetModel extends Model
{
    protected $table            = 'oai_sets';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'identify_id',
        'set_spec',
        'set_name',
        'set_description'
    ];

    protected $useTimestamps = false;
}

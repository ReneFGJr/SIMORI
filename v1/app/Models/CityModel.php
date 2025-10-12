<?php

namespace App\Models;

use CodeIgniter\Model;

class CityModel extends Model
{
    protected $table            = 'geo_city';
    protected $primaryKey       = 'id_city';
    protected $allowedFields    = [
        'id_city',
        'city_name',
        'latitude',
        'longitude',
        'id_country',
        'id_state'
    ];

    protected $useTimestamps = false;
}

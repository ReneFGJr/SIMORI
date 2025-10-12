<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {

        $RSP = view('layout/header');
        $RSP .= view('layout/navbar');
        $RSP .= view('welcome_logo');
        $RSP .= view('welcome_message');
        /******************** World Map */
        $IndicatorModel = new \App\Models\IndicatorModel();
        $data = $IndicatorModel->getDataMaps();
        $RSP .= view('mapa/world_map', $data);

        $RSP .= view('layout/footer');
        return $RSP;
    }
}

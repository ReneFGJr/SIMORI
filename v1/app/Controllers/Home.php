<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {

        $RSP = view('layout/main');
        $RSP .= view('layout/navbar');
        $RSP .= view('welcome_paralax');
        //$RSP .= view('welcome_message');
        return $RSP;
    }
}

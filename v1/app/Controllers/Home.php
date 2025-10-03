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
        $RSP .= view('layout/footer');
        return $RSP;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AutomatasController extends Controller
{
    function index()
    {
        return view('automatas.home');
    }

    function automatas_afd()
    {
        return view('automatas.afd');
    }

    function automatas_afnd()
    {
        return view('automatas.afnd');
    }
}

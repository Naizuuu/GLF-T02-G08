<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class AutomatasController extends Controller
{
    function index()
    {
        return view('automatas.home');
    }

    function automata_home()
    {
        return view('automatas.proceso.automata_home');
    }

    function afd_afd()
    {
        return view('automatas.proceso.afd_afd');
    }

    function afd_afnd()
    {
        return view('automatas.proceso.afd_afnd');
    }
}

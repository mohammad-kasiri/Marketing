<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return '<a href="http://localhost:8000/admin">Admin</a> | <a href="http://localhost:8000/agent">Agent</a>';
    }
}

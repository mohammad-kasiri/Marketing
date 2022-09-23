<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->check())
        {
            if (auth()->user()->level == 'admin') {
                return  redirect()->route('admin.index');
            }else{
                return redirect()->route('agent.index');
            }

        }else {
            return redirect()->route('login.form');
        }

        return view('welcome');
    }
}

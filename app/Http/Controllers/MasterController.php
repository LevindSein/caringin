<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }

    public function kasir(){
        echo "Kasir";
    }
}

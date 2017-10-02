<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserLabelPrint;

class PrintController extends FrontController
{
    public function index()
    {
        $prints = UserLabelPrint::all();
        
        return view('print.home', ['prints' => $prints])->withTitle('print-shop');
    }
}

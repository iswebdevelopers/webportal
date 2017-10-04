<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserLabelPrint;

class PrintController extends FrontController
{
    public function index()
    {
        $prints = UserLabelPrint::all(['order_id','type','quantity','id']);
        
        return view('print.home', ['prints' => $prints])->withTitle('print-shop');
    }

    public function rawdata($id)
    {
        $data = UserLabelPrint::findOrFail($id, ['raw_data']);

        return json_encode(['data' => $data->raw_data]);
    }
}

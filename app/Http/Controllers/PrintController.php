<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserLabelPrint;
use App\UserPrinterSetting;

class PrintController extends FrontController
{
    public function index()
    {
        $prints = UserLabelPrint::all(['order_id','type','quantity','id']);
        $setting = UserPrinterSetting::all()->first();
        
        return view('print.home', ['prints' => $prints,'setting' => $setting])->withTitle('print-shop');
    }

    public function rawdata($id)
    {
        $data = UserLabelPrint::findOrFail($id, ['raw_data']);

        return json_encode(['data' => $data->raw_data]);
    }

    public function setHost(Request $request, $id)
    {
        $setting = UserPrinterSetting::firstOrCreate(['user_id' => $id]);
        $setting->host = $request->host;
        $setting->port = $request->port;
        $setting->save();

        return $setting;
    }
}

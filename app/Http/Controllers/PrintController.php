<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserLabelPrint;
use App\UserPrinterSetting;

class PrintController extends FrontController
{
    /**
     * Print shop page details
     * @return user label prints list and printer settings of the user
     */
    public function index()
    {
        $prints = UserLabelPrint::all(['order_id','type','quantity','id']);
        $setting = UserPrinterSetting::all()->first();
        
        return view('print.home', ['prints' => $prints,'setting' => $setting])->withTitle('print-shop');
    }

    /**
     * send rawdata for the label requested in print shop
     * @param  id $id
     * @return rawdata from user label prints
     */
    public function rawdata($id)
    {
        $data = UserLabelPrint::findOrFail($id, ['raw_data']);

        return json_encode(['data' => $data->raw_data]);
    }

    /**
     * Saving host settings for user printer
     * @param Request $request
     * @param settings object
     */
    public function setHost(Request $request, $id)
    {
        $setting = UserPrinterSetting::firstOrCreate(['user_id' => $id]);
        $setting->host = $request->host;
        $setting->port = $request->port;
        $setting->save();

        return $setting;
    }
}

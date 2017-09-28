<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Setting;
use GuzzleHttp\Exception\ClientException as Exception;

class SupplierController extends FrontController
{
    public function __construct()
    {
        $this->client = new Client(['base_uri' => config('services.api.url')]);
    }

    public function index(Request $request)
    {
        try {
            $token = $request->session()->get('token');
            $page = $request->page ? $request->page : 1;
            
            $response = $this->client->request('GET', 'suppliers', ['query' => ['token' => $token, 'page'=>$page]]);
                
            if ($response->getstatusCode() == 200) {
                $result = json_decode($response->getBody()->getContents(), true);
            }
        } catch (InternalHttpException $e) {
            $error = json_decode($e->getResponse()->getContent(), true);
            $errors = [$error['data']['message']];
            
            return view('supplier.list')->withErrors($errors)->withTitle('suppliers');
        }
        return view('supplier.list', ['suppliers' => $result['data']])->withTitle('suppliers');
    }

    public function search(Request $request)
    {
        try {
            $token = $request->session()->get('token');
            
            $response = $this->client->request('GET', 'supplier/search/'.$request->term, ['query' => ['token' => $token]]);
                
            if ($response->getstatusCode() == 200) {
                $result = json_decode($response->getBody()->getContents(), true);
            }
        } catch (InternalHttpException $e) {
            $error = json_decode($e->getResponse()->getContent(), true);
            $errors = [$error['data']['message']];
            
            return view('supplier.list')->withErrors($errors)->withTitle('suppliers');
        }
        return view('supplier.list', ['suppliers' => $result['data']])->withTitle('suppliers');
    }
}

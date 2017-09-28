<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Setting;
use GuzzleHttp\Exception\ClientException as Exception;

class OrderController extends FrontController
{
    public function orderlist(Request $request)
    {
        try {
            $token = $request->session()->get('token');

            if ($request->isMethod('post')) {
                $response = $this->client->request('GET', 'order/'.$request->order_no, ['query' => ['token' => $token]]);
            } else {
                $response = $this->client->request('GET', 'orders/', ['query' => ['token' => $token]]);
            }

            if ($response->getstatusCode() == 200) {
                $result = json_decode($response->getBody()->getContents(), true);
            }
        } catch (InternalHttpException $e) {
            $error = json_decode($e->getResponse()->getContent(), true);
            $errors = [$error['data']['message']];
            
            return view('labels.list')->withErrors($errors)->withTitle('label_history');
        }

        return view('labels.list', ['orders' => $result['data']])->withTitle('label_orders');
    }

    public function search(Request $request)
    {
        $token = $request->session()->get('token');

        if ($request->isMethod('post')) {
            try {
                $response = $this->client->request('POST', 'order/'.$request->carton_type.'?token='.$token, ['form_params' => ['order_no'=>$request->order_no,'item_number' => $request->item_number]]);
                
                if ($response->getstatusCode() == 200) {
                    $result = json_decode($response->getBody()->getContents(), true);
                }
                
                return view('labels.search', ['orders' => $result['data']])->withTitle('label_carton')->withInput($request->all());
            } catch (InternalHttpException $e) {
                $error = json_decode($e->getResponse()->getContent(), true);
                $errors = [$error['data']['message']];
                
                return Redirect('portal/label/carton')->withErrors($errors)->withTitle('label_carton')->withInput($request->all());
            }
        } else {
            return view('labels.search')->withTitle('label_carton')->withInput($request->all());
        }
    }

    public function orderdetails(Request $request, int $order_no)
    {
        try {
            $token = $request->session()->get('token');
            $data = array();
            
            $response = $this->client->request('GET', 'order/details/'.$order_no, ['query' => ['token' => $token]]);
            
            if ($response->getstatusCode() == 200) {
                $result = json_decode($response->getBody()->getContents(), true);
                $data['orderdetails'] = $result['data'];
            }
            
            $response = $this->client->request('POST', 'order/cartonpack?token='.$token, [
                        'form_params' => ['order_no' => $order_no]]);
            
            if ($response->getstatusCode() == 200) {
                $result = json_decode($response->getBody()->getContents(), true);
                $data['cartonpack'] = $result['data'];
            }
            
            $response =  $this->client->request('POST', 'order/cartonloose?token='.$token, [
                        'form_params' => ['order_no' => $order_no]]);
            
            if ($response->getstatusCode() == 200) {
                $result = json_decode($response->getBody()->getContents(), true);
                $data['cartonloose'] = $result['data'];
            }
        } catch (InternalHttpException $e) {
            $error = json_decode($e->getResponse()->getContent(), true);
            $errors = [$error['data']['message']];
            
            return view('labels.options', ['orderdetails' => $data,'order_no' => $order_no])->withTitle('label_orders');
        }
        return view('labels.options', ['orderdetails' => $data,'order_no' => $order_no])->withTitle('label_orders');
    }
}

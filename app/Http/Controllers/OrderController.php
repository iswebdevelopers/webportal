<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Setting;
use GuzzleHttp\Exception\ClientException as Exception;

class OrderController extends FrontController
{
    /**
     * list of orders to be printed
     * @param  Request $request
     * @return data array of orders data
     */
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
        } catch (Exception $e) {
            $error = json_decode((string) $e->getResponse()->getBody(), true);
            $errors = [$error['data']['message']];
            
            return view('labels.list')->withErrors($errors)->withTitle('label_history');
        }

        return view('labels.list', ['orders' => $result['data']])->withTitle('label_orders');
    }

    /**
     * details of the order
     * @param  Request $request
     * @param  int     $order_no
     * @return data array of order details
     */
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
        } catch (Exception $e) {
            $error = json_decode((string) $e->getResponse()->getBody(), true);
            $errors = [$error['data']['message']];
            
            return view('labels.home', ['orderdetails' => $data,'order_no' => $order_no])->withTitle('label_orders');
        }
        return view('labels.home', ['orderdetails' => $data,'order_no' => $order_no])->withTitle('label_orders');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\TicketRequest;
use Setting;
use App\Jobs\processCartonLabels;
use GuzzleHttp\Exception\ClientException as Exception;

class LabelController extends FrontController
{
    public function createticket(Request $request)
    {
        try {
            $token = $request->session()->get('token');
            foreach ($request->data as $data) {
                $data['ticket_type'] = $request->type;
            
                $response = $this->client->request('POST', 'ticket/create/tips/request?token='.$token, [
                            'form_params' => $data
                            ]);
            }
            
            if ($response->getstatusCode() == 200) {
                $ticket_list = $this->getCreatedTickets($request, $request->type);
            }

            if (count($ticket_list) > 0) {
                $data = array_map([$this, 'getTipsTicketsData'], $ticket_list);
            }
        } catch (Exception $e) {
            $error = json_decode($e->getResponse()->getContent(), true);
            $errors = [$error['data']['message']];
            return view('labels.list')->withErrors($errors)->withTitle('label_history');
        }
    }

    public function getTipsTicketData(Request $request, $ticket)
    {
        try {
            $token = $request->session()->get('token');
            
            $response = $this->client->request('GET', 'tickets', ['query' => ['token'=>$token,'type'=>$type]]);
            
            if ($response->getstatusCode() == 200) {
                return $result = json_decode($response->getBody()->getContents(), true);
            }
        } catch (Exception $e) {
            throw new Exception("Error Processing Request - Method:getTipsTicketData", 1);
        }
    }
    public function getCreatedTickets(Request $request, $type = 'carton')
    {
        try {
            $token = $request->session()->get('token');
            
            $response = $this->client->request('GET', 'tickets', ['query' => ['token'=>$token,'type'=>$type]]);
            
            if ($response->getstatusCode() == 200) {
                return $result = json_decode($response->getBody()->getContents(), true);
            }
        } catch (Exception $e) {
            throw new Exception("Error Processing Request - Method:getCreatedTickets", 1);
        }
    }

    public function printcartons(Request $request, int $order_no)
    {
        $authUser = $this->getAuthUser($request);
        
        try {
            $token = $request->session()->get('token');
            $data = array();
            
            $response = $this->client->request('GET', 'order/'.$order_no.'/cartonpack', ['query' => ['token' => $token]]);
            
            if ($response->getstatusCode() == 200) {
                $result = json_decode($response->getBody()->getContents(), true);
                $data['cartonpack'] = $result['data'];
            }
            
            $response =  $this->client->request('GET', 'order/'.$order_no.'/cartonloose', ['query' => ['token' => $token]]);
            
            if ($response->getstatusCode() == 200) {
                $result = json_decode($response->getBody()->getContents(), true);
                $data['cartonloose'] = $result['data'];
            }

            //add it to the queue job
            processCartonLabels::dispatch($authUser, $data)->onQueue('cartonProcessing');
            
            $request->session()->flash('message', 'Carton Labels has been added to Print Shop');
            $request->session()->flash('class', 'alert-info');
            
            return redirect('/portal/label/order/'.$order_no);
        } catch (InternalHttpException $e) {
            $error = json_decode($e->getResponse()->getContent(), true);
            $errors = [$error['data']['message']];
                
            return Redirect('portal/label/carton')->withErrors($errors)->withTitle('label_carton')->withInput($request->all());
        }
    }

    public function printstickies(Request $request, int $order_no)
    {
        try {
            $token = $request->session()->get('token');
            $data = array();
            
            $response =  $this->client->request('GET', 'order/'.$order_no.'/ratiopack', ['query' => ['token' => $token]]);
            
            if ($response->getstatusCode() == 200) {
                $result = json_decode($response->getBody()->getContents(), true);
                $data['ratiopack'] = $result['data'];
            }
            
            $response =  $this->client->request('GET', 'order/'.$order_no.'/simplepack', ['query' => ['token' => $token]]);
            
            if ($response->getstatusCode() == 200) {
                $result = json_decode($response->getBody()->getContents(), true);
                $data['simplepack'] = $result['data'];
            }
            
            $response =  $this->client->request('GET', 'order/'.$order_no.'/looseitem', ['query' => ['token' => $token]]);
            
            if ($response->getstatusCode() == 200) {
                $result = json_decode($response->getBody()->getContents(), true);
                $data['looseitem'] = $result['data'];
            }
        } catch (InternalHttpException $e) {
            $error = json_decode($e->getResponse()->getContent(), true);
            $errors = [$error['data']['message']];
                
            return Redirect('portal/label/carton')->withErrors($errors)->withTitle('label_carton')->withInput($request->all());
        }
    }

    public function history(Request $request)
    {
        try {
            $token = $request->session()->get('token');
            $page = $request->page ? $request->page : 1;
            
            $response = $this->client->request('GET', 'ticket/tips/printed', ['query' => ['token' => $token,'page'=>$page]]);
            
            if ($response->getstatusCode() == 200) {
                $result = json_decode($response->getBody()->getContents(), true);
            }
        } catch (InternalHttpException $e) {
            $error = json_decode($e->getResponse()->getContent(), true);
            $errors = [$error['data']['message']];
            
            return view('labels.history')->withErrors($errors)->withTitle('label_history');
        }

        return view('labels.history', ['labels' => $result['data']])->withTitle('label_history');
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

    public function printcartontype(Request $request, string $cartontype, int $order_no, int $item_number = null)
    {
        $authUser = $this->getAuthUser($request);
        $token = $request->session()->get('token');

        try {
            $response = $this->client->request('GET', 'order/'.$order_no.'/'.$cartontype.'/'.$item_number, ['query' => ['token' => $token]]);
            
            if ($response->getstatusCode() == 200) {
                $result = json_decode($response->getBody()->getContents(), true);
                $data[$cartontype] = $result['data'];
            }
            
            processCartonLabels::dispatch($authUser, $data)->onQueue('cartonProcessing');
            
            $request->session()->flash('message', 'Carton Labels has been added to Print Shop');
            $request->session()->flash('class', 'alert-info');
            
            return redirect('/portal/label/order/'.$order_no);
        } catch (Exception $e) {
            $error = json_decode($e->getResponse()->getContent(), true);
            $errors = [$error['data']['message']];
            
            return Redirect('portal/label/carton')->withErrors($errors)->withTitle('label_carton')->withInput($request->all());
        }
    }
}

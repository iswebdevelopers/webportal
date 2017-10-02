<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException as Exception;
use Config;

class FrontController extends Controller
{
    public function __construct()
    {
        $this->client = new Client(['base_uri' => config('services.api.url')]);
    }

    public function getAuthUser(Request $request)
    {
        $token = $request->session()->get('token');
        try {
            $response = $this->client->request('GET', 'auth/user', ['query' => ['token' => $token]
                    ]);
            
            if ($response->getstatusCode() == 200) {
                $result = json_decode($response->getBody()->getContents(), true);

                return $result['authuser'];
            }
        } catch (Exception $e) {
            Log::info('Exception '. (string) $e->getResponse()->getBody());
        }
    }

    /**
     * getTipsTicketData - get the ticket data
     * @param  Request $request
     * @param  $ticket  ticket object from db
     * @return label data that will be sent to print shop
     */
    public function getTipsTicketData($ticket, Request $request)
    {
        try {
            $token = $request->session()->get('token');
            
            $response = $this->client->request('GET', 'ticket/tips/'.$ticket['order_no'].'/'.$ticket['item_number'], ['query' => ['token'=>$token]]);
            
            if ($response->getstatusCode() == 200) {
                $result = json_decode($response->getBody()->getContents(), true);
                return $result['data'];
            }
        } catch (Exception $e) {
            throw new Exception("Error Processing Request - Method:getTipsTicketData", 1);
        }
    }

    /**
     * getCreatedTickets - get all the created tickets
     * @param  Request $request
     * @param  string  $type carton-
     * @return
     */
    public function getCreatedTickets(Request $request)
    {
        try {
            $token = $request->session()->get('token');
            
            $response = $this->client->request('GET', 'tickets', ['query' => ['token'=>$token,]]);
            
            if ($response->getstatusCode() == 200) {
                $result = json_decode($response->getBody()->getContents(), true);
                return $result['data'];
            }
        } catch (Exception $e) {
            throw new Exception("Error Processing Request - Method:getCreatedTickets", 1);
        }
    }
}

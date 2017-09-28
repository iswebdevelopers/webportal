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
            Log::info('Exception '. $e->getMessage());
        }
    }
}

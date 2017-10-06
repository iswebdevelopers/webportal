<?php

namespace App\Http\Middleware;

use Closure;
use Config;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException as Exception;

/**
* ApiAuthenticatecheck as route middleware
*/
class ApiAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($token = $request->session()->get('token')) {
            try {
                $client = new Client(['base_uri' => config('services.api.url')]);
                $response = $client->request('GET', 'auth/user', [
                                'query' => ['token' => $token]
                            ]);
                if ($response->getstatusCode() == 200) {
                    $result = json_decode($response->getBody()->getContents(), true);
                    if (!$result['authuser']) {
                        return redirect('login');
                    }
                } else {
                    return redirect('login');
                }
            } catch (Exception $e) {
                return redirect('login');
            }
        } else {
            return redirect('login');
        }
        $request->session()->put('user_id', $result['authuser']['id']);
        
        \View::share('user', $result['authuser']);
        return $next($request);
    }
}

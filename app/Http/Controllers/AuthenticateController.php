<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use GuzzleHttp\Exception\ClientException as Exception;

class AuthenticateController extends FrontController
{
    /**
     * log in teh user with user input
     * @param  Request $request request object
     * @return token after successfull login or error
     */
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $credentials = $request->only(['email', 'password']);

            $validator = Validator::make($credentials, [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                
                return view('login')->withErrors($errors);
            } else {
                try {
                    $response = $this->client->request('POST', 'auth/login', ['query' =>
                        ['email' => $request->email, 'password' => $request->password]
                    ]);
                
                    if ($response->getstatusCode() == 200) {
                        $result = json_decode($response->getBody()->getContents());
                        $request->session()->put('token', $result->token);
                        session(['token'=>$result->token]);
                        return redirect('portal/dashboard');
                    } else {
                        $errors = [$response->getstatusCode()." - ".$response->getstatusText()];
                    }
                } catch (Exception $e) {
                    $errors = ['Please check your credentials'];
                }
                return view('login')->withErrors($errors);
            }
        } else {
            return view('login');
        }
    }
}

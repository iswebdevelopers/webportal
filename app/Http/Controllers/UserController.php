<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Setting;
use Validator;
use Config;
use GuzzleHttp\Exception\ClientException as Exception;

class UserController extends FrontController
{
    /**
     * list of users
     * @param  Request $request
     * @return users collections
     */
    public function users(Request $request)
    {
        try {
            $token = $request->session()->get('token');
            // $page = $request->page ? $request->page : 1;
            
            $response = $this->client->request('GET', 'users', ['query' => ['token' => $token]]);
                
            if ($response->getstatusCode() == 200) {
                $result = json_decode($response->getBody()->getContents(), true);
            }
        } catch (Exception $e) {
            $error = json_decode((string) $e->getResponse()->getBody(), true);
            $errors = [$error['data']['message']];
            
            return view('user.list')->withErrors($errors)->withTitle('users');
        }
        return view('user.list', ['users' => $result['data']])->withTitle('users');
    }


    /**
     * create user
     * @param  Request $request [description]
     * @return user object and message
     */
    public function create(Request $request)
    {
        $token = $request->session()->get('token');
        $roles = Config::get('user.roles');

        if ($request->isMethod('post')) {
            try {
                $response = $this->client->request('POST', 'auth/signup?token='.$token, ['form_params' => $request->all()]);
                
                if ($response->getstatusCode() == 200) {
                    $result = json_decode($response->getBody()->getContents(), true);
                }
                
                return view('user.edit', ['roles' => $roles, 'message' => 'User has been created','status' => 'success'])->withToken($token)->withTitle('users');
            } catch (Exception $e) {
                $error = json_decode((string) $e->getResponse()->getBody(), true);
                $errors = [$error['errors'][0]];
                return view('user.edit',['roles' => $roles])->withErrors($errors)->withTitle('users')->withToken($token)->withInput($request->all());
            }
        } else {
            return view('user.edit',['roles' => $roles])->withToken($token)->withTitle('users');
        }
    }

    /**
     * user recovery
     * @param  Request $request
     * @param  string  $id
     * @return email users with link
     */
    public function recovery(Request $request, $id='')
    {
        $token = $request->session()->get('token');

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->only('email'), [
                'email' => 'required|email'
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                
                return $data = ['status' => 'error','result' => $errors];
            }

            try {
                $response = $this->client->request('POST', 'auth/recovery?token='.$token, ['form_params' => ['email' => $request->email]]);
                
                if ($response->getstatusCode() == 200) {
                    $result = json_decode($response->getBody()->getContents(), true);
                }
                
                return $data = ['status' => 'success','result' => $result];
            } catch (Exception $e) {
                $error = json_decode((string) $e->getResponse()->getBody(), true);
                $errors = [$error['data']['message']];
                
                return $data = ['status' => 'error','result' => $errors];
            }
        } else {
            try {
                $response = $this->client->request('GET', 'users/'.$id, ['query' => ['token' => $token]]);
                
                if ($response->getstatusCode() == 200) {
                    $result = json_decode($response->getBody()->getContents(), true);
                }
            } catch (Exception $e) {
                $error = json_decode((string) $e->getResponse()->getBody(), true);
                $errors = [$error['data']['message']];
                
                return view('user.recovery')->withErrors($errors)->withTitle('setting')->withToken($token)->withInput($request->all());
            }
        }
        return view('user.recovery', ['users' => $result['data'][0]])->withToken($token)->withTitle('setting');
    }

    /**
     * Reset user password
     * @param  Request $request
     * @param  string  $token
     * @return return message
     */
    public function reset(Request $request, $token = '')
    {
        if ($request->isMethod('post')) {
            if (!$token) {
                $token = $request->token;
            }

            $credentials = $request->only(
            'email',
                'password',
                'password_confirmation',
                'token'
            );

            $validator = Validator::make($credentials, [
                'token' => 'required',
                'email' => 'required|email',
                'password' => 'required|confirmed|min:6',
                'password_confirmation' => 'required',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                return view('user.reset', ['token' => $token])->withErrors($errors)->withInput($request->all());
            }

            try {
                $response = $this->client->request(
                    'POST',
                    'auth/reset?token='.$token,
                            ['form_params' => ['email'=>$request->email,'password'=>$request->password,
                                'password_confirmation'=>$request->password_confirmation]
                            ]
                );
                
                if ($response->getstatusCode() == 200) {
                    $result = json_decode($response->getBody()->getContents(), true);
                }
            } catch (Exception $e) {
                $errors = [(string) $e->getResponse()->getBody()];
                
                return view('user.reset', ['token' => $request->token])->withErrors($errors)->withInput($request->all());
            }
            return view('user.reset', ['token' => $request->token,'data' => $result['data']]);
        } else {
            return view('user.reset', ['token' => $token]);
        }
    }

    /**
     * user logout
     * @param  Request $request
     * @return redirect to login page
     */
    public function logout(Request $request)
    {
        $token = $request->token;

        $loggedout = $request->session->flush();

        return redirect('login');
    }
}

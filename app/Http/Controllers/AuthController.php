<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Laravel\Passport\HasApiTokens;

class AuthController extends Controller
{


    public function __construct() 
    {
        $this->middleware('auth:api', ['except' => ['store', 'login', 'unauthorized']]);
    }

    /**
     * Display a login of the resource.
     */
    public function login(Request $request)
    {
        $array =  ['error' => ''];
        $email = $request->input('email');
        $password = $request->input('password');
        $token = Auth::attempt([
            'email' => $email, 
            'password' => $password
        ]);
        if(!$token) {
            $array['error'] = 'Usuário e/ou senha incorretos!';
            return $array;
        }
        $info = Auth::user();
        $info['avatar'] = url('media/avatars/'. $info['avatar']);
        $array['data'] = $info;
        $array['token'] = $token;
        return $array;
    }

    /**
     * Store a newly created resource in storage.
     * criando novo usuário
     */
    public function store(Request $request)
    {
        $array = ['error' => ''];
        $validators = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if(!$validators->fails()) {
            $name = $request->input('name');
            $email = $request->input('email');
            $password = $request->input('password');
            $emailExists = User::where('email', $email)->count();
            if($emailExists === 0) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $user = new User;
                $user->name = $name;
                $user->email = $email;
                $user->password = $hash;
                $user->save();
                $token = Auth::attempt([
                    'email' => $email, 
                    'password' => $password
                ]);
                if(!$token) {
                    $array['error'] = 'Ocorreu um erro.';
                    return $array;
                }
                $info = Auth::user();
                $info['avatar'] = url('media/avatars/'. $info['avatar']);
                $array['data'] = $info;
                $array['token'] = $token;
            } else {
                $array['error'] = 'Email já cadastrado';
                return $array;
            }
        } else {
            $array['error'] = 'Dados estão incorretos';
            return $array; 
        }
        return $array;
    }

    /**
     * Function to exit the application
     */
    public function logout()
    {
        Auth::logout();
        return ['error' => ''];
    }

    /**
     * Refresh the page
     */
    public function refresh()
    {
        $array = ['error' => ''];
        $token = Auth::refresh();
        $info = Auth::user();
        $info['avatar'] = url('media/avatars/'. $info['avatar']);
        $array['data'] = $info;
        $array['token'] = $token;
        return $array;
    }

    /**
     * If the user is not authorized
     */
    public function unauthorized()
    {
        return response()->json([
            'error' => 'Não autorizado.'
        ], 401);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

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
        $this->middleware('auth:api', ['except' => ['store', 'login']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

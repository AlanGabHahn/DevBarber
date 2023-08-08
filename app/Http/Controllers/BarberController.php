<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BarberController extends Controller
{   

    private $loggedUser;

    /**
     * construct for BarberController
     */
    public function __construct() 
    {
        $this->middleware('auth:api');
        $this->loggedUser = Auth::user();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $array = ['error' => ''];
        $data = $this->loggedUser;
        $data['avatar'] = url('media/avatars/'.$data['avatar']);
        $arra['data'] = $data;
        return $array;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

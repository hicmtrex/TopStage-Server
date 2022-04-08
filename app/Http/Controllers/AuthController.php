<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $fields = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
            'cin' => 'required|numeric',
            'domaine' => 'nullable|string',


        ]);

        $user = User::create([
            'first_name' => $fields['first_name'],
            'last_name' => $fields['last_name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'cin' => $fields['cin'],
            'domaine' => $fields['domaine'],
            "coordinator" => false,
            "service_rh" => false,
            "encadrant" => true,
            "status" => true,

        ]);

        $token = $user->createToken('sara-pfe-user')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token,

        ];

        return response($response, 201);
    }

    public function login(Request $request)
    {

        $fields = $request->validate([
            'email' => 'required|email|string|exists:users,email',
            'password' => 'required|string'
        ]);

        //find email
        $user = User::where('email', $fields['email'])->first();

        //check password

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'email or password wrong!'
            ], 401);
        }



        $token = $user->createToken('sara-pfe-user')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];


        return response($response, 201);
    }

    public function logout()
    {

        // $user = Auth::user();

        // $user->currentAccessToken()->delete();

        // return response([
        //     'success' => true
        // ]);
    }
    public function index()
    {
        $users = User::paginate(10);
        return $users;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields =  $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string',
            'cin' => 'required|numeric',
            'domaine' => 'nullable|string',
        ]);

        $user = User::create([
            'first_name' => $fields['first_name'],
            'last_name' => $fields['last_name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'cin' => $fields['cin'],
            'domaine' => $fields['domaine'],
            "coordinator" => false,
            "service_rh" => false,
            "encadrant" => true,
            "status" => true,

        ]);

        $token = $user->createToken('sara-pfe-user')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];


        return response($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return $user;
    }


    public function self_update(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->first_name = request('first_name');
            $user->last_name = request('last_name');
            $user->email = request('email');
            $user->cin = request('cin');

            $user->save();
            return $user;
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->update($request->all());
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return "user has been deleted";
    }
}

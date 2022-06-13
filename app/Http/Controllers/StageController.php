<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StageController extends Controller
{


    public function register(Request $request)
    {
        $fields = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|unique:stages,email',
            'password' => 'required|string|confirmed',
            'niveau' => 'string|required',
            'cin' => 'numeric',
            'phone' => 'numeric',
            'passport' => 'nullable|numeric',
            'image' => 'nullable',


        ]);
        if ($request->hasFile('image')) {
            $imageFullName = $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('images', $imageFullName);

            if ($request->cin) {
                $user = Stage::create([
                    'first_name' => $fields['first_name'],
                    'last_name' => $fields['last_name'],
                    'email' => $fields['email'],
                    'password' => bcrypt($fields['password']),
                    'cin' => $fields['cin'],
                    'niveau' => $fields['niveau'],
                    "status" => true,
                    "image" => Storage::url("images/" . $imageFullName)
                ]);
            } else {
                $user = Stage::create([
                    'first_name' => $fields['first_name'],
                    'last_name' => $fields['last_name'],
                    'email' => $fields['email'],
                    'password' => bcrypt($fields['password']),
                    'passport' => $fields['passport'],
                    'niveau' => $fields['niveau'],
                    "status" => true,
                    "image" => Storage::url("images/" . $imageFullName)
                ]);
            }
            $token = $user->createToken('sara-pfe-user')->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token,

            ];


            return response($response, 201);
        } else {
            if ($request->cin) {
                $user = Stage::create([
                    'first_name' => $fields['first_name'],
                    'last_name' => $fields['last_name'],
                    'email' => $fields['email'],
                    'password' => bcrypt($fields['password']),
                    'cin' => $fields['cin'],
                    'niveau' => $fields['niveau'],
                    "status" => true,
                    "image" => null
                ]);
            } else {
                $user = Stage::create([
                    'first_name' => $fields['first_name'],
                    'last_name' => $fields['last_name'],
                    'email' => $fields['email'],
                    'password' => bcrypt($fields['password']),
                    'passport' => $fields['passport'],
                    'niveau' => $fields['niveau'],
                    "status" => true,
                    "image" => null
                ]);
            }


            $token = $user->createToken('sara-pfe-user')->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token,

            ];


            return response($response, 201);
        }
    }


    public function login(Request $request)
    {

        $fields = $request->validate([
            'email' => 'required|email|string|exists:stages,email',
            'password' => 'required|string'
        ]);
        //find email
        $user = Stage::where('email', $fields['email'])->first();

        //check password

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'email or password wrong!'
            ], 401);
        }


        $token = $user->createToken('sara-pfe-stage')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];


        return response($response, 200);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->encadrant === true && $user->service_rh === false) {
            $stages = Stage::where("domaine", $user->domaine)->paginate(10);
            return $stages;
        }

        $stages = Stage::paginate(10);
        return $stages;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([

            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string',
            'cin' => 'required|numeric|digits:8|unique:users,cin',
            'passport' => 'nullable|string',
            'niveau' => 'required|string',
            'phone' => 'required|string',
        ]);

        return Stage::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Stage::find($id);
        return $user;
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
        $stage = Stage::find($id);
        $stage->update($request->all());
        return $stage;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Stage::destroy($id);
        return "stager has been deleted";
    }
}

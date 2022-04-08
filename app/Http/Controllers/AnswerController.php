<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function stage_answers()
    {
        $user = Auth::user();
        $answers = Answer::all()->where('user_id', $user->_id);

        return response($answers, 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $fields = $request->validate([
            'categories' => 'required|string',
            'difficulty' => 'required|string',
            'score' => 'required',
            'result' => 'required|boolean',
        ]);

        $answer =   Answer::create([
            "user_id" => $user->_id,
            "user_name" => $user->first_name,
            "categories" => $fields["categories"],
            "difficulty" => $fields["difficulty"],
            "score" => $fields["score"],
            "result" => $fields["result"],
        ]);

        return response($answer, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

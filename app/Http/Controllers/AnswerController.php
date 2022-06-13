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


    public function approvedResult()
    {


        $results = Answer::all()->where('passed', true);

        return  response()->json($results, 200);
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
            'passed' => 'required|boolean',
            'result' => 'required',
        ]);

        $answer =   Answer::create([
            "user_id" => $user->_id,
            "user_name" => $user->first_name,
            "categories" => $fields["categories"],
            "difficulty" => $fields["difficulty"],
            "score" => $fields["score"],
            "result" => $fields["result"],
            "passed" => $fields["passed"],
        ]);

        return response($answer, 201);
    }
}

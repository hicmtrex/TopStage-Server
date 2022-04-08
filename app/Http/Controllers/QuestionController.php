<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::paginate(10);
        return $questions;
    }

    public function questions()
    {
        $questions = [];
        $user = Auth::user();
        if ($user->niveau === "btp" || $user->niveau === "bac") {
            $questions = Question::all()->where('difficulty', "easy");
            return  response($questions, 200);
        } else if ($user->niveau === "bts" || $user->niveau === "licence") {
            $questions = Question::all()->where('difficulty', "medium");
            return  response($questions, 200);
        } else if ($user->niveau === "ingénierie" || $user->niveau === "master") {
            $questions = Question::all()->where('difficulty', "hard");

            return  response($questions, 200);
        } else {
            return "no niveau";
        }
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
            'title' => 'required|string',
            'answers' => 'required',
            'categories' => 'required',
            'topics' => 'required|string',
            'difficulty' => 'required|string',
        ]);

        return Question::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::find($id);
        return $question;
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
        $question = Question::find($id);
        $question->update($request->all());
        return $question;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Question::destroy($id);
        return "question has been deleted";
    }
}

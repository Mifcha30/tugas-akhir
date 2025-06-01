<?php

namespace App\Http\Controllers;

use App\Models\TestResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
   public function index()
{
    if (!file_get_contents(storage_path('app/public/soal.json'))) {
        dd('File tidak ditemukan!');
    }

    $json = file_get_contents(storage_path('app/public/soal.json'));

    $types = json_decode($json, true);

    if ($types === null) {
        dd('JSON tidak valid:', json_last_error_msg());
    }

    return view('test.index', ['testTypes' => array_keys($types)]);
}


    public function userForm($type)
    {
        return view('test.user_form', ['type' => $type]);
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'test_type' => 'required'
        ]);

        return redirect()->route('test.questions', ['type' => $request->test_type, 'name' => $request->name, 'email' => $request->email, 'phone' => $request->phone]);
    }

    public function showQuestions(Request $request, $type)
    {
       $soal = json_decode(file_get_contents(storage_path('app/public/soal.json')), true);

        return view('test.questions', [
            'questions' => $soal[$type],
            'type' => $type,
            'user' => $request->only(['name', 'email', 'phone'])
        ]);
    }

    public function submitAnswers(Request $request)
    {
        $score = array_sum($request->answers);
        $result = TestResult::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'test_type' => $request->test_type,
            'answers' => $request->answers,
            'score' => $score
        ]);

        return redirect()->route('test.result', $result->id);
    }

    public function showResult($id)
    {
        $result = TestResult::findOrFail($id);
        return view('test.result', compact('result'));
    }
}

<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('home');
});

Route::get('/ask', function () {
    return view('ask');
});

Route::post('/ask', function (Request $request) {
    $question = $request->input('question');

    try {
        $response = Http::post('http://127.0.0.1:5000/query', [
            'question' => $question
        ]);

        if (!$response->ok() || !isset($response['sql'])) {
            return back()->with('error', 'Could not get SQL from API.');
        }

        $sql = trim($response['sql']);
        $sql = preg_replace('/```(?:sql)?|```/', '', $sql);
        $sql = trim($sql, '`');

        $results = DB::select($sql);

        return view('results', [
            'question' => $question,
            'sql' => $sql,
            'results' => $results
        ]);
    } catch (\Exception $e) {
        return back()->with('error', 'Error: ' . $e->getMessage());
    }
});

Route::post('/ask', function (Request $request) {
    $question = $request->input('question');
    $dataset = $request->input('dataset');  // 👈 Get dataset from form

    try {
        $response = Http::post('http://127.0.0.1:5000/query', [
            'question' => $question,
            'dataset' => $dataset  // 👈 Send to API
        ]);

        if (!$response->ok() || !isset($response['sql'])) {
            return back()->with('error', 'Could not get SQL from API.');
        }

        $sql = trim($response['sql']);
        $sql = preg_replace('/```(?:sql)?|```/', '', $sql);
        $sql = trim($sql, '`');

        $results = DB::select($sql);

        return view('results', [
            'question' => $question,
            'sql' => $sql,
            'results' => $results
        ]);
    } catch (\Exception $e) {
        return back()->with('error', 'Error: ' . $e->getMessage());
    }
});

Route::get('/upload', function () {
    return view('upload');
});

Route::post('/upload', function (Request $request) {
    $file = $request->file('file');
    $question = $request->input('question');

    if (!$file || !$question) {
        return back()->with('error', 'Please upload a file and enter a question.');
    }

    try {
        $response = Http::attach(
            'file', file_get_contents($file->getRealPath()), $file->getClientOriginalName()
        )->post('http://127.0.0.1:5000/upload', [
            'question' => $question
        ]);

        if (!$response->ok() || !isset($response['sql']) || !isset($response['preview'])) {
            return back()->with('error', 'API failed to return valid results.');
        }

        $sql = trim($response['sql']);
        $sql = preg_replace('/```(?:sql)?|```/', '', $sql);
        $sql = trim($sql, '`');

        // ✅ FIX: Convert array to object to match DB::select()
        $preview = $response->json('preview');
        $results = array_map(function ($row) {
            return (object) $row;
        }, $preview);

        return view('results', [
            'question' => $question,
            'sql' => $sql,
            'results' => $results
        ]);

    } catch (\Exception $e) {
        return back()->with('error', 'Upload Error: ' . $e->getMessage());
    }
});

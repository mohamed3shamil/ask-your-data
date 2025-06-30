<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

Route::get('/', function () {
    return redirect('/ask');
});

Route::get('/ask', function () {
    return view('ask');
});

Route::post('/ask', function (Request $request) {
    $question = $request->input('question');

    try {
        // Send the question to the Flask backend
        $response = Http::post('http://127.0.0.1:5000/query', [
            'question' => $question
        ]);

        // Check if the response contains valid SQL
        if (!$response->ok() || !isset($response['sql'])) {
            return back()->with('error', 'Could not get SQL from API.');
        }

        // ✅ Clean the generated SQL
        $sql = trim($response['sql']);

        // Remove code block markers like ```sql or ```
        $sql = preg_replace('/```(?:sql)?|```/', '', $sql);

        // Remove wrapping backticks (if the entire SQL is inside them)
        $sql = trim($sql, '`');

        // Execute the query
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

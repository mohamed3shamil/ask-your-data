<!-- resources/views/ask.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Ask Your Data</title>
</head>
<body>
    <h1>Ask a Question</h1>
    <form method="POST" action="/ask">
        @csrf
        <label for="question">Enter your question:</label><br><br>
        <textarea id="question" name="question" rows="4" cols="60" required></textarea><br><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>

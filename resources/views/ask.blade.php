<!DOCTYPE html>
<html>
<head>
    <title>Ask Your Data - Question</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            max-width: 800px;
            margin: auto;
        }
        h1 {
            font-size: 32px;
            margin-bottom: 20px;
        }
        textarea {
            width: 100%;
            height: 120px;
            padding: 10px;
            font-size: 16px;
        }
        select {
            font-size: 18px;
            padding: 8px;
            margin-top: 15px;
            width: 100%;
        }
        button {
            margin-top: 20px;
            padding: 12px 24px;
            font-size: 18px;
            background-color: #3490dc;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover {
            background-color: #2779bd;
        }
        .back-link {
            margin-top: 30px;
            display: inline-block;
            font-size: 16px;
            text-decoration: underline;
            color: #333;
        }
    </style>
</head>
<body>

    <h1>Ask a Question</h1>

    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <form method="POST" action="/ask">
        @csrf
        <label for="question">Your Question:</label>
        <textarea name="question" required></textarea>

        <label for="dataset">Choose Dataset:</label>
        <select name="dataset" required>
            <option value="students">Students</option>
            <option value="employees">Employees</option>
            <option value="sales">Sales</option>
            <!-- Add more as needed -->
        </select>

        <button type="submit">Ask</button>
    </form>

    <a href="/" class="back-link">Go Back</a>

</body>
</html>

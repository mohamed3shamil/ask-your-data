<!DOCTYPE html>
<html>
<head>
    <title>Upload & Ask</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            max-width: 800px;
            margin: auto;
        }
        h2 {
            font-size: 28px;
            margin-bottom: 20px;
        }
        label {
            font-size: 16px;
        }
        input[type="file"],
        input[type="text"] {
            font-size: 16px;
            padding: 8px;
            width: 100%;
            margin-top: 8px;
            margin-bottom: 20px;
        }
        button {
            padding: 12px 24px;
            font-size: 16px;
            background-color: #3490dc;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #2779bd;
        }
        .back-link {
            display: inline-block;
            margin-top: 30px;
            font-size: 16px;
            text-decoration: underline;
            color: #333;
        }
    </style>
</head>
<body>

    <h2>Upload File & Ask a Question</h2>
    
    @if (session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <form action="{{ url('/upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label>Upload CSV/Excel file:</label>
        <input type="file" name="file" required>

        <label>Your question:</label>
        <input type="text" name="question" required>

        <button type="submit">Submit</button>
    </form>

    <a href="{{ url('/') }}" class="back-link">Go Back</a>

</body>
</html>

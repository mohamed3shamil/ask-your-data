<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Ask Your Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 60px;
            text-align: center;
        }

        h1 {
            font-size: 36px;
            margin-bottom: 40px;
        }

        .nav-buttons {
            display: flex;
            justify-content: center;
            gap: 30px;
        }

        .nav-buttons a {
            padding: 20px 40px;
            font-size: 20px;
            text-decoration: none;
            border: 2px solid #000;
            border-radius: 8px;
            color: #000;
        }

        .nav-buttons a:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>

    <h1>Welcome to Ask Your Data</h1>

    <div class="nav-buttons">
        <a href="{{ url('/ask') }}">Ask a Question</a>
        <a href="{{ url('/upload') }}">Upload & Ask</a>
    </div>

</body>
</html>

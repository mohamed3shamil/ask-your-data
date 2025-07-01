<!DOCTYPE html>
<html>
<head>
    <title>SQL Query Result</title>
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
        p {
            font-size: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 16px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f3f3f3;
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

    <h2>SQL Query Result</h2>

    <p><strong>Question:</strong> {{ $question }}</p>
    <p><strong>SQL:</strong> {{ $sql }}</p>

    @if (!empty($results) && count($results) > 0)
        <table>
            <thead>
                <tr>
                    @foreach (array_keys((array) $results[0]) as $key)
                        <th>{{ $key }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($results as $row)
                    <tr>
                        @foreach ((array) $row as $value)
                            <td>{{ $value }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No results found.</p>
    @endif

    <a href="{{ url()->previous() }}" class="back-link">Go Back</a>

</body>
</html>

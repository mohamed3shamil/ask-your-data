<!DOCTYPE html>
<html>
<head>
    <title>SQL Query Result</title>
</head>
<body>

    <h2>SQL Query Result</h2>

    <p><strong>Question:</strong> {{ $question }}</p>
    <p><strong>SQL:</strong> {{ $sql }}</p>

    @if (count($results) > 0)
        <table border="1" cellpadding="6" cellspacing="0">
            <thead>
                <tr>
                    @foreach ((array) $results[0] as $key => $value)
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

    <br><br>
    <a href="{{ url('/ask') }}"> Back to Ask</a>

</body>
</html>

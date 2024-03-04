<!DOCTYPE html>
<html lang="uk">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grouped Websites</title>
    <style>
    * { font-family: DejaVu Sans !important; }
    p {font-size: 10px;}
    .red-text { color: red; }
    table {
            border-collapse: collapse;
            width: 100%;
        }
    th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
        font-size: 10px;
    }
    h3 {
        text-align: center;
        color: #EF7918;
    }
  </style>
</head>
<body>
    <h1>Моніторинг. Звіт за xx-xx-xxxx</h1>
    @foreach($groupedWebsites as $facultyName => $websites)
        <h2>Факультет: {{ $facultyName }}</h2>
        @foreach($websites as $website)
            <h3>Сайт: {{ $website['link'] }}</h3>
            <table>
                <tr>
                    <th>Назва пункту</th>
                </tr>
                @foreach($website['values'] as $value)
                    <tr>
                        <td class="{{ $value['result'] ? '' : 'red-text' }}">{{ $value['name'] }}</td>
                        <!-- <td class="{{ $value['result'] ? '' : 'red-text' }}">{{ $value['result'] }}</td> -->
                    </tr>
                @endforeach
            </table>
            <div style='page-break-after: always'></div>
        @endforeach
    @endforeach
</body>
</html>
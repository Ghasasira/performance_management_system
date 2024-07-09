<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 20px;
        }
        h2 {
            font-size: 1.5rem;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #f0f0f0;
            color: #1e3a8a;
            text-align: left;
        }
        td {
            padding: 10px;
            text-align: left;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .total {
            margin-top: 20px;
        }
        .total h1 {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .highlight {
            background-color: #eff6ff;
            border: 1px solid #3b82f6;
            color: #3b82f6;
            padding: 5px;
            text-align: center;
            border-radius: 4px;
            display: inline-block;
        }
        .last-row {
            border: 1px solid #ccc;
        }
        .logo {
            display: block;
            margin: 0 auto 20px;
            max-width: 80px; /* Adjust the size as needed */
        }
        .heading{
            display: flex;
            width: 100%;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div>
        <div class="heading">
            <div>
                {{-- <img src="\assets\reportlogo.png" alt="Report Logo" class="logo"> --}}
                <h1>KPI Report</h1>
            </div>
        </div>

        <p>Name: {{$user->first_name}} {{$user->last_name}}</p>
        <p>Quarter: 2024 Q1</p>
        <div>
            <h2>Culture Performance</h2>
            <table>
                <thead>
                    <tr>
                        <th>Cultural Metric</th>
                        <th>Weight</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach ($data as $item) --}}
                    <tr>
                        <td>Integrity</td>
                        <td>6</td>
                        <td>{{$culture->integrity}}</td>
                        {{-- {{$data->integrity}}</td> --}}
                    </tr>
                    <tr>
                        <td>Equity</td>
                        <td>6</td>
                        <td>{{$culture->equity}}</td>
                        {{-- {{$data->equity}}</td> --}}
                    </tr>
                    <tr>
                        <td>People</td>
                        <td>6</td>
                        <td>{{$culture->people}}</td>
                        {{-- {{$data->people}}</td> --}}
                    </tr>
                    <tr>
                        <td>Excellence</td>
                        <td>6</td>
                        <td>{{$culture->excellence}}</td>
                        {{-- {{$data->excellence}}</td> --}}
                    </tr>
                    <tr>
                        <td>Teamwork</td>
                        <td>6</td>
                        <td>{{$culture->teamwork}}</td>
                        {{-- {{$data->teamwork}}</td> --}}
                    </tr>
                    <tr class="last-row">
                        <td>Total</td>
                        <td></td>
                        <td>
                            <div class=""><h3>{{$culture_score}}</h3></div>
                        </td>
                    </tr>
                    {{-- @endforeach --}}
                </tbody>
            </table>
        </div>

        <div>
            <h2>Competency Performance</h2>
            <table>
                <thead>
                    <tr>
                        <th>Competency Metric</th>
                        <th>Weight</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $item)
                    <tr>
                        <td>{{$item->title}}</td>
                        <td>{{$item->weight}}</td>
                        <td>{{$item->score}}</td>
                        {{-- {{$data->integrity}}</td> --}}
                    </tr>
                    @endforeach
                    <tr class="last-row">
                        <td colspan="2">Total</td>
                        <td>
                            <div class=""><h3>{{$competence_score}}</h3></div>
                        </td>
                    </tr>
                    {{-- @endforeach --}}
                </tbody>
            </table>
        </div>

        <div class="total">
            <h1>Overall Score: {{$overall_score}}%</h1>
        </div>
    </div>
</body>
</html>

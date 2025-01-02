<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KPIs</title>
    <link rel="icon" type="image/x-icon" href="assets/Asset.ico">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('assets/nbs.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            width: 100%;
            height: 100vh;
        }
        /* .custom-card {
            background-color: rgba(108, 117, 125, 0.5);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            min-width: 30%;
            display: flex;
            justify-content: center;
            align-items: center;
        } */

        .bodydiv{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: rgba(242, 245, 247, 0.233);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            margin: 10px
        }
        .custom-button {
            transition: all 0.3s;
        }
        .custom-button:hover {
            transform: scale(1.05);
        }
        .custom-link {
            color: white;
            text-decoration: none;
        }
        h4{
            color: white;
            text-align: center;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center">
    <div class="bodydiv">
        <img src="assets\Asset.ico" alt="Logo">
        <div>
            <h4>
                KPI Management System
            </h4>
        </div>
        <div class="custom-card">
            
            @if (Route::has('login'))
                <div class="">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="custom-link">
                            <button class="btn btn-success custom-button m-2">
                                Dashboard
                            </button>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="custom-link">
                            <button class="btn btn-primary custom-button m-2">
                                Log in
                            </button>
                        </a>

                        @if (Route::has('register'))
                        <!--{{ route('register') }}-->
                            <a href="#" class="custom-link">
                                <button class="btn btn-danger custom-button m-2">
                                    Register
                                </button>
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Yifelegal API</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        *{
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body{
            background-color: #00bef8;
            display: flex;
            height: 100vh;
            width: 100vw;
            justify-content: center;
            align-items: center;
        }
        #container{
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        #container h1{
            color: white;
            font-size: 60px;
        }
        #container p{
            color: white;
            font-size: 30px;
        }
        #container img{
            width: 200px;
        }
    </style>
</head>
<body>
<div id="container">
    <img src="{{asset("assets/images/yifelegal_logo.svg")}}" alt="app logo"/>
    <h1>ይፈለጋል API</h1>
    <p>This is a Laravel API made for the "ይፈለጋል" broker application</p>
</div>
</body>
</html>

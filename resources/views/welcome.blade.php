<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel & Vue.js</title>
    <link rel="stylesheet" href="http://localhost:3000/resources/css/app.css">
    <style>
        .home{
            background-color: whitesmoke;
        }
     </style>
</head>
<body>
    <div id="app" class="home">
        <home-component></home-component>
    </div>
    <script type="module" src="http://localhost:5173/resources/js/app.js"></script>
</body>
</html>

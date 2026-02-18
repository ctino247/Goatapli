<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>{{ \App\Models\Setting::get('site_name', config('app.name', 'Mobile Recruitment')) }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #e0f2fe; /* Light pastel blue */
            overflow-x: hidden;
        }
        .slide-transition {
            transition: transform 0.3s ease-in-out;
        }
        .app-container {
            max-width: 400px;
            width: 100%;
            height: 800px;
            background: #000; /* Dark background like in the image */
            border-radius: 40px;
            border: 8px solid #333;
            overflow: hidden;
            position: relative;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .white-card {
            background: white;
            border-radius: 40px 40px 0 0;
            padding: 30px;
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body class="antialiased flex items-center justify-center min-h-screen">
    <div class="app-container">
        @yield('content')
    </div>
</body>
</html>

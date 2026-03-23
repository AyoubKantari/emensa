<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; display: flex; flex-direction: column; min-height: 100vh; }
        header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; }
        header h1 { margin-bottom: 15px; }
        nav a { color: white; text-decoration: none; padding: 10px 20px; background: rgba(255,255,255,0.2); border-radius: 5px; margin-right: 10px; display: inline-block; }
        nav a:hover { background: rgba(255,255,255,0.3); }
        main { flex: 1; padding: 40px; background: #f5f5f5; }
        footer { background: #333; color: white; padding: 20px; text-align: center; }
    </style>
</head>
<body>
<header>@yield('header')</header>
<main>@yield('main')</main>
<footer>@yield('footer')</footer>
</body>
</html>

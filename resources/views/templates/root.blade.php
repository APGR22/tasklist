<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('root.title', 'Template')</title>
    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.8-dist/css/bootstrap.css') }}">
    @yield('root.header')
</head>
<body>
    @yield('root.body')
    
    <script src="{{ asset('bootstrap-5.3.8-dist/js/bootstrap.js') }}"></script>
    @yield('root.scripts')
</body>
</html>
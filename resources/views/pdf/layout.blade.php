<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <style>{!! file_get_contents(resource_path('css/pdf.css')) !!}</style>
</head>
<body>
    {{-- Colonna riservata ai loghi dei marchi. --}}
    <aside class="brand-logos"></aside>
    <main>
        @include('pdf.partials.header')
        @yield('content')
    </main>
</body>
</html>

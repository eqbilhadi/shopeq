<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="sm-hover-active" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>{{ $title ?? config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Starter web develop laravel" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('includes.styles')
</head>

<body>

    {{ $slot }}
    @include('includes.scripts')
</body>

</html>

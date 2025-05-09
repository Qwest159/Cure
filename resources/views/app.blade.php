<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">

        {{-- SEO----- --}}
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Cure') }}</title>
        <meta
          name="description"
          content="Rejoignez-nous pour une retraite en pleine nature avec la cure C9 Forever ! Durant plusieurs jours, transformez votre vie grâce à un programme complet : alimentation saine, sport quotidien et ressourcement au cœur de la campagne."
        />
        <meta name="keywords" content="cure bien-être" />
        <meta name="author" content="Virginie Vanden Bemden" />


        <!-- Meta tag pour le token CSRF -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">

        {{-- font awesome --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


        {{-- icone  --}}
        <link rel="icon" type="image/png" href="/storage/favicon-32x32.png" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Anthros SA</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite('resources/css/app.scss')
    @vite('resources/js/app.js')

    @yield('head')
</head>
<body class="landing">

<header id="main-header">
    <a href="/"><img src="{{ Vite::asset('resources/img/header-title.png') }}" alt="Anthros SA"></a>
</header>

<div id="socials-bar">
    <a class="discord" href="https://discord.gg/assa"><i class="fa-brands fa-discord"></i> Join our Discord</a>
    <a class="instagram" href="https://www.instagram.com/anthrosocietysa/"><i class="fa-brands fa-instagram"></i> @anthrosocietysa</a>
    <a class="twitter" href="https://x.com/Anthro_SA"><i class="fa-brands fa-twitter"></i> @Anthro_SA</a>
    <!--<a class="tiktok" href="https://www.tiktok.com/@anthros.sa"><i class="fa-brands fa-tiktok"></i> @anthros.sa</a>-->
</div>

@yield('body')

<footer id="main-footer">
    <p>Site made with &hearts; by Mibble | Banner photo by Donut</p>
    @if (auth()->user() !== null)
        <p>Logged in as <b>{{ auth()->user()->name }}</b>. <a href="/logout">Logout</a></p>
    @endif

</footer>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</body>
</html>

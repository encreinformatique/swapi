<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Swapi Test</title>

        <!-- Styles -->
        <style>
            body {font-family: system-ui,sans-serif;margin: 0;height: 100vh;}
            a {color: #377dff}
            a:hover {color: #494998}
            img {max-width: 100%;}
            .container {max-width: 600px;height: 100%; width: 100%;margin-left: auto;margin-right: auto; display: flex;align-items: center;justify-content: center;flex-direction: column;}
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Swapi API</h1>
            <img class="mx-auto" src="/assets/img/jyjondev_cinematic_macro_photography_X-Wing_starfighter.jpg"  alt="X-Wing en el desierto."/>
            <p>
                <a href="https://julien.devergnies.com">
                    foto generada con Midjourney
                </a>
            </p>
        </div>
    </body>
</html>

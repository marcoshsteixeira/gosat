<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        @vite(['resources/js/app.js', 'resources/css/app.css'])
    </head>

    <body>
        <nav class="navbar bg-primary navbar-default navigation-clean-button">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="javascript:void(0)">
                        <img src="gosat-logo-white-200x76.png" alt="GOSAT">
                    </a>
                </div>
            </div>
        </nav>
        <div id="app">
            <div class="container" style="margin-top: 20px">
                <cpf />
            </div>
        </div>
    </body>

</html>

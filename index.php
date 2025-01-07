<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ioEscribo - Inicio</title>
    <link rel="icon" type="image/x-icon" href="./assets/icons/icon.png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/styles.css" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL@20..48,100..700,0..1"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL@20..48,100..700,0..1"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL@20..48,100..700,0..1"
        rel="stylesheet">

    <script type="importmap">
      {
        "imports": {
          "@material/web/": "https://esm.run/@material/web/"
        }
      }
    </script>
    <script type="module">
        import '@material/web/all.js';
        import { styles as typescaleStyles } from '@material/web/typography/md-typescale-styles.js';

        document.adoptedStyleSheets.push(typescaleStyles.styleSheet);
    </script>
</head>

<body>
    <?php
    session_start();
    ?>
    <div class="container">
        <div class="index_div" style="width: 100%;">
            <div class="logo-index">
                <img src="./assets/img/ioEscribo_logo.png" alt="Logo" class="logo" id="logo-login" />
                <h1> ioEscribo </h1>
                <p>¡Escribe y comparte tus historias!</p>
            </div>
            <div class="login">
                <md-filled-tonal-button class="btn-login" onclick="window.location.href='./sign-up.php'"> <md-icon
                        slot="icon">person_add</md-icon>Crear
                    cuenta</md-filled-tonal-button>
                <md-filled-tonal-button class="btn-login" onclick="window.location.href='./login.php'"> <md-icon
                        slot="icon">login</md-icon>Iniciar
                    sesión</md-filled-tonal-button>
            </div>
        </div>
    </div>
</body>

</html>
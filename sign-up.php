<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ioEscribo - Registrar</title>
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
    <div class="container">
        <div class="login">
            <img src="./assets/img/ioEscribo_logo.png" alt="Logo" class="logo" id="logo-login" />
            <h1> Registrar usuario </h1>
            <?php
            include("controllers/sign-up-controller.php");
            ?>
            <form method="post" action="" id="sign-up-form">
                <md-outlined-text-field label="Nombre" type="text" name="nombre" value="" required></md-outlined-text-field>
                <md-outlined-text-field label="Correo electrónico" type="email" name="correo" required></md-outlined-text-field>
                <md-outlined-text-field label="Contraseña" type="password" name="pssword" required></md-outlined-text-field>
                
                <md-filled-tonal-button type="submit" name="btn-sign-up" value="Darse de alta" style="width:100%">
                    <md-icon slot="icon">person_add</md-icon>
            Crear cuenta
        </md-filled-tonal-button>
            </form>
            <a href="./login.php" class="account-link">¿Ya tienes una cuenta? Inicia sesión</a>
        </div>
    </div>
</body>
</html>
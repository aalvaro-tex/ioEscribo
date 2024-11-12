<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <div class="header">
        <img src="./assets/img/ioEscribo_logo.png" alt="Logo" class="logo" id="logo-header" />
        <div class="spacer"></div>
        <div class="contains-session-info">
            <p>Usuario: <span style="font-weight: 600;"><?php echo $_SESSION['nombre']; ?></span></p>
            <p>Correo: <span style="font-weight: 600;"><?php echo $_SESSION['correo']; ?></span></p>
        </div>
        <!-- 
        <md-filled-tonal-icon-button href="my-notifications.php">
            <md-icon>notifications</md-icon>
        </md-filled-tonal-icon-button> -->
        <div class="button">
            <md-filled-tonal-icon-button href="my-notifications.php">
                <md-icon>notifications</md-icon>
            </md-filled-tonal-icon-button>
            <span class="button__badge"><?php print_r($_SESSION['solicitudes'])?></span>
        </div>
        <md-filled-tonal-icon-button href="profile.php">
            <md-icon>account_circle</md-icon>
        </md-filled-tonal-icon-button>
        <md-filled-tonal-icon-button href="logout.php">
            <md-icon>logout</md-icon>
        </md-filled-tonal-icon-button>
    </div>
</body>

</html>
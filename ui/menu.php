<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ioEscribo</title>
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

<body>
    <?php
    include("ui/header.php");
    ?>
    <div class="lat-menu">
        <md-filled-tonal-button href="my-documents.php">
            Mis artículos
        </md-filled-tonal-button>
        <md-filled-tonal-button href="explore.php">
            Explorar
        </md-filled-tonal-button>
        <div class="spacer"></div>
        <md-filled-tonal-button href="settings.php">
            Configuración
        </md-filled-tonal-button>
    </div>
</body>

</html>
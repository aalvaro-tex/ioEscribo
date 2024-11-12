<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ioEscribo</title>
    <link rel="icon" type="image/x-icon" href="./assets/icons/icon.png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/styles.css" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL@20..48,100..700,0..1"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL@20..48,100..700,0..1"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL@20..48,100..700,0..1"
        rel="stylesheet">
    <script src="js/service.js"></script>

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
<?php
include("ui/header.php");
include("ui/menu.php");
include("controllers/my-notifications-controller.php");
$myNotificationsController = new MyNotificationsController();
?>

<body>
    <div class="contains-page">
        <div class="page-title">
            <h1>Mis notificaciones </h1>
        </div>
        <md-tabs aria-label="Opciones" class="option-tabs">
            <md-primary-tab id="edit-requests-tab" aria-controls="edit-requests-panel"
                onclick="viewPanel('edit-requests-panel')" inline-icon>
                <md-icon slot="icon">edit</md-icon>
                Solicitudes de edición
            </md-primary-tab>
            <md-primary-tab id="other-notifications-tab" aria-controls="other-notifications-panel"
                onclick="viewPanel('other-notifications-panel')" inline-icon>
                <md-icon slot="icon">group</md-icon>
                Otras notificaciones
            </md-primary-tab>
        </md-tabs>

        <!-- contiene las solicitudes de edición que nos han realizado -->
        <div id="edit-requests-panel" role="tabpanel" aria-labelledby="edit-requests-tab">
            <div class="article-table">
                <md-list id="edit-requests-list">
                    <?php
                    $searchResult = $myNotificationsController->getNotifications();
                    foreach ($searchResult as $row):
                        ?>
                        <md-list-item>
                            El usuario <span style="font-weight:600"><?php echo $row['solicitante']; ?> </span> ha
                            solicitado editar
                            el artículo
                            <span style="font-weight:600"><?php echo $row['titulo']; ?></span>
                            <form id="request-form" method="post" slot="end">
                                <input type="hidden" name="id_solicitud" value="<?php echo $row['id']; ?>">
                                <md-filled-tonal-icon-button type="submit" name="accept-request" form="request-form"
                                    value="Aceptar">
                                    <md-icon>check_circle</md-icon>
                                </md-filled-tonal-icon-button>
                                <md-filled-tonal-icon-button type="submit" name="reject-request" form="request-form"
                                    value="Rechazar">
                                    <md-icon>cancel</md-icon>
                                </md-filled-tonal-icon-button>
                            </form>
                        </md-list-item>
                        <md-divider inset></md-divider>
                    <?php endforeach;
                    ?>
                </md-list>
            </div>
        </div>

        <!-- contiene las solicitudes que nos han acepato o rechazado a nosotros -->
        <div id="other-notifications-panel" role="tabpanel" aria-labelledby="other-notifications-tab" style="display:none;">
            <div class="article-table">
                <md-list id="other-notifications-list">
                    <?php
                    $searchResult = $myNotificationsController->getMyOtherNotifications();
                    foreach ($searchResult as $row):
                        ?>
                        <md-list-item>
                            Tu solicitid para editar el artículo <span
                                style="font-weight:600"><?php echo $row['titulo']; ?></span>
                            ha sido <span style="font-weight:600"><?php echo $row['estado']; ?></span>
                        </md-list-item>
                        <md-divider inset></md-divider>
                    <?php endforeach;
                    ?>
                </md-list>
            </div>
        </div>

    </div>
</body>

</html>
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
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
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
include("controllers/edit-permissions-controller.php");
$editPermissionsController = new EditPermissionsController();
?>

<body
    onload='loadArticleInfo(<?php echo json_encode($editPermissionsController->getArticuloById($editPermissionsController->id_articulo), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES, 1) ?>)'>

    <div class="contains-page">
        <div class="page-title">
            <h1>Gestor de permisos</h1>
        </div>
        <div class="option-buttons">
            <md-filled-tonal-button onclick="openCollabModal(<?php echo $editPermissionsController->id_articulo ?>,'')">
                <md-icon slot="icon">add</md-icon>
                Añadir colaborador
            </md-filled-tonal-button>
        </div>
        <div class="article-info">
            <md-outlined-text-field label="Título" type="text" name="titulo" disabled id="article-title" value=""
                style="width:28%;">
            </md-outlined-text-field>
            <md-outlined-text-field label="Fecha de creación" type="text" name="fecha_creacion" disabled
                id="article-date" value="" style="width:28%;">
            </md-outlined-text-field>
            <md-outlined-text-field label="Autor" type="text" name="autor" disabled id="article-author" value=""
                style="width:40%;">
            </md-outlined-text-field>
            <div class="article-info-body">
            </div>
        </div>
        <md-divider style="width:85vw;"></md-divider>
        <h3 style="width:85vw;padding-left:10px;">Colaboradores</h3>
        <md-list id="my-documents-list">
            <?php
            $menu_id = 0;
            $collabs = $editPermissionsController->getCollaborators($editPermissionsController->id_articulo);
            if ($collabs) {
                foreach ($collabs as $row):
                    $menu_id = $menu_id + 1;
                    ?>
                    <md-list-item>
                        <span style="font-weight:600"><?php echo $row['nombre']; ?> - <?php echo $row['email']; ?> </span>
                        <div class="spacer"></div>
                        <span slot="end">
                            <md-icon class="document-more-options"
                                onclick="openCollabModal(<?php echo $editPermissionsController->id_articulo ?>,'<?php echo $row['email']; ?>')"
                                id="menu-a-<?php echo $menu_id ?>">person_remove</md-icon>
                        </span>
                    </md-list-item>
                    <md-divider inset></md-divider>
                <?php endforeach;
            } ?>
    </div>
</body>

<!-- Modal para añadir un colaborador -->
<md-dialog id="add-collab-modal" style="width:800px; height:250px;">
    <div slot="headline" id="add-collab-modal-title">
    </div>

    <form id="add-collab-form" method="post" slot="content">
        <md-outlined-text-field label="Correo del colaborador" type="email" name="login-collab" id="collab-email"
            required style="width:600px"></md-outlined-text-field>
    </form>

    <div slot="actions">
        <md-text-button type="submit" name="add-collab" id="add-collab-button" form="add-collab-form"
            value="Añadir">Añadir</md-text-button>
        <md-text-button type="submit" name="delete-collab" id="delete-collab-button" form="add-collab-form"
            value="Eliminar">Eliminar</md-text-button>
        <md-text-button type="button" value="Volver" onclick="closeModal('add-collab-modal')">Volver</md-text-button>
    </div>
</md-dialog>

</html>
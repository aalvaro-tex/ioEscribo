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
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
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
  include("ui/header.php");
  include("ui/menu.php");
  include("controllers/my-documents-controller.php");
  $myDocumentsController = new MyDocumentsController();
  ?>
  <div class="contains-page">
    <div class="page-title">
      <h1>Mis artículos</h1>
    </div>
    <div class="option-buttons">
      <md-filled-tonal-button onclick="openCreateModal('Nuevo artículo')">
        <md-icon slot="icon">add</md-icon>
        Nuevo artículo
      </md-filled-tonal-button>
    </div>
    <!-- tabs con las opciones de autor y colaborador -->
    <md-tabs aria-label="Opciones" class="option-tabs">
      <md-primary-tab id="author-tab" aria-controls="author-panel" onclick="viewPanel('author-panel')" inline-icon>
        <md-icon slot="icon">person</md-icon>
        Como autor
      </md-primary-tab>
      <md-primary-tab id="collab-tab" aria-controls="collab-panel" onclick="viewPanel('collab-panel')" inline-icon>
        <md-icon slot="icon">group</md-icon>
        Como colaborador
      </md-primary-tab>
    </md-tabs>

    <!-- contiene los articulos en los que aparecemos como autor -->
    <div id="author-panel" role="tabpanel" aria-labelledby="author-tab">
      <div class="article-table">
        <md-list id="my-documents-list">
          <?php
          $menu_id = 0;
          $articles = $myDocumentsController->getAllDocumentsByRol(1);
          if ($articles->num_rows === 0): ?>
            <md-list-item>
              <md-icon slot="start">no_sim</md-icon> No se encontraron resultados
            </md-list-item>
          <?php else:
            foreach ($articles as $row):
              $menu_id = $menu_id + 1;
              ?>
              <md-list-item>
                <md-icon slot="start"><?php
                // elijo el icono en funcion del rol
                if ($row['id_rol'] == 1) {
                  echo "person";
                } else {
                  echo "group";
                }
                ?></md-icon>
                <span style="font-weight:600"><?php echo $row['titulo']; ?></span>
                <div class="spacer"></div>
                <span><?php echo $row['fecha_creacion'] ?></span>
                <span slot="end">
                  <md-icon-button type="button" onclick="showMenu(<?php echo $menu_id ?>, 'a')"
                    id="menu-a-<?php echo $menu_id ?>">
                    <md-icon>more_vert</md-icon>
                  </md-icon-button>
                </span>
              </md-list-item>
              <md-divider inset></md-divider>
              <md-menu positioning="fixed" id="usage-menu-a-<?php echo $menu_id ?>" anchor="menu-a-<?php echo $menu_id ?>">
                <!-- desplegable con las opciones según rol -->
                <?php $rol = $myDocumentsController->getRol($row['id']);
                if ($rol->id_rol == 1): ?>
                  <md-menu-item
                    onclick='doSelectOption(<?php echo json_encode($row, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES, 1) ?>,1)'>
                    <span>Ver</span>
                  </md-menu-item>
                  <md-menu-item
                    onclick='doSelectOption(<?php echo json_encode($row, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES, 1) ?>, 2)'>
                    <span>Editar</span>
                  </md-menu-item>
                  <md-menu-item
                    onclick='doSelectOption(<?php echo json_encode($row, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES, 1) ?>, 3)'>
                    <span>Eliminar</span>
                  </md-menu-item>
                  <md-menu-item>
                    <span><a href="edit-permissions.php?id_articulo=<?php echo urlencode($row['id']) ?>">Gestionar
                        permisos</a></span>
                  </md-menu-item>
                <?php endif;
                if ($rol->id_rol == 2): ?>
                  <md-menu-item
                    onclick='doSelectOption(<?php echo json_encode($row, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES, 1) ?>, 1)'>
                    <span>Ver</span>
                  </md-menu-item>
                  <md-menu-item
                    onclick='doSelectOption(<?php echo json_encode($row, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES, 1) ?>, 2)'>
                    <span>Editar</span>
                  </md-menu-item>
                <?php endif;
                if ($rol->id_rol == 3): ?>
                  <md-menu-item
                    onclick='doSelectOption(<?php echo json_encode($row, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES, 1) ?>, 1)'>
                    Ver
                  </md-menu-item>
                <?php endif; ?>
              </md-menu>
            <?php endforeach; endif ?>
        </md-list>
      </div>
    </div>


    <!-- contiene los articulos en los que aparecemos como colaborador -->
    <div id="collab-panel" role="tabpanel" aria-labelledby="collab-tab" style="display:none;">
      <div class="article-table">
        <md-list id="my-documents-list">
          <?php
          $menu_id = 0;
          $articles = $myDocumentsController->getAllDocumentsByRol(2);
          if ($articles->num_rows === 0): ?>
            <md-list-item>
              <md-icon slot="start">no_sim</md-icon> No se encontraron resultados
            </md-list-item>
          <?php else:
            foreach ($articles as $row):
              $menu_id = $menu_id + 1;
              ?>
              <md-list-item>
                <md-icon slot="start"><?php
                // elijo el icono en funcion del rol
                if ($row['id_rol'] == 1) {
                  echo "person";
                } else {
                  echo "group";
                }
                ?></md-icon>
                <span style="font-weight:600"><?php echo $row['titulo']; ?></span>
                <div class="spacer"></div>
                <span><?php echo $row['fecha_creacion'] ?></span>
                <span slot="end">
                  <md-icon-button type="button" onclick="showMenu(<?php echo $menu_id ?>, 'c')"
                    id="menu-c-<?php echo $menu_id ?>">
                    <md-icon>more_vert</md-icon>
                  </md-icon-button>
                </span>
              </md-list-item>
              <md-divider inset></md-divider>
              <md-menu positioning="fixed" id="usage-menu-c-<?php echo $menu_id ?>" anchor="menu-c-<?php echo $menu_id ?>">
                <!-- desplegable con las opciones según rol -->
                <?php $rol = $myDocumentsController->getRol($row['id']);
                if ($rol->id_rol == 1): ?>
                  <md-menu-item
                    onclick='doSelectOption(<?php echo json_encode($row, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES, 1) ?>,1)'>
                    <span>Ver</span>
                  </md-menu-item>
                  <md-menu-item
                    onclick='doSelectOption(<?php echo json_encode($row, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES, 1) ?>, 2)'>
                    <span>Editar</span>
                  </md-menu-item>
                  <md-menu-item
                    onclick='doSelectOption(<?php echo json_encode($row, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES, 1) ?>, 3)'>
                    <span>Eliminar</span>
                  </md-menu-item>
                  <md-menu-item>
                    <span href="edit-permissions.php?id_articulo=<?php echo urlencode($row['id']) ?>">Gestionar
                      permisos</span>
                  </md-menu-item>
                <?php endif;
                if ($rol->id_rol == 2): ?>
                  <md-menu-item
                    onclick='doSelectOption(<?php echo json_encode($row, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES, 1) ?>, 1)'>
                    <span>Ver</span>
                  </md-menu-item>
                  <md-menu-item
                    onclick='doSelectOption(<?php echo json_encode($row, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES, 1) ?>, 2)'>
                    <span>Editar</span>
                  </md-menu-item>
                <?php endif;
                if ($rol->id_rol == 3): ?>
                  <md-menu-item
                    onclick='doSelectOption(<?php echo json_encode($row, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES, 1) ?>, 1)'>
                    Ver
                  </md-menu-item>
                <?php endif; ?>
              </md-menu>
            <?php endforeach; endif ?>
        </md-list>
      </div>
    </div>
  </div>


</body>

<!-- MODALS -->
<!-- Modal para crear, ver y editar un articulo -->
<md-dialog id="create-modal" style="max-width:100vw; max-height:80vh">
  <div slot="headline" id="create-article-modal-title">
  </div>
  <form slot="content" id="create-document-form" method="post">
    <md-outlined-text-field label="Título" type="text" name="titulo" required style="width:90vw;" maxlength="32"
      id="article-title" value="">
    </md-outlined-text-field>
    <md-outlined-text-field type="textarea" label="Descripción" rows="2" required id="description-text-input"
      maxlength="64" name="descripcion" style="width:90vw;" value="">
    </md-outlined-text-field>
    <md-outlined-text-field type="textarea" label="Contenido" rows="5" required maxlength="500" name="contenido"
      style="width:90vw;" id="article-content" value="">
    </md-outlined-text-field>
    <md-outlined-select label="Categoría" required style="width:90vw;" name="id_categoria" id="article-category"
      value="">
      <md-select-option value="">
        <div slot="headline"></div>
      </md-select-option>
      <?php
      $categories = $myDocumentsController->getAllCategories();
      foreach ($categories as $row): ?>
        <md-select-option value="<?php echo $row['id'] ?>">
          <div slot="headline"><?php echo $row['nombre'] ?></div>
        </md-select-option>
      <?php endforeach; ?>
    </md-outlined-select>
    <input type="number" name="id_articulo" id="create-article-id">
  </form>
  <div slot="actions">
    <md-text-button form="create-document-form" type="submit" name="add-document" value="Crear"
      id="create-article-button">Crear</md-text-button>
    <md-text-button form="create-document-form" type="submit" name="update-document" value="Actualizar"
      id="update-article-button">Actualizar</md-text-button>
    <md-text-button form="create-document-form" type="button"
      onclick="closeModal('create-modal')">Volver</md-text-button>
  </div>
</md-dialog>

<!-- Modal para eliminar un articulo -->
<md-dialog id="delete-modal" style="width:800px; height:330px;">
  <div slot="headline" id="delete-article-modal-title">
  </div>
  <h4 slot="content">
    <form id="delete-document-form" method="post">
      <h4>¿Seguro que deseas eliminar el siguiente artículo?</h4>
      <input type="number" name="id_articulo" id="delete-article-id">
      <md-outlined-text-field label="Título" type="titulo" name="login" id="delete-article-title" required
        readonly></md-outlined-text-field>
    </form>
  </h4>
  <div slot="actions">
    <md-text-button type="submit" name="delete-document" id="delete-article-button" form="delete-document-form"
      value="Eliminar">Eliminar</md-text-button>
    <md-text-button type="button" value="Volver" onclick="closeModal('delete-modal')">Volver</md-text-button>
  </div>
</md-dialog>

</html>
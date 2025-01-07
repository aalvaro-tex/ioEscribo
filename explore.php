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

<body>
  <?php
  include("ui/header.php");
  include("ui/menu.php");
  include("controllers/explore-controller.php");
  $exploreController = new ExploreController();
  ?>
  <div class="contains-page">
    <div class="page-title">
      <h1>Explorar</h1>
    </div>
    <div class="search-bar">
      <form method="post" id="explore-search-form">
        <md-outlined-text-field placeholder="Buscar por nombre" style="width:60vw" minlength="3" name="titulo">
          <md-icon slot="trailing-icon">search</md-icon>
        </md-outlined-text-field>
        <md-outlined-select label="Categoría" name="id_categoria" id="article-category" value=null style="width:20vw">
          <md-select-option value="">
            <div slot="headline"></div>
          </md-select-option>
          <?php
          $categories = $exploreController->getAllCategories();
          foreach ($categories as $row): ?>
            <md-select-option value="<?php echo $row['id'] ?>">
              <div slot="headline"><?php echo $row['nombre'] ?></div>
            </md-select-option>
          <?php endforeach; ?>
        </md-outlined-select>
      </form>
      <md-filled-tonal-icon-button style="width:56px;height:56px;" aria-label="Buscar" type="submit"
        form="explore-search-form" name="search-articles" value="Buscar">
        <md-icon>search</md-icon>
      </md-filled-tonal-icon-button>
    </div>
    <div style=" width: 85vw">
      <?php if (empty($_POST["titulo"]) && empty($_POST["id_categoria"])): ?>
        <h5>Mostrando: todos</h5>
      <?php elseif (!empty($_POST["titulo"]) && empty($_POST["id_categoria"])): ?>
        <h5>Mostrando: título que contiene "<?php echo $_POST["titulo"] ?>" </h5>
      <?php elseif (empty($_POST["titulo"]) && !empty($_POST["id_categoria"])): ?>
        <h5>Mostrando: categoría <?php print ($exploreController->getCategoryName($_POST["id_categoria"])['nombre']) ?>
        </h5>
      <?php else: ?>
        <h5>Mostrando: título que contiene "<?php echo $_POST["titulo"] ?>" y categoría
          <?php echo $exploreController->getCategoryName($_POST["id_categoria"]) ?>
        </h5>
      <?php endif; ?>
    </div>
    <md-list id="search-documents-list">
      <?php
      $menu_id = 0;
      $searchResult;
      if (!empty($_POST["search-articles"])) {
        $searchResult = $exploreController->search($_POST["titulo"], $_POST["id_categoria"]);
      } else {
        $searchResult = $exploreController->search(null, null);
      }
      if (empty($searchResult)): ?>
        <md-list-item>
          <md-icon slot="start">no_sim</md-icon> No se encontraron resultados
        </md-list-item>
      <?php else:
        foreach ($searchResult as $row):
          $menu_id = $menu_id + 1;
          ?>
          <md-list-item>
            <span style="font-weight:600"><?php echo $row['titulo']; ?> </span> por <span
              style="font-weight:600"><?php echo $row['autor']; ?> </span>
            <div class="spacer"></div>
            <span><?php echo $row['fecha_creacion'] ?></span>
            <span slot="end" style="display:flex; flex-direction: row;">
              <!-- opcion: ver articulo -->
              <md-icon-button type="button"
                onclick='viewArticle(<?php echo json_encode($row, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES, 1) ?>)'
                id="menu-a-<?php echo $menu_id ?>">
                <md-icon>visibility</md-icon>
              </md-icon-button>
              <!-- opcion: solicitar permiso de edicion -->
              <!-- solo si no es el autor del articulo -->
              <?php if ($row['autor'] != $_SESSION['correo']): ?>
                <form id="request-edit-form-<?php echo $row['id'] ?>" method="post">
                  <input type="hidden" name="id_articulo" id="id_articulo" value="<?php echo $row['id'] ?>">
                  <input type="hidden" name="solicitante" id="solicitante" value="<?php echo $_SESSION['correo'] ?>">
                  <input type="hidden" name="autor" id="autor" value="<?php echo $row['autor'] ?>">
                </form>
                <md-icon-button type="submit" name="request-edit" form="request-edit-form-<?php echo $row['id'] ?>"
                  value="Solicitar">
                  <md-icon>edit</md-icon>
                </md-icon-button>
              <?php endif; ?>
              <!-- opcion: descargar articulo -->
              <form id="download-form-<?php echo $row['id'] ?>" method="post" target="_blank"
                action="./utils/pdf_article.php" enctype="multipart/form-data">
                <input type="hidden" name="titulo-descarga" id="titulo-descarga" value="<?php echo $row['titulo'] ?>">
                <input type="hidden" name="descripcion-descarga" id="descripcion-descarga"
                  value="<?php echo $row['descripcion'] ?>">
                <input type="hidden" name="contenido-descarga" id="contenido-descarga"
                  value="<?php echo $row['contenido'] ?>">
                <input type="hidden" name="fecha-descarga" id="fecha-descarga" value="<?php echo $row['fecha_creacion'] ?>">
                <input type="hidden" name="autor-descarga" id="autor-descarga" value="<?php echo $row['autor'] ?>">
                <input type="hidden" name="categoria-descarga" id="categoria-descarga"
                  value="<?php echo $row['id_categoria'] ?>">
                <input type="hidden" name="id-articulo-descarga" id="id-articulo-descarga" value="<?php echo $row['id'] ?>">
              </form>
              <md-icon-button type="submit" name="download-article" form="download-form-<?php echo $row['id'] ?>"
                value="Descargar">
                <md-icon>download</md-icon>
              </md-icon-button>
            </span>
          </md-list-item>
          <md-divider inset></md-divider>
        <?php endforeach;
      endif ?>
    </md-list>
</body>

<md-dialog id="view-modal" style="max-width:100vw; max-height:80vh">
  <div slot="headline" id="view-article-modal-title">
  </div>
  <form slot="content" id="view-document-form">
    <md-outlined-text-field label="Título" type="text" name="titulo" style="width:90vw;" maxlength="32"
      id="article-title" value="">
    </md-outlined-text-field>
    <md-outlined-text-field type="textarea" label="Descripción" rows="2" id="description-text-input" maxlength="64"
      name="descripcion" style="width:90vw;" value="">
    </md-outlined-text-field>
    <md-outlined-text-field type="textarea" label="Contenido" rows="5" maxlength="500" name="contenido"
      style="width:90vw;" id="article-content" value="">
    </md-outlined-text-field>
    <md-outlined-select label="Categoría" required style="width:90vw;" name="id_categoria" id="view-category" value="">
    </md-outlined-select>
  </form>
  <div slot="actions">
    <md-text-button form="create-document-form" type="button" onclick="closeModal('view-modal')">Volver</md-text-button>
  </div>
</md-dialog>

</html>
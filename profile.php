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
include("controllers/user-controller.php");
$userController = new UserController();
?>

<body onload='loadUserInfo(<?php echo json_encode($userController->getUserByLogin()) ?>)'>
  <div class="contains-page">
    <div class="page-title">
      <h1>Hola, <?php echo $_SESSION["nombre"]; ?> </h1>
    </div>
    <h3 style="width:85vw;padding-left:10px;">Mis datos</h3>
    <div class="user-info">
      <md-outlined-text-field label="Nombre" type="text" name="nombre" disabled id="user-name" value=""
        style="width:40%;">
      </md-outlined-text-field>
      <md-outlined-text-field label="Correo electrónico" type="text" name="email" disabled id="user-email" value=""
        style="width:60%;">
      </md-outlined-text-field>
      <!-- no se si dejar editar los datos o no --> <!--
      <md-filled-tonal-icon-button style="width:56px;height:56px;">
        <md-icon>edit</md-icon>
      </md-filled-tonal-icon-button> -->
    </div>
          <!-- no se si dejar algo de la contraseña --> <!--
    <h3 style="width:85vw;padding-left:10px;">Mi contraseña</h3>
    <div class="password-info">
      <md-outlined-text-field label="Contraseña" type="password" name="nombre" disabled id="user-pssword" value="">
      </md-outlined-text-field>
      <md-filled-tonal-icon-button style="width:56px;height:56px;" onclick="viewPassword()">
        <md-icon id="pssword-icon">visibility</md-icon>
      </md-filled-tonal-icon-button>
    </div>
    -->
    <div class="delete-account">
      <md-filled-tonal-button onclick='openDeleteAccountModal(<?php echo json_encode($userController->getUserByLogin())?>)'>
        <md-icon id="pssword-icon" slot="icon">delete</md-icon>
        Eliminar cuenta
      </md-filled-tonal-button>
    </div>
  </div>
</body>

<!-- Modal para eliminar un articulo -->
<md-dialog id="delete-account-modal" style="width:800px; height:330px;">
  <div slot="headline" id="delete-account-modal-title">
  </div>
  <h4 slot="content">
    <form id="delete-account-form" method="post">
      <h4>¿Seguro que deseas eliminar la siguiente cuenta?</h4>
    <md-outlined-text-field label="Login" type="email" name="login" id="delete-account-login"
    required readonly ></md-outlined-text-field>
    </form>
  </h4>
  <div slot="actions">
    <md-text-button type="submit" name="delete-account" id="delete-account-button" form="delete-account-form"
      value="Eliminar">Eliminar</md-text-button>
    <md-text-button type="button" value="Volver" onclick="closeModal('delete-account-modal')">Volver</md-text-button>
  </div>
</md-dialog>

</html>
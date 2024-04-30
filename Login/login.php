<?php require "db-computo.php"; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script defer src="f_Login.js"></script>
  </head>
  <body>
  <form id="FRLogin" name="FRLogin" method="post">
    <div class="container">
      <div class="content">
        <div class="header">
          <a class="logo" href="#">
            <i class="fa-solid fa-font-awesome"></i>
          </a>
        </div>
<!-- Encabezado -->
        <h1>Inicia Sesión</h1>

        <div class="email-log-in">
          <input type="text" id="userName" name="userName" placeholder="Email">
          <label for="log-in">Usuario</label>
        </div>
        <br>

        <div class="email-log-in">
          <input type="password" id="Clave" name="Clave"  placeholder="Email">
          <label for="log-in">Contraseña</label>
        </div>

        <div class="action-buttons">
          <button type="button" class="primary-button" onclick="Entrar(event)" >Ingresar</button>
        </div>

        <div id="toast-notification" class="toast">
          <span class="toast-icon">ℹ️</span>
          <span class="toast-message"></span>
        </div>
        
      </div>
    </div>
  </form>
  </body>
</html>
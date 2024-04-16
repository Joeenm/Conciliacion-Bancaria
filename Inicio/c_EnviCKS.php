<?php
include 'db-conciliacion.php';

  // Obtener los datos del formulario
  global $conn;
  $NoCheque = trim($_POST['input-numero-cheque']);
  $FechaCks = trim($_POST['fecha']);
  $Beneficiarios = trim($_POST['p-orden-a']);
  $CodBen = "SELECT * FROM proveedores WHERE nombre = '$Beneficiarios'";
  $ResulBen = $conn->query($CodBen);
  $row = $ResulBen->fetch_assoc();
  $codigoBen = $row['codigo'];
  echo json_encode($codigoBen); // Devolver la respuesta como JSON
  $Monto = trim($_POST['suma-de']);
  $Detalle = trim($_POST['DetallesCks']);
  $Objeto1 = trim($_POST['objeto-1']);
  $MontoObj = trim($_POST['monto-1']);
  $sql = mysqli_query ($conn,"   INSERT INTO cheques (`numero_cheque`, `fecha`, `beneficiario`, `monto`, `descripcion`, `fecha_anulado`, `detalle_anulado`, `fecha_circulacion`, `fecha_reintegro`, `codigo_objeto1`, `monto_objeto1`) VALUES ('$NoCheque', '$FechaCks','$codigoBen','$Monto','$Detalle', '', '', '', '', '$Objeto1', '$MontoObj')");
  echo json_encode(array('aqui funciona?'));
  echo json_encode('la insercion fue exitosa.');


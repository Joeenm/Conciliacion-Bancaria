<?php
include 'db-conciliacion.php';

  // Obtener los datos del formulario
  global $conn;
  $FECHA = trim($_POST['Fecha']);
  $TRANSAC = trim($_POST['transaccion']);
  $MONTO = trim($_POST['Monto']);
  $CodTRANSAc = "SELECT * FROM transacciones WHERE detalle = '$TRANSAC'";
  $ResulBT = $conn->query($CodTRANSAc);
  $row = $ResulBT->fetch_assoc();
  $codigoT = $row['codigo'];
  echo json_encode($codigoT); // Devolver la respuesta como JSON*/
  $sql = mysqli_query ($conn,"   INSERT INTO otros (`transaccion `, `fecha`, `monto`) VALUES ('$TRANSAC', '$FECHA','$MONTO')");
  echo json_encode(array('aqui funciona?'));
  echo json_encode('la insercion fue exitosa.');
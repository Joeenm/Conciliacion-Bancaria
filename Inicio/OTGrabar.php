<?php
include 'db-conciliacion.php';
echo json_encode('Se entro en el php.');
  // Obtener los datos del formulario
  global $conn;
  $FECHA = trim($_POST['Fecha']);
  echo json_encode($FECHA);
  $TRANSAC = trim($_POST['transaccion']);
  echo json_encode($TRANSAC);
  $MONTO = trim($_POST['Monto']);
  echo json_encode($MONTO);
  $Grabar = mysqli_query ($conn,"   INSERT INTO otros (`transaccion`, `fecha`, `monto`) VALUES ('$TRANSAC', '$FECHA','$MONTO')");
  echo json_encode(array('aqui funciona?'));
  echo json_encode('la insercion fue exitosa.');
?>
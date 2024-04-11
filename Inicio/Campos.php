<?php
include 'db-conciliacion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
      mostrarAnulación(); 
  } 
}

function mostrarAnulación(){
  //echo "<pre>";
  //print_r($_POST);
  //echo "</pre>";
  //echo "<script>console.log('la funcion sirve en php');</script>";
  
  // Trim para eliminar espacios en blanco alrededor del número de cheque
  $numero_cheque = trim($_POST['numero_cheque']);
  
  // Convertir a mayúsculas o minúsculas para evitar problemas de sensibilidad
  $numero_cheque = strtolower($numero_cheque); // Puedes usar strtolower o strtoupper según tu preferencia
  
  if (isset($numero_cheque)) {
     // echo "<script>console.log('se ha entrado en el primer if');</script>";
      global $conn;
      
      // Limpiar el número de cheque nuevamente después de la conversión de mayúsculas o minúsculas
      $numero_cheque = $conn->real_escape_string($numero_cheque);
      
      //echo "<script>console.log('El cheque es: " . $numero_cheque . "');</script>";
      $sql = "SELECT * FROM cheques WHERE numero_cheque = '$numero_cheque'";
     // echo "<script>console.log('Consulta SQL: " . $sql . "');</script>";
      $result = $conn->query($sql);
     // echo "<script>console.log('El cheque exite, el metodo post sirvio');</script>";
      if ($result->num_rows > 0) {
         // echo "<script>console.log('se ha entrado en el segundo if');</script>";
          // Mostrar o mejor dicho asignar los resultados en los campos correspondientes
          $row = $result->fetch_assoc();
          $response = array(
              'fecha' => $row['fecha'],
              'beneficiario' => $row['beneficiario'],
              'monto' => $row['monto'],
              'descripcion' => $row['descripcion']
          );
          echo json_encode($response); // Devolver la respuesta como JSON
          return; // Asegúrate de salir de la función después de enviar la respuesta
      } else {
          echo json_encode(array('error' => 'No se encontró el cheque'));
      }
  } else {
    echo json_encode(array('error' => 'No entro en el if'));
  }
}
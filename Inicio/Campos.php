<?php
include 'db-conciliacion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        mostrarAnulación(); 
    } 
}

function mostrarAnulación(){
  // Verificar si se recibió el número de cheque
  if (isset($_POST['numero_cheque'])) {
      global $conn;
      
      // Limpiar y obtener el número de cheque
      $numero_cheque = trim($_POST['numero_cheque']);
      $numero_cheque = $conn->real_escape_string($numero_cheque);
      
      // Consultar la base de datos para obtener la información del cheque
      $sql = "SELECT * FROM cheques WHERE numero_cheque = '$numero_cheque'";
      $result = $conn->query($sql);
      
      if ($result->num_rows > 0) {
          // Obtener los datos del cheque
          $row = $result->fetch_assoc();
          
          // Obtener el nombre del beneficiario
          $beneficiario = $row['beneficiario'];
          $sql_beneficiario = "SELECT nombre FROM proveedores WHERE codigo = '$beneficiario'";
          $result_beneficiario = $conn->query($sql_beneficiario);
          
          if ($result_beneficiario && $result_beneficiario->num_rows > 0) {
              $row_beneficiario = $result_beneficiario->fetch_assoc();
              $nombre_beneficiario = $row_beneficiario['nombre'];
          } else {
              // Manejar el caso en que no se pueda obtener el nombre del beneficiario
              $nombre_beneficiario = '';
          }
                  
          // Preparar la respuesta JSON
          $response = array(
              'fecha' => $row['fecha'],
              'beneficiario' => $nombre_beneficiario,
              'monto' => $row['monto'],
              'descripcion' => $row['descripcion']
          );
          // Devolver la respuesta como JSON
          echo json_encode($response);
          return;
      } else {
          // Si no se encuentra el cheque, devolver un mensaje de error
          echo json_encode(array('error' => 'No se encontró el cheque'));
      }
  } else {
      // Si no se recibió el número de cheque, devolver un mensaje de error
      echo json_encode(array('error' => 'No se proporcionó el número de cheque'));
  }
}
?>

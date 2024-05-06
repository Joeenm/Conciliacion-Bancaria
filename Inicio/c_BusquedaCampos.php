<?php
include 'db-conciliacion.php';

function mostrarAnulación(){
    // Verificar si se recibió el número de cheque y si no está vacío
    if (isset($_POST['numero_cheque']) && !empty($_POST['numero_cheque'])) {
        global $conn;
        
        // Limpiar y obtener el número de cheque
        $numero_cheque = trim($_POST['numero_cheque']);
        $numero_cheque = $conn->real_escape_string($numero_cheque);
        
        // Consultar la base de datos para verificar si el número de cheque existe
        $check_query = "SELECT COUNT(*) as count FROM cheques WHERE numero_cheque = '$numero_cheque'";
        $check_result = $conn->query($check_query);
        $check_row = $check_result->fetch_assoc();
        $cheque_exists = $check_row['count'] > 0;

        if ($cheque_exists) {
            // Si el número de cheque existe, continuar con la consulta y procesamiento
            $sql = "SELECT * FROM cheques WHERE numero_cheque = '$numero_cheque' AND fecha_anulado = '0000-00-00' AND fecha_circulacion = '0000-00-00'";
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
                
                // Preparar la respuesta como array asociativo
                $response = array(
                    'success' => 'Datos de cheque encontrado.',
                    'data' => array(
                        'fecha' => $row['fecha'],
                        'beneficiario' => $nombre_beneficiario,
                        'monto' => $row['monto'],
                        'descripcion' => $row['descripcion']
                    )
                );
                // Devolver la respuesta como JSON
                echo json_encode($response);
                return;
            } else {
                // Si no se encuentra el cheque, devolver un mensaje de error
                echo json_encode(array('error' => 'El número de cheque ya ha sido anulado o sacado de circulación.'));
            }
        } else {
            // Si el número de cheque no existe en la base de datos, devolver un mensaje de error
            echo json_encode(array('error' => 'El número de cheque no existe en la base de datos.'));
        }
    } else {
        // Si no se recibió el número de cheque o está vacío, devolver un mensaje de error
        echo json_encode(array('error' => 'No se proporcionó un número de cheque válido.'));
    }
}

mostrarAnulación();
?>
<?php
include 'db-conciliacion.php';

// Verificar si se recibieron los datos necesarios y si objeto-1 no está vacío
if (isset($_POST['numero_cheque'], $_POST['objeto-1']) && !empty($_POST['numero_cheque']) && !empty($_POST['objeto-1'])) {
    // Obtener y limpiar los datos recibidos
    $numeroCK = trim($_POST['numero_cheque']);
    $Fecha_Circulacion = trim($_POST['objeto-1']);

    // Realizar la actualización en la base de datos si objeto-1 no está vacío
    global $conn;
    $sql = mysqli_query($conn, "UPDATE cheques SET fecha_reintegro='$Fecha_Circulacion' WHERE numero_cheque='$numeroCK'");
    
    if ($sql) {
        // Si la actualización se realizó correctamente, enviar mensaje de éxito
        echo json_encode(array('success' => 'Cheque sacado de circulación con éxito'));
    } else {
        // Si hubo un error en la actualización, enviar mensaje de error
        echo json_encode(array('error' => 'Error al sacar de circulación el cheque'));
    }
} else {
    // Si no se recibieron todos los datos necesarios o objeto-1 está vacío, enviar mensaje de error
    echo json_encode(array('error' => 'Faltan datos para sacar de circulación el cheque'));
}
?>
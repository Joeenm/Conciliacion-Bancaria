<?php
include 'db-conciliacion.php';

// Verificar si se recibieron los datos necesarios y si no están vacíos
if (isset($_POST['Fecha'], $_POST['transaccion'], $_POST['Monto']) && !empty($_POST['Fecha']) && !empty($_POST['transaccion']) && !empty($_POST['Monto'])) {
    // Obtener y limpiar los datos recibidos
    $FECHA = trim($_POST['Fecha']);
    $TRANSAC = trim($_POST['transaccion']);
    $MONTO = trim($_POST['Monto']);

    // Realizar la inserción en la base de datos si los campos no están vacíos
    global $conn;
    $Grabar = mysqli_query($conn, "INSERT INTO otros (`transaccion`, `fecha`, `monto`) VALUES ('$TRANSAC', '$FECHA','$MONTO')");
    
    if ($Grabar) {
        // Si la inserción se realizó correctamente, enviar mensaje de éxito
        echo json_encode(array('success' => 'La inserción fue grabada con éxito.'));
    } else {
        // Si hubo un error en la inserción, enviar mensaje de error
        echo json_encode(array('error' => 'Error al insertar los datos.'));
    }
} else {
    // Si falta algún dato o está vacío, enviar mensaje de error
    echo json_encode(array('error' => 'Faltan datos para realizar la inserción.'));
}
?>
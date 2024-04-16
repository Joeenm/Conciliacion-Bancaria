<?php
include 'db-conciliacion.php';

global $conn;
$numeroCK = trim($_POST['numero_cheque']);
echo json_encode('Aqui verifico si existe el numero de cheque');
echo json_encode($numeroCK);
$Fecha_Circulacion = trim($_POST['objeto-1']);
$sql = mysqli_query ($conn,"UPDATE cheques SET fecha_circulacion='$Fecha_Circulacion' WHERE numero_cheque='$numeroCK'");


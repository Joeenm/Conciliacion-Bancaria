<?php
include 'db-conciliacion.php';

global $conn;
$numeroCK = trim($_POST['numero-cheque']);
echo json_encode('Aqui verifico si existe el numero de cheque');
echo json_encode($numeroCK);
$Fecha_Anulado = trim($_POST['objeto-1']);
$Detalle_Anulado = trim($_POST['Objeto-2']);
$sql = mysqli_query ($conn,"UPDATE cheques SET fecha_anulado='$Fecha_Anulado', detalle_anulado='$Detalle_Anulado' WHERE numero_cheque='$numeroCK'");


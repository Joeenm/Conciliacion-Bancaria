<?php
require "db-conciliacion.php"; 
global $conn;

$DiaA = trim($_POST['Dia-Anterior_oculto']);
$MesA = trim($_POST['Mes-Anterior_oculto']);
$AgnoA = trim($_POST['Año-Anterior_oculto']);
$Dia = trim($_POST['Dia-Actual_oculto']);
$Mes = trim($_POST['Mes-Actual_oculto']);
$Agno = trim($_POST['Año-Actual_oculto']);
$libro_1 = trim($_POST['libro_1']);
$Depósito = trim($_POST['Depósito']);
$ChequesAnulados = trim($_POST['Cheques-Anulados']);
$NotasCrédito = trim($_POST['Notas-de-Crédito']);
$Ajustes = trim($_POST['Ajustes']);
$Subtotal = trim($_POST['Subtotal']);
$SUB_TOTAL = trim($_POST['SUB_TOTAL']);
$ChequesGirados = trim($_POST['Cheques-girados']);
$NotasDébitos = trim($_POST['Notas-Débitos']);
$Ajustes2 = trim($_POST['Ajustes2']);
$Subtotal2 = trim($_POST['Subtotal2']);
$SALDO_CONCILIADO = trim($_POST['SALDO_CONCILIADO']);
$SALDO_BANCO = trim($_POST['SALDO_BANCO']);
$DepósitosTránsito = trim($_POST['Depósitos-Tránsito']);
$Cheques_en_Circulación = trim($_POST['Cheques_en_Circulación']);
$Ajustes3 = trim($_POST['Ajustes3']);
$Subtotal3 = trim($_POST['Subtotal3']);
$SaldoT = trim($_POST['SaldoT']);

$sql_insert= "INSERT INTO `conciliacion`(`dia`, `mes`, `agno`, `dia_anterior`, `mes_anterior`, `agno_anterior`, `saldo_anterior`, `masdepositos`, `maschequesanulados`, `masnotascredito`, `masajusteslibro`, `sub1`, `subtotal1`, `menoschequesgirados`, `menosnotasdebito`, `menosajusteslibro`, `sub2`, `saldolibros`, `saldobanco`, `masdepositostransito`, `menoschequescirculacion`, `masajustesbanco`, `sub3`, `saldo_conciliado`) 
VALUES ('$Dia','$Mes','$Agno','$DiaA','$MesA','$AgnoA','$libro_1','$Depósito','$ChequesAnulados','$NotasCrédito','$Ajustes','$Subtotal','$SUB_TOTAL','$ChequesGirados','$NotasDébitos','$Ajustes2','$Subtotal2','$SALDO_CONCILIADO','$SALDO_BANCO','$DepósitosTránsito','$Cheques_en_Circulación','$Ajustes3','$Subtotal3','$SaldoT')";

if ($conn->query($sql_insert) === TRUE) {
    // La inserción fue exitosa
    echo json_encode(array('success' => 'La inserción fue exitosa.'));
} else {
    // Error al insertar en la base de datos
    echo json_encode(array('error' => 'Error al insertar en la base de datos.'));
}
<?php
require "db-conciliacion.php"; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        TotalConciliacion(); 
    } 
}

function TotalConciliacion(){
    if (isset($_POST['SALDO_BANCO'])) {
        global $conn;
        $SALDO_BANCO = floatval($_POST['SALDO_BANCO']);
        $Subtotal3 = floatval($_POST['Subtotal3']);
        
        $Total= ($SALDO_BANCO - $Subtotal3);
        $Total = number_format($Total, 2, '.', '');
        
        $response = array(
        'Total'=> $Total,
        );
    echo json_encode(array('La suma en total es' => $response ));
    }
}


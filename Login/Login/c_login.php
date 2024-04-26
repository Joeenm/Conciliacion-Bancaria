<?php
require "db-computo.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        HacerLogin(); 
    } 
}

function HacerLogin(){
    if (isset($_POST['userName']) && isset($_POST['Clave'])){
        global $conecction;
        $userName = trim($_POST['userName']);
        $Clave = trim($_POST['Clave']);
        $sql= "SELECT * FROM usuarios WHERE Usuario = '$userName' and Contraseña = '$Clave' ";
        $result = $conecction->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc(); // Obtener el primer registro
            $response = array(
                'usuario' => $row['Usuario'],
                'contra' => $row['Contraseña'],
            );
            echo json_encode($response);
        } else {
            echo json_encode(array('error' => 'El usuario y/o contraseña son incorrectos'));
        }
    }else{
        echo json_encode(array('error' => 'No se recibieron datos del formulario'));
    }
}

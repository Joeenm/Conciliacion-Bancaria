<?php
require "db-conciliacion.php"; 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        MostrarConciliacion(); 
    } 
}

function MostrarConciliacion(){
    if (isset($_POST['Selectmes']) && isset($_POST['age'])){
        global $conn;
        //echo json_encode(array('error' =>'entramos en php'));  //
        $C_Mes = trim($_POST['Selectmes']);
        $C_Mes = $conn->real_escape_string($C_Mes);
        $sql= "SELECT * FROM meses WHERE nombre_mes = '$C_Mes' ";
        $resultm = $conn->query($sql);
        $C_agno = trim($_POST['age']);

        if ($resultm->num_rows > 0) {
            // Obtener los datos del cheque
           // echo json_encode(array('error' =>'entramos en el if de mes')); //
            $rowm = $resultm->fetch_assoc();
            $Mes = $rowm['mes'];
            //echo json_encode($Mes); //
        }else{
          echo json_encode(array('error' => 'No se entró en el if del mes'));
        }  

    if($C_agno <= 2022 && $Mes <=11 ){  
        echo json_encode(array('error' =>'Fuera de año fiscal'));   
    } else {
        $sql = "SELECT * FROM conciliacion WHERE mes = '$Mes' and agno ='$C_agno' ";
        //echo json_encode($sql);//
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo json_encode(array('error' => 'Ya se concilio este Mes'));
            echo json_encode(array('error' => $Mes ));
          }else {
            if ($Mes == 1) {
                // Si el mes seleccionado es enero (01), el mes anterior es diciembre (12)
                $MesA = '12';
                // Si el mes seleccionado es enero, también necesitas obtener el año anterior
                $AgnoA = strval(intval($C_agno) - 1);
            } else {
                // Para otros meses, simplemente resta 1 al mes seleccionado
                $MesA = str_pad($Mes - 1, 2, '0', STR_PAD_LEFT); 
                // El año del mes anterior es el mismo que el año seleccionado
                $AgnoA = $C_agno;
            }
            $sql = "SELECT * FROM conciliacion WHERE mes = '$MesA' and agno ='$AgnoA' ";
            //echo json_encode($sql);//
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                echo json_encode(array('error' => 'aqui se puede trabajar la nueva conciliacion'));
            }else{
                echo json_encode(array('error' => 'El mes anterior no ha sido conciliado'));
            }
                  
        }
    }
        echo json_encode(array('error' =>'Antes del if en PHP'));
    }
}


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
        
      if ($resultm->num_rows > 0) {
          // Obtener los datos del cheque
         // echo json_encode(array('error' =>'entramos en el if de mes')); //
          $rowm = $resultm->fetch_assoc();
          $Mes = $rowm['mes'];
          //echo json_encode($Mes); //
      }else{
        echo json_encode(array('error' => 'No se entró en el if del mes'));
      }  

        $C_agno = trim($_POST['age']);
        $C_agno = $conn->real_escape_string($C_agno);
        $MesAnterior = $Mes-1;
        $sql = "SELECT * FROM conciliacion WHERE mes = '$Mes' and agno ='$C_agno' ";
        //echo json_encode($sql);//
        $result = $conn->query($sql);
        //echo json_encode(array('error' => 'a punto de entrar en el if de conciliacion php')); //
        if ($result->num_rows > 0) {
            // Obtener los datos del cheque
           // echo json_encode($result); //
         //   echo json_encode(array('error' => 'entramos en conciliacion php')); //
            $row = $result->fetch_assoc();
            $dia = $row['dia'];
            $dia_anterior=$row['dia_anterior'];
            $mes_anterior = $row['mes_anterior'];
            $agno_anterior = $row['agno_anterior'];

            $sqlM= "SELECT * FROM meses WHERE mes = '$mes_anterior' ";
                    $resultME = $conn->query($sqlM);
                if ($resultME->num_rows > 0) {
                    $row2 = $resultME->fetch_assoc();
                    $mes_anterior1 = $row2['nombre_mes'];
                    
                }else{
                    echo json_encode(array('error' => 'No se entró en el if del mes anterior'));
                }  
            $Saldo_Anterior = $row['saldo_anterior'];
            $masdepositos = $row['masdepositos'];
            $maschequesanulados = $row['maschequesanulados'];
            $masnotascredito = $row['masnotascredito'];
            $masajusteslibro = $row['masajusteslibro'];
            $sub1 = $row['sub1'];
            $subtotal1 = $row['subtotal1'];
            //
            $menoschequesgirados = $row['menoschequesgirados'];
            $menosnotasdebito = $row['menosnotasdebito'];
            $menosajusteslibro = $row['menosajusteslibro'];
            $sub2 = $row['sub2'];
            $saldolibros = $row['saldolibros'];
            //
            $saldobanco = $row['saldobanco'];
            $masdepositostransito = $row['masdepositostransito'];
            $menoschequescirculacion = $row['menoschequescirculacion'];
            $masajustesbanco = $row['masajustesbanco'];
            $sub3 = $row['sub3'];
            //
            $saldo_conciliado = $row['saldo_conciliado'];
            $mes_anterior1 = strtoupper($mes_anterior1);
            $C_Mes = strtoupper($C_Mes);
            $Libro_Pasado = $dia_anterior. " DE " . $mes_anterior1 . " DE " . $agno_anterior;
            $LibroActual = $dia . " DE ". $C_Mes . " DE " . $C_agno;
            $response = array(
                'Libro_Pasado' => $Libro_Pasado,
                'LibroActual' => $LibroActual,
                'saldo_anterior'=> $Saldo_Anterior,
                'masdepositos'=> $masdepositos,
                'maschequesanulados' => $maschequesanulados,
                'masnotascredito' => $masnotascredito,
                'masajusteslibro' => $masajusteslibro,
                'sub1' => $sub1,
                'subtotal1' => $subtotal1,
                'menoschequesgirados' => $menoschequesgirados,
                'menosnotasdebito' => $menosnotasdebito,
                'menosajusteslibro' => $menosajusteslibro,
                'sub2' => $sub2,
                'saldolibros' => $saldolibros,
                'saldobanco' => $saldobanco,
                'masdepositostransito' => $masdepositostransito,
                'menoschequescirculacion' => $menoschequescirculacion,
                'masajustesbanco' => $masajustesbanco,
                'sub3' => $sub3,
                'saldo_conciliado' => $saldo_conciliado
            );
            
            echo json_encode($response);
        }else{
            // Obtener la fecha del primer día del mes anterior
            $fechaAnterior = date("Y-m-d", strtotime("$C_agno-$Mes-01 -1 month"));

            // Obtener el último día del mes anterior
            $ultimoDiaAnterior = date("t", strtotime($fechaAnterior));

            // Obtener el nombre del mes anterior
            $nombreMesAnterior = date("F", strtotime($fechaAnterior));
            echo json_encode(array('error' => 'No se encontraron los datos en la BD'));
        }

    }else{
       echo json_encode(array('error' =>'antes del if en php'));
    }
}
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
        $C_Mes = trim($_POST['Selectmes']);
        $C_Mes = $conn->real_escape_string($C_Mes);
        $sql= "SELECT * FROM meses WHERE nombre_mes = '$C_Mes' ";
        $resultm = $conn->query($sql);
        $C_agno = trim($_POST['age']);

        if ($resultm->num_rows > 0) {
            $rowm = $resultm->fetch_assoc();
            $Mes = $rowm['mes'];
        }else{
          echo json_encode(array('error' => 'No se entró en el if del mes'));
        }  

    if($C_agno <= 2022 && $Mes <=12 ){  
        echo json_encode(array('error' =>'Fuera de año fiscal'));   
    } else {
        $sql = "SELECT * FROM conciliacion WHERE mes = '$Mes' and agno ='$C_agno' ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo json_encode(array('error' => 'Ya se concilio este Mes'));
          }else {
            if ($Mes == 1) {
                // Si el mes seleccionado es enero (01), el mes anterior es diciembre (12)
                $MesA = '12';
                // Si el mes seleccionado es enero, hay que obtener el año anterior
                $AgnoA = strval(intval($C_agno) - 1);
            } else {
                // Para otros meses, resta 1 al mes seleccionado
                $MesA = str_pad($Mes - 1, 2, '0', STR_PAD_LEFT); 
                // El año del mes anterior es el mismo que el año seleccionado
                $AgnoA = $C_agno;
            }
            $sqlMesAnterior= "SELECT * FROM meses WHERE mes = '$MesA'";
            $resultMA = $conn->query($sqlMesAnterior);
            if ($resultMA->num_rows > 0) {
                $rowA = $resultMA->fetch_assoc();
                $MesAnterior = $rowA['nombre_mes'];
            }else{
                echo json_encode(array('error' => 'No se entró en el if del mes anterior'));
            }  
            $sql = "SELECT * FROM conciliacion WHERE mes = '$MesA' and agno ='$AgnoA' ";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                $row1= $result->fetch_assoc();
                $dayA= $row1['dia'];    //Dia anterior
                $MesA = $row1['mes'];   //Mes anterior
                //el año del mes anterior es $AgnoA
                $Saldo_Anterior = $row1['saldo_conciliado'];
                $MesAnterior = strtoupper($MesAnterior);
                $C_Mes = strtoupper($C_Mes);
                $DiaActual = date('t', strtotime("$C_agno-$Mes-01")); 
                $Libro_Pasado = $dayA. " DE " . $MesAnterior . " DE " . $AgnoA;
                $LibroActual = $DiaActual . " DE ". $C_Mes . " DE " . $C_agno;

                //consulta para otros                
                $sql2 = "SELECT transaccion, SUM(monto) AS total_monto 
                    FROM otros 
                    WHERE MONTH(fecha) = '$Mes' and  Year(fecha) ='$C_agno'
                    GROUP BY transaccion"; 
                $resultado = $conn->query($sql2);
                // Verificar si la consulta fue exitosa
                if ($resultado) {
                    // Inicializar un array para almacenar los totales de montos por transacción
                    $transacciones = array(1, 2, 3, 4, 5, 6, 7, 8, 9);

                    // Inicializar todos los totales por transacción con 0
                    foreach ($transacciones as $transaccion) {
                        $totales_por_transaccion[$transaccion] = 0;
                    }

                    // Recorrer los resultados de la consulta
                    while ($fila = $resultado->fetch_assoc()) {
                        // Obtener el código de transacción y el total de montos
                        $transaccion = $fila['transaccion'];
                        $total_monto = $fila['total_monto'];
                        // Asignar los totales al array correspondiente
                        $totales_por_transaccion[$transaccion] = $total_monto;                      
                    }
                    $masdepositos = $totales_por_transaccion[1];
                    $masnotascredito = $totales_por_transaccion[2];
                    $masajusteslibro = $totales_por_transaccion[3];
                    $menosnotasdebito = $totales_por_transaccion[4];
                    $menosajusteslibro = $totales_por_transaccion[5];
                    $masdepositostransito = $totales_por_transaccion[6];
                    $masajustesbanco = $totales_por_transaccion[7];
                } else { 
                    // Manejar errores si la consulta falla
                    echo json_encode(array('error en Otros'. $conn->error));
                } //Aqui termina el if de Monstos de Transacciones

                // Obtener datos de Cheques Anulados
                $sql3 = "SELECT SUM(monto) AS total_Anulado 
                FROM cheques 
                WHERE MONTH(fecha_anulado) = '$Mes' AND YEAR(fecha_anulado) ='$C_agno'"; 
                $resultado2 = $conn->query($sql3);
                if ($resultado2) {
                    $Anulados = $resultado2->fetch_assoc();
                    $total_Anulados = $Anulados['total_Anulado'];
                    if($total_Anulados == null) {
                        $total_Anulados = 0; 
                    }
                } else {
                    echo json_encode(array('error_en_Cheques_Anulados' => $conn->error));
                }//aqui termina el if de cheques anulados
                
                // Obtener datos cheques Girados/creados
                $sql4 = "SELECT SUM(monto) AS total_Girados
                    FROM cheques 
                    WHERE MONTH(fecha) = '$Mes' and  Year(fecha) ='$C_agno' and fecha_reintegro = '0000-00-00' and fecha_Anulado='0000-00-00' and fecha_circulacion = '0000-00-00' "; 
                $resultado3 = $conn->query($sql4);
                if ($resultado3) {
                    $Girados = $resultado3->fetch_assoc();
                    $total_Girados = $Girados['total_Girados'];
                    if($total_Girados == null){
                       $total_Girados = 0; 
                    }  
                }else{
                    echo json_encode(array('error en Cheques Girados'. $conn->error));
                }//aqui termina el if de cheque creados

                //obtener los datos de cheques en circulacion
                $sql5 = "SELECT SUM(monto) AS total_Circulacion
                FROM cheques 
                WHERE MONTH(fecha) = '$Mes' AND YEAR(fecha) ='$C_agno' AND fecha_reintegro = '0000-00-00' AND fecha_Anulado = '0000-00-00' AND fecha_circulacion != '0000-00-00'";
                $resultado4 = $conn->query($sql5);
                if ($resultado4) {
                    $Circulacion = $resultado4->fetch_assoc();
                    $total_Circulacion = $Circulacion['total_Circulacion'];
                    if($total_Circulacion == null){
                       $total_Circulacion = 0; 
                    }   
                }else{
                    echo json_encode(array('error en Cheques en Circulacion'. $conn->error));
                }//aqui acaba el if de cheques en circulacion
                
                //operaciones de Sumas

                $sub1 = ($masdepositos +$total_Anulados + $masnotascredito + $masajusteslibro);
                $subtotal1 = $Saldo_Anterior + $sub1;
                $sub2 = ($total_Girados + $menosnotasdebito + $menosajusteslibro);
                $saldolibros = $subtotal1 - $sub2;
                $sub3 = ($masdepositostransito - $total_Circulacion + $masajustesbanco) ;

                $sub1 = number_format($sub1, 2, '.', '');
                $subtotal1 = number_format($subtotal1, 2, '.', '');
                $sub2 = number_format($sub2, 2, '.', '');
                $saldolibros = number_format($saldolibros, 2, '.', '');
                $sub3 = number_format($sub3, 2, '.', '');
                $Sub3Val = $sub3; 
                if($sub3<0){
                    $sub3 = "(" . $sub3 . ")";
                }

                $response = array(
                    'DayA' => $dayA,
                    'MesA'=> $MesA,
                    'AgnoA'=> $AgnoA,
                    'Dia' => $DiaActual,
                    'Mes' => $Mes,
                    'Agno' => $C_agno,
                    'Libro_Pasado' => $Libro_Pasado,//Si
                    'LibroActual' => $LibroActual,//si
                    'saldo_anterior'=> $Saldo_Anterior,//si
                    'masdepositos'=> $masdepositos,//si
                    'maschequesanulados' => $total_Anulados,//si
                    'masnotascredito' => $masnotascredito,//si
                    'masajusteslibro' => $masajusteslibro,//si
                    'sub1' => $sub1,//si
                    'subtotal1' => $subtotal1,//si
                    'menoschequesgirados' => $total_Girados,//si
                    'menosnotasdebito' => $menosnotasdebito,//si
                    'menosajusteslibro' => $menosajusteslibro,//si
                    'sub2' => $sub2,//si
                    'saldolibros' => $saldolibros,//si
                    //'saldobanco' => $saldobanco,//esto no va
                    'masdepositostransito' => $masdepositostransito,//si
                    'menoschequescirculacion' => $total_Circulacion,//si
                    'masajustesbanco' => $masajustesbanco,//si
                    'sub3' => $sub3,//si
                    'sub3V' => $Sub3Val,
                    //'saldo_conciliado' => $saldo_conciliado// no va
                );
                echo json_encode(array('La respuesta es' => $response ));
            }else{
                echo json_encode(array('error' => 'El mes anterior no ha sido conciliado'));
            }
                  
        }
    }
    }
}


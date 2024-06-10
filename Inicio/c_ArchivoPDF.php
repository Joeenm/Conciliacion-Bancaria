<?php 
ob_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require "db-conciliacion.php";
require_once('../TCPDF/tcpdf.php');
header('Content-Type: application/json');
$response = array();
$Name = trim($_POST['Nombre']);
list($nombre, $apellido) = explode(' ', $Name, 2);

$F1 = trim($_POST['Fecha1']);
$F2 = trim($_POST['Fecha2']);
$start_date = strval($F1);
$End_date = strval($F2);
$verifRuta = 0;
$sql = "SELECT * FROM rrhh WHERE nombre1 = '$nombre' AND apellido1 = '$apellido'";
$resultm = $conn->query($sql);
if ($resultm->num_rows > 0) {
    $rows = $resultm->fetch_assoc();
    $Cod = $rows['codigo_marcacion'];
    if($start_date == $End_date){
        $sql = "SELECT fecha, DATE_FORMAT(fecha, '%W') AS dia,
        MIN(hora) AS hora_entrada,
        MAX(hora) AS hora_salida
        FROM datos
        WHERE codigo = '$Cod'
        AND fecha = '$start_date'
        GROUP BY fecha, DATE_FORMAT(fecha, '%W')
        ORDER BY fecha ASC;";
        $verifRuta = 1;
    } else {
        $sql = "SELECT entrada.fecha, DATE_FORMAT(entrada.fecha, '%W') AS dia, MIN(entrada.hora) AS hora_entrada,
        MAX(salida.hora) AS hora_salida FROM datos entrada INNER JOIN datos salida ON entrada.codigo = salida.codigo 
        AND entrada.fecha = salida.fecha WHERE entrada.hora < salida.hora AND entrada.codigo = '$Cod' 
        AND entrada.fecha BETWEEN '$F1' AND '$F2' GROUP BY entrada.fecha, DATE_FORMAT(entrada.fecha, '%W')
        ORDER BY entrada.fecha ASC;"; 
    }
    
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // Mapeo de días de la semana en inglés a español
        $dias_espanol = [
            'Monday'    => 'Lun.',
            'Tuesday'   => 'Mar.',
            'Wednesday' => 'Mie.',
            'Thursday'  => 'Jue.',
            'Friday'    => 'Vie.',
            'Saturday'  => 'Sáb.',
            'Sunday'    => 'Dom.'
        ];

        $resultados = []; 
        while ($row = $result->fetch_assoc()) {
            // Traducir el día de la semana al español
            $dia_espanol = $dias_espanol[$row['dia']];
            // Agregar los datos al array de resultados
            $resultados[] = [
                'fecha' => DateTime::createFromFormat('Y-m-d', $row['fecha'])->format('d-m-Y'),
                'dia' => $dia_espanol,
                'hora_entrada' => $row['hora_entrada'],
                'hora_salida' => $row['hora_salida']
            ];
        }
        if($verifRuta != 1){// verificar en caso que sea una busqueda por rango
            $keys = array_keys($resultados);
            $completos = [];

            for ($i = 0; $i < count($keys); $i++) {
                $currentDate = DateTime::createFromFormat('d-m-Y', $resultados[$keys[$i]]['fecha']);
                if ($currentDate === false) {
                    continue; // Saltar si no es una fecha válida
                }

                $currentDayOfWeek = $currentDate->format('l');

                // Agregar registro actual
                $completos[] = $resultados[$keys[$i]];

                // Si no es el último registro, comprobar días intermedios
                if ($i < count($keys) - 1) {
                    $nextDate = DateTime::createFromFormat('d-m-Y', $resultados[$keys[$i + 1]]['fecha']);
                    $interval = new DateInterval('P1D');
                    $daysWithoutRecords = 0;

                    while ($currentDate->add($interval) < $nextDate) {
                        $daysWithoutRecords++;
                        if ($daysWithoutRecords > 6) {
                            break; // Saltar al próximo registro si hay más de una semana sin registros
                        }
                        $currentDayOfWeek = $currentDate->format('l');
                        $completos[] = [
                            'fecha' => $currentDate->format('d-m-Y'),
                            'dia' => $dias_espanol[$currentDayOfWeek],
                            'hora_entrada' => '',
                            'hora_salida' => ''
                        ];
                    }
                }
            }
        }else{// en caso de que sea una busque da un solo dia 
            $completos = [];
            $completos = $resultados;
        }
        ob_end_clean();

        class CustomPDF extends TCPDF {
            public $header_title = '';
            
            // Custom Header
            public function Header() {
                if (!empty($this->header_title)) {
                    // Establecer posición horizontal al centro
                    $this->SetX($this->original_lMargin);
                    // Ajustar Y para centrar verticalmente
                    $this->SetY(15);
                    $this->SetFont('dejavusans', 'B', 12);
                    $this->Cell(0, 15, $this->header_title, 0, 1, 'C'); // Centrar el texto
                }
            }
        }

        // Crear nuevo PDF
        $pdf = new CustomPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Establecer información del documento
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Raúl Arcia');
        $pdf->SetTitle('Reporte de Marcaciones');
        $pdf->SetSubject('Reporte');
        $pdf->SetKeywords('TCPDF, PDF, reporte, marcaciones');

        // Establecer cabecera y pie de página
        $pdf->SetHeaderData('Logo.png', 100, 'QA Insurance - Reporte de Marcaciones de ' . $Name, '');
        $pdf->setFooterData(array(0,64,0), array(0,64,128));

        // Establecer fuente para cabecera y pie de página
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // Establecer fuente predeterminada
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // Establecer márgenes
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // Establecer saltos de página automáticos
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // Establecer relación de escala de la imagen
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // Establecer fuente
        $pdf->SetFont('dejavusans', '', 10);

        // Añadir una página
        $pdf->AddPage();

        // Crear tabla HTML
        $html = '<table border="0" cellpadding="5">
            <thead>
                <tr>
                    <th style="border-top: 1px dashed  #000; border-bottom: 1px dashed  #000;">Fecha</th>
                    <th style="border-top: 1px dashed  #000; border-bottom: 1px dashed  #000;">Día</th>
                    <th style="border-top: 1px dashed  #000; border-bottom: 1px dashed  #000;">Hora de Entrada</th>
                    <th style="border-top: 1px dashed  #000; border-bottom: 1px dashed  #000;">Hora de Salida</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($completos as $fila) {
            $html .= '<tr>
                <td>' . $fila['fecha'] . '</td>
                <td>' . $fila['dia'] . '</td>
                <td>' . $fila['hora_entrada'] . '</td>
                <td>' . $fila['hora_salida'] . '</td>
            </tr>';
        }

        $html .= '</tbody></table>';

        // Imprimir texto usando writeHTMLCell()
        $pdf->writeHTML($html, true, false, true, false, '');

        // Cerrar y mostrar el PDF
        $pdfFileName = 'reporte_marcaciones.pdf';
        $projectDir = realpath(__DIR__ . '/..'); // Obtiene la ruta absoluta al directorio principal del proyecto
        $pdfFilePath = $projectDir . '/Inicio/' . $pdfFileName; // Ruta absoluta al archivo PDF
        $pdf->Output($pdfFilePath, 'F');
        
        $response['success'] = true;
        $response['pdf_url'] = $pdfFileName;
    } else {
        $response['success'] = false;
        $response['error'] = 'No se encontro registro de marcacion para estas fechas';
    }
} else {
    $response['success'] = false;
    $response['error'] = 'No existe registro de Marcacion de esta persona';
}
header('Content-Type: application/json');
echo json_encode($response);
?>

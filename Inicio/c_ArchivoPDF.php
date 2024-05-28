<?php 
ob_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require "db-conciliacion.php";
require_once('C:/Users/arcia/OneDrive/Escritorio/Ejemplos/Proyecto-I/TCPDF/tcpdf.php');
header('Content-Type: application/json');
$response = array();
$Name = trim($_POST['Nombre']);
/*$nameParts = explode(' ', $Name);
$Name1 = $nameParts[0]; // Nombre
$Name2 = $nameParts[1]; // Apellido */
$F1 = trim($_POST['Fecha1']);
$F1 = trim($_POST['Fecha2']);

$sql = "SELECT * FROM rrhh WHERE nombre1 = '$Name'";
$resultm = $conn->query($sql);
if ($resultm->num_rows > 0) {
    $rows = $resultm->fetch_assoc();
    $Cod = $rows['codigo_marcacion'];
    $sql = "SELECT entrada.fecha, DATE_FORMAT(entrada.fecha, '%W') AS dia, entrada.hora AS hora_entrada, salida.hora AS hora_salida
            FROM datos entrada INNER JOIN datos salida ON entrada.codigo = salida.codigo AND entrada.fecha = salida.fecha
            WHERE entrada.hora < salida.hora AND entrada.codigo = '$Cod' ORDER BY entrada.fecha ASC, entrada.hora ASC;";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Mapeo de días de la semana en inglés a español
        $dias_espanol = [
            'Monday'    => 'Lunes',
            'Tuesday'   => 'Martes',
            'Wednesday' => 'Miércoles',
            'Thursday'  => 'Jueves',
            'Friday'    => 'Viernes',
            'Saturday'  => 'Sábado',
            'Sunday'    => 'Domingo'
        ];
           // Traducir el día de la semana al español
        $dia_espanol = $dias_espanol[$row['dia']];
        $resultados = []; 
        while ($row = mysqli_fetch_assoc($result)) {
            // Traducir el día de la semana al español
            $dia_espanol = $dias_espanol[$row['dia']];
            // Agregar los datos al array de resultados
            $resultados[] = [
                'fecha' => $row['fecha'],
                'dia' => $dia_espanol,
                'hora_entrada' => $row['hora_entrada'],
                'hora_salida' => $row['hora_salida']
            ];
        }
        ob_end_clean();
    // Crear nuevo PDF
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Establecer información del documento
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Raúl Arcia');
    $pdf->SetTitle('Reporte de Marcaciones');
    $pdf->SetSubject('Reporte');
    $pdf->SetKeywords('TCPDF, PDF, reporte, marcaciones');

    // Establecer cabecera y pie de página
    $pdf->setHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
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

    // Título del PDF
    $pdf->Write(0, 'Reporte de Marcaciones', '', 0, 'C', true, 0, false, false, 0);

    // Crear tabla HTML
    $html = '<table border="1" cellpadding="4">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Día</th>
                <th>Hora de Entrada</th>
                <th>Hora de Salida</th>
            </tr>
        </thead>
        <tbody>';

    foreach ($resultados as $fila) {
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
        $response['error'] = 'NO existe registro de Marcacion de esta persona';
    }
}else {
    $response['success'] = false;
    $response['error'] = 'Error en la consulta';
}
header('Content-Type: application/json');
echo json_encode($response);
?>
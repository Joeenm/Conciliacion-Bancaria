<?php
// Incluir TCPDF usando la ruta absoluta
require_once('C:/Users/arcia/OneDrive/Escritorio/Ejemplos/Proyecto-I/TCPDF/tcpdf.php');
require "db-conciliacion.php"; 
// Conexión a la base de datos
// Código predefinido
$Cod = 7; // Valor predefinido para el código
$Name = "Raul Arcia";
$sql = "SELECT
    entrada.fecha,
    DATE_FORMAT(entrada.fecha, '%W') AS dia,
    entrada.hora AS hora_entrada,
    salida.hora AS hora_salida
FROM
    datos entrada
    INNER JOIN datos salida ON entrada.codigo = salida.codigo AND entrada.fecha = salida.fecha
WHERE
    entrada.hora < salida.hora
    AND entrada.codigo = '$Cod'
ORDER BY
    entrada.fecha ASC, entrada.hora ASC";

// Ejecutar la consulta
$result = $conn->query($sql);

if ($result) {
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

    // Array para almacenar los resultados
    $resultados = [];

    while ($row = $result->fetch_assoc()) {
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
} else {
    die("Error en la consulta: " . $conn->error);
}

// Crear nuevo PDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Establecer información del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Raúl Arcia');
$pdf->SetTitle('Reporte de Marcaciones');
$pdf->SetSubject('Reporte');
$pdf->SetKeywords('TCPDF, PDF, reporte, marcaciones');

// Establecer cabecera y pie de página
$pdf->setHeaderData('background.jpeg', 100, 'QA Insurance', 'Reporte de Marcaciones');
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
$pdf->Write(10, 'Marcaciones de '.$Name, '', 0, 'C', true, 0, false, false, 0);

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
$pdf->Output('reporte_marcaciones.pdf', 'I');

// Cerrar conexión
$conn->close();

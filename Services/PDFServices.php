<?php
// services/PDFService.php
require_once __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;

class PDFService
{
    public static function generatePDF(array $questions, array $respuestas, array $data, string $outputPath = null): string
    {
        if ($outputPath === null) {
            $outputPath = '../Public/File/formulario_' . time() . '.pdf';
        }

        // Convertir logo.svg a base64
        $logoPath = realpath(__DIR__ . '/../Public/logo.svg');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoPath = realpath(__DIR__ . '/../Public/logo.png');
            $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }

        // HTML del PDF
        $html = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        :root {
              --primary: #2e4396;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid var(--primary);
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
        .header img {
            height: 60px;
        }
        .header h2 {
            margin: 5px 0 0;
            color: var(--primary);
        }
        .client-data {
            background-color: #f5f5f5;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        .client-data p {
            margin: 5px 0;
        }
        .question {
            margin-bottom: 20px;
        }
        .question strong {
            display: block;
            margin-bottom: 5px;
            color: var(--primary);
        }
        hr {
            border: none;
            border-top: 1px solid #ccc;
            margin: 20px 0;
        }
    </style>
</head>
<body>

<div class="header">';

        if ($logoBase64) {
            $html .= '<img src="' . $logoBase64 . '" alt="Logo">';
        } else {
            $html .= '<p>[Logo no disponible]</p>';
        }

        $html .= '
</div>

<h1 style="text-align: center;">Respuestas del Formulario</h1>

<div class="client-data">
    <p><strong>Cliente:</strong> ' . htmlspecialchars($data['name']) . '</p>
    <p><strong>Contacto:</strong> ' . htmlspecialchars($data['client_phone']) . '</p>
    <p><strong>Dirección:</strong> ' . htmlspecialchars($data['address']) . '</p>
</div>
';

        // Preguntas y respuestas
        foreach ($questions as $question) {
            $pid = $question['option_id'];
            $texto = htmlspecialchars($question['name']);
            $respuesta = $respuestas["question_$pid"] ?? 'Sin responder';
            $respuesta = nl2br(htmlspecialchars($respuesta));

            $html .= "
            <div class='question'>
                <strong>$texto</strong>
                <div>$respuesta</div>
            </div>
            <hr>";
        }

        $html .= '
</body>
</html>';

        // Generar PDF
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        file_put_contents($outputPath, $dompdf->output());

        return $outputPath;
    }
}
?>
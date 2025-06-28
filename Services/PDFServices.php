<?php
// services/PDFService.php
require_once __DIR__ . '/../vendor/autoload.php'; ;

use Dompdf\Dompdf;
use Dompdf\Options;

class PDFService
{
    public static function generatePDF(array $questions, array $respuestas, string $outputPath = null): string
    {
        if ($outputPath === null) {
            $outputPath = '../Public/File/formulario_' . time() . '.pdf';
        }

        $html = '<h1 style="text-align: center;">Respuestas del formulario</h1><br><br>';

        foreach ($questions as $question) {
            $pid = $question['option_id'];
            $texto = htmlspecialchars($question['name']);
            $respuesta = $respuestas["question_$pid"] ?? 'Sin responder';
            $respuesta = nl2br(htmlspecialchars($respuesta));

            $html .= "<p><strong>$texto</strong><br>$respuesta</p><hr>";
        }

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        file_put_contents($outputPath, $dompdf->output());

        return $outputPath;
    }
}

?>
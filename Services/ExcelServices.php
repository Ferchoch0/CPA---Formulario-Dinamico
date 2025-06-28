<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Composer autoload

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelService
{
    public static function generateExcel(array $questions, array $respuestas, string $outputPath = null): string
    {
        if ($outputPath === null) {
            $outputPath = '../Public/File/formulario_' . time() . '.xlsx';
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Títulos
        $sheet->setCellValue('A1', 'Pregunta');
        $sheet->setCellValue('B1', 'Respuesta');

        $row = 2;

        foreach ($questions as $question) {
            $pid = $question['option_id'];
            $pregunta = $question['name'];
            $clave = "question_$pid";
            $respuesta = $respuestas[$clave] ?? 'Sin responder';

            $sheet->setCellValue("A$row", $pregunta);
            $sheet->setCellValue("B$row", $respuesta);

            $row++;
        }

        // Guardar el archivo
        $writer = new Xlsx($spreadsheet);
        $writer->save($outputPath);

        return $outputPath;
    }
}

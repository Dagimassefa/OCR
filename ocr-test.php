<?php
require_once 'vendor/autoload.php';
use thiagoalessio\TesseractOCR\TesseractOCR;

try {

    $tesseract = new TesseractOCR('test-img-2.png');
    $tesseract->executable('C:\Program Files\Tesseract-OCR\tesseract.exe');
    $rawText = $tesseract->run();
    echo "Raw OCR Output:\n";
    echo nl2br($rawText) . "<br><br>";
    $lines = explode("\n", $rawText);
    $htmlTable = "<table border='1' cellpadding='5' cellspacing='0'>\n<thead>\n<tr>";
    $thCount = 0;
    $headers = array_shift($lines);
    $headers = preg_replace('/\s*\|\s*/', ' ', $headers);
    $headersArray = preg_split('/\s+/', trim($headers));
    foreach ($headersArray as $header) {
        $htmlTable .= "<th>" . htmlspecialchars($header) . "</th>";
        $thCount++;
    }
    $htmlTable .= "</tr>\n</thead>\n<tbody>\n";
    
    foreach ($lines as $line) {

        $line = preg_replace('/\s*\|\s*/', ' ', $line);
        $columns = preg_split('/\s+/', trim($line));

        if (count($columns) === count($headersArray)) {
            $htmlTable .= "<tr>";
            foreach ($columns as $column) {
                $htmlTable .= "<td>" . htmlspecialchars($column) . "</td>";
            }
            $htmlTable .= "</tr>\n";
        }
    }


    $htmlTable .= "</tbody>\n</table>";

    echo "HTML Table Output:\n";
    echo $htmlTable;

    echo "<br>Total number of <th> tags: " . $thCount;
    
} catch (Exception $e) {

    echo 'Error: ' . $e->getMessage();
}
?>

<?php
require_once __DIR__ . '/../vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf(); // Ignorar este error

$html = "<h1 style='color:green;'>Viva el BETIS</h1>";

$mpdf->WriteHTML($html);
$mpdf->Output();

?>
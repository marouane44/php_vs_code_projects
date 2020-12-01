<?php
 require_once __DIR__ . '../vendor/autoload.php';

 $mpdf = new \Mpdf\Mpdf();
 $html='<img src="1.jpg"/>';
 $mpdf->WriteHTML($html);
 
 $mpdf->Output();

?>


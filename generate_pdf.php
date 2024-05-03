<?php
require_once('./tcpdf/tcpdf.php');

$periode = $_GET['periode'];
$total_kwh = $_GET['total_kwh'];
$money = $_GET['money'];

$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('Helvetica', '', 12);

// Hinzufügen des h1-Elements
$pdf->SetFont('Helvetica', 'B', 16);
$pdf->Cell(0, 10, 'Power Energy - Abrechnung', 0, 1, 'C'); // Zentrierte Ausrichtung

// Hinzufügen des Inhalts
$pdf->SetFont('Helvetica', '', 12);
$pdf->Cell(0, 10, 'Periode: ' . $periode, 0, 1);
$pdf->Cell(0, 10, 'Total Kw/h: ' . $total_kwh, 0, 1);
$pdf->Cell(0, 10, 'Betrag: ' . $money . ' CHF', 0, 1);

$pdf->Output('rechnung.pdf', 'I');
?>

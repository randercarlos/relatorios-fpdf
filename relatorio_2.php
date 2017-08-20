<?php

require 'vendor/autoload.php';

$pdf = new FPDF('L','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Times', '', 26);
$pdf->Cell(0, 10, utf8_encode('Relatorios com FPDF!'), 'B', 1, 'C');
$pdf->Cell(60, 10,'Desenvolvido com FPDF!', 0, 1);
$pdf->Output('I', 'relatorio.pdf');

<?php

require 'vendor/autoload.php';

class PDF extends FPDF
{
    const FONT = 'Helvetica';
    const FONT_TITULO_W = 16;
    const FONT_NORMAL_W = 10;
    const FONT_RODAPE_W = 10;
    const CELL_TABLE_H = 10;

    public function texto($str)
    {
        return iconv('UTF-8', 'windows-1252', $str);
    }

    // Page footer
    public function Footer()
    {
        // Posiciona a 1.5cm do rodapé
        $this->SetY(-15);

        // Seta a fonte e a cor
        $this->SetFont(self::FONT, 'I', self::FONT_RODAPE_W);
        $this->SetTextColor(0);

        // Define o número de página
        $this->Cell(0, 5, $this->texto('Página ' . $this->PageNo(). '/{nb}'), 'T', 0, 'C');
    }

    // Page footer
    public function Header()
    {
        // Logo
        //$this->Image('logo.png', 0, 0);
		$this->SetY(15);
        $this->SetTextColor(139,0,0);
        $this->SetFont(self::FONT, '', 12);

        // Header
		$this->Image('logotipo2.jpg', 20, 4);
        $this->Cell(0, 5, $this->texto('Sistema de Controle de Estoque - Comércio Preço Bom LTDA.'), '', 0, 'R');

        // Line break
        $this->Ln(15);
    }

    // carrega os dados a serem exibidos no relatório
    public function LoadData()
    {
        $data = [];
        for($i = 1; $i <= 10; $i++)
        {
            $data[] = array("country$i", "capital$i", rand(0, 100000), rand(0, 10000),
                "country$i", "capital$i", rand(0, 100000));
        }

        return $data;
    }


    public function gerarTabela($data)
    {
        // Seta o preenchimento do cabeçalho da tabela para branco
        $this->SetFillColor(255,255,255);

        // Seta a cor do cabeçalho da tabela
        $this->SetTextColor(105,105,105);

        // Seta a cor das bordas do cabeçalho da tabela
        $this->SetDrawColor(84, 84, 83);

        // seta a largura das bordas do cabeçalho da tabela
        $this->SetLineWidth(0.4);

        // seta a fonte da tabela
        $this->SetFont(self::FONT,'B', self::FONT_NORMAL_W);


        // Defini cada coluna do cabeçalho da tabela(Tamanho total da linha é 277)
        $this->Cell(50, self::CELL_TABLE_H, $this->texto('Country'), 'B', 0, 'C', true);
        $this->Cell(35, self::CELL_TABLE_H, $this->texto('Capital'), 'B', 0, 'C', true);
        $this->Cell(30, self::CELL_TABLE_H, $this->texto('Area (sq km)'), 'B', 0, 'C', true);
        $this->Cell(35, self::CELL_TABLE_H, $this->texto('Pop. (thousands)'), 'B', 0, 'C', true);
        $this->Cell(50, self::CELL_TABLE_H, $this->texto('Country'), 'B', 0, 'C', true);
        $this->Cell(35, self::CELL_TABLE_H, $this->texto('Capital'), 'B', 0, 'C', true);
        $this->Cell(42, self::CELL_TABLE_H, $this->texto('Area (sq km)'), 'B', 0, 'C', true);

        $this->Ln();

        // Restora as cores e fontes para o corpo da tabela
        $this->SetFillColor(230,230,250);
        $this->SetTextColor(25,25,112);
        $this->SetFont(self::FONT, '', self::FONT_NORMAL_W);

        // Data
        $colorir_linha = false;
        foreach($data as $row)
        {
            // Defini cada coluna do corpo da tabela(Tamanho total da linha é 277)
            $this->Cell(50, self::CELL_TABLE_H, $this->texto($row[0]), '', 0,'C', $colorir_linha);
            $this->Cell(35, self::CELL_TABLE_H, $this->texto($row[1]), 'L', 0,'C', $colorir_linha);
            $this->Cell(30, self::CELL_TABLE_H, number_format($row[2]), 'L', 0,'C', $colorir_linha);
            $this->Cell(35, self::CELL_TABLE_H, number_format($row[3]), 'L', 0,'C', $colorir_linha);
            $this->Cell(50, self::CELL_TABLE_H, $this->texto($row[4]), 'L', 0,'C', $colorir_linha);
            $this->Cell(35, self::CELL_TABLE_H, $this->texto($row[5]), 'L', 0,'C', $colorir_linha);
            $this->Cell(42, self::CELL_TABLE_H, number_format($row[6]), 'L', 0,'C', $colorir_linha);

            $this->Ln();
            $colorir_linha = !$colorir_linha;
        }

        // fecha a linha
        $this->Cell(0, 0, '', 'T', 1);
    }
}

$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();

// Data loading
$data = $pdf->LoadData();

$pdf->AddPage();

// Define a fonte, cor e imprimi o título do relatório
$pdf->SetFont(PDF::FONT,'B', PDF::FONT_TITULO_W);
$pdf->SetTextColor(0,100,0);
$pdf->Cell(0, 10, $pdf->texto('Relatórios de Categoria'), 0, 1, 'C');

$pdf->gerarTabela($data);

// Define a fonte, cor e imprimi o total de registros
$pdf->SetFont(PDF::FONT, 'B', PDF::FONT_NORMAL_W);
$pdf->SetTextColor(0,128,128);
$pdf->Cell(0, 15, $pdf->texto('Relatório gerado em: ' . date('d/m/Y H:i:s')), 0, 0, 'L');
$pdf->Cell(0, 15, $pdf->texto('Total de Registros: ' . count($data)), 0, 0, 'R');
$pdf->Output();

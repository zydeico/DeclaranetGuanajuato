<?php

require_once('lib/secure.php');
require_once('lib/DBConn.php');
require_once('lib/ext.php');
require_once('lib/pdf/mc_table.php');

$id = showVar($_GET['id']);
$db = new DBConn();

$pdf = new PDF_MC_Table("P");
$pdf->AliasNbPages('{total}');
$pdf->SetMargins(15, 40, 15);
$pdf->SetAutoPageBreak(true, 15);
$pdf->AddPage();


if ($id) {

    $data = $db->getArray("select DISTINCT(sp.ID_Serv), CONCAT_WS(' ', Paterno, Materno, Nombre) as Nombre, RFC, Dependencia, Puesto 
                            from servpub sp 
                            join declaraciones d on d.ID_Serv = sp.ID_Serv 
                            join dependencias dep on dep.ID_Dependencia = sp.ID_Dependencia 
                            join puestos p on p.ID_Puesto = sp.ID_Puesto 
                            Where sp.ID_Serv=" . $id . "");

}

////*************************************************////

if ($data) {
    
    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(180, 10, utf8_decode("ACUERDO DECLARACIÓN PATRIMONIAL PÚBLICA"), 'B', 0, 'C');
    $pdf->Ln();
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(35, 5, 'Nombre:', '', 0, 'R');
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(80, 5, utf8_decode($data[0]['Nombre']), '', 0, 'L');
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(35, 5, 'RFC:', '', 0, 'R');
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(80, 5, $data[0]['RFC'], '', 0, 'L');
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(35, 5, 'Dependencia:', '', 0, 'R');
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(80, 5, utf8_decode($data[0]['Dependencia']), '', 0, 'L');
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(35, 5, 'Puesto:', '', 0, 'R');
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(80, 5, $data[0]['Puesto'], '', 0, 'L');
    $pdf->Ln(5);

}

$pdf->Output('Acuerdo_'.$data[0]['RFC'].'.pdf','D');
?>
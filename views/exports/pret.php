<?php
require_once '../../ws/models/Prets.php';
require_once 'fpdf.php';

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 10, 'Detail du Pret', 0, 1, 'C');
        $this->Ln(10);
    }
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page '.$this->PageNo().'/{nb}', 0, 0, 'C');
    }
}

if (!isset($_GET['id_prets'])) {
    die('ID pret manquant');
}
$id_prets = intval($_GET['id_prets']);
$pret = Prets::getDetailsPret($id_prets);

if (!$pret) {
    die('Pret introuvable');
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

$pdf->Cell(0, 10, 'Client : ' . $pret['nom_clients'] . ' ' . $pret['prenom_clients'], 0, 1);
$pdf->Cell(0, 10, 'Type de pret : ' . $pret['nom_type_pret'], 0, 1);
$pdf->Cell(0, 10, 'Montant : ' . $pret['montant_prets'] . ' Ariary', 0, 1);
$pdf->Cell(0, 10, 'Taux : ' . $pret['pourcentage'] . ' %', 0, 1);
$pdf->Cell(0, 10, 'Duree : ' . $pret['duree_en_mois'] . ' mois', 0, 1);
if (isset($pret['pourcentage_assurance'])) {
    $pdf->Cell(0, 10, 'Assurance : ' . $pret['pourcentage_assurance'] . ' %', 0, 1);
}
if (isset($pret['delai_premier_remboursement'])) {
    $pdf->Cell(0, 10, 'Delai 1er remboursement : ' . $pret['delai_premier_remboursement'] . ' mois', 0, 1);
}
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Resume du pret', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'ID Pret : ' . $pret['id_prets'], 0, 1);
$pdf->Cell(0, 10, 'Date de debut : ' . $pret['date_debut'], 0, 1);
$pdf->Cell(0, 10, 'Duree totale : ' . $pret['duree_en_mois'] . ' mois', 0, 1);
$pdf->Output();
exit;

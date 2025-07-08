<?php
require_once '../../ws/models/Prets.php';
require_once 'fpdf.php';

class PDF extends FPDF {
    function Header() {
        // Logo
        // $this->Image('logo.png', 10, 6, 30); // Remplacez par le chemin de votre logo
        // Police Arial gras 15
        $this->SetFont('Arial', 'B', 15);
        // Décalage à droite
        $this->Cell(80);
        // Titre
        $this->Cell(30, 10, 'DETAIL DU PRET', 0, 0, 'C');
        // Saut de ligne
        $this->Ln(20);
    }

    function Footer() {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);
        // Police Arial italique 8
        $this->SetFont('Arial', 'I', 8);
        // Numéro de page
        $this->Cell(0, 10, 'Page '.$this->PageNo().'/{nb}', 0, 0, 'C');
    }

    function SectionTitle($title) {
        // Police Arial 12
        $this->SetFont('Arial', 'B', 12);
        // Couleur de fond
        $this->SetFillColor(200, 220, 255);
        // Titre
        $this->Cell(0, 6, $title, 0, 1, 'L', true);
        // Saut de ligne
        $this->Ln(4);
    }

    function InfoRow($label, $value) {
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(70, 7, $label, 0, 0);
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 7, $value, 0, 1);
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

// Section Informations Client
$pdf->SectionTitle('INFORMATIONS CLIENT');
$pdf->InfoRow('Nom complet:', $pret['nom_clients'] . ' ' . $pret['prenom_clients']);
$pdf->Ln(5);

// Section Détails du Prêt
$pdf->SectionTitle('DETAILS DU PRET');
$pdf->InfoRow('Type de pret:', $pret['nom_type_pret']);
$pdf->InfoRow('Montant:', number_format($pret['montant_prets'], 0, ',', ' ') . ' Ariary');
$pdf->InfoRow('Taux d\'interet:', $pret['pourcentage'] . ' %');

if (isset($pret['pourcentage_assurance'])) {
    $pdf->InfoRow('Taux assurance:', $pret['pourcentage_assurance'] . ' %');
}

$pdf->InfoRow('Duree:', $pret['duree_en_mois'] . ' mois');

if (isset($pret['delai_premier_remboursement'])) {
    $pdf->InfoRow('Delai 1er remboursement:', $pret['delai_premier_remboursement'] . ' mois');
}
$pdf->Ln(10);

// Section Récapitulatif
$pdf->SectionTitle('RECAPITULATIF');
$pdf->InfoRow('Reference pret:', 'PRET-' . str_pad($pret['id_prets'], 6, '0', STR_PAD_LEFT));
$pdf->InfoRow('Date de debut:', date('d/m/Y', strtotime($pret['date_debut'])));
$pdf->InfoRow('Duree totale:', $pret['duree_en_mois'] . ' mois');
$pdf->InfoRow('Date de fin theorique:', date('d/m/Y', strtotime($pret['date_debut'] . ' + ' . $pret['duree_en_mois'] . ' months')));

// Ajouter un cadre avec les informations importantes
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 7, 'Montant total a rembourser:', 0, 1);
$pdf->SetFont('Arial', '', 11);
$montant_total = $pret['montant_prets'] * (1 + $pret['pourcentage']/100);
if (isset($pret['pourcentage_assurance'])) {
    $montant_total += $pret['montant_prets'] * ($pret['pourcentage_assurance']/100);
}
$pdf->Cell(0, 7, number_format($montant_total, 0, ',', ' ') . ' Ariary', 0, 1);


// Calcul et affichage de la mensualité
function calculerMensualite($montant, $taux_annuel, $duree) {
    $r = $taux_annuel / 12 / 100;
    if ($r > 0) {
        $mensualite = $montant * ($r * pow(1 + $r, $duree)) / (pow(1 + $r, $duree) - 1);
    } else {
        $mensualite = $montant / $duree;
    }
    return round($mensualite, 2);
}

$mensualite = calculerMensualite($pret['montant_prets'], $pret['pourcentage'], $pret['duree_en_mois']);
$assurance_mensuelle = 0;
if (isset($pret['pourcentage_assurance'])) {
    $assurance_mensuelle = round($pret['montant_prets'] * $pret['pourcentage_assurance'] / 100, 2);
}
$mensualite_totale = $mensualite + $assurance_mensuelle;
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 7, 'Mensualite a payer:', 0, 1);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 7, number_format($mensualite_totale, 2, ',', ' ') . ' Ariary', 0, 1);
$pdf->Output();
exit;
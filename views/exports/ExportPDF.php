<?php
require('fpdf.php');

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 10);
        $this->SetXY(10, 36);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(80);
        // Titre
        $this->Cell(40, 10, iconv('UTF-8', 'windows-1252', 'Relevé de Notes'), 1, 0, 'C');
        
        // Saut de ligne
        $this->Ln(20);
    }

    // Pied de page
    function Footer() {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);
        
        // Police Arial italique 8
        $this->SetFont('Arial', 'I', 8);
        
        // Numéro de page
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

function infoETU($idEtudiant){
    $pdf = new PDF();
    $pdf->Output();
}

function pdf(){
    $idEtudiant = 1;
    infoETU($idEtudiant);
}
pdf();
?>
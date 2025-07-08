<?php
require_once __DIR__ . '/../models/Taux.php';
require_once __DIR__ . '/../models/Prets.php';
require_once __DIR__ . '/../helpers/Utils.php';

class StatistiquesController {
    public static function getInteretGagnes(){
        $taux = Taux::getAll();
        Flight::json($taux);
    }



    public static function getInteretsPrets() {
        $result = Prets::getInteretsPrets();
        Flight::json($result);
    }

    public static function getInteretsMois() {
        $mois_debut = $_GET['mois_debut'];
        $annee_debut = $_GET['annee_debut'];
        $mois_fin = $_GET['mois_fin'];
        $annee_fin = $_GET['annee_fin'];
        $date_debut = sprintf('%04d-%02d-01', $annee_debut, $mois_debut);
        $date_fin = date('Y-m-t', strtotime(sprintf('%04d-%02d-01', $annee_fin, $mois_fin)));
        $db = getDB();
        $sql = "SELECT DATE_FORMAT(date_echeance, '%m/%Y') AS mois_annee, SUM(montant_interets) AS total_interets, COUNT(DISTINCT id_prets) AS nb_prets
                FROM Echeances
                WHERE date_echeance >= ? AND date_echeance <= ?
                GROUP BY YEAR(date_echeance), MONTH(date_echeance)
                ORDER BY YEAR(date_echeance), MONTH(date_echeance)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$date_debut, $date_fin]);
        Flight::json($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public static function getMontantsParMois() {
        $mois_debut = $_GET['mois_debut'];
        $annee_debut = $_GET['annee_debut'];
        $mois_fin = $_GET['mois_fin'];
        $annee_fin = $_GET['annee_fin'];
        $date_debut = sprintf('%04d-%02d-01', $annee_debut, $mois_debut);
        $date_fin = date('Y-m-t', strtotime(sprintf('%04d-%02d-01', $annee_fin, $mois_fin)));
        $db = getDB();
        // On génère la liste des mois entre date_debut et date_fin
        $period = [];
        $current = strtotime($date_debut);
        $end = strtotime($date_fin);
        while ($current <= $end) {
            $period[] = [
                'mois_annee' => date('m/Y', $current),
                'annee' => date('Y', $current),
                'mois' => date('m', $current),
            ];
            $current = strtotime('+1 month', $current);
        }
        $results = [];
        foreach ($period as $p) {
            $mois = $p['mois'];
            $annee = $p['annee'];
            $date_fin_mois = date('Y-m-t', strtotime($annee.'-'.$mois.'-01'));
            // Fonds déposés cumulés jusqu'à fin du mois
            $sqlDepot = "SELECT COALESCE(SUM(f.montant_fonds),0) FROM Details_fonds df JOIN Fonds f ON df.id_fonds = f.id_fonds WHERE df.id_type_transactions = 1 AND df.date_details <= ?";
            $stmt = $db->prepare($sqlDepot);
            $stmt->execute([$date_fin_mois]);
            $fonds_deposes = floatval($stmt->fetchColumn());
            // Fonds prêtés cumulés jusqu'à fin du mois (Retrait)
            $sqlPrete = "SELECT COALESCE(SUM(f.montant_fonds),0) FROM Details_fonds df JOIN Fonds f ON df.id_fonds = f.id_fonds WHERE df.id_type_transactions = 2 AND df.date_details <= ?";
            $stmt = $db->prepare($sqlPrete);
            $stmt->execute([$date_fin_mois]);
            $fonds_pretes = floatval($stmt->fetchColumn());
            // Remboursements reçus cumulés jusqu'à fin du mois (Prélèvement prêt = 3)
            $sqlRemb = "SELECT COALESCE(SUM(f.montant_fonds),0) FROM Details_fonds df JOIN Fonds f ON df.id_fonds = f.id_fonds WHERE df.id_type_transactions = 3 AND df.date_details <= ?";
            $stmt = $db->prepare($sqlRemb);
            $stmt->execute([$date_fin_mois]);
            $remboursements = floatval($stmt->fetchColumn());
            $montant_disponible = $fonds_deposes - $fonds_pretes + $remboursements;
            $results[] = [
                'mois_annee' => $p['mois_annee'],
                'fonds_deposes' => $fonds_deposes,
                'fonds_pretes' => $fonds_pretes,
                'remboursements' => $remboursements,
                'montant_disponible' => $montant_disponible
            ];
        }
        Flight::json($results);
    }






} 
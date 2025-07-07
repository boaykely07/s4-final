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






} 
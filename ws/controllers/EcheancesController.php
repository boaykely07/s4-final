<?php
require_once __DIR__ . '/../models/Echeances.php';
require_once __DIR__ . '/../models/Prets.php';
    require_once __DIR__ . '/../models/Taux.php';

class EcheancesController {
    public static function getAll() {
        $echeances = Echeances::getAll();
        Flight::json($echeances);
    }

    public static function getById($id) {
        $echeance = Echeances::getById($id);
        Flight::json($echeance);
    }

    public static function create() {
        $data = Flight::request()->data;
        $id = Echeances::create($data);
        Flight::json(['message' => 'Echéance créée', 'id' => $id]);
    }

    public static function update($id) {
        $data = Flight::request()->data;
        Echeances::update($id, $data);
        Flight::json(['message' => 'Echéance modifiée']);
    }

    public static function delete($id) {
        Echeances::delete($id);
        Flight::json(['message' => 'Echéance supprimée']);
    }

    public static function generateForPret($id_prets) {
        // Récupérer les infos du prêt
     
        $pret = Prets::getById($id_prets);
        if (!$pret) return;
        $taux = null;
        if (!empty($pret['id_types_pret'])) {
            $db = getDB();
            $stmt = $db->prepare("SELECT pourcentage FROM Taux WHERE id_types_pret = ? LIMIT 1");
            $stmt->execute([$pret['id_types_pret']]);
            $row = $stmt->fetch();
            $taux = $row ? floatval($row['pourcentage']) : 0.0;
        }
        $montant = floatval($pret['montant_prets']);
        $n = intval($pret['duree_en_mois']);
        $r = $taux / 12 / 100; // taux mensuel
        $assurance = isset($pret['pourcentage_assurance']) ? floatval($pret['pourcentage_assurance']) : 0.0;
        $assurance_mensuelle = $montant * $assurance / 100;
        $delai = isset($pret['delai_premier_remboursement']) ? intval($pret['delai_premier_remboursement']) : 0;
        $date_debut = $pret['date_debut'];
        // Calcul de l'annuité constante
        $A = ($r > 0) ? ($montant * ($r * pow(1 + $r, $n)) / (pow(1 + $r, $n) - 1)) : ($montant / $n);
        $A = round($A, 2);
        $solde = $montant;
        $date_echeance = date('Y-m-d', strtotime("$date_debut +$delai month"));

        for ($i = 1; $i <= $n; $i++) {
            $interets = round($solde * $r, 2);
            $capital = round($A - $interets, 2);
            if ($i == $n) {
                $capital = $solde; // Ajustement dernière échéance
            }
            $montant_total = round($A + $assurance_mensuelle, 2);
            $solde_restant = round($solde - $capital, 2);
            if ($i == $n) {
                $solde_restant = 0.0;
            }
            // Insertion dans la table Echeances
            Echeances::create((object)[
                'id_prets' => $id_prets,
                'numero_echeance' => $i,
                'date_echeance' => $date_echeance,
                'montant_capital' => $capital,
                'montant_interets' => $interets,
                'montant_total' => $montant_total,
                'solde_restant' => $solde_restant
            ]);
            $solde = $solde - $capital;
            $date_echeance = date('Y-m-d', strtotime("$date_echeance +1 month"));
        }
    }
} 
<?php
require_once __DIR__ . '/../models/Prets.php';
require_once __DIR__ . '/../models/MouvementPrets.php';
require_once __DIR__ . '/../models/Fonds.php';
require_once __DIR__ . '/../models/DetailsFonds.php';
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../helpers/Utils.php';
require_once __DIR__ . '/EcheancesController.php';
require_once __DIR__ . '/../models/MouvementPrets.php';

class PretsController {
    public static function getAll() {
        $prets = Prets::getAll();
        Flight::json($prets);
    }

    public static function getById($id) {
        $pret = Prets::getById($id);
        Flight::json($pret);
    }

    public static function create() {
        try {
            $data = Flight::request()->data;
            
            // Vérifier le solde disponible
            $fonds = Fonds::getFondsActuel();
            if ($fonds['fonds_disponible'] < $data->montant_prets) {
                Flight::json([
                    'error' => 'Solde demandé supérieur au fonds existant',
                    'details' => [
                        'montant_demande' => floatval($data->montant_prets),
                        'fonds_disponible' => floatval($fonds['fonds_disponible'])
                    ]
                ], 400);
                return;
            }
    
            $pret_id = Prets::create($data);
            
            $db = getDB();
        // 1. Trouver le statut 'En attente'
        $stmt = $db->prepare("SELECT id_status_prets FROM Status_prets WHERE nom_status = 'En attente' LIMIT 1");
        $stmt->execute();
        $row = $stmt->fetch();
        $id_status_prets = $row ? $row['id_status_prets'] : 1;

        // 2. Insérer dans Mouvement_prets (statut En attente)
        MouvementPrets::create((object)[
            'id_prets' => $pret_id,
            'id_status_prets' => $id_status_prets,
            'date_mouvement' => date('Y-m-d')
        ]);

        // 3. Créer un nouveau fonds avec le montant du prêt
        $id_fonds = Fonds::create((object)['montant_fonds' => $data->montant_prets]);

        // 4. Trouver le type de transaction 'Retrait'
        $stmt = $db->prepare("SELECT id_type_transactions FROM Type_transactions WHERE nom_type_transactions = 'Retrait' LIMIT 1");
        $stmt->execute();
        $row = $stmt->fetch();
        $id_type_transactions = $row ? $row['id_type_transactions'] : 2;

        // 5. Insertion dans Details_fonds
        DetailsFonds::create((object)[
            'id_fonds' => $id_fonds,
            'id_type_transactions' => $id_type_transactions,
            'date_details' => date('Y-m-d'),
            'id_prets' => $pret_id
        ]);

        Flight::json(['message' => 'Prêt ajouté', 'id' => $pret_id]);
    } catch (Exception $e) {
        Flight::json([
            'error' => 'Erreur lors de la création du prêt',
            'details' => [
                'message' => $e->getMessage()
            ]
        ], 500);
    }
}

    public static function update($id) {
        $data = Flight::request()->data;
        Prets::update($id, $data);
        Flight::json(['message' => 'Prêt modifié']);
    }

    public static function delete($id) {
        Prets::delete($id);
        Flight::json(['message' => 'Prêt supprimé']);
    }

    public static function valider($id) {
        $db = getDB();
        // Trouver le statut 'Approuvé'
        $stmt = $db->prepare("SELECT id_status_prets FROM Status_prets WHERE nom_status = 'Approuvé' LIMIT 1");
        $stmt->execute();
        $row = $stmt->fetch();
        $id_status_prets = $row ? $row['id_status_prets'] : 2;
        // Insérer dans Mouvement_prets
        MouvementPrets::create((object)[
            'id_prets' => $id,
            'id_status_prets' => $id_status_prets,
            'date_mouvement' => date('Y-m-d')
        ]);
        // Générer les échéances automatiquement à la validation
        EcheancesController::generateForPret($id);
        Flight::json(['message' => 'Prêt validé !']);
    }

    public static function annuler($id) {
        $db = getDB();
        // Trouver le statut 'Rejeté'
        $stmt = $db->prepare("SELECT id_status_prets FROM Status_prets WHERE nom_status = 'Rejeté' LIMIT 1");
        $stmt->execute();
        $row = $stmt->fetch();
        $id_status_prets = $row ? $row['id_status_prets'] : 3;
        // Insérer dans Mouvement_prets
        MouvementPrets::create((object)[
            'id_prets' => $id,
            'id_status_prets' => $id_status_prets,
            'date_mouvement' => date('Y-m-d')
        ]);
        Flight::json(['message' => 'Prêt annulé !']);
    }

    // Calcule l'annuité constante (hors assurance)
    public static function calculerAnnuite($montant, $taux_annuel, $duree) {
        $r = $taux_annuel / 12 / 100;
        if ($r > 0) {
            $annuite = $montant * ($r * pow(1 + $r, $duree)) / (pow(1 + $r, $duree) - 1);
        } else {
            $annuite = $montant / $duree;
        }
        return round($annuite, 2);
    }

    // Calcule l'assurance mensuelle
    public static function calculerAssuranceMensuelle($montant, $assurance) {
        return round($montant * $assurance / 100, 2);
    }

    // Calcule la mensualité totale (annuité + assurance)
    public static function calculerMensualiteTotale($annuite, $assurance_mensuelle) {
        return round($annuite + $assurance_mensuelle, 2);
    }

    // Calcule le coût total du prêt (mensualité totale * durée)
    public static function calculerCoutTotal($mensualite_totale, $duree) {
        return round($mensualite_totale * $duree, 2);
    }

    // Simulation d'un prêt (API)
    public static function simulate() {
        $data = Flight::request()->data;
        $montant = floatval($data->montant);
        $taux = floatval($data->taux);
        $delai = isset($data->delai) ? intval($data->delai) : 0;
        $duree = intval($data->duree) - $delai;
        if ($duree < 1) $duree = 1;
        $assurance = isset($data->assurance) ? floatval($data->assurance) : 0;
        $annuite = self::calculerAnnuite($montant, $taux, $duree);
        $assurance_mensuelle = self::calculerAssuranceMensuelle($montant, $assurance);
        $mensualite_totale = self::calculerMensualiteTotale($annuite, $assurance_mensuelle);
        $cout_total = self::calculerCoutTotal($mensualite_totale, $duree);
        Flight::json([
            'annuite' => $annuite,
            'assurance_mensuelle' => $assurance_mensuelle,
            'mensualite_totale' => $mensualite_totale,
            'cout_total' => $cout_total
        ]);
    }
} 
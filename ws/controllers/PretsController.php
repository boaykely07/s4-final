<?php
require_once __DIR__ . '/../models/Prets.php';
require_once __DIR__ . '/../models/MouvementPrets.php';
require_once __DIR__ . '/../models/Fonds.php';
require_once __DIR__ . '/../models/DetailsFonds.php';
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../helpers/Utils.php';
require_once __DIR__ . '/EcheancesController.php';

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
        $data = Flight::request()->data;
        $pret_id = Prets::create($data);

        $db = getDB();
        // 1. Trouver le statut 'Approuvé'
        $stmt = $db->prepare("SELECT id_status_prets FROM Status_prets WHERE nom_status = 'Approuvé' LIMIT 1");
        $stmt->execute();
        $row = $stmt->fetch();
        $id_status_prets = $row ? $row['id_status_prets'] : 2;

        // 2. Insérer dans Mouvement_prets (statut Approuvé)
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

        // 6. Générer les échéances automatiquement
        
        EcheancesController::generateForPret($pret_id);

        Flight::json(['message' => 'Prêt ajouté', 'id' => $pret_id]);
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
} 
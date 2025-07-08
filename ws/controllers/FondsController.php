<?php
require_once __DIR__ . '/../models/Fonds.php';
require_once __DIR__ . '/../helpers/Utils.php';
require_once __DIR__ . '/../models/DetailsFonds.php';

class FondsController {
    public static function getAll() {
        $fonds = Fonds::getAll();
        Flight::json($fonds);
    }

    public static function getById($id) {
        $fonds = Fonds::getById($id);
        Flight::json($fonds);
    }

    public static function createOnly() {
        $data = Flight::request()->data;
        $id = Fonds::create($data);
        Flight::json(['message' => 'Fonds ajouté', 'id' => $id]);
    }

    public static function update($id) {
        $data = Flight::request()->data;
        Fonds::update($id, $data);
        Flight::json(['message' => 'Fonds modifié']);
    }

    public static function delete($id) {
        Fonds::delete($id);
        Flight::json(['message' => 'Fonds supprimé']);
    }

    public static function getFondsActuel() {
        $fonds = Fonds::getFondsActuel();
        Flight::json($fonds);
    }

    public static function create() {
        try {
            $data = Flight::request()->data;
            $id = Fonds::create($data);
            DetailsFonds::create((object)[
                'id_fonds' => $id,
                'id_type_transactions' => 1,
                'date_details' => date('Y-m-d'),
                'id_prets' => null
            ]);
            Flight::json(['message' => 'Fonds ajouté avec détails', 'id' => $id]);
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }
}
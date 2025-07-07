<?php
require_once __DIR__ . '/../models/Taux.php';
require_once __DIR__ . '/../helpers/Utils.php';

class TauxController {
    public static function getAll() {
        $taux = Taux::getAll();
        Flight::json($taux);
    }

    public static function getById($id) {
        $taux = Taux::getById($id);
        Flight::json($taux);
    }

    public static function create() {
        $data = Flight::request()->data;
        $id = Taux::create($data);
        Flight::json(['message' => 'Taux ajouté', 'id' => $id]);
    }

    public static function update($id) {
        $data = Flight::request()->data;
        Taux::update($id, $data);
        Flight::json(['message' => 'Taux modifié']);
    }

    public static function delete($id) {
        Taux::delete($id);
        Flight::json(['message' => 'Taux supprimé']);
    }
} 
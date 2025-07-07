<?php
require_once __DIR__ . '/../models/Echeances.php';

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
} 
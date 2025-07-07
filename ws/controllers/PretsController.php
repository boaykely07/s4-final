<?php
require_once __DIR__ . '/../models/Prets.php';
require_once __DIR__ . '/../helpers/Utils.php';

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
        $id = Prets::create($data);
        Flight::json(['message' => 'Prêt ajouté', 'id' => $id]);
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
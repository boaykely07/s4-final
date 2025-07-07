<?php
require_once __DIR__ . '/../models/TypesPret.php';
require_once __DIR__ . '/../helpers/Utils.php';

class TypesPretController {
    public static function getAll() {
        $types = TypesPret::getAll();
        Flight::json($types);
    }

    public static function getById($id) {
        $type = TypesPret::getById($id);
        Flight::json($type);
    }

    public static function create() {
        $data = Flight::request()->data;
        $id = TypesPret::create($data);
        Flight::json(['message' => 'Type de prêt ajouté', 'id' => $id]);
    }

    public static function update($id) {
        $data = Flight::request()->data;
        TypesPret::update($id, $data);
        Flight::json(['message' => 'Type de prêt modifié']);
    }

    public static function delete($id) {
        TypesPret::delete($id);
        Flight::json(['message' => 'Type de prêt supprimé']);
    }
} 
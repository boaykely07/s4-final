<?php
require_once __DIR__ . '/../models/StatusPrets.php';
require_once __DIR__ . '/../helpers/Utils.php';

class StatusPretsController {
    public static function getAll() {
        $status = StatusPrets::getAll();
        Flight::json($status);
    }

    public static function getById($id) {
        $status = StatusPrets::getById($id);
        Flight::json($status);
    }

    public static function create() {
        $data = Flight::request()->data;
        $id = StatusPrets::create($data);
        Flight::json(['message' => 'Statut ajouté', 'id' => $id]);
    }

    public static function update($id) {
        $data = Flight::request()->data;
        StatusPrets::update($id, $data);
        Flight::json(['message' => 'Statut modifié']);
    }

    public static function delete($id) {
        StatusPrets::delete($id);
        Flight::json(['message' => 'Statut supprimé']);
    }
} 
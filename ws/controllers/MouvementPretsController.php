<?php
require_once __DIR__ . '/../models/MouvementPrets.php';
require_once __DIR__ . '/../helpers/Utils.php';

class MouvementPretsController {
    public static function getAll() {
        $mouvements = MouvementPrets::getAll();
        Flight::json($mouvements);
    }

    public static function getById($id) {
        $mouvement = MouvementPrets::getById($id);
        Flight::json($mouvement);
    }

    public static function create() {
        $data = Flight::request()->data;
        $id = MouvementPrets::create($data);
        Flight::json(['message' => 'Mouvement ajouté', 'id' => $id]);
    }

    public static function update($id) {
        $data = Flight::request()->data;
        MouvementPrets::update($id, $data);
        Flight::json(['message' => 'Mouvement modifié']);
    }

    public static function delete($id) {
        MouvementPrets::delete($id);
        Flight::json(['message' => 'Mouvement supprimé']);
    }
} 
<?php
require_once __DIR__ . '/../models/TypeTransactions.php';
require_once __DIR__ . '/../helpers/Utils.php';

class TypeTransactionsController {
    public static function getAll() {
        $types = TypeTransactions::getAll();
        Flight::json($types);
    }

    public static function getById($id) {
        $type = TypeTransactions::getById($id);
        Flight::json($type);
    }

    public static function create() {
        $data = Flight::request()->data;
        $id = TypeTransactions::create($data);
        Flight::json(['message' => 'Type de transaction ajouté', 'id' => $id]);
    }

    public static function update($id) {
        $data = Flight::request()->data;
        TypeTransactions::update($id, $data);
        Flight::json(['message' => 'Type de transaction modifié']);
    }

    public static function delete($id) {
        TypeTransactions::delete($id);
        Flight::json(['message' => 'Type de transaction supprimé']);
    }
} 
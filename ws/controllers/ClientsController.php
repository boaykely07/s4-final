<?php
require_once __DIR__ . '/../models/Clients.php';
require_once __DIR__ . '/../helpers/Utils.php';

class ClientsController {
    public static function getAll() {
        $clients = Clients::getAll();
        Flight::json($clients);
    }

    public static function getById($id) {
        $client = Clients::getById($id);
        Flight::json($client);
    }

    public static function create() {
        $data = Flight::request()->data;
        $id = Clients::create($data);
        Flight::json(['message' => 'Client ajouté', 'id' => $id]);
    }

    public static function update($id) {
        $data = Flight::request()->data;
        Clients::update($id, $data);
        Flight::json(['message' => 'Client modifié']);
    }

    public static function delete($id) {
        Clients::delete($id);
        Flight::json(['message' => 'Client supprimé']);
    }
} 
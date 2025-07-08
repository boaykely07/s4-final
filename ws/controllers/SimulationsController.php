<?php
require_once __DIR__ . '/../models/Simulations.php';

class SimulationsController {
    public static function getAll() {
        $sims = Simulations::getAll();
        Flight::json($sims);
    }
    public static function getById($id) {
        $sim = Simulations::getById($id);
        Flight::json($sim);
    }
    public static function create() {
        $data = Flight::request()->data;
        $id = Simulations::create($data);
        Flight::json(['message' => 'Simulation enregistrée', 'id' => $id]);
    }
    public static function delete($id) {
        Simulations::delete($id);
        Flight::json(['message' => 'Simulation supprimée']);
    }
} 
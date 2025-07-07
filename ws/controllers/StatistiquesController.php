<?php
require_once __DIR__ . '/../models/Taux.php';
require_once __DIR__ . '/../models/Prets.php';
require_once __DIR__ . '/../helpers/Utils.php';

class StatistiquesController {
    public static function getInteretGagnes(){
        $taux = Taux::getAll();
        Flight::json($taux);
    }



    public static function getInteretsPrets() {
        $result = Prets::getInteretsPrets();
        Flight::json($result);
    }






} 
<?php
require_once __DIR__ . '/../controllers/EtudiantController.php';
require_once __DIR__ . '/../controllers/StatistiquesController.php';

Flight::route('GET /etudiants', ['EtudiantController', 'getAll']);
Flight::route('GET /tauxInteret', ['StatistiquesController', 'getInteretGagnes']);
Flight::route('GET /interetsPrets', ['StatistiquesController', 'getInteretsPrets']);
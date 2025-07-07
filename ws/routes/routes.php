<?php
require_once __DIR__ . '/../controllers/EtudiantController.php';
require_once __DIR__ . '/../controllers/StatistiquesController.php';

Flight::route('GET /etudiants', ['EtudiantController', 'getAll']);
Flight::route('GET /tauxInteret', ['StatistiquesController', 'getInteretGagnes']);
Flight::route('GET /interetsPrets', ['StatistiquesController', 'getInteretsPrets']);
require_once __DIR__ . '/../controllers/PretsController.php';
require_once __DIR__ . '/../controllers/TypesPretController.php';
require_once __DIR__ . '/../controllers/ClientsController.php';

Flight::route('GET /etudiants', ['EtudiantController', 'getAll']);

// Prêts
Flight::route('GET /prets', ['PretsController', 'getAll']);
Flight::route('GET /prets/@id', ['PretsController', 'getById']);
Flight::route('POST /prets', ['PretsController', 'create']);
Flight::route('PUT /prets/@id', ['PretsController', 'update']);
Flight::route('DELETE /prets/@id', ['PretsController', 'delete']);

// Types de prêt (pour listes déroulantes)
Flight::route('GET /typespret', ['TypesPretController', 'getAll']);

// Clients (pour listes déroulantes)
Flight::route('GET /clients', ['ClientsController', 'getAll']);

<?php
require_once __DIR__ . '/../controllers/EtudiantController.php';
require_once __DIR__ . '/../controllers/FondsController.php';
require_once __DIR__ . '/../controllers/TauxController.php';

Flight::route('GET /etudiants', ['EtudiantController', 'getAll']);
Flight::route('POST /fonds', ['FondsController', 'create']);
Flight::route('GET /fonds/actuel', ['FondsController', 'getFondsActuel']);

require_once __DIR__ . '/../controllers/StatistiquesController.php';

Flight::route('GET /etudiants', ['EtudiantController', 'getAll']);
Flight::route('GET /tauxInteret', ['StatistiquesController', 'getInteretGagnes']);
Flight::route('GET /interetsPrets', ['StatistiquesController', 'getInteretsPrets']);
Flight::route('GET /interetsMois', ['StatistiquesController', 'getInteretsMois']);
Flight::route('GET /statistiques/montants', ['StatistiquesController', 'getMontantsParMois']);
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

// Types de prêt (pour listes déroulantes et ajout)
Flight::route('GET /typespret', ['TypesPretController', 'getAll']);
Flight::route('POST /typespret', ['TypesPretController', 'create']);

// Taux (pour listes déroulantes)
Flight::route('GET /taux', ['TauxController', 'getAll']);

// Clients (pour listes déroulantes)
Flight::route('GET /clients', ['ClientsController', 'getAll']);
Flight::route('POST /prets/valider/@id', ['PretsController', 'valider']);
Flight::route('POST /prets/annuler/@id', ['PretsController', 'annuler']);

// Simulation de prêt (API)
Flight::route('POST /simulateurpret', ['PretsController', 'simulate']);

require_once __DIR__ . '/../controllers/SimulationsController.php';

// Simulations
Flight::route('GET /simulations', ['SimulationsController', 'getAll']);
Flight::route('GET /simulations/@id', ['SimulationsController', 'getById']);
Flight::route('POST /simulations', ['SimulationsController', 'create']);
Flight::route('DELETE /simulations/@id', ['SimulationsController', 'delete']);
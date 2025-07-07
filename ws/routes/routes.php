<?php
require_once __DIR__ . '/../controllers/EtudiantController.php';
require_once __DIR__ . '/../controllers/FondsController.php';

Flight::route('GET /etudiants', ['EtudiantController', 'getAll']);
Flight::route('POST /fonds', ['FondsController', 'create']);


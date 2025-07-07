<?php
require_once __DIR__ . '/../controllers/EtudiantController.php';

Flight::route('GET /etudiants', ['EtudiantController', 'getAll']);

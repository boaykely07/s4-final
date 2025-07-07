<?php
require_once __DIR__ . '/../controllers/FondsController.php';

Flight::route('POST /fonds', ['FondsController', 'create']);
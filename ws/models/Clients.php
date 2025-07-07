<?php
require_once __DIR__ . '/../db.php';

class Clients {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM Clients");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM Clients WHERE id_clients = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Clients (nom_clients, prenom_clients, date_naissance, salaire) VALUES (?, ?, ?, ?)");
        $stmt->execute([$data->nom_clients, $data->prenom_clients, $data->date_naissance, $data->salaire]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE Clients SET nom_clients = ?, prenom_clients = ?, date_naissance = ?, salaire = ? WHERE id_clients = ?");
        $stmt->execute([$data->nom_clients, $data->prenom_clients, $data->date_naissance, $data->salaire, $id]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM Clients WHERE id_clients = ?");
        $stmt->execute([$id]);
    }
} 
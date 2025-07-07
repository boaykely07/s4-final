<?php
require_once __DIR__ . '/../db.php';

class Taux {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM Taux");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM Taux WHERE id_taux = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Taux (id_types_pret, pourcentage) VALUES (?, ?)");
        $stmt->execute([$data->id_types_pret, $data->pourcentage]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE Taux SET id_types_pret = ?, pourcentage = ? WHERE id_taux = ?");
        $stmt->execute([$data->id_types_pret, $data->pourcentage, $id]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM Taux WHERE id_taux = ?");
        $stmt->execute([$id]);
    }
} 
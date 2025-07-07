<?php
require_once __DIR__ . '/../db.php';

class TypesPret {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM Types_pret");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM Types_pret WHERE id_types_pret = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Types_pret (nom_type_pret) VALUES (?)");
        $stmt->execute([$data->nom_type_pret]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE Types_pret SET nom_type_pret = ? WHERE id_types_pret = ?");
        $stmt->execute([$data->nom_type_pret, $id]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM Types_pret WHERE id_types_pret = ?");
        $stmt->execute([$id]);
    }
} 
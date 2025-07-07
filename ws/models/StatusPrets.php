<?php
require_once __DIR__ . '/../db.php';

class StatusPrets {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM Status_prets");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM Status_prets WHERE id_status_prets = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Status_prets (nom_status) VALUES (?)");
        $stmt->execute([$data->nom_status]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE Status_prets SET nom_status = ? WHERE id_status_prets = ?");
        $stmt->execute([$data->nom_status, $id]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM Status_prets WHERE id_status_prets = ?");
        $stmt->execute([$id]);
    }
} 
<?php
require_once __DIR__ . '/../db.php';

class MouvementPrets {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM Mouvement_prets");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM Mouvement_prets WHERE id_mouvement_prets = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Mouvement_prets (id_prets, id_status_prets, date_mouvement) VALUES (?, ?, ?)");
        $stmt->execute([$data->id_prets, $data->id_status_prets, $data->date_mouvement]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE Mouvement_prets SET id_prets = ?, id_status_prets = ?, date_mouvement = ? WHERE id_mouvement_prets = ?");
        $stmt->execute([$data->id_prets, $data->id_status_prets, $data->date_mouvement, $id]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM Mouvement_prets WHERE id_mouvement_prets = ?");
        $stmt->execute([$id]);
    }
} 
<?php
require_once __DIR__ . '/../db.php';

class Fonds {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM Fonds");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM Fonds WHERE id_fonds = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Fonds (montant_fonds) VALUES (?)");
        $stmt->execute([$data->montant_fonds]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE Fonds SET montant_fonds = ? WHERE id_fonds = ?");
        $stmt->execute([$data->montant_fonds, $id]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM Fonds WHERE id_fonds = ?");
        $stmt->execute([$id]);
    }

    public static function getFondsActuel() {
        $db = getDB();
        $stmt = $db->query("
            SELECT 
                (SELECT montant_fonds FROM Fonds ORDER BY id_fonds DESC LIMIT 1) - 
                COALESCE(SUM(montant_prets), 0) as fonds_disponible 
            FROM Prets
        ");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
} 
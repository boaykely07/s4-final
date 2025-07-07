<?php
require_once __DIR__ . '/../db.php';

class DetailsFonds {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM Details_fonds");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM Details_fonds WHERE id_details_fonds = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Details_fonds (id_fonds, id_type_transactions, date_details, id_prets) VALUES (?, ?, ?, ?)");
        $stmt->execute([$data->id_fonds, $data->id_type_transactions, $data->date_details, $data->id_prets]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE Details_fonds SET id_fonds = ?, id_type_transactions = ?, date_details = ?, id_prets = ? WHERE id_details_fonds = ?");
        $stmt->execute([$data->id_fonds, $data->id_type_transactions, $data->date_details, $data->id_prets, $id]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM Details_fonds WHERE id_details_fonds = ?");
        $stmt->execute([$id]);
    }
} 
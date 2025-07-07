<?php
require_once __DIR__ . '/../db.php';

class TypeTransactions {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM Type_transactions");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM Type_transactions WHERE id_type_transactions = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Type_transactions (nom_type_transactions) VALUES (?)");
        $stmt->execute([$data->nom_type_transactions]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE Type_transactions SET nom_type_transactions = ? WHERE id_type_transactions = ?");
        $stmt->execute([$data->nom_type_transactions, $id]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM Type_transactions WHERE id_type_transactions = ?");
        $stmt->execute([$id]);
    }
} 
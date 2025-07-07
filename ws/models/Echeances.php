<?php
require_once __DIR__ . '/../db.php';

class Echeances {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM Echeances");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM Echeances WHERE id_echeance = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Echeances (id_prets, numero_echeance, date_echeance, montant_capital, montant_interets, montant_total, solde_restant) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data->id_prets,
            $data->numero_echeance,
            $data->date_echeance,
            $data->montant_capital,
            $data->montant_interets,
            $data->montant_total,
            $data->solde_restant
        ]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE Echeances SET id_prets = ?, numero_echeance = ?, date_echeance = ?, montant_capital = ?, montant_interets = ?, montant_total = ?, solde_restant = ? WHERE id_echeance = ?");
        $stmt->execute([
            $data->id_prets,
            $data->numero_echeance,
            $data->date_echeance,
            $data->montant_capital,
            $data->montant_interets,
            $data->montant_total,
            $data->solde_restant,
            $id
        ]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM Echeances WHERE id_echeance = ?");
        $stmt->execute([$id]);
    }
} 
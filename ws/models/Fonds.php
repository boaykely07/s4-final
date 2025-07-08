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

    public static function createOnly($data) {
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
        // Somme des dépôts
        $sqlDepot = "
            SELECT COALESCE(SUM(f.montant_fonds), 0) as total_depot
            FROM Details_fonds df
            JOIN Fonds f ON df.id_fonds = f.id_fonds
            WHERE df.id_type_transactions = 1
        ";
        $stmt = $db->query($sqlDepot);
        $totalDepot = $stmt->fetchColumn();

        // Somme des retraits
        $sqlRetrait = "
            SELECT COALESCE(SUM(f.montant_fonds), 0) as total_retrait
            FROM Details_fonds df
            JOIN Fonds f ON df.id_fonds = f.id_fonds
            WHERE df.id_type_transactions = 2
        ";
        $stmt = $db->query($sqlRetrait);
        $totalRetrait = $stmt->fetchColumn();

        $fondsDisponible = $totalDepot - $totalRetrait;
        return ['fonds_disponible' => $fondsDisponible];
    }

    public static function create($data) {
        $db = getDB();
        try {
            $db->beginTransaction();
            
            // Insertion dans Fonds
            $stmt = $db->prepare("INSERT INTO Fonds (montant_fonds) VALUES (?)");
            $stmt->execute([$data->montant_fonds]);
            $id_fonds = $db->lastInsertId();
            $db->commit();
            return $id_fonds;
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }
} 
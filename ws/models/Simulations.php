<?php
require_once __DIR__ . '/../db.php';

class Simulations {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT s.*, t.nom_type_pret, c.nom_clients, c.prenom_clients FROM Simulations s JOIN Types_pret t ON s.id_types_pret = t.id_types_pret JOIN Clients c ON s.id_clients = c.id_clients");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT s.*, t.nom_type_pret, c.nom_clients, c.prenom_clients FROM Simulations s JOIN Types_pret t ON s.id_types_pret = t.id_types_pret JOIN Clients c ON s.id_clients = c.id_clients WHERE s.id_simulation = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Simulations (id_types_pret, id_clients, montant_prets, date_debut, duree_en_mois, pourcentage_assurance, delai_premier_remboursement) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data->id_types_pret,
            $data->id_clients,
            $data->montant_prets,
            $data->date_debut,
            $data->duree_en_mois,
            $data->pourcentage_assurance,
            $data->delai_premier_remboursement
        ]);
        return $db->lastInsertId();
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM Simulations WHERE id_simulation = ?");
        $stmt->execute([$id]);
    }
} 
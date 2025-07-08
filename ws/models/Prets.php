<?php
require_once __DIR__ . '/../db.php';

class Prets {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("
            SELECT p.*, s.nom_status
            FROM Prets p
            LEFT JOIN (
                SELECT m1.id_prets, m1.id_status_prets
                FROM Mouvement_prets m1
                WHERE m1.id_mouvement_prets = (
                    SELECT m2.id_mouvement_prets
                    FROM Mouvement_prets m2
                    WHERE m2.id_prets = m1.id_prets
                    ORDER BY m2.date_mouvement DESC, m2.id_mouvement_prets DESC
                    LIMIT 1
                )
            ) mp ON p.id_prets = mp.id_prets
            LEFT JOIN Status_prets s ON mp.id_status_prets = s.id_status_prets
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM Prets WHERE id_prets = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Prets (id_types_pret, id_clients, montant_prets, date_debut, duree_en_mois, pourcentage_assurance, delai_premier_remboursement) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data->id_types_pret,
            $data->id_clients,
            $data->montant_prets,
            $data->date_debut,
            $data->duree_en_mois,
            isset($data->pourcentage_assurance) ? $data->pourcentage_assurance : null,
            isset($data->delai_premier_remboursement) ? $data->delai_premier_remboursement : null
        ]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE Prets SET id_types_pret = ?, id_clients = ?, montant_prets = ?, date_debut = ?, duree_en_mois = ?, pourcentage_assurance = ?, delai_premier_remboursement = ? WHERE id_prets = ?");
        $stmt->execute([
            $data->id_types_pret,
            $data->id_clients,
            $data->montant_prets,
            $data->date_debut,
            $data->duree_en_mois,
            isset($data->pourcentage_assurance) ? $data->pourcentage_assurance : null,
            isset($data->delai_premier_remboursement) ? $data->delai_premier_remboursement : null,
            $id
        ]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM Prets WHERE id_prets = ?");
        $stmt->execute([$id]);
    }
} 
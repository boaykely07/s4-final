-- Suppression de la base de données si elle existe pour un test propre
DROP DATABASE IF EXISTS banque;

-- Création de la base de données
CREATE DATABASE banque;
USE banque;

-- Table pour les fonds totaux de la banque
CREATE TABLE Fonds(
    id_fonds INT AUTO_INCREMENT PRIMARY KEY,
    -- Il est préférable d'utiliser DECIMAL pour les montants financiers
    montant_fonds DECIMAL(20, 2) NOT NULL
);

-- Table pour les différents types de prêts possibles
CREATE TABLE Types_pret(
    id_types_pret INT AUTO_INCREMENT PRIMARY KEY,
    nom_type_pret VARCHAR(50) NOT NULL UNIQUE
);

-- Table pour les taux associés à chaque type de prêt
CREATE TABLE Taux(
    id_taux INT AUTO_INCREMENT PRIMARY KEY,
    id_types_pret INT NOT NULL,
    -- Un pourcentage peut avoir des décimales (ex: 4.75%)
    pourcentage DECIMAL(5, 2) NOT NULL,
    FOREIGN KEY (id_types_pret) REFERENCES Types_pret(id_types_pret)
);

-- Table des clients
CREATE TABLE Clients(
    id_clients INT AUTO_INCREMENT PRIMARY KEY,
    nom_clients VARCHAR(50) NOT NULL,
    prenom_clients VARCHAR(50) NOT NULL,
    date_naissance DATE,
    -- Erreur de frappe corrigée: DECINAL -> DECIMAL. Précision ajoutée.
    salaire DECIMAL(10, 2)
);

-- Table des prêts accordés aux clients
CREATE TABLE Prets(
    id_prets INT AUTO_INCREMENT PRIMARY KEY,
    id_types_pret INT NOT NULL,
    id_clients INT NOT NULL,
    -- Utilisation de DECIMAL pour le montant
    montant_prets DECIMAL(15, 2) NOT NULL,
    -- Virgule manquante corrigée ici
    date_debut DATE NOT NULL,
    -- Durée en mois
    duree_en_mois INT NOT NULL,
    -- Ajout des clés étrangères pour l'intégrité des données
    FOREIGN KEY (id_types_pret) REFERENCES Types_pret(id_types_pret),
    FOREIGN KEY (id_clients) REFERENCES Clients(id_clients)
);

-- Table pour les statuts possibles d'un prêt (ex: En attente, Approuvé, Rejeté, Remboursé)
CREATE TABLE Status_prets(
    -- Correction de la faute de frappe : satus -> status
    id_status_prets INT AUTO_INCREMENT PRIMARY KEY,
    nom_status VARCHAR(50) NOT NULL UNIQUE
);

-- Table pour suivre l'historique des statuts d'un prêt
CREATE TABLE Mouvement_prets(
    id_mouvement_prets INT AUTO_INCREMENT PRIMARY KEY,
    id_prets INT NOT NULL,
    -- Correction de la faute de frappe : satus -> status
    id_status_prets INT NOT NULL,
    date_mouvement DATE NOT NULL,
    -- Ajout des clés étrangères
    FOREIGN KEY (id_prets) REFERENCES Prets(id_prets),
    FOREIGN KEY (id_status_prets) REFERENCES Status_prets(id_status_prets)
);

-- Table pour les types de transactions financières (ex: Dépôt, Retrait, Prélèvement prêt)
CREATE TABLE Type_transactions(
    id_type_transactions INT AUTO_INCREMENT PRIMARY KEY,
    nom_type_transactions VARCHAR(50) NOT NULL UNIQUE
);
INSERT INTO Type_transactions ('Depot')

-- Table pour détailler les mouvements de fonds
CREATE TABLE Details_fonds(
    id_details_fonds INT AUTO_INCREMENT PRIMARY KEY,
    id_fonds INT NOT NULL,
    id_type_transactions INT NOT NULL,
    -- Correction de la faute de frappe : transactionsn -> transactions
    date_details DATE NOT NULL,
    -- Ajout d'une référence au prêt si la transaction est liée à un prêt
    id_prets INT NULL, -- NULL car une transaction n'est pas toujours liée à un prêt
    FOREIGN KEY (id_fonds) REFERENCES Fonds(id_fonds),
    FOREIGN KEY (id_type_transactions) REFERENCES Type_transactions(id_type_transactions),
    FOREIGN KEY (id_prets) REFERENCES Prets(id_prets)
);

-- Table pour les échéances de remboursement
CREATE TABLE Echeances (
    id_echeance INT AUTO_INCREMENT PRIMARY KEY,
    id_prets INT NOT NULL,
    numero_echeance INT NOT NULL, -- Numéro de l'échéance (1, 2, 3, ...)
    date_echeance DATE NOT NULL, -- Date prévue pour l'échéance
    montant_capital DECIMAL(15, 2) NOT NULL, -- Partie du capital remboursé
    montant_interets DECIMAL(15, 2) NOT NULL, -- Intérêts payés pour cette échéance
    montant_total DECIMAL(15, 2) NOT NULL, -- Montant total de l'échéance (capital + intérêts + assurance si applicable)
    solde_restant DECIMAL(15, 2) NOT NULL, -- Solde restant après cette échéance
    FOREIGN KEY (id_prets) REFERENCES Prets(id_prets)
);

ALTER TABLE Prets
ADD pourcentage_assurance DECIMAL(5, 2) NULL, -- Pourcentage d'assurance, peut être NULL
ADD delai_premier_remboursement INT NULL; -- Délai en mois pour le 1er remboursement (S4 INFO uniquement)

-- Table pour stocker les paramètres des simulations
CREATE TABLE Simulations (
    id_simulation INT AUTO_INCREMENT PRIMARY KEY,
    id_types_pret INT NOT NULL,
    montant_prets DECIMAL(15, 2) NOT NULL,
    date_debut DATE NOT NULL,
    duree_en_mois INT NOT NULL,
    pourcentage_assurance DECIMAL(5, 2) NULL,
    delai_premier_remboursement INT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_types_pret) REFERENCES Types_pret(id_types_pret)
);
-- Types de prêts
INSERT INTO Types_pret (nom_type_pret) VALUES
('Immobilier'),
('Consommation'),
('Auto');

-- Statuts de prêts
INSERT INTO Status_prets (nom_status) VALUES
('En attente'),
('Approuve'),
('Rejete'),
('Rembourse');

-- Types de transactions
INSERT INTO Type_transactions (nom_type_transactions) VALUES
('Depot'),
('Retrait');

-- Clients
INSERT INTO Clients (nom_clients, prenom_clients, date_naissance, salaire) VALUES
('Dupont', 'Jean', '1980-05-12', 3500.00),
('Martin', 'Claire', '1992-11-23', 2800.00),
('Durand', 'Paul', '1975-03-30', 4200.00);

-- Fonds
INSERT INTO Fonds (montant_fonds) VALUES
(1000000.00),
(500000.00);

-- Taux (liés aux types de prêts créés plus haut)
INSERT INTO Taux (id_types_pret, pourcentage) VALUES
(1, 3.50),
(2, 6),
(3, 4.10);

-- Details_fonds (liés aux fonds, types de transactions, id_prets NULL pour test simple)
INSERT INTO Details_fonds (id_fonds, id_type_transactions, date_details, id_prets) VALUES
(1, 1, '2024-01-10', NULL),
(2, 1, '2024-01-15', NULL);

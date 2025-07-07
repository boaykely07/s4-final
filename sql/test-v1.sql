-- Types de pret
INSERT INTO Types_pret (nom_type_pret) VALUES
('Pret Immobilier'),        -- id = 1
('Pret Auto'),              -- id = 2
('Pret à la Consommation'); -- id = 3

-- Taux associés à chaque type de pret
INSERT INTO Taux (id_types_pret, pourcentage) VALUES
(1, 3.50),  -- Pret Immobilier
(2, 5.00),  -- Pret Auto
(3, 7.25);  -- Pret à la Consommation

-- Clients
INSERT INTO Clients (nom_clients, prenom_clients, date_naissance, salaire) VALUES
('Dupont', 'Jean', '1985-04-12', 3500.00),  -- id = 1
('Martin', 'Marie', '1992-09-23', 2800.50), -- id = 2
('Moreau', 'Luc', '1995-01-30', 2100.00);   -- id = 3

-- Prets
INSERT INTO Prets (id_types_pret, id_clients, montant_prets, date_debut, duree_en_mois) VALUES
(1, 1, 200000.00, '2023-01-15', 240), -- Jean Dupont, Pret Immo, 20 ans
(2, 2, 15000.00, '2023-03-01', 60),   -- Marie Martin, Pret Auto, 5 ans
(3, 3, 5000.00, '2023-04-05', 36);    -- Luc Moreau, Pret Conso, 3 ans

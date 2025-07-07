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

-- Echéances pour Jean Dupont (prêt id=1)
INSERT INTO Echeances (id_prets, numero_echeance, date_echeance, montant_capital, montant_interets, montant_total, solde_restant) VALUES
(1, 1, '2023-02-15', 800.00, 600.00, 1400.00, 199200.00),
(1, 2, '2023-03-15', 800.00, 590.00, 1390.00, 198400.00),
(1, 3, '2023-04-15', 800.00, 580.00, 1380.00, 197600.00);

-- Echéances pour Marie Martin (prêt id=2)
INSERT INTO Echeances (id_prets, numero_echeance, date_echeance, montant_capital, montant_interets, montant_total, solde_restant) VALUES
(2, 1, '2023-04-10', 250.00, 62.50, 312.50, 14750.00),
(2, 2, '2023-05-10', 250.00, 61.00, 311.00, 14500.00),
(2, 3, '2023-06-10', 250.00, 59.50, 309.50, 14250.00);

-- Echéances pour Luc Moreau (prêt id=3)
INSERT INTO Echeances (id_prets, numero_echeance, date_echeance, montant_capital, montant_interets, montant_total, solde_restant) VALUES
(3, 1, '2023-05-20', 140.00, 30.21, 170.21, 4860.00),
(3, 2, '2023-06-20', 140.00, 29.50, 169.50, 4720.00),
(3, 3, '2023-07-20', 140.00, 28.80, 168.80, 4580.00);

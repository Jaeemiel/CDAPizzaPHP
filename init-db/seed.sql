USE CDAPizza;

INSERT INTO client (nom, prenom, telephone, rue, code_postal, ville) VALUES
('Dupont', 'Jean', '0612345678', '12 rue des Lilas', '40000', 'Mont-de-Marsan'),
('Martin', 'Marie', '0623456789', '5 avenue de la Paix', '40000', 'Mont-de-Marsan'),
('Durand', 'Pierre', '0634567890', '8 rue du Moulin', '40100', 'Dax'),
('Leroy', 'Sophie', '0645678901', '3 boulevard Victor Hugo', '40100', 'Dax');

INSERT INTO pizza (libelle, ingredients, prix, en_stock) VALUES
('Pepperoni', 'Tomate, Mozzarella, Pepperoni', 10.50, 1),
('Classique', 'Tomate, Mozzarella, Jambon', 9.00, 1),
('Savoyarde', 'Crème, Reblochon, Lardons, Pommes de terre', 11.50, 1),
('Végétarienne', 'Tomate, Mozzarella, Poivrons, Champignons', 8.50, 1);

INSERT INTO commande (created_at, etat, montant_final, client_id) VALUES
('2024-03-01 12:00:00', 'LIVRER', 48.00, 1),
('2024-03-02 19:30:00', 'PRETE', 28.50, 2),
('2024-03-03 20:00:00', 'PREPARATION', 33.50, 3),
('2024-03-05 13:00:00', 'LIVRER', 32.40, 1),
('2024-03-06 20:00:00', 'PREPARATION', 49.88, 1),
('2024-03-04 18:45:00', 'PAYER', 29.50, 4);

INSERT INTO commande_pizza (commande_id, pizza_id, nb_pizza, prix_unitaire) VALUES
(1, 1, 2, 10.50),
(1, 2, 3, 9.00),
(2, 3, 1, 11.50),
(2, 4, 2, 8.50),
(3, 1, 1, 10.50),
(3, 3, 2, 11.50),
(4, 2, 4, 9.00),
(5, 1, 5, 10.50),
(6, 2, 2, 9.00),
(6, 3, 1, 11.50);

USE CDAPersonnel;

INSERT INTO utilisateur (login, password, role) VALUES
('guichet1', '$2y$10$nd.1ipCZiGnSuhx6HaB0D.lSGbKcw1tWcMtOi04FRY.UrTg0OnRii', 'GUICHET'),
('cuisine1', '$2y$10$swd8X6uew21DGxYz3khwquCuNjgL7PUNLY/PaF11GTlPmxdymEynC', 'CUISINE');
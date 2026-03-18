INSERT INTO client (pseudo, telephone, rue, code_postal, ville) VALUES
('Jean', '0612345678', '12 rue des Lilas', '40000', 'Mont-de-Marsan'),
('Marie', '0623456789', '5 avenue de la Paix', '40000', 'Mont-de-Marsan'),
('Pierre', '0634567890', '8 rue du Moulin', '40100', 'Dax'),
('Sophie', '0645678901', '3 boulevard Victor Hugo', '40100', 'Dax');

INSERT INTO type_pizza (libelle) VALUES
('Pepperoni'),
('Classique'),
('Savoyarde'),
('Végétarienne');

INSERT INTO pizza (prix, type_id) VALUES
(10.50, 1),
(9.00, 2),
(11.50, 3),
(8.50, 4);

INSERT INTO ingredient (libelle, en_stock) VALUES
('Tomate', 1),
('Mozzarella', 1),
('Pepperoni', 1),
('Jambon', 1),
('Crème', 1),
('Reblochon', 1),
('Lardons', 1),
('Pommes de terre', 1),
('Poivrons', 1),
('Champignons', 1);

INSERT INTO ingredient_type_pizza (ingredient_id, type_pizza_id, quantite, unite) VALUES
(1, 1, 100, 'g'),
(2, 1, 150, 'g'),
(3, 1, 80, 'g'),
(1, 2, 100, 'g'),
(2, 2, 150, 'g'),
(4, 2, 80, 'g'),
(5, 3, 200, 'ml'),
(6, 3, 150, 'g'),
(7, 3, 100, 'g'),
(8, 3, 200, 'g'),
(1, 4, 100, 'g'),
(2, 4, 150, 'g'),
(9, 4, 80, 'g'),
(10, 4, 80, 'g');

INSERT INTO commande (date_heure, etat, client_id) VALUES
('2024-03-01 12:00:00', 'LIVRER', 1),
('2024-03-02 19:30:00', 'PRETE', 2),
('2024-03-03 20:00:00', 'PREPARATION', 3),
('2024-03-05 13:00:00', 'LIVRER', 1),
('2024-03-06 20:00:00', 'PREPARATION', 1),
('2024-03-04 18:45:00', 'PAYER', 4);

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


SELECT cl.pseudo, COUNT(co.client_id)
FROM client as cl, command as co
WHERE cl.id = co.client_id
GROUP BY client_id
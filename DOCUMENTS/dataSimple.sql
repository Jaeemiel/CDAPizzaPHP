INSERT INTO client (pseudo, telephone, rue, code_postal, ville) VALUES
('Jean', '0612345678', '12 rue des Lilas', '40000', 'Mont-de-Marsan'),
('Marie', '0623456789', '5 avenue de la Paix', '40000', 'Mont-de-Marsan'),
('Pierre', '0634567890', '8 rue du Moulin', '40100', 'Dax'),
('Sophie', '0645678901', '3 boulevard Victor Hugo', '40100', 'Dax');

INSERT INTO pizza (libelle, ingredients, prix, en_stock) VALUES
('Pepperoni', 'Tomate, Mozzarella, Pepperoni', 10.50, 1),
('Classique', 'Tomate, Mozzarella, Jambon', 9.00, 1),
('Savoyarde', 'Crème, Reblochon, Lardons, Pommes de terre', 11.50, 1),
('Végétarienne', 'Tomate, Mozzarella, Poivrons, Champignons', 8.50, 1);

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
FROM client as cl, commande as co
WHERE cl.id = co.client_id
GROUP BY client_id;
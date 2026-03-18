--1ere tenta
DROP TABLE IF EXISTS commande_pizza;
DROP TABLE IF EXISTS commande;
DROP TABLE IF EXISTS pizza;
DROP TABLE IF EXISTS client;

CREATE TABLE IF NOT EXISTS client(
    id INT AUTO_INCREMENT PRIMARY KEY,
    pseudo VARCHAR(255) NOT NULL,
    nb_commande INT
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS pizza(
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(100) NOT NULL,
    prix DECIMAL(10,2) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS commande(
    id INT AUTO_INCREMENT PRIMARY KEY,
    montant DECIMAL(10,2) NOT NULL, -- 10 = nb de chiffre total
    date_heure DATETIME,
    client_id INT NOT NULL,
    etat ENUM('PAYER', 'PREPARATION', 'PRETE','LIVRER') DEFAULT 'PAYER',
    FOREIGN KEY (client_id) REFERENCES client(id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS commande_pizza(
    commande_id INT NOT NULL,
    pizza_id INT NOT NULL,
    nb_pizza INT NOT NULL,
    PRIMARY KEY (commande_id, pizza_id),
    FOREIGN KEY (commande_id) REFERENCES commande(id) ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (pizza_id) REFERENCES pizza(id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;


--TRIGGER nbcommande
-- 1ere tenta => mauvais endroit et ne marche pas comme ça
DELIMITER $$

CREATE TRIGGER trg_calcule_nbcommande_after_insert
AFTER INSERT ON client
FOR EACH ROW
BEGIN
  UPDATE client SET NEW.nb_commande = OLD.nb_commande + 1;
END$$

DELIMITER ;

DELIMITER $$

-- 2 eme tenta :
DELIMITER $$

CREATE TRIGGER trg_calcule_nbcommande_after_insert
AFTER INSERT ON commande
FOR EACH ROW
BEGIN
  UPDATE client SET nb_commande = nb_commande + 1 where id = NEW.client_id;
END$$

DELIMITER ;



-- TRIGGER Montant AFTER INSERT

-- 1ere tenta => on ne connait pas prix et ne savait pas qu'on pouvait faire des variables
DELIMITER $$

CREATE TRIGGER trg_calcule_montant_after_insert
AFTER INSERT ON commande_pizza
FOR EACH ROW
BEGIN
  UPDATE commande set montant = montant + (NEW.nb_pizza * prix) where id = NEW.commande_id;
END$$

DELIMITER ;

-- 2 eme tenta => pas SELECT mais un SELECT INTO
DELIMITER $$

CREATE TRIGGER trg_calcule_montant_after_insert
AFTER INSERT ON commande_pizza
FOR EACH ROW
BEGIN
  DECLARE prix DECIMAL(10,2);
  SET prix = SELECT prix FROM pizza WHERE pizza_id = id;
  UPDATE commande set montant = montant + (NEW.nb_pizza * prix) where id = NEW.commande_id;
END$$

DELIMITER ;


-- 3 eme tenta => soit set soit select into ?? et acces a commande_pizza
DELIMITER $$

CREATE TRIGGER trg_calcule_montant_after_insert
AFTER INSERT ON commande_pizza
FOR EACH ROW
BEGIN
  DECLARE prix DECIMAL(10,2);
  SET prix = SELECT p.prix into prix FROM pizza as p, commande_pizza as c WHERE c.pizza_id = p.id;
  UPDATE commande set montant = montant + (NEW.nb_pizza * prix) where id = NEW.commande_id;
END$$

DELIMITER ;

-- 4 eme tenta
DELIMITER $$

CREATE TRIGGER trg_calcule_montant_after_insert
AFTER INSERT ON commande_pizza
FOR EACH ROW
BEGIN
  DECLARE prix DECIMAL(10,2);
  SELECT p.prix INTO prix FROM pizza as p WHERE NEW.pizza_id = p.id;
  UPDATE commande set montant = montant + (NEW.nb_pizza * prix) where id = NEW.commande_id;
END$$

DELIMITER ;


-- TRIGGER Montant AFTER Update

-- 1ere tenta => mauvaise logique
DELIMITER $$

CREATE TRIGGER trg_calcule_montant_after_update
AFTER Update ON commande_pizza
FOR EACH ROW
BEGIN
  DECLARE prix DECIMAL(10,2);
  SELECT p.prix INTO prix FROM pizza as p WHERE NEW.pizza_id = p.id;
  UPDATE commande set montant = OLD.montant + (NEW.nb_pizza * prix) where id = NEW.commande_id;
END$$

DELIMITER ;


-- 2eme tenta => bonne logique mais Old.montant pas acces
DELIMITER $$

CREATE TRIGGER trg_calcule_montant_after_update
AFTER Update ON commande_pizza
FOR EACH ROW
BEGIN
  DECLARE prix DECIMAL(10,2);
  SELECT p.prix INTO prix FROM pizza as p WHERE NEW.pizza_id = p.id;
  UPDATE commande set montant = montant - OLD.montant + (NEW.nb_pizza * prix) where id = NEW.commande_id;
END$$

DELIMITER ;


-- 3eme tenta
DELIMITER $$

CREATE TRIGGER trg_calcule_montant_after_update
AFTER Update ON commande_pizza
FOR EACH ROW
BEGIN
  DECLARE newPrix DECIMAL(10,2);
  DECLARE oldPrix DECIMAL(10,2);
  SELECT p.prix INTO newPrix FROM pizza as p WHERE NEW.pizza_id = p.id;
  SELECT p.prix INTO oldPrix FROM pizza as p WHERE OLD.pizza_id = p.id;
  UPDATE commande set montant = montant - (OLD.nb_pizza * oldPrix) + (NEW.nb_pizza * newPrix) where id = NEW.commande_id;
END$$

DELIMITER ;

-------------------------------------------------------------------------------------------------------------------------------

--2eme tenta
DROP TABLE IF EXISTS commande_pizza;
DROP TABLE IF EXISTS ingredient_type_pizza;
DROP TABLE IF EXISTS commande;
DROP TABLE IF EXISTS pizza;
DROP TABLE IF EXISTS client;
DROP TABLE IF EXISTS ingredient;
DROP TABLE IF EXISTS type_pizza;

CREATE TABLE IF NOT EXISTS client(
    id INT AUTO_INCREMENT PRIMARY KEY,
    pseudo VARCHAR(50) NOT NULL,
    telephone VARCHAR(12) NOT NULL,
    rue VARCHAR(255) NOT NULL,
    code_postal VARCHAR(10) NOT NULL,
    ville VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS type_pizza(
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS pizza(
    id INT AUTO_INCREMENT PRIMARY KEY,
    prix DECIMAL(10,2) NOT NULL,
    type_id INT NOT NULL,
    FOREIGN KEY (type_id) REFERENCES type_pizza(id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS commande(
    id INT AUTO_INCREMENT PRIMARY KEY,
    montant DECIMAL(10,2) NOT NULL DEFAULT 0, -- 10 = nb de chiffre total
    date_heure DATETIME,
    etat ENUM('PAYER', 'PREPARATION', 'PRETE','LIVRER') DEFAULT 'PAYER',
    client_id INT NOT NULL,
    FOREIGN KEY (client_id) REFERENCES client(id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS commande_pizza(
    commande_id INT NOT NULL,
    pizza_id INT NOT NULL,
    nb_pizza INT NOT NULL,
    prix_unitaire DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (commande_id, pizza_id),
    FOREIGN KEY (commande_id) REFERENCES commande(id) ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (pizza_id) REFERENCES pizza(id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS ingredient(
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(100) NOT NULL,
    en_stock BOOLEAN NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS ingredient_type_pizza(
    ingredient_id INT NOT NULL,
    type_pizza_id INT NOT NULL,
    quantite INT NOT NULL,
    unite VARCHAR(20) NOT NULL,
    PRIMARY KEY (ingredient_id, type_pizza_id),
    FOREIGN KEY (ingredient_id) REFERENCES ingredient(id) ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (type_pizza_id) REFERENCES type_pizza(id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

DELIMITER $$

CREATE TRIGGER trg_calcule_montant_after_insert
AFTER INSERT ON commande_pizza
FOR EACH ROW
BEGIN
  UPDATE commande set montant = montant + (NEW.nb_pizza * New.prix_unitaire) where id = NEW.commande_id;
END$$

DELIMITER ;

DELIMITER $$

CREATE TRIGGER trg_calcule_montant_after_update
AFTER Update ON commande_pizza
FOR EACH ROW
BEGIN
  UPDATE commande set montant = montant - (OLD.nb_pizza * OLD.prix_unitaire) + (NEW.nb_pizza * NEW.prix_unitaire) where id = NEW.commande_id;
END$$

DELIMITER ;
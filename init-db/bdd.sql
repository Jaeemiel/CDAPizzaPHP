-- ================================================
-- BASE COMMANDE PIZZERIA
-- ================================================
CREATE DATABASE IF NOT EXISTS CDAPizza;
GRANT ALL PRIVILEGES ON CDAPizza.* TO 'lambdas'@'%';

USE CDAPizza;
 DROP TABLE IF EXISTS commande_pizza;
 DROP TABLE IF EXISTS commande;
 DROP TABLE IF EXISTS pizza;
 DROP TABLE IF EXISTS client;


-- Maj traçabilité : Client, Pizza, Utilisateur
-- Maj table client pseudo -> nom, prénom
CREATE TABLE IF NOT EXISTS client(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    telephone VARCHAR(12) NOT NULL,
    rue VARCHAR(255) NOT NULL,
    code_postal VARCHAR(10) NOT NULL,
    ville VARCHAR(100) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
    ) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS pizza(
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(100) NOT NULL,
    ingredients TEXT NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    en_stock BOOLEAN NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
    ) ENGINE=InnoDB;

-- maj date_heure -> created_at
CREATE TABLE IF NOT EXISTS commande(
    id INT AUTO_INCREMENT PRIMARY KEY,
    montant DECIMAL(10,2) NOT NULL DEFAULT 0, -- 10 = nb de chiffre total
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    etat ENUM('PAYER', 'PREPARATION', 'PRETE','LIVRER') DEFAULT 'PAYER',
    commentaire TEXT,
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

-- ================================================
-- BASE PERSONNEL
-- ================================================

CREATE DATABASE IF NOT EXISTS CDAPersonnel;
GRANT ALL PRIVILEGES ON CDAPersonnel.* TO 'lambdas'@'%';

USE CDAPersonnel;
DROP TABLE IF EXISTS utilisateur;

CREATE TABLE IF NOT EXISTS utilisateur (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    login    VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,     -- hash bcrypt, jamais en clair
    role     ENUM('GUICHET', 'CUISINE') NOT NULL,
    actif    BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
    ) ENGINE=InnoDB;


-- actif comme en_stock pour pizza c'est temporaire
-- delete_at c'est définitif jusqu'à qu'on le rembauche


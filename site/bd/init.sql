-- Suppression des tables existantes si elles existent
DROP TABLE IF EXISTS Avis CASCADE;
DROP TABLE IF EXISTS Evenement CASCADE;
DROP TABLE IF EXISTS Actualite CASCADE;
DROP TABLE IF EXISTS Commande CASCADE;
DROP TABLE IF EXISTS Messages CASCADE;
DROP TABLE IF EXISTS Utilisateur CASCADE;
DROP TABLE IF EXISTS Sous_article CASCADE;
DROP TABLE IF EXISTS Article CASCADE;
DROP TABLE IF EXISTS Rubrique CASCADE;

-- Création de la table 'Utilisateur'
CREATE TABLE Utilisateur (
						  id SERIAL PRIMARY KEY,
                          num_etu CHAR(8) NOT NULL,
                          est_admin BOOLEAN NOT NULL,
						  newsletter BOOLEAN NOT NULL,
						  prenom VARCHAR(255) NOT NULL,
                          nom VARCHAR(255) NOT NULL,
                          email VARCHAR(255) NOT NULL,
                          mdp VARCHAR(255) NOT NULL
);

INSERT INTO Utilisateur (num_etu, est_admin, newsletter, prenom, nom, email, mdp) VALUES ('', TRUE, FALSE, 'Owner', '', 'owner@mail.com', '$2y$10$tXrXVbIJ5L2VXUR7Avcq1ORxMD7oD4TaRv50zQqvP39ib9Ojd3mqe');

-- Création de la table 'Evenement'
CREATE TABLE Evenement (
                       id SERIAL PRIMARY KEY,
                       nom VARCHAR(255) NOT NULL,
                       date TIMESTAMP NOT NULL,
                       description TEXT NOT NULL,
                       adresse VARCHAR(255),
                       nb_places INT NOT NULL
);

-- Création de la table 'Article'
CREATE TABLE Article (
                         id SERIAL PRIMARY KEY,
                         categorie VARCHAR(255) NOT NULL,
                         nom VARCHAR(255) NOT NULL,
						 description TEXT NOT NULL,
                         prix DECIMAL(10, 2) NOT NULL
);



-- Création de la table 'Sous_article'
CREATE TABLE Sous_article (
                        id SERIAL PRIMARY KEY,
                        article_id INT NOT NULL,
                        couleur VARCHAR(255),
                        taille VARCHAR(10),
                        stock INT NOT NULL,
                        FOREIGN KEY (article_id) REFERENCES Article(id) ON DELETE CASCADE
);

-- Création de la table 'Rubrique'
CREATE TABLE Rubrique (
                       id SERIAL PRIMARY KEY,
                       nom VARCHAR(255) NOT NULL,
                       description TEXT NOT NULL
);

-- Création de la table 'Commande'
CREATE TABLE Commande (
                          numero SERIAL PRIMARY KEY,
                          article_id INT NOT NULL,
                          utilisateur_id SERIAL,
                          nb_articles INT NOT NULL,
                          date TIMESTAMP NOT NULL,
                          FOREIGN KEY (article_id) REFERENCES Sous_article(id) ON DELETE CASCADE,
                          FOREIGN KEY (utilisateur_id) REFERENCES Utilisateur(id) ON DELETE CASCADE
);


-- Création de la table 'Actualite'
CREATE TABLE Actualite (
                          id SERIAL PRIMARY KEY,
                          utilisateur_id SERIAL,
                          objet VARCHAR(255) NOT NULL,
                          date TIMESTAMP NOT NULL,
                          contenu TEXT NOT NULL,
                          FOREIGN KEY (utilisateur_id) REFERENCES Utilisateur(id) ON DELETE CASCADE
);

-- Création de la table 'Messages'
CREATE TABLE Messages (
                          id SERIAL PRIMARY KEY, 
                          utilisateur_id SERIAL,
                          objet VARCHAR(255) NOT NULL,
                          date TIMESTAMP NOT NULL,
                          contenu TEXT NOT NULL,
                          FOREIGN KEY (utilisateur_id) REFERENCES Utilisateur(id) ON DELETE CASCADE
);


-- Création de la table 'Avis'
CREATE TABLE Avis (
                          id SERIAL PRIMARY KEY, 
                          utilisateur_id SERIAL,
                          note INT NOT NULL CHECK (note BETWEEN 1 AND 5),
                          contenu TEXT,
                          FOREIGN KEY (utilisateur_id) REFERENCES Utilisateur(id) ON DELETE CASCADE
);

-- Création de la procédure pour insérer un article avec un sous-article par défaut
CREATE OR REPLACE PROCEDURE CreateArticleWithSousArticle(
    p_categorie VARCHAR(255),
    p_nom VARCHAR(255),
    p_description TEXT,
    p_prix DECIMAL(10, 2)
)
LANGUAGE plpgsql
AS $$
BEGIN
    INSERT INTO Article (categorie, nom, description, prix)
    VALUES (p_categorie, p_nom, p_description, p_prix);
    
    PERFORM pg_catalog.setval('article_id_seq', lastval(), true);

    INSERT INTO Sous_article (article_id, couleur, taille, stock)
    VALUES (lastval(), NULL, NULL, 0);
END;
$$;

-- Création de la procédure pour modifier un sous-article
CREATE OR REPLACE PROCEDURE UpdateSousArticle(
    p_id INT,              -- ID du sous-article à modifier
    p_couleur VARCHAR(255), -- nouvelle couleur
    p_taille VARCHAR(10),   -- nouvelle taille
    p_stock INT            -- nouveau stock
)
LANGUAGE plpgsql
AS $$
BEGIN
    UPDATE Sous_article
    SET couleur = p_couleur,
        taille = p_taille,
        stock = p_stock
    WHERE id = p_id;
END;
$$;

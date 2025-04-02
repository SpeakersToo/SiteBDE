-- Suppression des tables existantes si elles existent
DROP TABLE IF EXISTS Avis CASCADE;
DROP TABLE IF EXISTS Evenement CASCADE;
DROP TABLE IF EXISTS Actualite CASCADE;
DROP TABLE IF EXISTS Commande CASCADE;
DROP TABLE IF EXISTS Messages CASCADE;
DROP TABLE IF EXISTS Utilisateur CASCADE;
DROP TABLE IF EXISTS Sous_article CASCADE;
DROP TABLE IF EXISTS Article CASCADE;

-- Création de la table 'Utilisateur'
CREATE TABLE Utilisateur (
						  id SERIAL PRIMARY KEY,
                          num_etu CHAR(8) NOT NULL,
                          est_admin BOOLEAN NOT NULL,
						  prenom VARCHAR(255) NOT NULL,
                          nom VARCHAR(255) NOT NULL,
                          email VARCHAR(255) NOT NULL,
                          mdp VARCHAR(255) NOT NULL
);

INSERT INTO Utilisateur (num_etu, est_admin, prenom, nom, email, mdp) VALUES ('', TRUE, 'owner', '', '', '$2y$10$tXrXVbIJ5L2VXUR7Avcq1ORxMD7oD4TaRv50zQqvP39ib9Ojd3mqe');

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
                        couleur VARCHAR(255) NOT NULL,
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


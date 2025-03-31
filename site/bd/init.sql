-- Suppression des tables existantes si elles existent
DROP TABLE IF EXISTS Avis CASCADE;
DROP TABLE IF EXISTS Evenement CASCADE;
DROP TABLE IF EXISTS Actualite CASCADE;
DROP TABLE IF EXISTS Utilisateur CASCADE;
DROP TABLE IF EXISTS Commande CASCADE;
DROP TABLE IF EXISTS Article CASCADE;
DROP TABLE IF EXISTS Sous_article CASCADE;
DROP TABLE IF EXISTS Messages CASCADE;

-- Création de la table 'Utilisateur'
CREATE TABLE Utilisateur (
                          numetu VARCHAR(8) PRIMARY KEY,
                          estAdmin BOOLEAN NOT NULL,
                          nom VARCHAR(255) NOT NULL,
                          prenom VARCHAR(255) NOT NULL,
                          mail VARCHAR(255) NOT NULL,
                          pwd VARCHAR(255) NOT NULL
);

-- Création de la table 'Evenement'
CREATE TABLE Evenement (
                       id SERIAL PRIMARY KEY,
                       nom VARCHAR(255) NOT NULL,
                       date TIMESTAMP NOT NULL,
                       description TEXT NOT NULL,
                       nb_places INT NOT NULL
);

-- Création de la table 'Article'
CREATE TABLE Article (
                         id SERIAL PRIMARY KEY,
                         categorie VARCHAR(255) NOT NULL,
                         nom VARCHAR(255) NOT NULL,
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


-- Création de la table 'Commande'
CREATE TABLE Commande (
                          numero SERIAL PRIMARY KEY,
                          article_id INT NOT NULL,
                          numetu VARCHAR(8),
                          nb_articles INT NOT NULL,
                          date TIMESTAMP NOT NULL,
                          FOREIGN KEY (article_id) REFERENCES Sous_article(id) ON DELETE CASCADE,
                          FOREIGN KEY (numetu) REFERENCES Utilisateur(numetu) ON DELETE CASCADE
);


-- Création de la table 'Actualite'
CREATE TABLE Actualite (
                          id SERIAL PRIMARY KEY,
                          auteur_numetu VARCHAR(8),
                          objet VARCHAR(255) NOT NULL,
                          date TIMESTAMP NOT NULL,
                          contenu TEXT NOT NULL,
                          FOREIGN KEY (auteur_numetu) REFERENCES Utilisateur(numetu) ON DELETE CASCADE
);

-- Création de la table 'Messages'
CREATE TABLE Messages (
                          id SERIAL PRIMARY KEY, 
                          auteur_numetu VARCHAR(8),
                          objet VARCHAR(255) NOT NULL,
                          date TIMESTAMP NOT NULL,
                          contenu TEXT NOT NULL,
                          FOREIGN KEY (auteur_numetu) REFERENCES Utilisateur(numetu) ON DELETE CASCADE
);


-- Création de la table 'Avis'
CREATE TABLE Avis (
                          id SERIAL PRIMARY KEY, 
                          auteur_numetu VARCHAR(8),
                          note INT NOT NULL CHECK (note BETWEEN 1 AND 5),
                          contenu TEXT,
                          FOREIGN KEY (auteur_numetu) REFERENCES Utilisateur(numetu) ON DELETE CASCADE
);


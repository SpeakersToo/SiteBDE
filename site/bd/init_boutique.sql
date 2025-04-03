DELETE FROM Article;

-- Insertion des événements
CALL CreateArticleWithSousArticle('GOODIES', 'Clé USB', 'Une clé USB du BDE de 32 Go', 15.99);
CALL CreateArticleWithSousArticle('GOODIES', 'Tasse', 'Une tasse en porcelaine promotant le BDE', 9.99);
CALL CreateArticleWithSousArticle('TEXTILE', 'Casquette', 'Une casquette pour représenter le BDE', 9.99);
CALL CreateArticleWithSousArticle('TEXTILE', 'Bob', 'Un bob pour représenter le BDE', 9.99);

CALL CreateArticleWithSousArticle('TEXTILE', 'T-Shirt', 'Un T-shirt pour à l''icône du BDE', 20);
CALL CreateArticleWithSousArticle('TEXTILE', 'Pull', 'Un pull pour représenter le BDE', 40);

INSERT INTO Sous_article (article_id, couleur, taille, stock) VALUES
(4, 'Black', 'S', 10),
(4, 'Black', 'M', 10),
(4, 'Black', 'L', 10),
(4, 'Black', 'XL', 10),
(4, 'White', 'S', 10),
(4, 'White', 'M', 10),
(4, 'White', 'L', 10),
(4, 'White', 'XL', 10),
(4, 'Pink', 'S', 10),
(4, 'Pink', 'M', 10),
(4, 'Pink', 'L', 10),
(4, 'Pink', 'XL', 10);
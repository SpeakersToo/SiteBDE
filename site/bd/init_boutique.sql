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
(4, 'Black', 'M', 8),
(4, 'Black', 'L', 7),
(4, 'Black', 'XL', 3),
(4, 'Green', 'S', 42),
(4, 'Green', 'M', 63),
(4, 'Green', 'L', 10),
(4, 'Green', 'XL', 27),
(4, 'Orange', 'S', 12),
(4, 'Orange', 'M', 6),
(4, 'Orange', 'L', 19),
(4, 'Orange', 'XL', 1);
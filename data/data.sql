DROP TABLE IF EXISTS `posts`;
CREATE TABLE posts (
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	user VARCHAR UNIQUE,
	name VARCHAR,
	slug VARCHAR,
	description VARCHAR,
	keyswords VARCHAR,
	content TEXT,
	created DATETIME,
	publish INTEGER,
	comment INTEGER, 
	hit INTEGER
);

INSERT INTO posts (id, user, name, slug, description, keyswords, content, created, publish, comment, hit)
VALUES ('1', 'user', 'name', 'slug', 'description', 'keyswords', 'content', 'NOW()', '1', '1', '1');

DROP TABLE IF EXISTS `options`;
CREATE TABLE options (
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	name VARCHAR UNIQUE,
	value VARCHAR
);

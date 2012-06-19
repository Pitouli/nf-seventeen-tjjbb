CREATE TABLE modele (
	id SERIAL PRIMARY KEY,
	nom VARCHAR NOT NULL,
	capacite_fret INTEGER NOT NULL,
	capacite_voyageur SMALLINT NOT NULL
);

CREATE TABLE avion (
	id SERIAL PRIMARY KEY,
	id_modele INTEGER REFERENCES modele(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL
);

CREATE TABLE ville (
	id SERIAL PRIMARY KEY,
	nom VARCHAR UNIQUE NOT NULL
);

CREATE TABLE aeroport (
	id SERIAL PRIMARY KEY,
	nom VARCHAR NOT NULL,
	id_ville INTEGER REFERENCES ville(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL,
	UNIQUE (nom, id_ville)
);

CREATE TABLE terminal (
	id SERIAL PRIMARY KEY,
	nom VARCHAR NOT NULL,
	id_aeroport INTEGER REFERENCES aeroport(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL,
	UNIQUE (nom, id_aeroport)
);

CREATE TABLE vol (
	id SERIAL PRIMARY KEY,
	depart TIMESTAMP NOT NULL,
	arrive TIMESTAMP NOT NULL,
	id_terminal_dep INTEGER REFERENCES terminal(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL,
	id_terminal_ar INTEGER REFERENCES terminal(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL,
	id_avion INTEGER REFERENCES avion(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL,
	CHECK (arrive > depart)
);

CREATE TABLE client (
	id SERIAL PRIMARY KEY
);

CREATE TABLE particulier (
	id_client INTEGER REFERENCES client(id) ON UPDATE CASCADE ON DELETE CASCADE PRIMARY KEY,
	nom VARCHAR NOT NULL,
	prenom VARCHAR NOT NULL,
	UNIQUE (nom, prenom)
);

CREATE TABLE entreprise (
	id_client INTEGER REFERENCES client(id) ON UPDATE CASCADE ON DELETE CASCADE PRIMARY KEY,
	nom VARCHAR UNIQUE NOT NULL
);

CREATE VIEW v_client AS
    SELECT id_client, nom, prenom, 'PARTICULIER' as cat FROM particulier
	UNION
    SELECT id_client, nom, '-' as prenom, 'ENTREPRISE' as cat FROM entreprise
;

/*
CREATE VIEW reservation AS
    SELECT id, id_client, prix, 'billet' as cat FROM billet
	UNION
    SELECT id, id_client, prix, 'titre' as cat FROM titre
;

CREATE TABLE billet (
	id INTEGER DEFAULT nextval('id_reservation_seq') PRIMARY KEY,
	id_client INTEGER REFERENCES particulier(id_client) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL,
	prix REAL NOT NULL,
	CHECK (prix >= 0)  
);

CREATE TABLE titre (
	id INTEGER DEFAULT nextval('id_reservation_seq') PRIMARY KEY,
	id_client INTEGER REFERENCES client(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL,
	prix REAL NOT NULL,
	masse_fret REAL NOT NULL,
	CHECK (masse_fret >= 0 AND prix >= 0)  
);
*/

CREATE TABLE reservation (
	id SERIAL PRIMARY KEY,
	prix REAL NOT NULL,
	CHECK (prix >= 0)
);

CREATE TABLE titre (
	id_reservation INTEGER REFERENCES reservation(id) ON UPDATE CASCADE ON DELETE CASCADE PRIMARY KEY,
	id_client INTEGER REFERENCES client(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL,
	masse_fret REAL NOT NULL,
	CHECK (masse_fret >= 0)
);

CREATE TABLE billet (
	id_reservation INTEGER REFERENCES reservation(id) ON UPDATE CASCADE ON DELETE CASCADE PRIMARY KEY,
	id_particulier INTEGER REFERENCES particulier(id_client) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL
);

CREATE VIEW v_reservation AS
    SELECT b.id_reservation, b.id_particulier as id_client, r.prix, 0 as masse_fret, 'BILLET' as cat FROM billet b, reservation r WHERE b.id_reservation = r.id
	UNION
    SELECT t.id_reservation, t.id_client, r.prix, t.masse_fret, 'TITRE' as cat FROM titre t, reservation r WHERE t.id_reservation = r.id
;

CREATE TABLE supporte (
	id_modele INTEGER REFERENCES modele(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL,
	id_terminal INTEGER REFERENCES terminal(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL
);

CREATE TABLE utilise (
	id_vol INTEGER REFERENCES vol(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL,
	id_reservation INTEGER REFERENCES reservation(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL
);
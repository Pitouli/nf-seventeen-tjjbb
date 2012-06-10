CREATE TABLE modele (
	id SERIAL PRIMARY KEY,
	nom VARCHAR NOT NULL,
	capacite_fret INTEGER NOT NULL,
	capacite_voyageur SMALLINT NOT NULL
);

CREATE TABLE avion (
	id SERIAL PRIMARY KEY,
	id_modele INTEGER REFERENCES modele(id) ON DELETE CASCADE NOT NULL
);

CREATE TABLE ville (
	id SERIAL PRIMARY KEY,
	nom VARCHAR UNIQUE NOT NULL
);

CREATE TABLE aeroport (
	id SERIAL PRIMARY KEY,
	nom VARCHAR NOT NULL,
	id_ville INTEGER REFERENCES ville(id) ON DELETE CASCADE NOT NULL,
	UNIQUE (nom, id_ville)
);

CREATE TABLE terminal (
	id SERIAL PRIMARY KEY,
	nom VARCHAR NOT NULL,
	id_aeroport INTEGER REFERENCES aeroport(id) ON DELETE CASCADE NOT NULL,
	UNIQUE (nom, id_aeroport)
);

CREATE TABLE vol (
	id SERIAL PRIMARY KEY,
	depart DATE NOT NULL,
	arrive DATE NOT NULL,
	id_terminal_dep INTEGER REFERENCES terminal(id) ON DELETE CASCADE NOT NULL,
	id_terminal_ar INTEGER REFERENCES terminal(id) ON DELETE CASCADE NOT NULL,
	CHECK (arrive > depart)
);

CREATE TABLE client (
	id SERIAL PRIMARY KEY
);

CREATE TABLE particulier (
	id_client INTEGER REFERENCES client(id) ON DELETE CASCADE PRIMARY KEY,
	nom VARCHAR NOT NULL,
	prenom VARCHAR NOT NULL,
	UNIQUE (nom, prenom)
);

CREATE TABLE entreprise (
	id_client INTEGER REFERENCES client(id) ON DELETE CASCADE PRIMARY KEY,
	nom VARCHAR UNIQUE NOT NULL
);

CREATE TABLE reservation (
	id SERIAL PRIMARY KEY,
	prix REAL NOT NULL
);

CREATE TABLE billet (
	id_reservation INTEGER REFERENCES reservation(id) ON DELETE CASCADE PRIMARY KEY,
	id_particulier INTEGER REFERENCES particulier(id_client) ON DELETE CASCADE NOT NULL
);

CREATE TABLE titre (
	id_reservation INTEGER REFERENCES reservation(id) ON DELETE CASCADE PRIMARY KEY,
	id_client INTEGER REFERENCES client(id) ON DELETE CASCADE NOT NULL,
	masse_fret REAL NOT NULL
);

CREATE TABLE supporte (
	id_modele INTEGER REFERENCES modele(id) ON DELETE CASCADE NOT NULL,
	id_terminal INTEGER REFERENCES terminal(id) ON DELETE CASCADE NOT NULL
);

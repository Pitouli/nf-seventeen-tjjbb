CREATE TABLE modele (
	id SERIAL PRIMARY KEY,
	nom VARCHAR,
	capacite_fret INTEGER,
	capacite_voyageur SMALLINT
);

CREATE TABLE avion (
	id SERIAL PRIMARY KEY,
	id_modele INTEGER REFERENCES modele(id) NOT NULL
);

CREATE TABLE ville (
	id SERIAL PRIMARY KEY,
	nom VARCHAR
);

CREATE TABLE aeroport (
	id SERIAL PRIMARY KEY,
	nom VARCHAR,
	id_ville INTEGER REFERENCES ville(id) NOT NULL
);

CREATE TABLE terminal (
	id SERIAL PRIMARY KEY,
	nom VARCHAR,
	id_aeroport INTEGER REFERENCES aeroport(id) NOT NULL
);

CREATE TABLE vol (
	id SERIAL PRIMARY KEY,
	depart DATE,
	arrive DATE,
	id_terminal_dep INTEGER REFERENCES terminal(id) NOT NULL,
	id_terminal_ar INTEGER REFERENCES terminal(id) NOT NULL	
);

CREATE TABLE client (
	id SERIAL PRIMARY KEY
);

CREATE TABLE particulier (
	id_client INTEGER REFERENCES client(id) PRIMARY KEY,
	nom VARCHAR,
	prenom VARCHAR
);

CREATE TABLE entreprise (
	id_client INTEGER REFERENCES client(id)PRIMARY KEY,
	nom VARCHAR
);

CREATE TABLE reservation (
	id SERIAL PRIMARY KEY,
	prix REAL
);

CREATE TABLE billet (
	id_reservation INTEGER REFERENCES reservation(id) PRIMARY KEY,
	id_particulier INTEGER REFERENCES particulier(id_client) NOT NULL
);

CREATE TABLE titre (
	id_reservation INTEGER REFERENCES reservation(id) PRIMARY KEY,
	id_client INTEGER REFERENCES client(id) NOT NULL,
	masse_fret REAL
);

CREATE TABLE supporte (
	id_modele INTEGER REFERENCES modele(id) NOT NULL,
	id_terminal INTEGER REFERENCES terminal(id) NOT NULL
);

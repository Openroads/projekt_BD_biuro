-- Projekt Bazy danych --

-- Mariusz Grochowski		--
-- Szymon Matysik 		--
-- Tomasz Mazur			--
-- Dariusz Szyszlak		--

-- Baza danych--
-- Biuro podróży--


CREATE DATABASE IF NOT EXIST 'biuro_podrozy' DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
use 'biuro_podrozy';


-- Struktura tabeli  KLIENT --

CREATE TABLE klient (
	pesel int(11) PRIMARY KEY,
	imie varchar(20) NOT NULL,
	nazwisko varchar(20) NOT NULL,
	adres varchar(25) NOT NULL
);

-- Struktura tabeli  TERMIN --

CREATE TABLE termin(
	dataWyjazdu date NOT NULL,
	dataPowrotu date NOT NULL,
	miejsce varchar(15) NOT NULL,
	cena NOT NULL,
	numerOferty NOT NULL,

	PRIMARY KEY (dataWyjazdu,numerOferty),
	CONSTRAINT fk_oferta_nrOferty foreign key(numerOferty) references oferta(nrOferty)
	/* cos z keyami */
);





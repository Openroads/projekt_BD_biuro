-- Projekt Bazy danych --

-- Mariusz Grochowski		--
-- Szymon Matysik 		--
-- Tomasz Mazur			--
-- Dariusz Szyszlak		--

-- Baza danych--
-- Biuro podróży--

drop database biuro_podrozy;
CREATE DATABASE IF NOT EXISTS biuro_podrozy DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
use biuro_podrozy;


-- Struktura tabeli  KLIENT --

CREATE TABLE klient (
	pesel char(11) PRIMARY KEY,
	imie varchar(20) NOT NULL,
	nazwisko varchar(20) NOT NULL,
	adres varchar(25) NOT NULL

) ENGINE=InnoDB;



-- Struktura tabeli  NOCLEG --

CREATE TABLE nocleg(
	nazwa varchar(30) NOT NULL,
	rodzaj ENUM ("Willa","Hotel","Hostel") NOT NULL, /*dorzucac swoje pomysly--*/
	wyzywienie varchar(20) NOT NULL,	/*moze tez enuma z wyborem ze sniadaniem, obiad + sniadaanie , bez wyzywienia ? */
	cena decimal(10,2) NOT NULL, 
	adres varchar(25) NOT NULL,
	PRIMARY KEY(nazwa)
);

-- Struktura tabeli  OFERTA --

CREATE TABLE oferta(
	numerOferty int(4) NOT NULL,
	nazwa varchar(100) NOT NULL,
	skad varchar(10) NOT NULL,
	dokad varchar(10) NOT NULL,
	srodekTransportu varchar(15) NOT NULL,
	rodzaj ENUM('Normal','Bed & Breakast','Half Board','Full Board','All Inclusive') NOT NULL,

	PRIMARY KEY(numerOferty)
);

-- Struktura tabeli  TERMIN --

CREATE TABLE termin(
	dataWyjazdu date NOT NULL,
	dataPowrotu date NOT NULL,
	miejsce varchar(15) NOT NULL,
	cena decimal(8,2) NOT NULL,
	numerOferty int(4) NOT NULL,

	PRIMARY KEY (dataWyjazdu,numerOferty),
	CONSTRAINT fk_oferta_nrOferty FOREIGN KEY(numerOferty) REFERENCES oferta(numerOferty) ON UPDATE CASCADE ON DELETE NO ACTION
	/* cos z keyami */
);

-- Struktura tabeli  ZAKUP --

CREATE TABLE zakup(
	numerZakupu int(4) NOT NULL,
	suma decimal(10,2) NOT NULL,
	pesel char(11) NOT NULL,

	PRIMARY KEY(numerZakupu),

	CONSTRAINT fk_klient_pesel FOREIGN KEY(pesel) REFERENCES klient(pesel) ON UPDATE CASCADE ON DELETE RESTRICT
);

-- Struktura tabeli  TYP OFERTY --

CREATE TABLE typOferty(
	numerOferty int(4) NOT NULL,
	numerZakupu int(4) NOT NULL,
	nazwa varchar(30) NOT NULL,
	PRIMARY KEY(numerZakupu,numerOferty,nazwa),

	CONSTRAINT fk_oferta_nrOferty_to FOREIGN KEY(numerOferty) REFERENCES oferta(numerOferty) ON UPDATE CASCADE ON DELETE RESTRICT,
	CONSTRAINT fk_zakup_nrZakupu_to FOREIGN KEY(numerZakupu) REFERENCES zakup(numerZakupu ) ON UPDATE CASCADE ON DELETE RESTRICT,
	CONSTRAINT fk_nazwa_nocleg_to FOREIGN KEY(nazwa) REFERENCES nocleg(nazwa) ON UPDATE CASCADE ON DELETE RESTRICT
);

-- Struktura tabeli  ZAKUP TERMIN --

CREATE TABLE zakup_termin(
	numerZakupu int(4) NOT NULL,
	numerOferty int(4) NOT NULL,
	dataWyjazdu date NOT NULL,


	CONSTRAINT fk_oferta_nrOferty_zt FOREIGN KEY(numerOferty) REFERENCES oferta(numerOferty) ON UPDATE CASCADE ON DELETE RESTRICT,
	CONSTRAINT fk_zakup_nrZakupu_zt FOREIGN KEY(numerZakupu) REFERENCES zakup(numerZakupu ) ON UPDATE CASCADE ON DELETE RESTRICT,
	CONSTRAINT fk_termin_dataWyjazdu_zt  FOREIGN KEY(dataWyjazdu) REFERENCES termin(dataWyjazdu) ON UPDATE RESTRICT ON DELETE RESTRICT
);



-- Dane dla tabeli KLIENT -- 

INSERT INTO klient (pesel,imie,nazwisko,adres) VALUES
('92041507890',"Mariusz","Grochowski","Kraków Mickiewicza 33/3"),
('90101202341',"Jan","Nowy","Warszawa Warszawska 12b/4");



-- Dane dla tabeli nocleg --
INSERT INTO nocleg(nazwa,rodzaj,wyzywienie,cena,adres) VALUES
("Hotel pod Budą ","Hotel","Sniadanie",200.30,"Kraków Pradnicka 54"),
("Hotel po ","bled","bd",200.30,"Kraków Pradnicka 54");;






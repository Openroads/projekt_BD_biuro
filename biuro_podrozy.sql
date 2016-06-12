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
	rodzaj ENUM('Normal','Bed & Breakfast','Half Board','Full Board','All Inclusive') NOT NULL,

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
	numerZakupu int(4) NOT NULL AUTO_INCREMENT,
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

CREATE TABLE zakupTermin(
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
('95121205658',"Stefan","Kerr","Wrocław Konopnickiej 13/7"),
('90101202341',"Jan","Nowy","Warszawa Warszawska 12b/4"),
('93013005992',"Katarzyna","Eckel","Koło Krakowska 21"),
('87022204553',"Tomasz","Mazur","Nowy Sącz Limanowskiego 38"),
('96101609381',"Dariusz","Szyszlak","Łęki Dukielskie Randomowa 404"),
('89011904331',"Szymon","Matysik","Wałcz Śmieszna 1/1"),
('90071623830',"Robert","Lewandowski","Górnica Korki 1/4"),
('95091808858',"Anna","Arwato","Poznań Symfonii 12/34"),
('91121207341',"Jerzy","Grębosz","Gdańsk Słowackiego 44a"),
('78033008792',"Magda","Rynkowska","Piła Klęczyny 111/2"),
('88427204853',"Kinga","Matysik","Wałcz Śmieszna 1/1"),
('95111698381',"Martyna","Mazur","Nowy Sącz Limanowskiego 38"),
('96093008834',"Agnieszka","Grochowska","Kraków Mickiewicza 33/3"),
('84021402332',"Weronika","Szyszlak","Łęki Dukielskie Randomowa 404");



-- Dane dla tabeli nocleg --
INSERT INTO nocleg(nazwa,rodzaj,wyzywienie,cena,adres) VALUES
("Hotel pod Budą","Hotel","Sniadanie",200.30,"Kraków Pradnicka 54"),
("Domek Janka","Hostel","Bez wyżywienia",150.50,"Kraków Pradnicka 54"),
("Exclusive hotel","Hotel","Sniadanie",450.50,"Warszawa Pradnicka 54"),
("Willa maks","Willa","Sniadanie + Obiad",150.50,"Tokio Huaguwai 224"),
("Chatka malenka","Hostel","Bez wyżywienia",190.50,"Berlin Frusen 14");

-- Dane dla tabeli oferta --
INSERT INTO oferta(numerOferty,nazwa,skad,dokad,srodekTransportu,rodzaj) VALUES
(0001, "Wycieczka dookoła Świata", "Kraków", "Kraków", "Kajak", "Full Board"),
(0002, "Gorące Karaiby - Spełnienie marzeń...", "Gdańsk", "Karaiby", "Samolot", "All Inclusive"),
(0003, "Tropikalne Kongo - Postaw stopę w świecie wiecznej zieleni.", "Warszawa", "Kinszasa", "Pociąg", "All Inclusive"),
(0004, "Antyczne Włochy - Tropem wielkich podbojów antycznej Europy.", "Poznań", "Rzym", "Autobus", "Half Board"),
(0005, "Korea Północna - Ostatnie życzenie.", "Zamość", "Pjongjang", "Pociąg", "Bed & Breakfast"),
(0006, "Wielki Kanion - USA", "Kraków", "Nowy Jork", "Prom", "Bed & Breakfast");


-- Dane dla tabeli termin --

INSERT INTO termin (dataWyjazdu, dataPowrotu, miejsce, cena, numerOferty) VALUES
('2016-07-01', '2016-07-08', "Pjongjang", 650.50, 0005),
('2016-07-05', '2016-07-19', "Rzym", 725.99, 0004),
('2016-07-06', '2016-09-12', "Kraków", 1625.99, 0001),
('2016-07-11', '2016-07-21', "Karaiby", 660.45, 0002),
('2016-08-04', '2016-08-18', "Karaiby", 750.80, 0002),
('2016-08-24', '2016-08-31', "Nowy Jork", 680.80, 0006),
('2016-09-02', '2016-09-09', "Nowy Jork", 613.50, 0006);


DELIMITER //
CREATE PROCEDURE dokonaj_zakupu(numerOferty int(4),nazwaNoclegu varchar(30), dataWyj date,pesel char(11))
BEGIN
	set @cenaNoclegu = (select cena from nocleg where nocleg.nazwa = nazwaNoclegu);
	set @cenaTerminu = (select cena from termin where termin.dataWyjazdu = dataWyj);
	set @suma = @cenaTerminu+@cenaNoclegu;

	INSERT INTO zakup(pesel,suma) VALUES (pesel,@suma);

	set @numerZ = (select numerZakupu from zakup where zakup.pesel = pesel);

	INSERT INTO typOferty	VALUES
	(numerOferty,@numerZ,nazwaNoclegu);
	INSERT INTO zakupTermin values
	(@numerZ,numerOferty,dataWyj);
END // 
DELIMITER ;

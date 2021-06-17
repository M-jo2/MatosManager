CREATE DATABASE `MatosManagerDB` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;


CREATE TABLE `ComputerStuff` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Quantity` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ComputerStuff_UN` (`Name`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;



CREATE TABLE `OfficeStuff` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Quantity` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `OfficeStuff_UN` (`Name`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;



CREATE TABLE `Person` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `Room` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Room_UN` (`Name`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4;


CREATE TABLE `ComputerStuffToPerson` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Date` datetime DEFAULT NULL,
  `PersonID` int(11) DEFAULT NULL,
  `ComputerStuffID` int(11) DEFAULT NULL,
  `IsReturned` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`ID`),
  KEY `NewTable_FK` (`PersonID`),
  KEY `NewTable_FK_1` (`ComputerStuffID`),
  CONSTRAINT `NewTable_FK` FOREIGN KEY (`PersonID`) REFERENCES `Person` (`ID`),
  CONSTRAINT `NewTable_FK_1` FOREIGN KEY (`ComputerStuffID`) REFERENCES `ComputerStuff` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4;


CREATE TABLE `OfficeStuffToRoom` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Date` datetime DEFAULT NULL,
  `RoomID` int(11) DEFAULT NULL,
  `OfficeStuffID` int(11) DEFAULT NULL,
  `IsReturned` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`ID`),
  KEY `OfficeStuffToRoom_FK` (`OfficeStuffID`),
  KEY `OfficeStuffToRoom_FK_1` (`RoomID`),
  CONSTRAINT `OfficeStuffToRoom_FK` FOREIGN KEY (`OfficeStuffID`) REFERENCES `OfficeStuff` (`ID`),
  CONSTRAINT `OfficeStuffToRoom_FK_1` FOREIGN KEY (`RoomID`) REFERENCES `Room` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

INSERT INTO ComputerStuff (Name,Quantity) VALUES
	 ('Lenovo x201',150),
	 ('Lenovo L480',8),
	 ('Ipad 2',0),
	 ('Commodore 64',64),
	 ('Atari 8bits family',2),
	 ('AlienWare ovni 2000',7),
	 ('Raspberry 3B',2),
	 ('Cluster Arduino',2),
	 ('Amstrad CPC 6128',1),
	 ('Souris sans fil',45),
	 ('Clavier sans fil',32),
	 ('Projecteur portatif',15),
	 ('Samsung Galaxy note 2',87),
	 ('Nokia 3310',6),
	 ('Routeur cisco',10);

INSERT INTO OfficeStuff (Name,Quantity) VALUES
	 ('Projecteur',12),
	 ('Bureau',26),
	 ('Tableau blanc',5),
	 ('Télévision',2),
	 ('Ventillateur',6),
	 ('Frigo',2),
	 ('Machine à café',2),
	 ('Micro-onde',3),
	 ('Tapis',45),
	 ('Armoire',32),
	 ('Lampe de bureau',15),
	 ('Téléphone fixe',87),
	 ('Pannier en osier',1),
	 ('Balance',3);

INSERT INTO Person (Name,FirstName) VALUES
	 ('Plouk','Xavier'),
	 ('Marin','Aurélie'),
	 ('Alikha','Moustafa'),
	 ('Pasmaudus','JeanClaudus'),
	 ('Tirianna','Laurélianne'),
	 ('Koutrapoulie','Radjich'),
	 ('Matin','Martin'),
	 ('Riontousse','Mariannalita'),
	 ('Pastel','Martin'),
	 ('Ernaelsten','GG');
	
INSERT INTO Room (Name) VALUES
	 ('Direction'),
	 ('Local 000'),
	 ('Local 001'),
	 ('Local 003'),
	 ('Local 800'),
	 ('Secrétariat'),
	 ('Toilette 01'),
	 ('Toilette 02');

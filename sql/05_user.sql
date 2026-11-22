USE `pompiersdb`;

DROP TABLE IF EXISTS `password_history`;
DROP TABLE IF EXISTS `user`;

;
CREATE TABLE `user` (
  `IdUser` int(4) NOT NULL,
  `Login` varchar(50) NOT NULL,
  `Nom` varchar(50) NOT NULL,
  `Prenom` varchar(50) NOT NULL,
  `Mail` varchar(100) NOT NULL,
  `PasswordHash` varchar(255) NOT NULL,
  `Role` int(1) NOT NULL,
  `MatriculePompier` varchar(7) DEFAULT NULL,
  `Deleted` BOOLEAN NOT NULL DEFAULT FALSE,
  PRIMARY KEY (`IdUser`),
  UNIQUE KEY `Login` (`Login`),
  UNIQUE KEY `Mail` (`Mail`),
  UNIQUE KEY `MatriculePompier` (`MatriculePompier`),
  CONSTRAINT `FK_Pompier4` FOREIGN KEY (`MatriculePompier`) REFERENCES `pompiers` (`Matricule`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `password_history` (
    `IdHistory` int(11) NOT NULL AUTO_INCREMENT,
    `IdUser` int(4) NOT NULL,
    `PasswordHash` varchar(255) NOT NULL,
    `DateChange` datetime NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`IdHistory`),
    KEY `FK_User1` (`IdUser`),
    CONSTRAINT `FK_User1` FOREIGN KEY (`IdUser`) REFERENCES `user` (`IdUser`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `user` VALUES
    (1,'admin','Cannelle','Admin','admin@cannelle.local','$2y$12$RtkMPadHL3Gt9ORNitNSuOLqXUUcvLbJt.4KuFgjfW8A1xLLO1AXW',1,NULL,0),
    (2,'secretaire','Cannelle','Secretaire','secretaire@cannelle.local','$2y$12$RtkMPadHL3Gt9ORNitNSuOLqXUUcvLbJt.4KuFgjfW8A1xLLO1AXW',2,NULL,0),
    (3,'responsable','Lalien','Jul','responsable@cannelle.local','$2y$12$RtkMPadHL3Gt9ORNitNSuOLqXUUcvLbJt.4KuFgjfW8A1xLLO1AXW',3,'Ma00013',0),
    (4,'pompier','Dubois','Enzo','pompier@cannelle.local','$2y$12$RtkMPadHL3Gt9ORNitNSuOLqXUUcvLbJt.4KuFgjfW8A1xLLO1AXW',4,'Ma00001',0);

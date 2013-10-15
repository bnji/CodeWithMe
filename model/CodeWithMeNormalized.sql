/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

CREATE TABLE IF NOT EXISTS `CWM_File` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `ProjectId` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Data` mediumtext,
  `UserId` int(11) NOT NULL,
  `SolutionName` varchar(255) DEFAULT NULL,
  `ProjectName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `CWM_Project` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `SolutionId` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `CWM_Share` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `Url` char(11) NOT NULL,
  `UserId` int(10) NOT NULL,
  `FileId` int(10) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `CWM_SharedSolution` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `OwnerUserId` int(10) DEFAULT NULL,
  `FriendUserId` int(10) DEFAULT NULL,
  `SolutionId` int(10) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `CWM_Solution` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `UserId` int(10) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `CWM_SolutionProject` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `SolutionId` int(10) NOT NULL,
  `ProjectId` int(10) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `CWM_User` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `Email` varchar(255) NOT NULL,
  `EmailHash` char(40) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

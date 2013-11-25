# Dump of table CWM_ApiKey
# ------------------------------------------------------------

DROP TABLE IF EXISTS `CWM_ApiKey`;

CREATE TABLE `CWM_ApiKey` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `PublicKey` char(40) CHARACTER SET latin1 NOT NULL,
  `PrivateKey` char(40) CHARACTER SET latin1 NOT NULL,
  `AppName` varchar(25) CHARACTER SET latin1 NOT NULL,
  `AppDescription` varchar(255) CHARACTER SET latin1 NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;



# Dump of table CWM_ApiKeySession
# ------------------------------------------------------------

DROP TABLE IF EXISTS `CWM_ApiKeySession`;

CREATE TABLE `CWM_ApiKeySession` (
  `ApiKeyId` int(10) NOT NULL,
  `LastAccess` datetime NOT NULL,
  `UserId` int(10) NOT NULL,
  `TokenValue` varchar(40) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`ApiKeyId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table CWM_File
# ------------------------------------------------------------

DROP TABLE IF EXISTS `CWM_File`;

CREATE TABLE `CWM_File` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `ProjectId` int(11) NOT NULL,
  `Name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `Data` mediumtext CHARACTER SET latin1,
  `UserId` int(11) NOT NULL,
  `SolutionName` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `ProjectName` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `ShareId` int(10) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;



# Dump of table CWM_Project
# ------------------------------------------------------------

DROP TABLE IF EXISTS `CWM_Project`;

CREATE TABLE `CWM_Project` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `SolutionId` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;



# Dump of table CWM_Share
# ------------------------------------------------------------

DROP TABLE IF EXISTS `CWM_Share`;

CREATE TABLE `CWM_Share` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `Url` char(11) CHARACTER SET latin1 NOT NULL,
  `UserId` int(10) NOT NULL,
  `FileId` int(10) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;



# Dump of table CWM_SharedSolution
# ------------------------------------------------------------

DROP TABLE IF EXISTS `CWM_SharedSolution`;

CREATE TABLE `CWM_SharedSolution` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `OwnerUserId` int(10) DEFAULT NULL,
  `FriendUserId` int(10) DEFAULT NULL,
  `SolutionId` int(10) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;



# Dump of table CWM_Solution
# ------------------------------------------------------------

DROP TABLE IF EXISTS `CWM_Solution`;

CREATE TABLE `CWM_Solution` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `UserId` int(10) NOT NULL,
  `Name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;



# Dump of table CWM_SolutionProject
# ------------------------------------------------------------

DROP TABLE IF EXISTS `CWM_SolutionProject`;

CREATE TABLE `CWM_SolutionProject` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `SolutionId` int(10) NOT NULL,
  `ProjectId` int(10) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;



# Dump of table CWM_SourceDraft
# ------------------------------------------------------------

DROP TABLE IF EXISTS `CWM_SourceDraft`;

CREATE TABLE `CWM_SourceDraft` (
  `Id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Content` longtext CHARACTER SET latin1 NOT NULL,
  `Language` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `Url` varchar(11) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `Theme` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;



# Dump of table CWM_User
# ------------------------------------------------------------

DROP TABLE IF EXISTS `CWM_User`;

CREATE TABLE `CWM_User` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `Email` varchar(255) CHARACTER SET latin1 NOT NULL,
  `EmailHash` char(40) CHARACTER SET latin1 NOT NULL,
  `Password` varchar(255) CHARACTER SET latin1 NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '0',
  `IsFirstTime` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;



# Dump of table CWM_UserApiKey
# ------------------------------------------------------------

DROP TABLE IF EXISTS `CWM_UserApiKey`;

CREATE TABLE `CWM_UserApiKey` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `UserId` int(10) NOT NULL,
  `ApiKeyId` int(10) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
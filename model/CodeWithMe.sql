/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping structure for table benham_other.CWM_Share
CREATE TABLE IF NOT EXISTS `CWM_Share` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `Url` char(11) NOT NULL,
  `UserId` int(10) NOT NULL,
  `SolutionId` int(10) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping structure for table benham_other.CWM_Solution
CREATE TABLE IF NOT EXISTS `CWM_Solution` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `UserId` int(10) NOT NULL,
  `SolutionName` varchar(255) DEFAULT NULL,
  `ProjectName` varchar(255) DEFAULT NULL,
  `FileName` varchar(255) NOT NULL,
  `FileData` mediumtext,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping structure for table benham_other.CWM_User
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

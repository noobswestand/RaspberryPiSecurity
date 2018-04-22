--
-- Table structure for table `capture`
--

CREATE TABLE IF NOT EXISTS `capture` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `location` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`)
);
INSERT INTO `capture` (`ID`,`time`,`location`) VALUES (null,null,'imgs/0.jpg');


CREATE TABLE IF NOT EXISTS `weekday` (
  `ID` int(1) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
);
CREATE TABLE IF NOT EXISTS `time` (
  `ID` int(5) NOT NULL AUTO_INCREMENT,
  `start` float NOT NULL,
  `end` float NOT NULL,
  `DayID` int(11) NOT NULL,
  FOREIGN KEY (`DayID`) 	REFERENCES weekday(`ID`),
  PRIMARY KEY (`ID`)
);



INSERT INTO `weekday` (`ID`, `name`) VALUES
(1, 'Sunday'),(2, 'Monday'),(3, 'Tuesday'),(4, 'Wednesday'),(5, 'Thursday'),(6, 'Friday'),(7, 'Saturday');

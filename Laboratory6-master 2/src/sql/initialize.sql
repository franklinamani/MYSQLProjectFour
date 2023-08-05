DROP TABLE IF EXISTS `Volume`, `Authorship`, `Author`, `Book`, `Publisher`;

CREATE TABLE `Author` (
  `ID`                NUMERIC(13)           NOT NULL,
  `Name`              VARCHAR(255)          NOT NULL,
  `DateOfBirth`       DATE                  NOT NULL,

  CONSTRAINT `Author_PK` PRIMARY KEY (`ID`)
);

CREATE TABLE `Publisher` (
  `ID`                NUMERIC(13)           NOT NULL,
  `Name`              VARCHAR(255)          NOT NULL,

  CONSTRAINT `Publisher_PK` PRIMARY KEY (`ID`)
);

CREATE TABLE `Book` (
  `ISBN`              NUMERIC(13)           NOT NULL,
  `Title`             VARCHAR(255)          NOT NULL,
  `PublishDate`       DATE                  NULL,
  `Publisher_ID`      NUMERIC(13)           NOT NULL,

  CONSTRAINT `Book_PK` PRIMARY KEY (`ISBN`),
  CONSTRAINT `Book_FK` FOREIGN KEY (`Publisher_ID`) REFERENCES `Publisher` (`ID`)
);

CREATE TABLE `Volume` (
  `Series_Book_ISBN`  NUMERIC(13)           NOT NULL,
  `Volume_Book_ISBN`  NUMERIC(13)           NOT NULL,
  `Position`          NUMERIC(2) UNSIGNED   NOT NULL,

  CONSTRAINT `Volume_PK` PRIMARY KEY (`Series_Book_ISBN`, `Volume_Book_ISBN`),
  CONSTRAINT `Volume_FK_Series` FOREIGN KEY (`Series_Book_ISBN`) REFERENCES `Book` (`ISBN`),
  CONSTRAINT `Volume_FK_Volume` FOREIGN KEY (`Volume_Book_ISBN`) REFERENCES `Book` (`ISBN`)
);

CREATE TABLE `Authorship` (
  `Book_ISBN`         NUMERIC(13)           NOT NULL,
  `Author_ID`         NUMERIC(13)           NOT NULL,
  `RoyaltyPercent`    NUMERIC(3,1)          NOT NULL,
  `LeadAuthor`        BOOLEAN               NOT NULL,
  `Position`          NUMERIC(2) UNSIGNED   NOT NULL,

  CONSTRAINT `Authorship_PK` PRIMARY KEY (`Book_ISBN`, `Author_ID`),
  CONSTRAINT `Authorship_FK_Book`   FOREIGN KEY (`Book_ISBN`) REFERENCES `Book`   (`ISBN`),
  CONSTRAINT `Authorship_FK_Author` FOREIGN KEY (`Author_ID`) REFERENCES `Author` (`ID`)
);
<?php
function CreateDatabase(DatabaseHandler $Db)
{
    $Db = new DatabaseHandler();

    if (!$Db->TableExists("Rights"))
    {
        $Db->CreateTable("Rights",
                "`RightID` int(11) NOT NULL,
                `RightName` varchar(50) NOT NULL,
                PRIMARY KEY (`RightID`)",
                "ENGINE=InnoDB DEFAULT CHARSET=latin1");

        $Db->Insert("Rights", "`RightID`, `RightName`", "1, 'Admin'");
    }
                
    if (!$Db->TableExists("Users"))
    {
        $Db->CreateTable("Users",
                "`UserID` INT NOT NULL,
                `RightID` INT NULL,
                `Username` VARCHAR(30) NULL,
                `Password` VARCHAR(128) NULL,
                `Salt` VARCHAR(128) NULL,
                PRIMARY KEY (`UserID`),
                INDEX `User_Rights_idx` (`RightID` ASC),
                CONSTRAINT `Users_Rights`
                FOREIGN KEY (`RightID`)
                REFERENCES `Rights` (`RightID`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION",
                "ENGINE=InnoDB DEFAULT CHARSET=latin1");

    }
                
    if (!$Db->TableExists("FailedConnectionLogs"))
    {
        $Db->CreateTable("FailedConnectionLogs",
                "`UserID` INT NOT NULL,
                `ConnectionDate` DATETIME NOT NULL,
                PRIMARY KEY (`UserID`, `ConnectionDate`),
                CONSTRAINT `Users_FailedConnectionLogs`
                FOREIGN KEY (`UserID`)
                REFERENCES `Users` (`UserID`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION",
                "ENGINE=InnoDB DEFAULT CHARSET=latin1");
    }
                
    if (!$Db->TableExists("VerticalMenu"))
    {
        $Db->CreateTable("VerticalMenu",
                "`IndexMenu` INT NOT NULL,
                `IndexParent` INT NULL,
                `Name` VARCHAR(45) NULL,
                `Link` VARCHAR(255) NULL,
                `Color` VARCHAR(6) NULL,
                `OpenNewPage` TINYINT NULL,
                PRIMARY KEY (`IndexMenu`, `IndexParent`)",
                "ENGINE=InnoDB DEFAULT CHARSET=latin1");
    }
                
    if (!$Db->TableExists("HomeMenu"))
    {
        $Db->CreateTable("HomeMenu",
            "`Position` int(11) NOT NULL,
            `Text` varchar(30) NOT NULL,
            `FilePath` varchar(255) NOT NULL,
            `Colspan` int(11) NOT NULL,
            `Rowspan` int(11) NOT NULL",
            "ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    }
	
    if (!$Db->TableExists("QuickMenu"))
    {
        $Db->CreateTable("QuickMenu",
            "`Name` varchar(30) NOT NULL,
            `Link` varchar(255) NOT NULL"
            , "ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    }
}
?>

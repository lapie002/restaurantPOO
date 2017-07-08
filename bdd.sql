      -- insertion d un utilisateur admin via MySQL
      -- INSERT INTO `Admins` (`ID`, `NOM`, `PRENOM`, `EMAIL`, `PASSWORD`) VALUES (NULL, 'lapierre', 'bruno', 'lapierre.bruno@gmail.com', '63a9f0ea7bb98050796b649e85481845');

# -----------------------------------------------------------------------------
#       TABLE : COMPOSER
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS COMPOSER
 (
   IDPLAT INT(11) NOT NULL  ,
   IDMENU INT(11) NOT NULL
   , PRIMARY KEY (IDPLAT,IDMENU),
   FOREIGN KEY (IDPLAT) REFERENCES Plats(ID),
   FOREIGN KEY (IDMENU) REFERENCES Menus(ID)
 )
 comment = "";

# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE COMPOSER
# -----------------------------------------------------------------------------


CREATE  INDEX I_FK_COMPOSER_PLATS
     ON COMPOSER (IDPLAT ASC);

CREATE  INDEX I_FK_COMPOSER_MENUS
     ON COMPOSER (IDMENU ASC);


# -----------------------------------------------------------------------------
#       CREATION DES REFERENCES DE TABLE
# -----------------------------------------------------------------------------

ALTER TABLE COMPOSER
  ADD CONSTRAINT FK_COMPOSER_PLATS
      FOREIGN KEY (IDPLAT) REFERENCES Plats(ID);

ALTER TABLE COMPOSER
  ADD CONSTRAINT FK_COMPOSER_MENUS
      FOREIGN KEY (IDMENU) REFERENCES Menus(ID);

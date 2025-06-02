#-------------------------------------------------------------------------------
#--- Change database -----------------------------------------------------------
#-------------------------------------------------------------------------------
USE projet_panneau_solaire;

#-------------------------------------------------------------------------------
#--- Database cleanup ----------------------------------------------------------
#-------------------------------------------------------------------------------
DROP TABLE IF EXISTS lieu;
DROP TABLE IF EXISTS date;
DROP TABLE IF EXISTS installation;

#------------------------------------------------------------
Script MySQL.,
#------------------------------------------------------------


#------------------------------------------------------------
Table: date,
#------------------------------------------------------------

CREATE TABLE date(
        mois_installation  Int NOT NULL ,
        annee_installation Int NOT NULL
    ,CONSTRAINT date_PK PRIMARY KEY (mois_installation,annee_installation)
)ENGINE=InnoDB;


#------------------------------------------------------------
Table: installation,
#------------------------------------------------------------

CREATE TABLE installation(
        id_installation    Int  Auto_increment  NOT NULL ,
        nb_panneau         Int NOT NULL ,
        marque_panneau     Varchar (64) NOT NULL ,
        modele_panneau     Varchar (64) NOT NULL ,
        puissance_crete    Int NOT NULL ,
        surface            Int NOT NULL ,
        pente              Int NOT NULL ,
        production_pvgis   Int NOT NULL ,
        nb_onduleur        Int NOT NULL ,
        marque_onduleur Int NOT NULL ,
        modele_onduleur    Varchar (64) NOT NULL ,
        installateur       Varchar (64) NOT NULL ,
        mois_installation  Int NOT NULL ,
        annee_installation Int NOT NULL
    ,CONSTRAINT installation_PK PRIMARY KEY (id_installation)
,CONSTRAINT installation_date_FK FOREIGN KEY (mois_installation,annee_installation) REFERENCES date(mois_installation,annee_installation)
)ENGINE=InnoDB;


#------------------------------------------------------------
Table: lieu,
#------------------------------------------------------------

CREATE TABLE lieu(
        longitude        Float NOT NULL ,
        latitude         Float NOT NULL ,
        code_region      Int NOT NULL ,
        nom_region       Varchar (64) NOT NULL ,
        code_postal      Int NOT NULL ,
        code_departement Varchar (64) NOT NULL ,
        nom_departement  Varchar (64) NOT NULL ,
        code_insee       Int NOT NULL ,
        nom_ville        Varchar (128) NOT NULL ,
        population       Int NOT NULL ,
        id_installation  Int NOT NULL
    ,CONSTRAINT lieu_PK PRIMARY KEY (longitude,latitude)

    ,CONSTRAINT lieu_installation_FK FOREIGN KEY (id_installation) REFERENCES installation(id_installation)
)ENGINE=InnoDB;

#-------------------------------------------------------------------------------
#--- Populate databases --------------------------------------------------------
#-------------------------------------------------------------------------------

#---INSERT INTO comments(comment,photoId,userlogin) VALUES('cacaprout', '1', 'cir2');

SET autocommit = 0;
SET names utf8;

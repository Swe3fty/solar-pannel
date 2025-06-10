#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: region
#------------------------------------------------------------

CREATE TABLE region(
        nom_reg Varchar (64) NOT NULL
	,CONSTRAINT region_PK PRIMARY KEY (nom_reg)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: departementa
#------------------------------------------------------------

CREATE TABLE departement(
        nom_dep Varchar (64) NOT NULL ,
        nom_reg Varchar (64) NOT NULL
	,CONSTRAINT departement_PK PRIMARY KEY (nom_dep)

	,CONSTRAINT departement_region_FK FOREIGN KEY (nom_reg) REFERENCES region(nom_reg)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: ville
#------------------------------------------------------------

CREATE TABLE ville(
        code_insee Int NOT NULL ,
        nom_ville  Varchar (128) NOT NULL ,
        population Int NOT NULL ,
        nom_dep    Varchar (64) NOT NULL
	,CONSTRAINT ville_PK PRIMARY KEY (code_insee)

	,CONSTRAINT ville_departement_FK FOREIGN KEY (nom_dep) REFERENCES departement(nom_dep)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: installateur
#------------------------------------------------------------

CREATE TABLE installateur(
        nom_inst Varchar (64) NOT NULL
	,CONSTRAINT installateur_PK PRIMARY KEY (nom_inst)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: panneau
#------------------------------------------------------------

CREATE TABLE panneau(
        modele_panneau Varchar (64) NOT NULL ,
        marque_panneau Varchar (64) NOT NULL
	,CONSTRAINT panneau_PK PRIMARY KEY (modele_panneau)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: onduleur
#------------------------------------------------------------

CREATE TABLE onduleur(
        modele_ond Varchar (64) NOT NULL ,
        marque_ond Varchar (64) NOT NULL
	,CONSTRAINT onduleur_PK PRIMARY KEY (modele_ond)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: installation
#------------------------------------------------------------

CREATE TABLE installation(
        id_installation  Int  Auto_increment  NOT NULL ,
        nb_panneau       Int NOT NULL ,
        puissance_crete  Int NOT NULL ,
        surface          Int NOT NULL ,
        pente            Int NOT NULL ,
        production_pvgis Int NOT NULL ,
        nb_onduleur      Int NOT NULL ,
        latitude         Float NOT NULL ,
        longitude        Float NOT NULL ,
        mois_inst        Int NOT NULL ,
        annee_inst       Int NOT NULL ,
        nom_inst         Varchar (64) NOT NULL ,
        modele_ond       Varchar (64) NOT NULL ,
        modele_panneau   Varchar (64) NOT NULL ,
        code_insee       Int NOT NULL
	,CONSTRAINT installation_PK PRIMARY KEY (id_installation)

	,CONSTRAINT installation_installateur_FK FOREIGN KEY (nom_inst) REFERENCES installateur(nom_inst)
	,CONSTRAINT installation_onduleur0_FK FOREIGN KEY (modele_ond) REFERENCES onduleur(modele_ond)
	,CONSTRAINT installation_panneau1_FK FOREIGN KEY (modele_panneau) REFERENCES panneau(modele_panneau)
	,CONSTRAINT installation_ville2_FK FOREIGN KEY (code_insee) REFERENCES ville(code_insee)
)ENGINE=InnoDB;


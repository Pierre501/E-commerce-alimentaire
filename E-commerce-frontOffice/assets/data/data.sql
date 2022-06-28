-- create database e_commerce;
-- grant all privileges on database e_commerce to admin;
-- psql -d e_commerce -U admin -W

create extension pgcrypto;


create table if not exists administrateur(
	idadministrateur int not null,
	username varchar(100) not null,
	motdepasse varchar(100) not null,
	primary key(idadministrateur)
);
insert into administrateur values(1, 'administrateur@gmail.com', encode(digest('Admin2022','sha1'),'hex'));


create table if not exists client(
	idclient serial not null,
	nom varchar(100) not null,
	prenom varchar(100) not null,
	username varchar(100) not null,
	motdepasse varchar(100) not null,
	adresse varchar(255) not null,
	primary key(idclient)
);
insert into client values(default, 'Jean', 'Luc', 'jean@gmail.com',  encode(digest('jean2022','sha1'),'hex'), 'Analakely');


create table if not exists portefeuille(
	idportefeuille serial not null,
	idclient int not null,
	montant decimal(10,2) not null,
	montantdepense decimal(10,2) not null,
	status varchar(20) not null,
	datedepot date not null,
	primary key(idportefeuille),
	foreign key(idclient) references client(idclient)
);
insert into portefeuille values(default, 1, 0, 0, 'valide', '2022-06-24');


create view viewportefeuille as select idclient, sum(montant) as montant, sum(montantdepense) as montantdepense, status, current_date as dateEncours from portefeuille group by idclient, status, dateEncours;


create view viewportefeuillefinal as select idclient, montant, montantdepense, dateEncours, status, (montant-montantdepense) as solde from viewportefeuille;


create view viewsclient as select
	client.idclient,
	client.nom,
	client.prenom,
	client.username,
	client.motdepasse,
	client.adresse,
	viewportefeuillefinal.montant,
	viewportefeuillefinal.status,
	viewportefeuillefinal.montantdepense,
	viewportefeuillefinal.solde,
	viewportefeuillefinal.dateEncours
from client join viewportefeuillefinal on client.idclient = viewportefeuillefinal.idclient;



create table if not exists categories(
	idcategorie int not null,
	categorie varchar(50) not null,
	primary key(idcategorie)
);
insert into categories values(1, 'Matieres grasses');
insert into categories values(2, 'Produits laitiers');	
insert into categories values(3, 'Legumes et fruits');
insert into categories values(4, 'Produits sucres');
insert into categories values(5, 'Fruit de mer');
insert into categories values(6, 'Boissons');


create table if not exists produits(
	idproduit serial not null,
	idcategorie int not null,
	designation varchar(255) not null,
	description varchar(255) default null,
	unite varchar(20) not null,
	primary key(idproduit),
	foreign key(idcategorie) references categories(idcategorie)
);
insert into produits values(default, 1, 'Cote de porc', null, 'Kilogramme');
insert into produits values(default, 2, 'Huile', null, 'Litre');
insert into produits values(default, 2, 'Sel', null, 'Kilogramme');
insert into produits values(default, 3, 'Pomme de terre', null, 'Kilogramme');
insert into produits values(default, 3, 'Carotte', null, 'Kilogramme');
insert into produits values(default, 3, 'Poirreau', null, 'Kilogramme');
insert into produits values(default, 3, 'Haricot', null, 'Kilogramme');
insert into produits values(default, 6, 'Bouteille christalline', null, 'Nombre');
insert into produits values(default, 6, 'Fromage', null, 'Kilogramme');
insert into produits values(default, 1, 'Viande de boeuf', null, 'Kilogramme');
insert into produits values(default, 4, 'Glace vanilla choco', null, 'Kilogramme');




create table if not exists detailsproduits(
	iddetaisproduits serial not null,
	idproduit int not null,
	poidunitaire decimal(10,4) not null,
	prixUnitaire decimal(10,2) not null,
	datedetailsproduits date not null,
	primary key(iddetaisproduits),
	foreign key(idproduit) references produits(idproduit)
);
insert into detailsproduits values(default, 1, 0.5, 12000, '2022-06-24');
insert into detailsproduits values(default, 2, 0.25, 3500, '2022-06-24');
insert into detailsproduits values(default, 3, 0.2, 500, '2022-06-24');
insert into detailsproduits values(default, 4, 1, 1650, '2022-06-24');
insert into detailsproduits values(default, 5, 0.5, 1300, '2022-06-24');
insert into detailsproduits values(default, 6, 0.33, 1000, '2022-06-24');
insert into detailsproduits values(default, 7, 0.25, 2200, '2022-06-24');
insert into detailsproduits values(default, 8, 6, 9000, '2022-06-24');
insert into detailsproduits values(default, 9, 0.25, 6600, '2022-06-24');
insert into detailsproduits values(default, 10, 0.75, 17320, '2022-06-24');
insert into detailsproduits values(default, 11, 1, 21000, '2022-06-24');



create table if not exists imagesproduits(
	idimagesproduits serial not null,
	idproduit int not null,
	images varchar(255) not null,
	primary key(idimagesproduits),
	foreign key(idproduit) references produits(idproduit)
);
insert into imagesproduits values(default, 1, 'assets/images/produits/meal4.jpg');
insert into imagesproduits values(default, 2, 'assets/images/produits/yaourt-nature.jpg');
insert into imagesproduits values(default, 3, 'assets/images/produits/lait.webp');
insert into imagesproduits values(default, 4, 'assets/images/produits/pomme-de-terre.jpg');
insert into imagesproduits values(default, 5, 'assets/images/produits/carrote.jpg');
insert into imagesproduits values(default, 6, 'assets/images/produits/carrote.jpg');
insert into imagesproduits values(default, 7, 'assets/images/produits/courgette.jpg');
insert into imagesproduits values(default, 8, 'assets/images/produits/carrote.jpg');
insert into imagesproduits values(default, 9, 'assets/images/produits/fromage-fondue.jpg');
insert into imagesproduits values(default, 10, 'assets/images/produits/choux.jpg');
insert into imagesproduits values(default, 11, 'assets/images/produits/coca-cola.jpg');


create table if not exists recette(
	idrecette serial not null,
	nomrecette varchar(100) not null,
	images varchar(255) not null,
	primary key(idrecette)
);
insert into recette values(default, 'Cote de porc', 'assets/images/produits/recette1.jpg');
insert into recette values(default, 'Heno omby sy tsaramaso', 'assets/images/produits/recette1.jpg');


create table if not exists detailsrecette(
	iddetailsrecette serial not null,
	idrecette int not null,
	idproduit int not null,
	quantitedetailsrecette decimal(10,4) not null,
	seuilproduit int not null,
	primary key(iddetailsrecette),
	foreign key(idrecette) references recette(idrecette),
	foreign key(idproduit) references produits(idproduit)
);
insert into detailsrecette values(default, 1, 1, 0.75, 25);
insert into detailsrecette values(default, 1, 2, 0.2, 40);
insert into detailsrecette values(default, 1, 4, 1, 50);
insert into detailsrecette values(default, 1, 5, 1, 10);
insert into detailsrecette values(default, 1, 6, 0.5, 25);
insert into detailsrecette values(default, 2, 9, 0.5, 50);
insert into detailsrecette values(default, 2, 7, 0.6, 50);
insert into detailsrecette values(default, 2, 6, 0.1, 50);
insert into detailsrecette values(default, 2, 2, 0.05, 50);



create table if not exists stockentrant(
	idstockentrant serial not null,
	idproduit int not null,
	quantitestockentrant decimal(10,2) not null,
	datestockentrant date not null,
	primary key(idstockentrant),
	foreign key(idproduit) references produits(idproduit)
);
insert into stockentrant values(default, 1, 100, '2022-06-22');
insert into stockentrant values(default, 2, 100, '2022-06-22');
insert into stockentrant values(default, 3, 100, '2022-06-22');
insert into stockentrant values(default, 4, 100, '2022-06-22');
insert into stockentrant values(default, 5, 100, '2022-06-22');
insert into stockentrant values(default, 6, 100, '2022-06-22');
insert into stockentrant values(default, 7, 100, '2022-06-22');
insert into stockentrant values(default, 8, 100, '2022-06-22');
insert into stockentrant values(default, 9, 100, '2022-06-22');
insert into stockentrant values(default, 10, 100, '2022-06-22');

create view viewstockentrant as select idproduit, sum(quantitestockentrant) as sommequantitestockentrant from stockentrant group by idproduit;



create table if not exists stocksortant(
	idstocksortant serial not null,
	idproduit int not null,
	quantitestocksortant decimal(10,2) not null,
	datestocksortant date not null,
	primary key(idstocksortant),
	foreign key(idproduit) references produits(idproduit)
);


create view viewstocksortant as select idproduit, sum(quantitestocksortant) as sommequantitestocksortant from stocksortant group by idproduit;



create view viewstockrestant as select
	produits.designation,
	produits.unite,
	viewstockentrant.idproduit,
	viewstockentrant.sommequantitestockentrant,
	case 
		when viewstocksortant.sommequantitestocksortant is Null then 0
		else viewstocksortant.sommequantitestocksortant
	end as sommequantitestocksortant
from produits join viewstockentrant on produits.idproduit = viewstockentrant.idproduit
left join viewstocksortant on viewstockentrant.idproduit = viewstocksortant.idproduit;


create view viewstockrestantfinal as select
	viewstockrestant.designation,
	viewstockrestant.unite,
	(viewstockrestant.sommequantitestockentrant - viewstockrestant.sommequantitestocksortant) as sommequantitestockrestant,
	current_date as datestock
from viewstockrestant group by viewstockrestant.designation,viewstockrestant.unite,viewstockrestant.sommequantitestockentrant,viewstockrestant.sommequantitestocksortant,datestock;


create view viewstatistiqueproduits as select
	produits.designation,
	case 
		when stocksortant.quantitestocksortant is Null then 0
		else stocksortant.quantitestocksortant
	end as quantitestocksortant
from produits left join stocksortant on produits.idproduit = stocksortant.idproduit;


create view infosrecette as select
	produits.idproduit,
	produits.designation,
	detailsproduits.poidunitaire,
	detailsproduits.prixUnitaire,
	detailsrecette.idrecette,
	detailsrecette.quantitedetailsrecette,
	detailsrecette.seuilproduit
from detailsproduits join detailsrecette on detailsproduits.idproduit = detailsrecette.idproduit
join produits on detailsproduits.idproduit = produits.idproduit;

create view annulationpanier as select
	infosrecette.idrecette,
	panier.idpanier,
	panier.idproduit
from infosrecette join panier on infosrecette.idproduit = panier.idproduit;



create table if not exists panier(
	idpanier serial not null,
	idproduit int not null,
	quantiteproduit int not null,
	quantitepanier decimal(10,4) not null,
	prixtotal decimal(10,2) not null,
	primary key(idpanier),
	foreign key(idproduit) references produits(idproduit)
);
create view viewpanier as select idproduit, sum(quantiteproduit) as quantiteproduit, sum(quantitepanier) as quantitepanier, sum(prixtotal) as prixtotal from panier group by idproduit;

alter table panier add parentproduits varchar(20) not null;


create view listepanier as select
	viewpanier.quantiteproduit,
	produits.idproduit,
	produits.designation,
	detailsproduits.poidunitaire,
	detailsproduits.prixUnitaire,
	case 
		when viewpanier.quantitepanier = 0 then detailsproduits.poidunitaire*viewpanier.quantiteproduit
		else viewpanier.quantitepanier
	end as quantitepanier,
	case 
		when viewpanier.prixtotal = 0 then detailsproduits.prixUnitaire*viewpanier.quantiteproduit
		else viewpanier.prixtotal
	end as prixtotal
from viewpanier join produits on viewpanier.idproduit = produits.idproduit
join detailsproduits on produits.idproduit = detailsproduits.idproduit;


create table if not exists produitsrestant(
	idproduitsrestant serial not null,
	idrecette int not null,
	idproduit int not null,
	quantiteRestant decimal(10,4) not null,
	primary key(idproduitsrestant),
	foreign key(idrecette) references recette(idrecette),
	foreign key(idproduit) references produits(idproduit)
);
create view viewproduitsrestant as select idproduit, sum(quantiteRestant) as quantiteRestant from produitsrestant group by idproduit;


create view reste as select
	produits.idproduit,
	produits.designation,
	viewproduitsrestant.quantiteRestant
from produits join viewproduitsrestant on produits.idproduit = viewproduitsrestant.idproduit;


create table if not exists payement(
	idpayement serial not null,
	idclient int not null,
	montant decimal(10,2) not null,
	datepayement date not null,
	primary key(idpayement),
	foreign key(idclient) references client(idclient)
);


create view listepayement as select
	client.nom,
	client.prenom,
	sum(payement.montant) as montant,
	payement.datepayement
from client join payement on client.idclient = payement.idclient group by client.nom, client.prenom, payement.datepayement;





create table if not exists detailspayement(
	iddetailspayement serial not null,
	idpayement int not null,
	idproduit int not null,
	quantite decimal(10,4) not null,
	prixtotal decimal(10,2) not null,
	primary key(iddetailspayement),
	foreign key(idpayement) references payement(idpayement),
	foreign key(idproduit) references produits(idproduit)
);


create table if not exists statistiquerecette(
	idstatistiquerecette serial not null,
	idrecette int not null,
	quantiterecette int not null,
	primary key(idstatistiquerecette),
	foreign key(idrecette) references recette(idrecette)
);

create view viewstatistiquerecette as select 
	recette.nomrecette,
	statistiquerecette.idrecette,
	sum(statistiquerecette.quantiterecette) as quantiterecette
from recette left join statistiquerecette on recette.idrecette = statistiquerecette.idrecette
group by recette.nomrecette,statistiquerecette.idrecette;



create view viewstatistiquerecettefinal as select
	nomrecette,
	idrecette,
	case
		when quantiterecette is Null then 0
		else quantiterecette
	end as quantiterecette
from viewstatistiquerecette;





-- drop view viewpaniersfinal;
-- drop view calculquantite;
-- drop view viewstatistiqueproduits;
-- drop view viewstockrestantfinal;
-- drop view viewstockrestant;
-- drop view viewstocksortant;
-- drop view viewstockentrant;
-- drop table detailsrecette;
-- drop table recette;
-- drop table stocksortant;
-- drop table stockentrant;
-- drop table imagesproduits;
-- drop table detailsproduits;
-- drop table produits;
-- drop table categories;



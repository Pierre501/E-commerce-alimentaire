<?php

namespace App\Controllers;

use App\Models\Administrateur;
use App\Models\Categories;
use App\Models\DetailsProduits;
use App\Models\ImagesProduits;
use App\Models\ListePayement;
use App\Models\Produits;
use App\Models\Statistique;
use App\Models\StatistiqueRecette;
use App\Models\StockEntrant;
use App\Models\StockRestant;
use App\Models\ViewsClients;
use CodeIgniter\RESTful\ResourceController;

class ApiController extends ResourceController
{
    public function verificationLoginAdmin()
    {
        $data = array();
        $username = $this->request->getVar('username');
        $mdp = $this->request->getVar('motdepasse');
        if(!empty($username) && !empty($mdp))
        {
            $admin = new Administrateur();
            $admin->setUsername($username);
            $admin->setMotDePasse($mdp);
            $condition = $admin->verificationLogin();
            if($condition == true)
            {
                $data['condition'] = true;
            }
            else
            {
                $data['condition'] = false;
            }
        }
        else
        {
            $data['condition'] = false;
        }
        return $this->respondCreated($data);
    }

    public function getAllPayement()
    {
        $dataFinal = array();
        $liste = new ListePayement();
        $tabListe = $liste->getAllListePayement();
        foreach($tabListe as $liste)
        {
            $i=0;
            $data[$i]['nom'] = $liste->getNomClient();
            $data[$i]['prenom'] = $liste->getPrenomClient();
            $data[$i]['montant'] = $liste->getMontant();
            $data[$i]['datepayement'] = $liste->getDatePayement();
            $dataFinal[] = $data;
            $i++;
        }
        return $this->respondCreated($dataFinal);
    }

    public function getAllProduits()
    {
        $produits = new Produits();
        $data = $produits->findAll();
        return $this->respondCreated($data);
    }

    public function getAllCategories()
    {
        $categorie = new Categories();
        $data = $categorie->findAll();
        return $this->respondCreated($data);
    }

    public function getAllStatistiqueRecette()
    {
        $dataFinal = array();
        $statistique = new StatistiqueRecette();
        $tabStatistique = $statistique->getAllStatistiqueRecette();
        foreach($tabStatistique as $statistiques)
        {
            $i = 0;
            $data[$i]['idrecette'] = $statistiques->getIdRecette();
            $data[$i]['nomrecette'] = $statistiques->getNomRecette();
            $data[$i]['quantiterecette'] = $statistiques->getQuantiteRecette();
            $dataFinal[] = $data;
            $i++;
        }
        return $this->respondCreated($dataFinal);
    }

    public function getAllStockRestants()
    {
        $dataFinal = array();
        $stock = new StockRestant();
        $tabStock = $stock->getAllStockRestant();
        foreach($tabStock as $stockRestant)
        {
            $i = 0;
            $data[$i]['designation'] = $stockRestant->getDesignation();
            $data[$i]['quantite'] = $stockRestant->getQuantite();
            $data[$i]['dateStock'] = $stockRestant->getDateStock();
            $dataFinal[] = $data;
            $i++;
        }
        return $this->respondCreated($dataFinal);
    }

    public function getAllPorteFeuilleNonValide()
    {
        $dataFinal = array();
        $views = new ViewsClients();
        $tabPorteFeuilleNonValide = $views->getAllPorteFeuille("Non valide");
        foreach($tabPorteFeuilleNonValide as $porteFeuille)
        {
            $i = 0;
            $data[$i]['idclient'] = $porteFeuille->getIdClient();
            $data[$i]['nom'] = $porteFeuille->getNom();
            $data[$i]['prenom'] = $porteFeuille->getPrenom();
            $data[$i]['username'] = $porteFeuille->getUsername();
            $data[$i]['motdepasse'] = $porteFeuille->getMotDePasse();
            $data[$i]['adresse'] = $porteFeuille->getAdresse();
            $data[$i]['montant'] = $porteFeuille->getMontant();
            $data[$i]['status'] = $porteFeuille->getStatus();
            $data[$i]['dateencours'] = $porteFeuille->getDateDepot();
            $dataFinal[] = $data;
            $i++;
        }
        return $this->respondCreated($dataFinal);
    }

    public function getStatistiqueProduits()
    {
        $dataFinal = array();
        $statistique = new Statistique();
        $tabStatistique = $statistique->getStatistiqueProduits();
        foreach($tabStatistique as $statistiques)
        {
            $i = 0;
            $data[$i]['designation'] = $statistiques->getDesignation();
            $data[$i]['quantite'] = $statistiques->getQuantite();
            $dataFinal[] = $data;
            $i++;
        }
        return $this->respondCreated($dataFinal);
    }

    public function validationPorteFeuille()
    {
        $idClient = $this->request->getVar('idclient');
        $dateDepot = $this->request->getVar('datedepot');
        $views = new ViewsClients();
        $views->setIdClient($idClient);
        $views->setDateDepot($dateDepot);
        $views->updateAllPorteFeuille();
        $response['message'] = "Modification effectué";
        return $this->respondCreated($response);
    }

    public function addStockEntrant()
    {
        $rules['idproduit'] = "required";
        $rules['quantitestockentrant'] = "required";
        $rules['datestockentrant'] = "required";

        $messages['idproduit']['required'] = "idproduit is required";
        $messages['quantitestockentrant']['required'] = "quantitestockentrant is required";
        $messages['datestockentrant']['required'] = "datestockentrant is required";

        if(!$this->validate($rules, $messages))
        {
            $response['message'] = $this->validator->getErrors();
        }
        else
        {
            $idProduits = $this->request->getVar('idproduit');
            $quantiteStockEntrant = $this->request->getVar('quantitestockentrant');
            $dateStockEntrant = $this->request->getVar('datestockentrant');
            $stock = new StockEntrant();
            $stock->setIdProduits($idProduits);
            $stock->setQuantiteStockEntrant($quantiteStockEntrant);
            $stock->setDateStockEntrant($dateStockEntrant);
            $dataStockEntrant = $stock->getDataStockEntrant();
            $stock->save($dataStockEntrant);
            $response['message'] = "Inscription effectué";
        }
        return $this->respondCreated($response);
    }

    public function addProduits()
    {

        $rules['idcategorie'] = "required";
        $rules['designation'] = "trim|required|is_unique[produits.designation]";
        $rules['description'] = "trim|required";
        $rules['prixunitaire'] = "required";
        $rules['datedetailsproduits'] = "required";

        $messages['idcategorie']['required'] = "idcategorie is required";
        $messages['designation']['required'] = "designation is required";
        $messages['designation']['is_unique'] = "designation is unique";
        $messages['description']['required'] = "description is required";
        $messages['prixunitaire']['required'] = "prixunitaire is required";
        $messages['datedetailsproduits']['required'] = "datedetailsproduits is required";
        
        if(!$this->validate($rules, $messages))
        {
            $response['message'] = $this->validator->getErrors();
        }
        else
        {
            $idCategorie = $this->request->getVar('idcategorie');
            $designation = $this->request->getVar('designation');
            $description = $this->request->getVar('description');
            $prixUnitaire = $this->request->getVar('prixunitaire');
            $datePrixUnitaire = $this->request->getVar('datedetailsproduits');
            $produits = new Produits();
            $produits->setIdCategorie($idCategorie);
            $produits->setDesignation($designation);
            $produits->setDescription($description);
            $dataProduit = $produits->getdataInsertionProduits($produits);
            $produits->save($dataProduit);
            $idProduit = $produits->getProduitByName($designation)->getIdProduits();
            $detailsProduits = new DetailsProduits();
            $detailsProduits->setIdProduits($idProduit);
            $detailsProduits->setPrixUnitaire($prixUnitaire);
            $detailsProduits->setDateDetailsProduits($datePrixUnitaire);
            $dataDetailsProduits = $detailsProduits->getDataDetailsProduits($detailsProduits);
            $detailsProduits->save($dataDetailsProduits);
            $file = $this->request->getFile('images');
            $photo = $file->getName();
            $temp = explode(".",$photo);
            $newfilename = round(microtime(true)) . '.' . end($temp);
            if ($file->move("assets/images/produits/", $newfilename)) 
            {
                $dataImages['idproduit'] = $idProduit;
                $dataImages['images'] = "assets/images/produits/".$newfilename;
                $images = new ImagesProduits();
                $images->save($dataImages);
                $response['message'] = "Inscription effectué";
            }
            else
            {
                $response['message'] = $this->validator->getErrors();
            }
        }
        return $this->respondCreated($response);
    }
}



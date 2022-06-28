<?php

namespace App\Controllers;

use App\Models\Categories;
use App\Models\Client;
use App\Models\Connexion;
use App\Models\DetailsPayement;
use App\Models\InfosRecette;
use App\Models\ListePanier;
use App\Models\Panier;
use App\Models\Payement;
use App\Models\PorteFeuille;
use App\Models\ProduitsRestant;
use App\Models\Recette;
use App\Models\StatistiqueRecette;
use App\Models\StockRestant;
use App\Models\StockSortant;
use App\Models\ViewsClients;
use App\Models\ViewsProduits;

class HomeController extends BaseController
{
    public function home()
    {
        $categorie = $this->request->getGet('categorie');
        $views = new ViewsProduits();
        if(!empty($categorie))
        {
            $data['tabProduit'] = $views->getAllViewProduitsByCategorie($categorie);
        }
        else
        {
            $data['tabProduit'] = $views->getAllViewProduitsParDesignation();
        }
        $categorie = new Categories();
        $data['tabCategorie'] = $categorie->getAllCategories();
        return view('home', $data);
    }

    public function addPanierv2()
    {
        $idRecette = $this->request->getGet('idrecette');
        $confirm = $this->request->getGet('confirm');
        $idProduit = $this->request->getGet('idproduit');
        if($confirm == "Non")
        {
            $quantite = 1;
            $infos = new InfosRecette();
            $panierProduits = new Panier();
            $panierProduits->setIdProduits($idProduit);
            $panierProduits->setQuantiteProduit($quantite);
            $panierProduits->setQuantite($quantite*$infos->getSimpleInfosRecettev2($idProduit)->getPoidUnitaire());
            $panierProduits->setPrixTotal($quantite*$infos->getSimpleInfosRecettev2($idProduit)->getPrixUnitaire());
            $panierProduits->setParentProduits("recette");
            $dataPanierProduit = $panierProduits->getDataPanierProduits();
            $panierProduits->save($dataPanierProduit);
            $produitsRestant = new ProduitsRestant();
            $produitsRestant->supprimerSommeRestant($idProduit);
            $data['tabRestant'] = $produitsRestant->getSimpleProduitsRestant();
            $categorie = new Categories();
            $data['tabCategorie'] = $categorie->getAllCategories();
            return view('confirm', $data);
        }
        else
        {
            $quantite = 1;
            $panier = new Panier();
            $panier->insertionPanierv2($idRecette, $quantite);
            $reste = new ProduitsRestant();
            $reste->insertionProduitsRestantv2($idRecette, $quantite);
        }
        $categorie = new Categories();
        $data['tabCategorie'] = $categorie->getAllCategories();
        $recette = new Recette();
        $data['tabRecette'] = $recette->getAllRecette();
        $liste = new ListePanier();
        $connexion = new Connexion();
        $data['listePanier'] = $liste->getAllListePanier($connexion->dbConnexion());
        $panier = new Panier();
        $data['sommeTotal'] = $panier->getSommePanier();
        pg_close($connexion->dbConnexion());
        return view('panier', $data);
    }

    public function addPanier()
    {
        $data = array();
        $idRecette = $this->request->getPost('idrecette');
        $quantite = 1;
        $idProduit = $this->request->getPost('idproduit');
        if(!empty($quantite))
        {
            if(empty($idRecette))
            {
                $infos = new InfosRecette();
                $panierProduits = new Panier();
                $panierProduits->setIdProduits($idProduit);
                $panierProduits->setQuantiteProduit($quantite);
                $panierProduits->setQuantite($quantite*$infos->getSimpleInfosRecettev2($idProduit)->getPoidUnitaire());
                $panierProduits->setPrixTotal($quantite*$infos->getSimpleInfosRecettev2($idProduit)->getPrixUnitaire());
                $panierProduits->setParentProduits("produits");
                $dataPanierProduit = $panierProduits->getDataPanierProduits();
                $panierProduits->save($dataPanierProduit);
                $categorie = $this->request->getGet('categorie');
                $views = new ViewsProduits();
                if(!empty($categorie))
                {
                    $data['tabProduit'] = $views->getAllViewProduitsByCategorie($categorie);
                }
                else
                {
                    $data['tabProduit'] = $views->getAllViewProduitsParDesignation();
                }
                $categorie = new Categories();
                $data['tabCategorie'] = $categorie->getAllCategories();
                return view('home', $data);
            }
            else
            {
                $produitsRestant = new ProduitsRestant();
                $condition = $produitsRestant->verifierQuantiteRestant();
                if($condition == false)
                {
                    $panier = new Panier();
                    $panier->insertionPanier($idRecette, $quantite);
                    $reste = new ProduitsRestant();
                    $reste->insertionProduitsRestant($idRecette, $quantite);
                }
                else
                {
                    $infos = new InfosRecette();
                    $verification = $infos->verificationProduitsRestant($idRecette, $quantite);
                    if($verification == true)
                    {
                        $data['tabRestant'] = $produitsRestant->getSimpleProduitsRestant();
                        $categorie = new Categories();
                        $data['tabCategorie'] = $categorie->getAllCategories();
                        return view('confirm', $data);
                    }
                    else
                    {
                        $panier = new Panier();
                        $panier->insertionPanierv2($idRecette, $quantite);
                        $reste = new ProduitsRestant();
                        $reste->insertionProduitsRestantv2($idRecette, $quantite);
                    }
                    $data['tabDetailsRecette'] = $infos->getAllInfosRecetteFinal($idRecette, $quantite);
                    return view('confirmation', $data);

                }
                $statistiqueRecette = new StatistiqueRecette();
                $statistiqueRecette->setIdRecette($idRecette);
                $statistiqueRecette->setQuantiteRecette($quantite);
                $dataStatistiqueRecette = $statistiqueRecette->getDataStatistiqueRecette();
                $statistiqueRecette->save($dataStatistiqueRecette);
                $categorie = new Categories();
                $data['tabCategorie'] = $categorie->getAllCategories();
                $recette = new Recette();
                $data['tabRecette'] = $recette->getAllRecette();
                return view('recette', $data);
            }
        }
        else
        {

        }
    }

    public function annulationPanier()
    {
        $recette = $this->request->getGet('recette');
        $panier = new Panier();
        $panier->deleteAllPanierRecette($recette);
        $categorie = new Categories();
        $data['tabCategorie'] = $categorie->getAllCategories();
        $recette = new Recette();
        $data['tabRecette'] = $recette->getAllRecette();
        $liste = new ListePanier();
        $connexion = new Connexion();
        $data['listePanier'] = $liste->getAllListePanier($connexion->dbConnexion());
        $data['sommeTotal'] = $panier->getSommePanier();
        $reste = new ProduitsRestant();
        $reste->deleteAllSommeRestant();
        pg_close($connexion->dbConnexion());
        return view('panier', $data);
    }

    public function verificationLoginClient()
    { 
        $data = array();
        $username = $this->request->getPost('username');
        $mdp = $this->request->getPost('motdepasse');
        $categorie = $this->request->getGet('categorie');
        $views = new ViewsProduits();
        if(!empty($categorie))
        {
            $data['tabProduit'] = $views->getAllViewProduitsByCategorie($categorie);
        }
        else
        {
            $data['tabProduit'] = $views->getAllViewProduitsParDesignation();
        }
        $categorie = new Categories();
        $data['tabCategorie'] = $categorie->getAllCategories();
        $recette = new Recette();
        $data['tabRecette'] = $recette->getAllRecette();
        if(!empty($username) && !empty($mdp))
        {
            $views = new ViewsClients();
            $views->setUsername($username);
            $views->setMotDepasse($mdp);
            $condition = $views->verificationLogin();
            if($condition == true)
            {
                $client = new Client();
                $client->setUsername($username);
                $client->setMotDepasse($mdp);
                $data['idClient'] = $client->getSimpleClient()->getIdClient();
                $data['solde'] = $views->getSolde();
                $panier = new Panier();
                $data['sommeTotal'] = $panier->getSommePanier();
                return view('client', $data);
            }
            else
            {
                $data['message'] = "Oups! Veiullez réessayez s'il vous plait!";
                return view('login', $data);
            }
        }
        else
        {
            $data['message'] = "Oups! Veiullez réessayez s'il vous plait!";
            return view('login', $data);
        }
    }

    public function addArgent()
    {
        $idClient = $this->request->getPost('idclient');
        $montant = $this->request->getPost('montant');
        $date = $this->request->getPost('datedepot');
        $solde = $this->request->getPost('solde');
        if(!empty($idClient) && !empty($montant) && !empty($date))
        {
            $porteFeuille = new PorteFeuille();
            $porteFeuille->setIdClient($idClient);
            $porteFeuille->setMontant($montant);
            $porteFeuille->setDateDepot($date);
            $porteFeuille->setStatus("Non valide");
            $dataPorteFeuille = $porteFeuille->getDataPorteFeuille();
            $porteFeuille->save($dataPorteFeuille);
        }
        else
        {
            $data['message'] = "Oups! Veiullez réessayez s'il vous plait!";
        }
        $data['idClient'] = $idClient;
        $data['solde'] = $solde;
        $panier = new Panier();
        $data['sommeTotal'] = $panier->getSommePanier();
        return view('client', $data);
    }

    public function payement()
    {
        $idClient = $this->request->getPost('idclient');
        $solde = $this->request->getPost('solde');
        $netApayer = $this->request->getPost('netapayer');
        if($solde < $netApayer)
        {
            $data['erreur'] = "Vôtre solde est insuffisant";
        }
        else
        {
            $payement = new Payement();
            $payement->setIdClient($idClient);
            $payement->setMontant($netApayer);
            $payement->insertionPayement();
            $idPayement = $payement->getSimpleIdPayement($idClient);
            $connexion = new Connexion();
            $details = new DetailsPayement();
            $details->insertionDetailsPayement($connexion->dbConnexion(), $idPayement);
            $stock = new StockSortant();
            $stock->insertionStockSortant($connexion->dbConnexion());
            $panier = new Panier();
            $panier->deleteAllPanier();
        }
        $data['idClient'] = $idClient;
        $data['solde'] = $solde;
        $porteFeuille = new PorteFeuille();
        $porteFeuille->insertionNetApaye($idClient, $netApayer);
        $panier = new Panier();
        $data['sommeTotal'] = $panier->getSommePanier();
        pg_close($connexion->dbConnexion());
        return view('client', $data);
    }


    public function inscription()
    {

        $rules['nom'] = "trim|required";
        $rules['prenom'] = "trim|required";
        $rules['username'] = "trim|valid_email|min_length[6]|required|is_unique[client.username]";
        $rules['motdepasse'] = "trim|required|min_length[3]";
        $rules['adresse'] = "trim|required";

        $messages['nom']['required'] = "Name is required";
        $messages['prenom']['required'] = "First name is required";
        $messages['username']['required'] = "Username is required";
        $messages['username']['valid_email'] = "Email address is not in format";
        $messages['username']['is_unique'] = "Email address already exists";
        $messages['username']['min_length'] = "Email minimal is 6 length";
        $messages['motdepasse']['min_length'] = "Email minimal is 8 length";
        $messages['adresse']['required'] = "Adresse is required";

        if (!$this->validate($rules, $messages))
        {
            $data['message'] = $this->validator->getErrors();
            $data['erreur'] = "Oups! Veiullez réessayez s'il vous plait!";
        }
        else
        {
            $data['nom'] = $this->request->getVar('nom');
            $data['prenom'] = $this->request->getVar('prenom');
            $data['username'] = $this->request->getVar('username');
            $data['motdepasse'] = sha1($this->request->getVar('motdepasse'));
            $data['adresse'] = $this->request->getVar('adresse');
            $client = new Client();
            $client->save($data);
            $data['messageInscrption'] = "Inscription effectuée";
            $client->setUsername($data['username']);
            $client->setMotDepasse($this->request->getVar('motdepasse'));
            $customer = $client->getSimpleClient();
            $porteFeuille = new PorteFeuille();
            $porteFeuille->setIdClient($customer->getIdClient());
            $porteFeuille->insertionPortefeuille();
        }
        $categorie = $this->request->getGet('categorie');
        $views = new ViewsProduits();
        if(!empty($categorie))
        {
            $data['tabProduit'] = $views->getAllViewProduitsByCategorie($categorie);
        }
        else
        {
            $data['tabProduit'] = $views->getAllViewProduitsParDesignation();
        }
        $categorie = new Categories();
        $data['tabCategorie'] = $categorie->getAllCategories();
        $recette = new Recette();
        $data['tabRecette'] = $recette->getAllRecette();
        return view('login', $data);
    }

    public function rechereche()
    {
        $designation = $this->request->getPost('designation');
        $views = new ViewsProduits();
        $data['tabProduit'] = $views->rechercherProduits($designation);
        $categorie = new Categories();
        $data['tabCategorie'] = $categorie->getAllCategories();
        $recette = new Recette();
        $data['tabRecette'] = $recette->getAllRecette();
        return view('home', $data);
    }

    public function fiche()
    {
        $categorie = $this->request->getGet('categorie');
        $designation = $this->request->getGet('designation');
        $views = new ViewsProduits();
        $data['produits'] = $views->getSimpleViewProduitsParDesignation($designation);
        if(!empty($categorie))
        {
            $data['tabProduit'] = $views->getAllViewProduitsByCategorie($categorie);
        }
        else
        {
            $data['tabProduit'] = $views->getAllViewProduitsParDesignation();
        }
        $categorie = new Categories();
        $data['tabCategorie'] = $categorie->getAllCategories();
        $recette = new Recette();
        $data['tabRecette'] = $recette->getAllRecette();
        $stock = new StockRestant();
        $data['quantite'] = $stock->getQuantiteStock($designation);
        return view('fiche', $data);
    }

    public function teste()
    {
        $infos = new InfosRecette();
        $reste = new ProduitsRestant();
        $data['tabInfos'] = $infos->getAllInfosRecetteFinal(2,1);
        $data['reste'] =  $reste->getSommeRestant(6);
        return view('teste', $data);
    }

    public function recette()
    {
        $categorie = new Categories();
        $data['tabCategorie'] = $categorie->getAllCategories();
        $recette = new Recette();
        $data['tabRecette'] = $recette->getAllRecette();
        return view('recette', $data);
    }

    public function listepanier()
    {
        $categorie = new Categories();
        $data['tabCategorie'] = $categorie->getAllCategories();
        $recette = new Recette();
        $data['tabRecette'] = $recette->getAllRecette();
        $liste = new ListePanier();
        $connexion = new Connexion();
        $data['listePanier'] = $liste->getAllListePanier($connexion->dbConnexion());
        $panier = new Panier();
        $data['sommeTotal'] = $panier->getSommePanier();
        pg_close($connexion->dbConnexion());
        return view('panier', $data);
    }

    public function login()
    {
        $categorie = $this->request->getGet('categorie');
        $views = new ViewsProduits();
        if(!empty($categorie))
        {
            $data['tabProduit'] = $views->getAllViewProduitsByCategorie($categorie);
        }
        else
        {
            $data['tabProduit'] = $views->getAllViewProduitsParDesignation();
        }
        $categorie = new Categories();
        $data['tabCategorie'] = $categorie->getAllCategories();
        $recette = new Recette();
        $data['tabRecette'] = $recette->getAllRecette();
        return view('login', $data);
    }
}

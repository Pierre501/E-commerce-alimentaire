<?php

namespace App\Models;

use CodeIgniter\Model;

class ViewsProduits extends Model
{

    protected $idProduits;
    protected $designation;
    protected $description;
    protected $prixUnitaire;
    protected $datePrixUnitaire;
    protected $tabImagesProduits;
    protected $unite;


    public function setIdProduits($idProduits)
    {
        $this->idProduits = $idProduits;
    }

    public function getIdProduits()
    {
        return $this->idProduits;
    }

    public function setDesignation($designation)
    {
        $this->designation = $designation;
    }

    public function getDesignation()
    {
        return $this->designation;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescrption()
    {
        return $this->description;
    }

    public function setPrixUnitaire($prixUnitaire)
    {
        $this->prixUnitaire = $prixUnitaire;
    }

    public function getPrixUnitaire()
    {
        return $this->prixUnitaire;
    }

    public function setDatePrixUnitaire($datePrixUnitaire)
    {
        $this->datePrixUnitaire = $datePrixUnitaire;
    }

    public function getDatePrixUnitaire()
    {
        return $this->datePrixUnitaire;
    }

    public function setTabImagesProduits($tabImagesProduits)
    {
        $this->tabImagesProduits = $tabImagesProduits;
    }

    public function getTabImagesProduits()
    {
        return $this->tabImagesProduits;
    }

    public function setUnite($unite)
    {
        $this->unite = $unite;
    }

    public function getUnite()
    {
        return $this->unite;
    }

    public function getAllViewProduits()
    {
        $data = array();
        $images = new ImagesProduits();
        $builder = $this->db->table('produits');
        $builder->select('*');
        $builder->join('detailsproduits', 'produits.idproduit = detailsproduits.idproduit');
        $query = $builder->get();
        foreach($query->getResultArray() as $rows)
        {
            $views = new ViewsProduits();
            $views->setIdProduits($rows['idproduit']);
            $views->setDesignation($rows['designation']);
            $views->setDescription($rows['description']);
            $views->setPrixUnitaire($rows['prixunitaire']);
            $views->setDatePrixUnitaire($rows['datedetailsproduits']);
            $views->setTabImagesProduits($images->getAllImagesParProduits($rows['designation']));
            $data[] = $views;
        }
        return $data;
    }

    public function getAllViewProduitsByCategorie($categorie)
    {
        $data = array();
        $images = new ImagesProduits();
        $builder = $this->db->table('categories');
        $builder->select('*');
        $builder->join('produits', 'categories.idcategorie = produits.idcategorie');
        $builder->join('detailsproduits', 'produits.idproduit = detailsproduits.idproduit');
        $builder->where('categorie', $categorie);
        $query = $builder->get();
        foreach($query->getResultArray() as $rows)
        {
            $views = new ViewsProduits();
            $views->setIdProduits($rows['idproduit']);
            $views->setDesignation($rows['designation']);
            $views->setDescription($rows['description']);
            $views->setPrixUnitaire($rows['prixunitaire']);
            $views->setDatePrixUnitaire($rows['datedetailsproduits']);
            $views->setTabImagesProduits($images->getAllImagesParProduits($rows['designation']));
            $data[] = $views;
        }
        return $data;
    }

    public function getSimpleViewProduitsParDesignation($designation)
    {
        $images = new ImagesProduits();
        $builder = $this->db->table('produits');
        $builder->select('*');
        $builder->join('detailsproduits', 'produits.idproduit = detailsproduits.idproduit');
        $builder->where('designation', $designation);
        $query = $builder->get();
        $rows = $query->getRowArray();
        $views = new ViewsProduits();
        $views->setIdProduits($rows['idproduit']);
        $views->setDesignation($rows['designation']);
        $views->setDescription($rows['description']);
        $views->setUnite($rows['unite']);
        $views->setPrixUnitaire($rows['prixunitaire']);
        $views->setDatePrixUnitaire($rows['datedetailsproduits']);
        $views->setTabImagesProduits($images->getAllImagesParProduits($rows['designation']));
        return $views;
    }

    public function getAllViewProduitsParDesignation()
    {
        $data = array();
        $produits = new Produits();
        $tabProduits = $produits->getCinqDernierProduit();
        foreach($tabProduits as $produit)
        {
            $data[] = $this->getSimpleViewProduitsParDesignation($produit->getDesignation());
        }
        return $data;
    }

    public function verificationRecherche($recherche, $designation)
    {
        $retour = false;
        $recherche = strtolower($recherche);
        $taille = strlen($recherche);
        if(stristr($recherche, substr($designation, 0, $taille)))
        {
            $retour = true;
        }
        return $retour;
    }

    public function rechercherProduits($designation)
    {
        $data = array();
        $tabProduits = $this->getAllViewProduits();
        foreach($tabProduits as $produits)
        {
            $condition = $this->verificationRecherche($designation, $produits->getDesignation());
            if($condition == true)
            {
                $data[] = $produits;
            }
        }
        return $data;
    }
}

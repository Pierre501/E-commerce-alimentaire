<?php

namespace App\Models;


class ListePanier 
{

    protected $idProduits;
    protected $designation;
    protected $poidUnitaire;
    protected $prixUnitaire;
    protected $quaniteProduits;
    protected $quantitePanier;
    protected $prixTotal;

    public function setIdProduits($idProduits)
    {
        $this->idProduit = $idProduits;
    }

    public function getIdProduits()
    {
        return $this->idProduit;
    }

    public function setDesignation($designation)
    {
        $this->designation = $designation;
    }

    public function getDesignation()
    {
        return $this->designation;
    }

    public function setPoidUntaire($poidUnitaire)
    {
        $this->poidUnitaire = $poidUnitaire;
    }

    public function getPoidUnitaire()
    {
        return $this->poidUnitaire;
    }

    public function setPrixUnitaire($prixUnitaire)
    {
        $this->prixUnitaire = $prixUnitaire;
    }

    public function getPrixUnitaire()
    {
        return $this->prixUnitaire;
    }

    public function setQuantiteProduits($quaniteProduits)
    {
        $this->quaniteProduits = $quaniteProduits;
    }

    public function getQuantiteProduits()
    {
        return $this->quaniteProduits;
    }

    public function setQuantitePanier($quantitePanier)
    {
        $this->quantitePanier = $quantitePanier;
    }

    public function getQuantitePanier()
    {
        return $this->quantitePanier;
    }

    public function setPrixTotal($prixTotal)
    {
        $this->prixTotal = $prixTotal;
    }

    public function getPrixTotal()
    {
        return $this->prixTotal;
    }

    public function getAllListePanier($con)
    {
        $data = array();
        $sql = "select * from listepanier";
        $query = pg_query($con, $sql);
        while($rows = pg_fetch_array($query))
        {
            $liste = new ListePanier();
            $liste->setIdProduits($rows['idproduit']);
            $liste->setDesignation($rows['designation']);
            $liste->setPoidUntaire($rows['poidunitaire']);
            $liste->setPrixUnitaire($rows['prixunitaire']);
            $liste->setQuantiteProduits($rows['quantiteproduit']);
            $liste->setQuantitePanier($rows['quantitepanier']);
            $liste->setPrixTotal($rows['prixtotal']);
            $data[] = $liste;
        }
        return $data;
    }
}

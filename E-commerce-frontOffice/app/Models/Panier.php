<?php

namespace App\Models;

use CodeIgniter\Model;

class Panier extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'panier';
    protected $primaryKey       = 'idpanier';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['idpanier', 'idproduit', 'quantiteproduit', 'quantitepanier', 'prixtotal', 'parentproduits'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    protected $idPanier;
    protected $idProduits;
    protected $quaniteProduit;
    protected $quanite;
    protected $prixTotal;
    protected $parentProduits;


    public function setIdPanier($idPanier)
    {
        $this->idPanier = $idPanier;
    }

    public function getIdPanier()
    {
        return $this->idPanier;
    }

    public function setIdProduits($idProduits)
    {
        $this->idProduit = $idProduits;
    }

    public function getIdProduits()
    {
        return $this->idProduit;
    }

    public function setQuantiteProduit($quaniteProduit)
    {
        $this->quaniteProduit = $quaniteProduit;
    }

    public function getQuantiteProduit()
    {
        return $this->quaniteProduit;
    }

    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }

    public function getQuantite()
    {
        return $this->quantite;
    }

    public function setPrixTotal($prixTotal)
    {
        $this->prixTotal = $prixTotal;
    }

    public function getPrixTotal()
    {
        return $this->prixTotal;
    }

    public function setParentProduits($parentProduits)
    {
        $this->parentProduits = $parentProduits;
    }

    public function getParentProduits()
    {
        return $this->parentProduits;
    }

    public function getDataPanierProduits()
    {
        $data['idproduit'] = $this->getIdProduits();
        $data['quantiteproduit'] = $this->getQuantiteProduit();
        $data['quantitepanier'] = $this->getQuantite();
        $data['prixtotal'] = $this->getPrixTotal();
        $data['parentproduits'] = $this->getParentProduits();
        return $data;
    }

    public function insertionPanier($idRecette, $quantite)
    {
        $infosRecette = new InfosRecette();
        $tabInfosRecette = $infosRecette->getAllInfosRecetteFinal($idRecette, $quantite);
        foreach($tabInfosRecette as $infos)
        {
            $panier = new Panier();
            $panier->setIdProduits($infos->getIdProduits());
            $panier->setQuantiteProduit($quantite);
            $panier->setQuantite($infos->getPoidEngage());
            $panier->setPrixTotal($infos->getPrixEngage());
            $panier->setParentProduits("recette");
            $dataPanier = $panier->getDataPanierProduits();
            $panier->save($dataPanier);
        }
    }

    public function insertionPanierv2($idRecette, $quantite)
    {
        $infosRecette = new InfosRecette();
        $tabInfosRecette = $infosRecette->getAllInfosRecetteFinalv2($idRecette, $quantite);
        foreach($tabInfosRecette as $infos)
        {
            $panier = new Panier();
            $panier->setIdProduits($infos->getIdProduits());
            $panier->setQuantiteProduit($quantite);
            $panier->setQuantite($infos->getPoidEngage());
            $panier->setPrixTotal($infos->getPrixEngage());
            $panier->setParentProduits("recette");
            $dataPanier = $panier->getDataPanierProduits();
            $panier->save($dataPanier);
        }
    }

    public function deleteAllPanier()
    {
        $sql = "delete from panier";
        $this->db->query($sql);
    }

    public function deleteAllPanierRecette($recette)
    {
        $sql = "delete from panier where parentproduits = %s";
        $sql = sprintf($sql, $this->db->escape($recette));
        $this->db->query($sql);
    }

    public function verifierResteRecette()
    {
        $verifier = false;
        $sql = "select count(*) as rows from panier where parentproduits = 'recette'";
        $query = $this->db->query($sql);
        $rows = $query->getRowArray();
        if($rows['rows' == 1])
        {
            $verifier = true;
        }
        return $verifier;
    }

    public function getSommeProduits()
    {
        $prixTotal = 0;
        $sql = "select (prixtotal) as prixtotal from panier where parentproduits = 'produits'";
        $query = $this->db->query($sql);
        $rows = $query->getRowArray();
        if(!empty($rows['prixtotal']))
        {
            $prixTotal = $rows['prixtotal'];
        }
        return $prixTotal;
    }

    public function getSommePanier()
    {
        $sql = "select sum(prixtotal) as prixtotal from panier";
        $query = $this->db->query($sql);
        $rows = $query->getRowArray();
        $somme = $rows['prixtotal'];
        return $somme;
    }
}

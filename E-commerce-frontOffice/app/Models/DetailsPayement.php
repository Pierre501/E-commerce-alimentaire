<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailsPayement extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'detailspayement';
    protected $primaryKey       = 'iddetailspayement';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['iddetailspayement', 'idpayement', 'idproduit', 'quantite', 'prixtotal'];

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


    protected $idDetailsPayement;
    protected $idPayement;
    protected $idProduit;
    protected $quantite;
    protected $prixTotal;


    public function setIddetailsPayement($idDetailsPayement)
    {
        $this->idDetailsPayement = $idDetailsPayement;
    }

    public function getIdDetailsPayement()
    {
        return $this->idDetailsPayement;
    }

    public function setIdPayement($idPayement)
    {
        $this->idPayement = $idPayement;
    }

    public function getIdPayement()
    {
        return $this->idPayement;
    }

    public function setIdProduits($idProduits)
    {
        $this->idProduit = $idProduits;
    }

    public function getIdProduits()
    {
        return $this->idProduit;
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

    public function getDataDetailsPayement()
    {
        $data['idpayement'] = $this->getIdPayement();
        $data['idproduit'] = $this->getIdProduits();
        $data['quantite'] = $this->getQuantite();
        $data['prixtotal'] = $this->getPrixTotal();
        return $data;
    }

    public function insertionDetailsPayement($con, $idPayement)
    {
        $liste = new ListePanier();
        $listePanier = $liste->getAllListePanier($con);
        foreach($listePanier as $listes)
        {
            $details = new DetailsPayement();
            $details->setIdPayement($idPayement);
            $details->setIdProduits($listes->getIdProduits());
            $details->setQuantite($listes->getQuantitePanier());
            $details->setPrixTotal($listes->getPrixTotal());
            $dataDetailsPayement = $details->getDataDetailsPayement();
            $details->save($dataDetailsPayement);
        }
    }
}

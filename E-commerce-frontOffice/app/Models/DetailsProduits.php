<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailsProduits extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'detailsproduits';
    protected $primaryKey       = 'idDetaisProduits';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['iddetaisproduits', 'idproduit', 'prixunitaire', 'datedetailsproduits'];

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


    protected $idDetailsProduits;
    protected $idProduit;
    protected $prixUnitaire;
    protected $dateDetailsProduits;

    public function setIdDetailsProduits($idDetailsProduits)
    {
        $this->idDetailsProduits = $idDetailsProduits;
    }

    public function getIdDetailsProduits()
    {
        return $this->idDetailsProduits;
    }

    public function setIdProduits($idProduits)
    {
        $this->idProduit = $idProduits;
    }

    public function getIdProduits()
    {
        return $this->idProduit;
    }

    public function setPrixUnitaire($prixUnitaire)
    {
        $this->prixUnitaire = $prixUnitaire;
    }

    public function getPrixUnitaire()
    {
        return $this->prixUnitaire;
    }

    public function setDateDetailsProduits($dateDtailsProduits)
    {
        $this->dateDetailsProduits = $dateDtailsProduits;
    }

    public function getDateDetailsProduits()
    {
        return $this->dateDetailsProduits;
    }

    public function getDataDetailsProduits($detailsProduits)
    {
        $data['idproduit'] = $detailsProduits->getIdProduits();
        $data['prixunitaire'] = $detailsProduits->getPrixUnitaire();
        $data['datedetailsproduits'] = $detailsProduits->getDateDetailsProduits();
        return $data;
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class StockEntrant extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'stockentrant';
    protected $primaryKey       = 'idstockentrant';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['idstockentrant', 'idproduit', 'quantitestockentrant', 'datestockentrant'];

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

    protected $idStockEntrant;
    protected $idProduit;
    protected $quantiteStockEntrant;
    protected $dateStockEntrant;

    public function setIdStockEntrant($idStockEntrant)
    {
        $this->idStockEntrant = $idStockEntrant;
    }

    public function getIdStockEntrant()
    {
        return $this->idStockEntrant;
    }

    public function setIdProduits($idProduits)
    {
        $this->idProduit = $idProduits;
    }

    public function getIdProduits()
    {
        return $this->idProduit;
    }

    public function setQuantiteStockEntrant($quantiteStockEntrant)
    {
        $this->quantiteStockEntrant = $quantiteStockEntrant;
    }

    public function getQuantiteStockEntrant()
    {
        return $this->quantiteStockEntrant;
    }

    public function setDateStockEntrant($dateStockEntrant)
    {
        $this->dateStockEntrant = $dateStockEntrant;
    }

    public function getDateStockEntrant()
    {
        return $this->dateStockEntrant;
    }

    public function getDataStockEntrant()
    {
        $data['idproduit'] = $this->getIdProduits();
        $data['quantitestockentrant'] = $this->getQuantiteStockEntrant();
        $data['datestockentrant'] = $this->getDateStockEntrant();
        return $data;
    }
}

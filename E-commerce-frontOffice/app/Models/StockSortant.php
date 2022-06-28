<?php

namespace App\Models;

use CodeIgniter\Model;

class StockSortant extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'stocksortant';
    protected $primaryKey       = 'idstocksortant';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['idstocksortant', 'idproduit', 'quantitestocksortant', 'datestocksortant'];

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


    protected $idStockSortant;
    protected $idProduit;
    protected $quantiteStockSortant;
    protected $dateStockSortant;

    
    public function setIdStockSortant($idStockSortant)
    {
        $this->idStockSortant = $idStockSortant;
    }

    public function getIdStockSortant()
    {
        return $this->idStockSortant;
    }

    public function setIdProduits($idProduits)
    {
        $this->idProduit = $idProduits;
    }

    public function getIdProduits()
    {
        return $this->idProduit;
    }

    public function setQuantiteStockSortant($quantiteStockSortant)
    {
        $this->quantiteStockSortant = $quantiteStockSortant;
    }

    public function getQuantiteStockSortant()
    {
        return $this->quantiteStockSortant;
    }

    public function setDateStockSortant($dateStockSortant)
    {
        $this->dateStockSortant = $dateStockSortant;
    }

    public function getDateStockSortant()
    {
        return $this->dateStockSortant;
    }

    public function getDataStockRestant()
    {
        $data['idproduit'] = $this->getIdProduits();
        $data['quantitestocksortant'] = $this->getQuantiteStockSortant();
        $data['datestocksortant'] = "current_date";
        return $data;
    }

    public function insertionSimpleStockSortant()
    {
        $sql = "insert into stocksortant values(default, %d, %d, current_date)";
        $sql = sprintf($sql, $this->getIdProduits(), $this->getQuantiteStockSortant());
        $this->db->query($sql);
    }

    public function insertionStockSortant($con)
    {
        $liste = new ListePanier();
        $listePanier = $liste->getAllListePanier($con);
        foreach($listePanier as $listes)
        {
            $stock = new StockSortant();
            $stock->setIdProduits($listes->getIdProduits());
            $stock->setQuantiteStockSortant($listes->getQuantitePanier());
            $stock->insertionSimpleStockSortant();
        }
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class StockRestant extends Model
{
    protected $designation;
    protected $quantite;
    protected $dateStock;

    public function setDesignation($designation)
    {
        $this->designation = $designation;
    }

    public function getDesignation()
    {
        return $this->designation;
    }

    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }

    public function getQuantite()
    {
        return $this->quantite;
    }

    public function setDateStock($date)
    {
        $this->dateStock = $date;
    }

    public function getdateStock()
    {
        return $this->dateStock;
    }

    public function getAllStockRestant()
    {
        $data = array();
        $sql = "select * from viewstockrestantfinal";
        $query = $this->db->query($sql);
        foreach($query->getResultArray() as $rows)
        {
            $stock = new StockRestant();
            $stock->setDesignation($rows['designation']);
            $stock->setQuantite($rows['sommequantitestockrestant']);
            $stock->setDateStock($rows['datestock']);
            $data[] = $stock;
        }
        return $data;
    }

    public function getQuantiteStock($designation)
    {
        $stock = 0;
        $tabStockRestant = $this->getAllStockRestant();
        foreach($tabStockRestant as $stockRestant)
        {
            if($stockRestant->getDesignation() == $designation)
            {
                $stock = $stockRestant->getQuantite();
                break;
            }
        }
        return $stock;
    }
}

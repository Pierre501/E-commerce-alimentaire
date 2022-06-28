<?php

namespace App\Models;

use CodeIgniter\Model;

class Statistique extends Model
{
    protected $designation;
    protected $quantite;

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

    public function getStatistiqueProduits()
    {
        $data = array();
        $sql = "select designation, sum(quantitestocksortant) as quantite from viewstatistiqueproduits group by designation";
        $query = $this->db->query($sql);
        foreach($query->getResultArray() as $rows)
        {
            $statistique = new Statistique();
            $statistique->setDesignation($rows['designation']);
            $statistique->setQuantite($rows['quantite']);
            $data[] = $statistique;
        }
        return $data;
    }
}

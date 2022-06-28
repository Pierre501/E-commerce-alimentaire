<?php

namespace App\Models;

use CodeIgniter\Model;

class Produits extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'produits';
    protected $primaryKey       = 'idproduit';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['idproduit', 'idcategorie', 'designation', 'description'];

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

    protected $idProduit;
    protected $idCategorie;
    protected $designation;
    protected $description;

    public function setIdProduits($idProduits)
    {
        $this->idProduit = $idProduits;
    }

    public function getIdProduits()
    {
        return $this->idProduit;
    }

    public function setIdCategorie($idCategorie)
    {
        $this->idCategorie = $idCategorie;
    }

    public function getIdCategorie()
    {
        return $this->idCategorie;
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


    public function getCinqDernierProduit()
    {
        $data = array();
        $sql = "select * from produits order by idproduit desc limit 5";
        $query = $this->db->query($sql);
        foreach($query->getResultArray() as $rows)
        {
            $produits = new Produits();
            $produits->setIdProduits($rows['idproduit']);
            $produits->setDesignation($rows['designation']);
            $produits->setDescription($rows['description']);
            $data[] = $produits;
        }
        return $data;
    }

    public function getdataInsertionProduits($produits)
    {
        $data['idcategorie'] = $produits->getIdCategorie();
        $data['designation'] = $produits->getDesignation();
        $data['description'] = $produits->getDescrption();
        return $data;
    }

    public function getProduitByName($designation)
    {
        $sql = "select * from produits where designation = %s";
        $sql = sprintf($sql, $this->db->escape($designation));
        $query = $this->db->query($sql);
        $rows = $query->getRowArray();
        $produits = new Produits();
        $produits->setIdProduits($rows['idproduit']);
        $produits->setIdCategorie($rows['idcategorie']);
        $produits->setDesignation($rows['designation']);
        $produits->setDescription($rows['description']);
        return $produits;
    }
}






<?php

namespace App\Models;

use CodeIgniter\Model;

class Categories extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'categories';
    protected $primaryKey       = 'idcategorie';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['idcategorie', 'categorie'];

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

    

    protected $idCategorie;
    protected $categorie;


    public function setIdCategorie($id)
    {
        $this->idCategorie = $id;
    }

    public function getIdCategorie()
    {
        return $this->idCategorie;
    }

    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }

    public function getCategorie()
    {
        return $this->categorie;
    }

    public function getAllCategories()
    {
        $data = array();
        $sql = "select * from categories";
        $query = $this->db->query($sql);
        foreach($query->getResultArray() as $rows)
        {
            $categorie = new Categories();
            $categorie->setIdCategorie($rows['idcategorie']);
            $categorie->setCategorie($rows['categorie']);
            $data[] = $categorie;
        }
        return $data;
    }
}

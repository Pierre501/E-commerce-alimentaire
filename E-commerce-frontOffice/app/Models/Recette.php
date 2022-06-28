<?php

namespace App\Models;

use CodeIgniter\Model;

class Recette extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'recette';
    protected $primaryKey       = 'idrecette';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['idrecette', 'nomrecette', 'images'];

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


    protected $idRecette;
    protected $nomRecette;
    protected $images;


    public function setIdRecette($idRecette)
    {
        $this->idRecette = $idRecette;
    }

    public function getIdRecette()
    {
        return $this->idRecette;
    }

    public function setNomRecette($nomRecette)
    {
        $this->nomRecette = $nomRecette;
    }

    public function getNomRecette()
    {
        return $this->nomRecette;
    }

    public function setImages($images)
    {
        $this->images = $images;
    }

    public function getImages()
    {
        return $this->images;
    }

    public function getAllRecette()
    {
        $data = array();
        $sql = "select * from recette";
        $query = $this->db->query($sql);
        foreach($query->getResultArray() as $rows)
        {
            $recette = new Recette();
            $recette->setIdRecette($rows['idrecette']);
            $recette->setNomRecette($rows['nomrecette']);
            $recette->setImages($rows['images']);
            $data[] = $recette;
        }
        return $data;
    }
}

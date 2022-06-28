<?php

namespace App\Models;

use CodeIgniter\Model;

class ImagesProduits extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'imagesproduits';
    protected $primaryKey       = 'idimagesproduits';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['idimagesproduits', 'idproduit', 'images'];

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


    protected $idImagesProduit;
    protected $idProduit;
    protected $images;

    public function setIdImagesProduit($idImagesProduit)
    {
        $this->idImagesProduit = $idImagesProduit;
    }

    public function getIdImagesProduit()
    {
        return $this->idImagesProduit;
    }

    public function setIdProduit($idProduit)
    {
        $this->idProduit = $idProduit;
    }

    public function getIdProduit()
    {
        return $this->idProduit;
    }

    public function setImages($images)
    {
        $this->images = $images;
    }

    public function getImages()
    {
        return $this->images;
    }

    public function getAllImagesParProduits($produits)
    {
        $data = array();
        $builder = $this->db->table('produits');
        $builder->select('*');
        $builder->join('imagesproduits', 'produits.idproduit = imagesproduits.idproduit');
        $builder->where('designation', $produits);
        $query = $builder->get();
        foreach($query->getResultArray() as $rows)
        {
            $images = new ImagesProduits();
            $images->setIdImagesProduit($rows['idimagesproduits']);
            $images->setIdProduit($rows['idproduit']);
            $images->setImages($rows['images']);
            $data[] = $images;
        }
        return $data;
    }
}

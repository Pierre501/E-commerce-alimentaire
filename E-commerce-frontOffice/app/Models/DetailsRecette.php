<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailsRecette extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'detailsrecette';
    protected $primaryKey       = 'iddetailsrecette';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['iddetailsrecette', 'idrecette', 'idproduit', 'quantitedetailsrecette', 'seuilproduit'];

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


    protected $idDetailsRecette;
    protected $idRecette;
    protected $idProduit;
    protected $quantitedetailsRecette;
    protected $seuilProduit;



    public function setIdDetailRecette($idDetailsRecette)
    {
        $this->idDetailsRecette = $idDetailsRecette;
    }

    public function getIdDetailsRecette()
    {
        return $this->idDetailsRecette;
    }

    public function setIdProduits($idProduits)
    {
        $this->idProduit = $idProduits;
    }

    public function getIdProduits()
    {
        return $this->idProduit;
    }

    public function setIdRecette($idRecette)
    {
        $this->idRecette = $idRecette;
    }

    public function getIdRecette()
    {
        return $this->idRecette;
    }

    public function setQuantiteDetailsRecette($quantitedetailsRecette)
    {
        $this->quantitedetailsRecette = $quantitedetailsRecette;
    }

    public function getQuantiteDetailsRecette()
    {
        return $this->quantitedetailsRecette;
    }

    public function setSeuilProduits($seuilProduit)
    {
        $this->seuilProduit = $seuilProduit;
    }

    public function getSeuilProduits()
    {
        return $this->seuilProduit;
    }

    public function getAllDetailsRecette($idRecette)
    {
        $data = array();
        $sql = "select * from infosrecette where idrecette = %d";
        $sql = sprintf($sql, $idRecette);
        $query = $this->db->query($sql);
        foreach($query->getResultArray() as $rows)
        {
            $recette = new DetailsRecette();
            $recette->setIdProduits($rows['idproduit']);
            $recette->setIdRecette($rows['idrecette']);
            $recette->setQuantiteDetailsRecette($rows['quantitedetailsrecette']);
            $recette->setSeuilProduits($rows['seuilproduit']);
            $data[] = $recette;
        }
        return $data;
    }
}

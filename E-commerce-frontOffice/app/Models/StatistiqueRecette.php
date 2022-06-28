<?php

namespace App\Models;

use CodeIgniter\Model;

class StatistiqueRecette extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'statistiquerecette';
    protected $primaryKey       = 'idstatistiquerecette';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['idstatistiquerecette', 'idrecette', 'quantiterecette'];

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

    protected $idStatistiqueRecette;
    protected $idRecette;
    protected $nomRecette;
    protected $quantiteRecette;


    public function setIdStatiqueRecette($idStatistiqueRecette)
    {
        $this->idStatistiqueRecette = $idStatistiqueRecette;
    }

    public function getIdStatistiqueRecette()
    {
        return $this->idStatistiqueRecette;
    }

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

    public function setQuantiteRecette($quantiteRecette)
    {
        $this->quantiteRecette = $quantiteRecette;
    }

    public function getQuantiteRecette()
    {
        return $this->quantiteRecette;
    }

    public function getDataStatistiqueRecette()
    {
        $data['idrecette'] = $this->getIdRecette();
        $data['quantiterecette'] = $this->getQuantiteRecette();
        return $data;
    }

    public function getAllStatistiqueRecette()
    {
        $data = array();
        $sql = "select * from viewstatistiquerecettefinal";
        $query = $this->db->query($sql);
        foreach($query->getResultArray() as $rows)
        {
            $statistique = new StatistiqueRecette();
            $statistique->setIdRecette($rows['idrecette']);
            $statistique->setNomRecette($rows['nomrecette']);
            $statistique->setQuantiteRecette($rows['quantiterecette']);
            $data[] = $statistique;
        }
        return $data;
    }
}



<?php

namespace App\Models;

use CodeIgniter\Model;

class ListePayement extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'listepayement';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

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

    protected $nomClient;
    protected $prenomClient;
    protected $montant;
    protected $datepayement;

    public function setNomClient($nomClient)
    {
        $this->nomClient = $nomClient;
    }

    public function getNomClient()
    {
        return $this->nomClient;
    }

    public function setPrenomClient($prenomClient)
    {
        $this->prenomClient = $prenomClient;
    }

    public function getPrenomClient()
    {
        return $this->prenomClient;
    }

    public function setMontant($montant)
    {
        $this->montant = $montant;
    }

    public function getMontant()
    {
        return $this->montant;
    }

    public function setDatePayement($datepayement)
    {
        $this->datepayement = $datepayement;
    }

    public function getDatePayement()
    {
        return $this->datepayement;
    }

    public function getAllListePayement()
    {
        $data = array();
        $sql = "select * from listepayement";
        $query = $this->db->query($sql);
        foreach($query->getResultArray() as $rows)
        {
            $liste = new ListePayement();
            $liste->setNomClient($rows['nom']);
            $liste->setPrenomClient($rows['prenom']);
            $liste->setMontant($rows['montant']);
            $liste->setDatePayement($rows['datepayement']);
            $data[] = $liste;
        }
        return $liste;
    }
}

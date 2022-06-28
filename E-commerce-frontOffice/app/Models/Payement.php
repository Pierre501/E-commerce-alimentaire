<?php

namespace App\Models;

use CodeIgniter\Model;

class Payement extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'payement';
    protected $primaryKey       = 'idpayement';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['idpayement', 'idclient', 'montant', 'datepayement'];

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


    protected $idPayement;
    protected $idClient;
    protected $montant;
    protected $datePayement;


    public function setIdPayement($idPayement)
    {
        $this->idPayement = $idPayement;
    }

    public function getIdPayement()
    {
        return $this->idPayement;
    }

    public function setIdClient($idClient)
    {
        $this->idClient = $idClient;
    }

    public function getIdClient()
    {
        return $this->idClient;
    }

    public function setMontant($montant)
    {
        $this->montant = $montant;
    }

    public function getMontant()
    {
        return $this->montant;
    }

    public function setDatePayement($datePayement)
    {
        $this->datePayement = $datePayement;
    }

    public function getDatePayement()
    {
        return $this->datePayement;
    }

    public function getDataPayement()
    {
        $data['idclient'] = $this->getIdClient();
        $data['montant'] = $this->getMontant();
        $data['datepayement'] = "current_date";
        return $data;
    }

    public function insertionPayement()
    {
        $sql = "insert into payement values(default, %d, %d, current_date)";
        $sql = sprintf($sql, $this->getIdClient(), $this->getMontant());
        $this->db->query($sql);
    }

    public function getSimpleIdPayement($idClient)
    {
        $sql = "select max(idpayement) idpayement from payement where idclient = %d";
        $sql = sprintf($sql, $idClient);
        $query = $this->db->query($sql);
        $rows = $query->getRowArray();
        $idPayement = $rows['idpayement'];
        return $idPayement;
    }
}

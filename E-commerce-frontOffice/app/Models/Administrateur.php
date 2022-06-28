<?php

namespace App\Models;

use CodeIgniter\Model;

class Administrateur extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'administrateurs';
    protected $primaryKey       = 'idadministrateur';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['idadministrateur', 'username', 'motdepasse'];

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

    protected $idAdministrateur;
    protected $username;
    protected $motDePasse;


    public function setIdAdministrateur($id)
    {
        $this->idAdministrateur = $id;
    }

    public function getIdAdministrateur()
    {
        return $this->idAdministrateur;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setMotDePasse($mdp)
    {
        $this->motDePasse = $mdp;
    }

    public function getMotDepasse()
    {
        return $this->motDePasse;
    }

    public function verificationLogin()
    {
        $login = false;
        $sql = "select count(*) as rows from administrateur where username = %s and motdepasse = %s";
        $sql = sprintf($sql, $this->db->escape($this->getUsername()), $this->db->escape(sha1($this->getMotDepasse())));
        $query = $this->db->query($sql);
        $rows = $query->getRowArray();
        if($rows['rows'] == 1)
        {
            $login = true;
        }
        return $login;
    }
}






<?php

namespace App\Models;

use CodeIgniter\Model;

class Client extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'client';
    protected $primaryKey       = 'idclient';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['idclient', 'nom', 'prenom', 'username', 'motdepasse', 'adresse'];

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


    protected $idClient;
    protected $nom;
    protected $prenom;
    protected $username;
    protected $motDePasse;
    protected $adresse;

    public function setIdClient($idClient)
    {
        $this->idClient = $idClient;
    }

    public function getIdClient()
    {
        return $this->idClient;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setMotDepasse($motDePasse)
    {
        $this->motDePasse = $motDePasse;
    }

    public function getMotDePasse()
    {
        return $this->motDePasse;
    }

    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    public function getAdresse()
    {
        return $this->adresse;
    }

    public function getSimpleClient()
    {
        $sql = "select * from client where username = %s and motdepasse = %s";
        $sql = sprintf($sql, $this->db->escape($this->getUsername()), $this->db->escape(sha1($this->getMotDePasse())));
        $query = $this->db->query($sql);
        $rows = $query->getRowArray();
        $client = new Client();
        $client->setIdClient($rows['idclient']);
        $client->setNom($rows['nom']);
        $client->setprenom($rows['prenom']);
        $client->setUsername($rows['username']);
        $client->setMotDepasse($rows['motdepasse']);
        $client->setAdresse($rows['adresse']);
        return $client;
    }
}

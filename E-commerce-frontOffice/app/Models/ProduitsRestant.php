<?php

namespace App\Models;

use CodeIgniter\Model;

class ProduitsRestant extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'produitsrestant';
    protected $primaryKey       = 'idproduitsrestant';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['idproduitsrestant', 'idrecette', 'idproduit', 'quantiterestant'];

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


    protected $idProduitsRestant;
    protected $idRecette;
    protected $idProduit;
    protected $quantiteRestant;
    protected $designation;


    public function setDesignation($designation)
    {
        $this->designation = $designation;
    }

    public function getDesignation()
    {
        return $this->designation;
    }

    public function setIdProduitsRestant($idProduitsRestant)
    {
        $this->idProduitsRestant = $idProduitsRestant;
    }

    public function getIdProduitsRestant()
    {
        return $this->idProduitsRestant;
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

    public function setQuantiteRestant($quantiteRestant)
    {
        $this->quantiteRestant = $quantiteRestant;
    }

    public function getQuantiteRestant()
    {
        return $this->quantiteRestant;
    }

    public function verifierQuantiteRestant()
    {
        $verifier = true;
        $sql = "select count(*) as rows from produitsrestant";
        $query = $this->db->query($sql);
        $rows = $query->getRowArray();
        if($rows['rows'] == 0)
        {
            $verifier = false;
        }
        return $verifier;
    }

    public function getDataProduitsRestant()
    {
        $data['idrecette'] = $this->getIdRecette();
        $data['idproduit'] = $this->getIdProduits();
        $data['quantiterestant'] = $this->getQuantiteRestant();
        return $data;
    }


    public function getSimpleProduitsRestant()
    {
        $data = array();
        $sql = "select * from reste where quantiterestant > 0";
        $query = $this->db->query($sql);
        foreach($query->getResultArray() as $rows)
        {
            if($rows['designation'] != "Cote de porc")
            {
                $reste = new ProduitsRestant();
                $reste->setIdProduits($rows['idproduit']);
                $reste->setDesignation($rows['designation']);
                $reste->setQuantiteRestant($rows['quantiterestant']);
                $data[] = $reste;
            }
        }
        return $data;
    }


    public function insertionProduitsRestant($idRecette, $quantite)
    {
        $infosRecette = new InfosRecette();
        $tabInfosRecette = $infosRecette->getAllInfosRecetteFinal($idRecette, $quantite);
        foreach($tabInfosRecette as $infos)
        {
            $reste = new ProduitsRestant();
            $reste->setIdRecette($infos->getIdRecette());
            $reste->setIdProduits($infos->getIdProduits());
            $reste->setQuantiteRestant($infos->getResteProduits());
            $dataProduitsRestant = $reste->getDataProduitsRestant();
            $reste->save($dataProduitsRestant);
        }
    }

    public function insertionProduitsRestantv2($idRecette, $quantite)
    {
        $infosRecette = new InfosRecette();
        $tabInfosRecette = $infosRecette->getAllInfosRecetteFinalv2($idRecette, $quantite);
        foreach($tabInfosRecette as $infos)
        {
            $reste = new ProduitsRestant();
            $reste->setIdRecette($infos->getIdRecette());
            $reste->setIdProduits($infos->getIdProduits());
            $reste->setQuantiteRestant($infos->getResteProduits());
            $dataProduitsRestant = $reste->getDataProduitsRestant();
            $reste->save($dataProduitsRestant);
        }
    }

    public function verifierQuantiteDisponible($idProduit, $quantite)
    {
        $verifier = false;
        $sql = "select * from viewproduitsrestant where idproduit = %d";
        $sql = sprintf($sql, $idProduit);
        $query = $this->db->query($sql);
        $rows = $query->getRowArray();
        if(!empty($rows['quantiterestant']))
        {
            if($quantite <= $rows['quantiterestant'])
            {
                $verifier = true;
            }
        }
        return $verifier;
    }

    public function getSommeRestant($idProduit)
    {
        $sommeRestant = 0;
        $sql = "select * from viewproduitsrestant where idproduit = %d";
        $sql = sprintf($sql, $idProduit);
        $query = $this->db->query($sql);
        $rows = $query->getRowArray();
        if(!empty($rows['quantiterestant']))
        {
            $sommeRestant = $rows['quantiterestant'];
        }
        return $sommeRestant;
    }

    public function supprimerSommeRestant($idProduit)
    {
        $sql = "delete from produitsrestant where idproduit = %d";
        $sql = sprintf($sql, $idProduit);
        $this->db->query($sql);
    }

    public function deleteAllSommeRestant()
    {
        $sql = "delete from produitsrestant";
        $this->db->query($sql);
    }
}




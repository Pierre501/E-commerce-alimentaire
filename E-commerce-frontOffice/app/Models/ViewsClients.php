<?php

namespace App\Models;

use CodeIgniter\Model;

class ViewsClients extends Model
{
    protected $idClient;
    protected $nom;
    protected $prenom;
    protected $username;
    protected $motDePasse;
    protected $adresse;
    protected $montant;
    protected $status;
    protected $dateDepot;

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

    public function setMontant($montant)
    {
        $this->montant = $montant;
    }

    public function getMontant()
    {
        return $this->montant;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setDateDepot($dateDepot)
    {
        $this->dateDepot = $dateDepot;
    }

    public function getDateDepot()
    {
        return $this->dateDepot;
    }

    public function getAllPorteFeuille($status)
    {
        $data = array();
        $sql = "select * from viewsclient where status = %s";
        $sql = sprintf($sql, $this->db->escape($status));
        $query = $this->db->query($sql);
        foreach($query->getResultArray() as $rows)
        {
            $views = new ViewsClients();
            $views->setIdClient($rows['idclient']);
            $views->setNom($rows['nom']);
            $views->setPrenom($rows['prenom']);
            $views->setUsername($rows['username']);
            $views->setMotDepasse($rows['motdepasse']);
            $views->setAdresse($rows['adresse']);
            $views->setMontant($rows['montant']);
            $views->setStatus($rows['status']);
            $views->setDateDepot($rows['dateencours']);
            $data[] = $views;
        }
        return $data;
    }

    public function getAllIdPorteFeuille()
    {
        $data = array();
        $sql = "select *from portefeuille where idclient = %d and datedepot = %s";
        $sql = sprintf($sql, $this->getIdClient(), $this->db->escape($this->getDateDepot()));
        $query = $this->db->query($sql);
        foreach($query->getResultArray() as $rows)
        {
            $data[] = $rows['idportefeuille'];
        }
        return $data;
    }

    public function updatePorteFeuille($idPorteFeuille)
    {
        $sql = "update portefeuille set status = 'valide' where idportefeuille = %d";
        $sql = sprintf($sql, $idPorteFeuille);
        $this->db->query($sql);
    }

    public function updateAllPorteFeuille()
    {
        $tabIdPorteFeuille = $this->getAllIdPorteFeuille();
        for($i = 0; $i < count($tabIdPorteFeuille); $i++)
        {
            $this->updatePorteFeuille($tabIdPorteFeuille[$i]);
        }
    }

    public function verificationLogin()
    {
        $verifier = false;
        $sql = "select count(*) ligne from client where username = %s and motdepasse = %s";
        $sql = sprintf($sql, $this->db->escape($this->getUsername()), $this->db->escape(sha1($this->getMotDePasse())));
        $query = $this->db->query($sql);
        $rows = $query->getRowArray();
        if($rows['ligne'] == 1)
        {
            $verifier = true;
        }
        return $verifier;
    }

    public function getSolde()
    {
        $solde = 0;
        $sql = "select solde from viewsclient where username = %s and motdepasse = %s and status = 'valide'";
        $sql = sprintf($sql, $this->db->escape($this->getUsername()), $this->db->escape(sha1($this->getMotDePasse())));
        $query = $this->db->query($sql);
        $rows = $query->getRowArray();
        $solde = $rows['solde'];
        return $solde;
    }
}



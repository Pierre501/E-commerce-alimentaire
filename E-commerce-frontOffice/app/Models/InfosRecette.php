<?php 
namespace App\Models;

use CodeIgniter\Model;

class InfosRecette extends Model
{

    protected $DBGroup          = 'default';
    protected $table            = 'infosrecette';
    protected $primaryKey       = 'idproduit';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['idproduit', 'designation', 'poidunitaire', 'prixunitaire', 'idrecette', 'quantitedetailsrecette', 'seuilproduit'];

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

    protected $idProduits;
    protected $idRecette;
    protected $designation;
    protected $poidUnitaire;
    protected $prixUnitaire;
    protected $seuilProduits;
    protected $quantiteDetailsRecette;
    protected $poidEngage;
    protected $prixEngage;
    protected $resteProduits;


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

    public function setDesignation($designation)
    {
        $this->designation = $designation;
    }

    public function getDesignation()
    {
        return $this->designation;
    }

    public function setPoidUntaire($poidUnitaire)
    {
        $this->poidUnitaire = $poidUnitaire;
    }

    public function getPoidUnitaire()
    {
        return $this->poidUnitaire;
    }

    public function setPrixUnitaire($prixUnitaire)
    {
        $this->prixUnitaire = $prixUnitaire;
    }

    public function getPrixUnitaire()
    {
        return $this->prixUnitaire;
    }

    public function setSeuilProduits($seuilProduits)
    {
        $this->seuilProduits = $seuilProduits;
    }

    public function getSeuilProduits()
    {
        return $this->seuilProduits;
    }

    public function setQuantiteDetailsRecette($quantiteDetailsRecette)
    {
        $this->quantiteDetailsRecette = $quantiteDetailsRecette;
    }

    public function getQuantiteDetailsRecette()
    {
        return $this->quantiteDetailsRecette;
    }

    public function setPoidEngage($poidEngage)
    {
        $this->poidEngage = $poidEngage;
    }

    public function getPoidEngage()
    {
        return $this->poidEngage;
    }

    public function setPrixEngage($prixEngage)
    {
        $this->prixEngage = $prixEngage;
    }

    public function getPrixEngage()
    {
        return $this->prixEngage;
    }

    public function setResteProduits($resteProduits)
    {
        $this->resteProduits = $resteProduits;
    }

    public function getResteProduits()
    {
        return $this->resteProduits;
    }

    public function getSimpleInfosRecette($idRecette)
    {
        $data = array();
        $sql = "select * from infosrecette where idrecette = %d";
        $sql = sprintf($sql, $idRecette);
        $query = $this->db->query($sql);
        foreach($query->getResultArray() as $rows)
        {
            $infos = new InfosRecette();
            $infos->setIdProduits($rows['idproduit']);
            $infos->setIdRecette($rows['idrecette']);
            $infos->setDesignation($rows['designation']);
            $infos->setPoidUntaire($rows['poidunitaire']);
            $infos->setPrixUnitaire($rows['prixunitaire']);
            $infos->setSeuilProduits($rows['seuilproduit']);
            $infos->setQuantiteDetailsRecette($rows['quantitedetailsrecette']);
            $data[] = $infos;
        }
        return $data;
    }


    public function getSimpleInfosRecettev2($idProduit)
    {
        $sql = "select * from infosrecette where idproduit = %d";
        $sql = sprintf($sql, $idProduit);
        $query = $this->db->query($sql);
        $infos = new InfosRecette();
        foreach($query->getResultArray() as $rows)
        {
            $infos->setPoidUntaire($rows['poidunitaire']);
            $infos->setPrixUnitaire($rows['prixunitaire']);
            break;
        }
        return $infos;
    }

    public function getAllInfosRecette($idRecette, $quantite)
    {
        $data = array();
        $tabInfosRecette = $this->getSimpleInfosRecette($idRecette);
        foreach($tabInfosRecette as $infosRecette)
        {
            $infos = new InfosRecette();
            $infos->setIdProduits($infosRecette->getIdProduits());
            $infos->setIdRecette($infosRecette->getIdRecette());
            $infos->setDesignation($infosRecette->getDesignation());
            $infos->setPoidUntaire($infosRecette->getPoidUnitaire());
            $infos->setPrixUnitaire($infosRecette->getPrixUnitaire());
            $infos->setSeuilProduits($infosRecette->getSeuilProduits());
            $infos->setQuantiteDetailsRecette($infosRecette->getQuantiteDetailsRecette()*$quantite);
            if($infosRecette->getPoidUnitaire() < $infosRecette->getQuantiteDetailsRecette()*$quantite)
            {
                $poidEngage = $infosRecette->getPoidUnitaire() * 2;
                $prixEngage = $infosRecette->getPrixUnitaire() * 2;
                $infos->setPoidEngage($poidEngage);
                $infos->setPrixEngage($prixEngage);
                while($poidEngage < $infosRecette->getQuantiteDetailsRecette()*$quantite)
                {
                    $i = 3;
                    $poidEngage = $infosRecette->getPoidUnitaire() * $i;
                    $prixEngage = $infosRecette->getPrixUnitaire() * $i;
                    $infos->setPoidEngage($poidEngage);
                    $infos->setPrixEngage($prixEngage);
                    if($poidEngage > $infosRecette->getQuantiteDetailsRecette()*$quantite)
                    {
                        break;
                    }
                    $i++;
                }
            }
            else
            {
                $infos->setPoidEngage($infos->getPoidUnitaire());
                $infos->setPrixEngage($infos->getPrixUnitaire());
            }
            $data[] = $infos;
        }
        return $data;
    }


    public function getAllInfosRecettev2($idRecette, $quantite)
    {
        $data = array();
        $produitsRestant = new ProduitsRestant();
        $tabInfosRecette = $this->getSimpleInfosRecette($idRecette);
        foreach($tabInfosRecette as $infosRecette)
        {
            $infos = new InfosRecette();
            $infos->setIdProduits($infosRecette->getIdProduits());
            $infos->setIdRecette($infosRecette->getIdRecette());
            $infos->setDesignation($infosRecette->getDesignation());
            $infos->setPoidUntaire($infosRecette->getPoidUnitaire());
            $infos->setPrixUnitaire($infosRecette->getPrixUnitaire());
            $infos->setSeuilProduits($infosRecette->getSeuilProduits());
            $quantiteDetailsRecette = $infosRecette->getQuantiteDetailsRecette() * $quantite;
            $infos->setQuantiteDetailsRecette($quantiteDetailsRecette);
            $sommeRestant = $produitsRestant->getSommeRestant($infosRecette->getIdProduits());
            if($quantiteDetailsRecette <= $sommeRestant)
            {
                $infos->setPoidEngage($sommeRestant);
                $infos->setPrixEngage(0);
                $produitsRestant->supprimerSommeRestant($infosRecette->getIdProduits());
            }
            else
            {
                $produitsRestant->supprimerSommeRestant($infosRecette->getIdProduits());
                $poidEngage = $infosRecette->getPoidUnitaire() + $sommeRestant;
                $prixEngage = $infosRecette->getPrixUnitaire();
                if($poidEngage < $quantiteDetailsRecette)
                {
                    $produitsRestant->supprimerSommeRestant($infosRecette->getIdProduits());
                    $poidEngage = $infosRecette->getPoidUnitaire() * 2;
                    $prixEngage = $infosRecette->getPrixUnitaire() * 2;
                    if($poidEngage < $quantiteDetailsRecette)
                    {
                        while($poidEngage < $quantiteDetailsRecette)
                        {
                            $i = 3;
                            $poidEngage += $infosRecette->getPoidUnitaire() * $i;
                            $prixEngage = $infosRecette->getPrixUnitaire() * $i;
                            $infos->setPrixEngage($prixEngage);
                            $infos->setPoidEngage($poidEngage);
                            if($poidEngage > $quantiteDetailsRecette)
                            {
                                break;
                            }
                            $i++;
                        }
                    }
                    else
                    {
                        $infos->setPoidEngage($poidEngage);
                        $infos->setPrixEngage($prixEngage);
                    }
                }
                else
                {
                    $infos->setPoidEngage($poidEngage);
                    $infos->setPrixEngage($prixEngage);
                }
            }
            $data[] = $infos;
        }
        return $data;
    }

    public function getAllInfosRecetteFinal($idRecette, $quantite)
    {
        $data = array();
        $tabInfosRecette = $this->getAllInfosRecette($idRecette, $quantite);
        foreach($tabInfosRecette as $infosRecette)
        {
            $infos = new InfosRecette();
            $infos->setIdProduits($infosRecette->getIdProduits());
            $infos->setIdRecette($infosRecette->getIdRecette());
            $infos->setDesignation($infosRecette->getDesignation());
            $infos->setPoidUntaire($infosRecette->getPoidUnitaire());
            $infos->setPrixUnitaire($infosRecette->getPrixUnitaire());
            $infos->setSeuilProduits($infosRecette->getSeuilProduits());
            $infos->setQuantiteDetailsRecette($infosRecette->getQuantiteDetailsRecette());
            $infos->setPoidEngage($infosRecette->getPoidEngage());
            $infos->setPrixEngage($infosRecette->getPrixEngage());
            $infos->setResteProduits($infosRecette->getPoidEngage()-$infosRecette->getQuantiteDetailsRecette());
            $data[] = $infos;
        }
        return $data;
    }

    public function getAllProduitsRestant($idRecette, $quantite)
    {
        $data = array();
        $reste = new ProduitsRestant();
        $tabInfos = $this->getAllInfosRecetteFinal($idRecette, $quantite);
        foreach($tabInfos as $infosRecette)
        {
            $sommeRestant  = $reste->getSommeRestant($infosRecette->getIdProduits());
            if($infosRecette->getQuantiteDetailsRecette() <= $sommeRestant)
            {
                $data[] = $infosRecette;
            }
        }
        return $data;
    }

    public function verificationProduitsRestant($idRecette, $quantite)
    {
        $verfier = false;
        $reste = new ProduitsRestant();
        $tabInfos = $this->getAllInfosRecette($idRecette, $quantite);
        foreach($tabInfos as $infosRecette)
        {
            $sommeRestant  = $reste->getSommeRestant($infosRecette->getIdProduits());
            if($infosRecette->getQuantiteDetailsRecette() <= $sommeRestant)
            {
                $verfier = true;
                break;
            }
        }
        return $verfier;
    }

    public function getAllInfosRecetteFinalv2($idRecette, $quantite)
    {
        $data = array();
        $tabInfosRecette = $this->getAllInfosRecettev2($idRecette, $quantite);
        foreach($tabInfosRecette as $infosRecette)
        {
            $infos = new InfosRecette();
            $infos->setIdProduits($infosRecette->getIdProduits());
            $infos->setIdRecette($infosRecette->getIdRecette());
            $infos->setDesignation($infosRecette->getDesignation());
            $infos->setPoidUntaire($infosRecette->getPoidUnitaire());
            $infos->setPrixUnitaire($infosRecette->getPrixUnitaire());
            $infos->setSeuilProduits($infosRecette->getSeuilProduits());
            $infos->setQuantiteDetailsRecette($infosRecette->getQuantiteDetailsRecette());
            $infos->setPoidEngage($infosRecette->getPoidEngage());
            $infos->setPrixEngage($infosRecette->getPrixEngage());
            $infos->setResteProduits($infosRecette->getPoidEngage()-$infosRecette->getQuantiteDetailsRecette());
            $data[] = $infos;
        }
        return $data;
    }
}

?>
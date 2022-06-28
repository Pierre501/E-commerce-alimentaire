<?php 
class ViewsClient
{
    protected $idClient;
    protected $nom;
    protected $prenom;
    protected $username;
    protected $motDePasse;
    protected $adresse;
    protected $idPorteFeuille;
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

    public function setIdPorteFeulile($idPorteFeuille)
    {
        $this->idPorteFeuille = $idPorteFeuille;
    }

    public function getidPorteFeuille()
    {
        return $this->idPorteFeuille;
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

    public function getAllPorteFeuilleNonValide()
    {
        $data = array();
        $url = "http://localhost/www/Evaluation-de-stage/E-commerce-frontOffice/porteFeuilles";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $tabPorteFeuille = json_decode($response, true);
        for($i = 0; $i < count($tabPorteFeuille); $i++)
        {
            foreach($tabPorteFeuille[$i] as $porteFeuille)
            {
                $views = new ViewsClient();
                $views->setIdClient($porteFeuille['idclient']);
                $views->setNom($porteFeuille['nom']);
                $views->setPrenom($porteFeuille['prenom']);
                $views->setUsername($porteFeuille['username']);
                $views->setMotDepasse($porteFeuille['motdepasse']);
                $views->setAdresse($porteFeuille['adresse']);
                $views->setMontant($porteFeuille['montant']);
                $views->setStatus($porteFeuille['status']);
                $views->setDateDepot($porteFeuille['dateencours']);
                $data[] = $views;
            }
        }
        return $data;
    }
}
?>
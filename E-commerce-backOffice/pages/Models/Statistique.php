<?php 
class Statistique
{

    protected $designation;
    protected $quantite;

    public function setDesignation($designation)
    {
        $this->designation = $designation;
    }

    public function getDesignation()
    {
        return $this->designation;
    }

    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }

    public function getQuantite()
    {
        return $this->quantite;
    }

    public function getAllStatistiqueProduits()
    {
        $data = array();
        $url = "http://localhost/www/Evaluation-de-stage/E-commerce-frontOffice/statistiqueProduits";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $tabStatistique = json_decode($response, true);
        for($i = 0; $i < count($tabStatistique); $i++)
        {
            foreach($tabStatistique[$i] as $statisitques)
            {
                $statisitque = new Statistique();
                $statisitque->setDesignation($statisitques['designation']);
                $statisitque->setQuantite($statisitques['quantite']);
                $data[] = $statisitque;
            }
        }
        return $data;
    }

    public function getAllDesignation()
    {
        $data = array();
        $tabStatistique = $this->getAllStatistiqueProduits();
        foreach($tabStatistique as $statisitque)
        {
            $data[] = $statisitque->getDesignation();
        }
        return $data;
    }

    public function getAllQuantite()
    {
        $data = array();
        $tabStatistique = $this->getAllStatistiqueProduits();
        foreach($tabStatistique as $statisitque)
        {
            $data[] = $statisitque->getQuantite();
        }
        return $data;
    }
}

?>






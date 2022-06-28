<?php 
class StatistiqueRecette
{

    protected $idRecette;
    protected $nomRecette;
    protected $quantiteRecette;

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

    public function getAllStatistiqueRecette()
    {
        $data = array();
        $url = "http://localhost/www/Evaluation-de-stage/E-commerce-frontOffice/statistiqueRecette";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $tabStatistiqueRecette = json_decode($response, true);
        for($i = 0; $i < count($tabStatistiqueRecette); $i++)
        {
            foreach($tabStatistiqueRecette[$i] as $statistiques)
            {
                $statistique = new StatistiqueRecette();
                $statistique->setIdRecette($statistiques['idrecette']);
                $statistique->setNomRecette($statistiques['nomrecette']);
                $statistique->setQuantiteRecette($statistiques['quantiterecette']);
                $data[] = $statistique;
            }
        }
        return $data;
    }

    public function getAllQuantiteRecette()
    {
        $data = array();
        $tabStatistiqueRecette = $this->getAllStatistiqueRecette();
        foreach($tabStatistiqueRecette as $statistique)
        {
            $data[] = $statistique->getQuantiteRecette();
        }
        return $data;
    }

    public function getAllNomRecette()
    {
        $data = array();
        $tabStatistiqueRecette = $this->getAllStatistiqueRecette();
        foreach($tabStatistiqueRecette as $statistique)
        {
            $data[] = $statistique->getNomRecette();
        }
        return $data;
    }
}
?>







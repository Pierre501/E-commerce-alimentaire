<?php 
class Categories
{
    private $idCategorie;
    private $categorie;

    public function setIdCategories($idCategorie)
    {
        $this->idCategorie = $idCategorie;
    }

    public function getIdCategorie()
    {
        return $this->idCategorie;
    }

    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }

    public function getCategorie()
    {
        return $this->categorie;
    }

    public function getAllCategories()
    {
        $data = array();
        $url = "http://localhost/www/Evaluation-de-stage/E-commerce-frontOffice/categories";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $tabCategorie = json_decode($response, true);
        foreach($tabCategorie as $categories)
        {
            $categorie = new Categories();
            $categorie->setIdCategories($categories['idcategorie']);
            $categorie->setCategorie($categories['categorie']);
            $data[] = $categorie;
        }
        return $data;
    }
}

?>
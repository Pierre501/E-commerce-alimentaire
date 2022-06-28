<?php 
class Produits
{
    protected $idProduit;
    protected $idCategorie;
    protected $designation;
    protected $description;

    public function setIdProduits($idProduits)
    {
        $this->idProduit = $idProduits;
    }

    public function getIdProduits()
    {
        return $this->idProduit;
    }

    public function setIdCategorie($idCategorie)
    {
        $this->idSCategorie = $idCategorie;
    }

    public function getIdCategorie()
    {
        return $this->idCategorie;
    }

    public function setDesignation($designation)
    {
        $this->designation = $designation;
    }

    public function getDesignation()
    {
        return $this->designation;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescrption()
    {
        return $this->description;
    }

    public function getAllProduits()
    {
        $data = array();
        $url = "http://localhost/www/Evaluation-de-stage/E-commerce-frontOffice/produits";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $tabProduits = json_decode($response, true);
        foreach($tabProduits as $produits)
        {
            $produit = new Produits();
            $produit->setIdProduits($produits['idproduit']);
            $produit->setIdCategorie($produits['idcategorie']);
            $produit->setDesignation($produits['designation']);
            $produit->setDescription($produits['description']);
            $data[] = $produit;
        }
        return $data;
    }
}

?>
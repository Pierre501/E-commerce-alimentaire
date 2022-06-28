<?php 
class StockRestant
{
    protected $designation;
    protected $quantite;
    protected $dateStock;

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

    public function setDateStock($date)
    {
        $this->dateStock = $date;
    }

    public function getdateStock()
    {
        return $this->dateStock;
    }

    public function getAllStockRestant()
    {
        $data = array();
        $url = "http://localhost/www/Evaluation-de-stage/E-commerce-frontOffice/stockRestants";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $tabStockRestant = json_decode($response, true);
        for($i = 0; $i < count($tabStockRestant); $i++)
        {
            foreach($tabStockRestant[$i] as $stockRestant)
            {
                $stock = new StockRestant();
                $stock->setDesignation($stockRestant['designation']);
                $stock->setQuantite($stockRestant['quantite']);
                $stock->setDateStock($stockRestant['dateStock']);
                $data[] = $stock;
            }
        }
        return $data;
    }
}
?>
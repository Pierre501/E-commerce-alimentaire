<?php 
if(isset($_POST['produit']) && isset($_POST['quantite']) && isset($_POST['date']))
{
    $data['idproduit'] = $_POST['produit'];
    $data['quantitestockentrant'] = $_POST['quantite'];
    $data['datestockentrant'] = $_POST['date'];
    $url = "http://localhost/www/Evaluation-de-stage/E-commerce-frontOffice/addStockEntrant";
    $data_json = json_encode($data);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: '.strlen($data_json)));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $tabJson = json_decode($response, true);
    $condition = $tabJson['condition'];
    if($condition == "Inscription effectué")
    {
        header('Location: stock.php');
    }
    else
    {
        header('Location: stock.php?erreur');
    }
}
else if(isset($_POST['idclient']) && isset($_POST['datedepot']))
{
    $data['idclient'] = $_POST['idclient'];
    $data['datedepot'] = $_POST['datedepot'];
    $url = "http://localhost/www/Evaluation-de-stage/E-commerce-frontOffice/upDatePorteFeuille";
    $data_json = json_encode($data);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: '.strlen($data_json)));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $tabJson = json_decode($response, true);
    $condition = $tabJson['message'];
    if($condition == "Modification effectué")
    {
        header('Location: validation.php');
    }
    else
    {
        header('Location: validation.php?erreur');
    }
}
?>
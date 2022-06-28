<?php 
if(isset($_POST['username']) && isset($_POST['motdepasse']))
{
    $data['username'] = $_POST['username'];
    $data['motdepasse'] = $_POST['motdepasse'];
    $url = "http://localhost/www/Evaluation-de-stage/E-commerce-frontOffice/loginAdmin";
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
    if($condition == true)
    {
        header('Location: admin.php');
    }
    else
    {
        header('Location: login.php?erreur');
    }
}
else
{
    $data['idcategorie'] = $_POST['idcategorie'];
    $data['designation'] = $_POST['designation'];
    $data['prixunitaire'] = $_POST['prixunitaire'];
    $data['datedetailsproduits'] = $_POST['dateprixunitaire'];
    $data['description'] = $_POST['description'];
    $url = "http://localhost/www/Evaluation-de-stage/E-commerce-frontOffice/addProduits";
    $ch = curl_init();
    $data['images'] = new CurlFile($_FILES['images']['tmp_name'], $_FILES['images']['type'], $_FILES['images']['name']);
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$data); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $tabJson = json_decode($response, true);
    if($tabJson['message'] == "Inscription effectué")
    {
    	header('Location: ajout.php');
    }
    else
    {
        header('Location: ajout.php?erreur');
    }
}
?>
<?php
$servername = "mysql:host=localhost;dbname=gestion_finance";
$username = "root";
$password = "";

try{
    $conn = new PDO($servername, $username, $password);

    //definr le mode d'erreur pdo sur l'exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo "Echec à la connexion : " . $e->getMessage();
}

?>
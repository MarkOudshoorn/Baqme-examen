<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "baqmedb";

try {
    // Maak een nieuwe PDO-verbinding
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Stel de foutmodus in op uitzonderingen
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
} catch(PDOException $e) {
    // Als er een fout optreedt bij het maken van de verbinding, toon dan een foutmelding
    echo "Verbindingsfout: " . $e->getMessage();
    
    exit();
}
?>

<?php
session_start();

// Als de gebruiker al is ingelogd, stuur ze door naar de startpagina
if(isset($_SESSION['gebruiker_id'])) {
    header("Location: baqme_homepage.php");
    exit;
}

require_once "Global/DBconnect.php";
global $db;
$foutmelding = null;



$gebruikersnaam = null;
$wachtwoord = null;

if(isset($_POST["gebruikersnaam"]) && $_POST["gebruikersnaam"] != null)
    $gebruikersnaam = $_POST["gebruikersnaam"];
if(isset($_POST["wachtwoord"]) && $_POST["wachtwoord"] != null)
    $wachtwoord = $_POST["wachtwoord"];


if($gebruikersnaam && $wachtwoord)
{
    // Query om te controleren of de gebruiker bestaat in de database
    $query = "SELECT gebruiker_id, gebruikersnaam, wachtwoord, rol FROM gebruikers WHERE gebruikersnaam = ?";

    try {
        // Bereid de SQL-statement voor
        $stmt = $db->pdo->prepare($query);
        
        // Bind parameters
        $stmt->bindParam(1, $gebruikersnaam, PDO::PARAM_STR);
        
        // Voer de statement uit
        $stmt->execute();
        
        // Haal resultaten op
        $gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Controleer of de gebruiker bestaat en of het wachtwoord klopt
        if($gebruiker && password_verify($wachtwoord, $gebruiker['wachtwoord'])) {
            // Start een nieuwe sessie
            $_SESSION["gebruiker_id"] = $gebruiker['gebruiker_id'];
            $_SESSION["gebruikersnaam"] = $gebruiker['gebruikersnaam'];
            $_SESSION["rol"] = $gebruiker['rol']; // Voeg rol toe aan sessie
            
            // Doorstuur de gebruiker naar de startpagina
            header("Location: baqme_homepage.php");
            exit;
        } else {
            // Foutmelding als gebruikersnaam of wachtwoord onjuist is
            $foutmelding = "Ongeldige gebruikersnaam of wachtwoord.";
        }
    } catch(PDOException $e) {
        // Foutmelding als er een fout optreedt bij het uitvoeren van de query
        echo "Oops! Er ging iets mis: " . $e->getMessage();
    }
}

?>


<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Inloggen</title>
    <link rel="stylesheet" href="stylesheet.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body id="loginBody">
<div id="loginMenu_center">
    <div id="loginMenu_header">
        <div id="loginMenu_BQLogo">
            <img id="loginMenu_BQLogo_img" src="Resources/BQ-Logo.png">
        </div>
        <div id="loginMenu_BQLogoText">
            <h2>Dashboard</h2>
        </div>
    </div>
    <div id="loginMenu_content">
        <div id="loginMenu_content_flair">
            <div id="LineContainer_1">
                <div class="Line"></div>
                <div class="Line"></div>
                <div class="Line"></div>
            </div>
            <div id="LineContainer_2">
                <div class="Line"></div>
                <div class="Line"></div>
                <div class="Line"></div>
                <div class="Line"></div>
            </div>
        </div>
        <div id="loginMenu_content_form">
            <form id="loginMenu_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div>
                    <input class="input_field" type="text" name="gebruikersnaam" placeholder="Gebruikersnaam...">
                </div>    
                <div>
                    <input class="input_field" type="password" name="wachtwoord" placeholder="Wachtwoord...">
                </div>
                <div>
                    <input class="button" type="submit" value="Inloggen">
                </div>
            </form>
        </div>
    </div>
    
    <?php 
        if($foutmelding != null)
        {
            echo '<div class="errorBox">' . $foutmelding . '</div>';
        }
        else
        {
            echo '<div class="errorBox_noError"';
        }
    ?>
</div>
</body>
</html>

<?php
session_start();

//als de gebruikers niet ingelogt stuur naar login.php om in te logen
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}
//als de user al ingelogt dan stuur de gebruikers naar dashboard.php
if(isset($_SESSION['loggedInGebruiker'])) {
    header("Location: dashboard.php");
    exit;
}
require_once "../Classes/gebruikers.php";
require_once "../Global/DBconnect.php";
global $db;
<<<<<<< Updated upstream

=======
//als nog niet ingelogt is,de variabelen zijn nu null voor controleren
>>>>>>> Stashed changes
$foutmelding = null;
$gebruikersnaam = null;
$wachtwoord = null;

if(isset($_POST["gebruikersnaam"]) && $_POST["gebruikersnaam"] != null)
    $gebruikersnaam = $_POST["gebruikersnaam"];
if(isset($_POST["wachtwoord"]) && $_POST["wachtwoord"] != null)
    $wachtwoord = $_POST["wachtwoord"];


if($gebruikersnaam && $wachtwoord){
    //query om te controleren of de gebruiker bestaat in de database
    $query = "SELECT * FROM gebruikers WHERE gebruikersnaam = ?";
    try {
        $stmt = $db->pdo->prepare($query);
        $stmt->bindParam(1, $gebruikersnaam, PDO::PARAM_STR);
        $stmt->execute();
        //haal resultaten op
        $gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);
        
        //heir check of de gebruiker bestaat en of het wachtwoord klopt is
        if($gebruiker && password_verify($wachtwoord, $gebruiker['wachtwoord'])) {
            $_SESSION["loggedInGebruiker"] = new Gebruiker($gebruiker['gebruiker_id'], $gebruiker['gebruikersnaam'], 
                                                        $gebruiker['wachtwoord'], $gebruiker['rol'], $gebruiker['created_at'],
                                                        $gebruiker['profilepicture']);
            header("Location: dashboard.php");
            exit;
        } else {
            //als gebruikersnaam of wachtwoord onjuist is geeft foutmelding dat:
            $foutmelding = "Ongeldige gebruikersnaam of wachtwoord.";
        }
    } catch(PDOException $e) {
        //als er andere problemen zijn met database geeft dit foutmelding:
        echo "Oops! Er ging iets mis: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Inloggen</title>
    <link rel="stylesheet" href="../Global/stylesheet.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body id="loginBody">
<div id="loginMenu_center">
    <div id="loginMenu_header">
        <div id="loginMenu_BQLogo">
            <img id="loginMenu_BQLogo_img" src="../Resources/BQ-Logo.png">
        </div>
        <div id="loginMenu_BQLogoText">
            <h2>Dashboard</h2>
        </div>
    </div>
    <!--dit line's de div s zijn voor  de style ALLEEN -->
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
    //hier is de plek waar ik wil de foutmelding zien
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

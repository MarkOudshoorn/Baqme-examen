<?php
session_start();


require_once "Global/DBconnect.php";
global $db;

$foutmelding = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ontvang gegevens van het registratieformulier
    $gebruikersnaam = htmlspecialchars($_POST['gebruikersnaam']);
    $wachtwoord = htmlspecialchars($_POST['wachtwoord']);
    $bevestig_wachtwoord = htmlspecialchars($_POST['bevestig_wachtwoord']);
    $rol = htmlspecialchars($_POST['rol']); // Ontvang de geselecteerde rol

           // Valideer het e-mailformaat voor gebruikersnaam
        if (!filter_var($gebruikersnaam, FILTER_VALIDATE_EMAIL)) {
            $foutmelding = "Voer alstublieft een geldig e-mailadres";
        } elseif (empty($wachtwoord) || empty($bevestig_wachtwoord)) {
            $foutmelding = "Vul alle velden in.";
        } elseif ($wachtwoord != $bevestig_wachtwoord) {
            $foutmelding = "Wachtwoorden komen niet overeen.";
        } else {
            try {
                // Bereid de SQL-statement voor om gebruiker toe te voegen aan de database
                $sql = "INSERT INTO gebruikers (gebruikersnaam, wachtwoord, rol) VALUES (:gebruikersnaam, :wachtwoord, :rol)";
                $stmt = $db->pdo->prepare($sql);

                // Hash het wachtwoord
                $hashed_wachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);
        
                // Bind variabelen aan de voorbereide verklaring als parameters
                $stmt->bindValue(':gebruikersnaam', $gebruikersnaam, PDO::PARAM_STR);
                $stmt->bindValue(':wachtwoord', $hashed_wachtwoord, PDO::PARAM_STR);
                $stmt->bindValue(':rol', $rol, PDO::PARAM_STR);
        
                // Voer de voorbereide verklaring uit om de gebruiker toe te voegen
                if($stmt->execute()) {
                    // Doorstuur de gebruiker naar de inlogpagina
                    header("Location: login.php");
                    exit();
                } else {
                    // Foutmelding als het niet mogelijk is om de query uit te voeren
                    $foutmelding = "Er is iets misgegaan. Probeer het later opnieuw.";
                }
            } catch (PDOException $e) {
                // Foutmelding als er een fout optreedt bij het uitvoeren van de query
                echo "Oops! Er ging iets mis: " . $e->getMessage();
            }
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
                <form id="loginMenu_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateForm()">
                    <div>
                        <input class="input_field" type="text" id="gebruikersnaam" name="gebruikersnaam" placeholder="Gebruikersnaam...">
                    </div>    
                    <div>
                        <input class="input_field" type="password" name="wachtwoord" placeholder="Wachtwoord...">
                    </div>
                    <div>
                        <input class="input_field" type="password" name="bevestig_wachtwoord" placeholder="Bevestig wachtwoord...">
                    </div>
                    <div>Kies gebruiker als</div>
                    <div>
                       
                        <select class="" name="rol" required>
                            <option value="user">Gebruiker</option>
                            <option value="admin">Beheerder</option>
                        </select>
                    </div>
                    <div>
                        <input class="button" type="submit" value="Registreren">
                    </div>
                </form>
            </div>
        </div>
        <?php
        if(isset($foutmelding)) {
            echo '<div class="errorBox">' . $foutmelding . '</div>';
        }
        ?>
    </div>
</body>
</html>

<?php
session_start();
// voor vieligheid met URL: als de gebruikers niet ingelogt stuur naar login.php om in te logen
if(!isset($_SESSION['loggedInGebruiker']))
{
    header("location: login.php");
}
require_once "../Global/DBconnect.php";
global $db;
//zet nu de fout mendingen null nu dan kan je displayen als heb
$foutmelding = null;
if($_SERVER["REQUEST_METHOD"] == "POST") {
    //dit zijn de gegevens van het registratieformulier
    $gebruikersnaam = htmlspecialchars($_POST['gebruikersnaam']);
    $wachtwoord = htmlspecialchars($_POST['wachtwoord']);
    $bevestig_wachtwoord = htmlspecialchars($_POST['bevestig_wachtwoord']);
    $rol = htmlspecialchars($_POST['rol']);
           //dit is soort filtter om de user informiren dat moet goed gegevens intypen
        if (!filter_var($gebruikersnaam, FILTER_VALIDATE_EMAIL)) {
            $foutmelding = "Voer alstublieft een geldig e-mailadres";
        } elseif (empty($wachtwoord) || empty($bevestig_wachtwoord)) {
            $foutmelding = "Vul alle velden in.";
        } elseif ($wachtwoord != $bevestig_wachtwoord) {
            $foutmelding = "Wachtwoorden komen niet overeen.";
        } else {
            try {
                //als de user gegevens klopt is opslaan in de database
                $sql = "INSERT INTO gebruikers (gebruikersnaam, wachtwoord, rol) VALUES (:gebruikersnaam, :wachtwoord, :rol)";
                $stmt = $db->pdo->prepare($sql);
                //hashing van het wachtwoord
                $hashed_wachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);
                //voorbereide verklaring als parameters
                $stmt->bindValue(':gebruikersnaam', $gebruikersnaam, PDO::PARAM_STR);
                $stmt->bindValue(':wachtwoord', $hashed_wachtwoord, PDO::PARAM_STR);
                $stmt->bindValue(':rol', $rol, PDO::PARAM_STR);
                if($stmt->execute()) {
                    //stuur gebruiker naar de inlogpagina
                    header("Location: dashboard.php");
                    exit();
                } else {
                    //als er iets mis gaat geef dit melding
                    $foutmelding = "Er is iets misgegaan. Probeer het later opnieuw.";
                }
            } catch (PDOException $e) {
                //en als iets fout gaat met data verbinding geef dit melding
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
                <h2>Registreren</h2>
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
        //hier is de plek waar ik wil de foutmelding zien
        if(isset($foutmelding)) {
            echo '<div class="errorBox">' . $foutmelding . '</div>';
        }
        ?>
    </div>
</body>
</html>

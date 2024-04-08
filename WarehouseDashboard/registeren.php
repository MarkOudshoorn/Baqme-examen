<?php
session_start();

// Als de gebruiker niet is ingelogd als admin, stuur ze terug naar de startpagina
if(!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: baqme_homepage.php");
    exit;
}

require_once "Global/DBconnecting.php";
global $db;

$foutmelding = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ontvang gegevens van het registratieformulier
    $gebruikersnaam = htmlspecialchars($_POST['gebruikersnaam']);
    $wachtwoord = htmlspecialchars($_POST['wachtwoord']);
    $bevestig_wachtwoord = htmlspecialchars($_POST['bevestig_wachtwoord']);
    $rol = htmlspecialchars($_POST['rol']); // Ontvang de geselecteerde rol

    // Valideer gegevens
    if(empty($gebruikersnaam) || empty($wachtwoord) || empty($bevestig_wachtwoord)) {
        $foutmelding = "Vul alle velden in.";
    } elseif($wachtwoord != $bevestig_wachtwoord) {
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
    <title>Registreren</title>
</head>
<body>
    <h2>Registreren</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <label>Gebruikersnaam</label>
            <input type="text" name="gebruikersnaam">
        </div>    
        <div>
            <label>Wachtwoord</label>
            <input type="password" name="wachtwoord">
        </div>
        <div>
            <label>Bevestig wachtwoord</label>
            <input type="password" name="bevestig_wachtwoord">
        </div>
        <div>
            <label>Rol</label>
            <select name="rol">
                <option value="user">Gebruiker</option>
                <option value="admin">Beheerder</option>
            </select>
        </div>
        <div>
            <input type="submit" value="Registreren">
        </div>
    </form>
    <p>Terug naar  <a href="baqme_homepage.php">Homepage</a>.</p>
    <?php
    if(isset($foutmelding)) {
        echo "<p>$foutmelding</p>";
    }
    ?>
</body>
</html>

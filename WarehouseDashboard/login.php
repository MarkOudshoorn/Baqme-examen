<?php
session_start();

// Als de gebruiker al is ingelogd, stuur ze door naar de startpagina
if(isset($_SESSION['gebruiker_id'])) {
    header("Location: baqme_homepage.php");
    exit;
}

require_once "Global/DBconnect.php";
global $db;

$foutmelding = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ontvang gegevens van het inlogformulier
    $gebruikersnaam = htmlspecialchars($_POST['gebruikersnaam']);
    $wachtwoord = htmlspecialchars($_POST['wachtwoord']);

    // Query om te controleren of de gebruiker bestaat in de database
    $sql = "SELECT gebruiker_id, gebruikersnaam, wachtwoord, rol FROM gebruikers WHERE gebruikersnaam = ?";
    
    try {
        // Bereid de SQL-statement voor
        $stmt = $db->pdo->prepare($sql);
        
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
</head>
<body>
    <h2>Inloggen</h2>
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
            <input type="submit" value="Inloggen">
        </div>
    </form>
    <?php if($foutmelding): ?>
        <p><?php echo $foutmelding; ?></p>
    <?php endif; ?>
</body>
</html>

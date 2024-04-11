<?php
require_once 'DBconnect.php'; 
require_once '../Classes/gebruikers.php'; 

$howManyAccounts = 0;

// Functie om wachtwoord te hashen
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Haal de beschikbare rollen op uit de database
$roles = [];
$stmt = $db->pdo->query("SELECT DISTINCT rol FROM gebruikers");
if ($stmt) {
    while($row = $stmt->fetch()) {
        $roles[] = $row['rol'];
    }
}

// Check of een POST-verzoek is verzonden om wachtwoord bij te werken
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updatePassword'])) {
    $accountId = $_POST['accountId'];
    $newPassword = hashPassword($_POST['newPassword']); // Hash het nieuwe wachtwoord

    try {
        $stmt = $db->pdo->prepare("UPDATE gebruikers SET wachtwoord = :newPassword WHERE gebruiker_id = :accountId");
        $stmt->bindParam(':newPassword', $newPassword);
        $stmt->bindParam(':accountId', $accountId);
        if ($stmt->execute()) {
            echo "Wachtwoord succesvol bijgewerkt.";
        } else {
            echo "Er is een fout opgetreden bij het bijwerken van het wachtwoord.";
            // Debugging: Voeg een regel toe om de query te bekijken die wordt uitgevoerd
            echo "Query: " . $stmt->queryString;
        }
    } catch (PDOException $e) {
        echo "Fout bij het bijwerken van het wachtwoord: " . $e->getMessage();
    }
}

// Check of een POST-verzoek is verzonden om een gebruiker te verwijderen
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteUser'])) {
    $deleteUserId = $_POST['deleteUserId'];

    try {
        $stmt = $db->pdo->prepare("DELETE FROM gebruikers WHERE gebruiker_id = :deleteUserId");
        $stmt->bindParam(':deleteUserId', $deleteUserId);
        if ($stmt->execute()) {
            echo "Gebruiker succesvol verwijderd.";
        } else {
            echo "Er is een fout opgetreden bij het verwijderen van de gebruiker.";
            // Debugging: Voeg een regel toe om de query te bekijken die wordt uitgevoerd
            echo "Query: " . $stmt->queryString;
        }
    } catch (PDOException $e) {
        echo "Fout bij het verwijderen van de gebruiker: " . $e->getMessage();
    }
}

// Check of een POST-verzoek is verzonden om de rol bij te werken
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateRole'])) {
    $accountId = $_POST['accountId'];
    $newRole = $_POST['newRole'];

    try {
        $stmt = $db->pdo->prepare("UPDATE gebruikers SET rol = :newRole WHERE gebruiker_id = :accountId");
        $stmt->bindParam(':newRole', $newRole);
        $stmt->bindParam(':accountId', $accountId);
        if ($stmt->execute()) {
            echo "Rol succesvol bijgewerkt.";
        } else {
            echo "Er is een fout opgetreden bij het bijwerken van de rol.";
            // Debugging: Voeg een regel toe om de query te bekijken die wordt uitgevoerd
            echo "Query: " . $stmt->queryString;
        }
    } catch (PDOException $e) {
        echo "Fout bij het bijwerken van de rol: " . $e->getMessage();
    }
}

// Check of een POST-verzoek is verzonden om alle wijzigingen op te slaan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['saveChanges'])) {
    // Voeg hier de logica toe om alle wijzigingen op te slaan
    // Dit kan bijvoorbeeld het uitvoeren van een updatequery zijn voor alle records
    // Zorg ervoor dat je de updatequery's correct opstelt en uitvoert op basis van je specifieke behoeften
    // Hieronder staat een voorbeeld van hoe je dit zou kunnen doen:
    try {
        // Voor elke gebruiker in de database
        $stmt = $db->pdo->query("SELECT * FROM gebruikers");
        if ($stmt) {
            while($row = $stmt->fetch()) {
                $accountId = $row["gebruiker_id"];
                // Voeg hier de logica toe om de wijzigingen voor elke gebruiker op te slaan
                // Bijvoorbeeld: updatequery's voor wachtwoord, rol, etc.
                // Update wachtwoord
                // Update rol
                // Voer de updatequery's uit
            }
        }
        // Geef een succesmelding weer als alles succesvol is opgeslagen
        echo "Alle wijzigingen succesvol opgeslagen.";
    } catch (PDOException $e) {
        // Geef een foutmelding weer als er een fout optreedt bij het opslaan van de wijzigingen
        echo "Fout bij het opslaan van de wijzigingen: " . $e->getMessage();
    }
}

// Functie om een accountweergave toe te voegen
function AddAccountPass($gebruiker, $roles)
{
    global $howManyAccounts;
    ?>
    <div class="accountPass">
        <div class="accountPass_pfp">
            <img src="<?php echo $gebruiker->getProfilePicture(); ?>">
        </div>
        <div class="accountPass_details">
            <?php echo $gebruiker->getGebruikersnaam(); ?><br>
            <form method='POST' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>'>
                <input type='hidden' name='accountId' value='<?php echo $gebruiker->getGebruikerId(); ?>'>
                <input type='password' name='newPassword' placeholder='Nieuw Wachtwoord' required>
                <button type='submit' name='updatePassword'>Wachtwoord bijwerken</button>
            </form>
            <form method='POST' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>'>
                <input type='hidden' name='deleteUserId' value='<?php echo $gebruiker->getGebruikerId(); ?>'>
                <button type='submit' name='deleteUser'>Gebruiker verwijderen</button>
            </form>
        </div>
        <div class="accountPass_options">
            <form method='POST' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>'>
                <input type='hidden' name='accountId' value='<?php echo $gebruiker->getGebruikerId(); ?>'>
                <select name='newRole'>
                    <?php foreach ($roles as $role): ?>
                        <option value='<?php echo $role; ?>'><?php echo $role; ?></option>
                    <?php endforeach; ?>
                </select>
                <button type='submit' name='updateRole'>Rol bijwerken</button>
            </form>
        </div>
    </div>
    <?php
    $howManyAccounts++;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Global/stylesheet.css">
    <script src="../Global/jsFunctions.js"></script>
    <title>Dashboard</title>
</head>
<body>
    <div id="bgBlur" onclick="ToggleSubMenu()"></div>
    <nav id="navbar">
        <div id=navbar_buttonLeft onclick="Redirect('../login.php?logout=true')">
            <img src="../Resources/null.png">
        </div>
        <div id="navbar_buttonCenter" onclick="Redirect('../baqme_homepage.php')">
            <img src="../Resources/BQ-Logo-text.png">
        </div>
        <div id="navbar_buttonRight" onclick="ToggleSubMenu()">
            <img src="../Resources/setting.svg">
        </div>
        <div id="subMenu">
            <div id="accounts">
                <?php 
                require_once 'DBconnect.php';
                require_once '../Classes/gebruikers.php';

                $stmt = $db->pdo->query("SELECT * FROM gebruikers");

                if ($stmt) {
                    while($row = $stmt->fetch()) {
                        $gebruiker = new Gebruiker($row["gebruiker_id"], $row["gebruikersnaam"], $row["wachtwoord"], $row["rol"], $row["created_at"], $row["profilepicture"]);
                        AddAccountPass($gebruiker, $roles);
                    }
                } else {
                    echo "Geen gebruikers gevonden.";
                }
                ?>
            </div>
        </div>
        <div id="saveButton">
            <form method='POST' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>'>
                <button type='submit' name='saveChanges'>Opslaan</button>
            </form>
        </div>
    </nav>
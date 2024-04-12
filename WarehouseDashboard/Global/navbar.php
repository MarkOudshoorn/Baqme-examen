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
// Controleer of de gebruiker is ingelogd en haal de rol op uit de database
function checkUserRole($db) {
    // Controleer of de gebruiker is ingelogd
    if (isset($_SESSION['gebruiker_id'])) {
        // Haal de gebruikersrol op uit de database
        $gebruiker_id = $_SESSION['gebruiker_id'];
        $stmt = $db->pdo->prepare("SELECT rol FROM gebruikers WHERE gebruiker_id = :gebruiker_id");
        $stmt->bindParam(':gebruiker_id', $gebruiker_id);
        if ($stmt->execute()) {
            $row = $stmt->fetch();
            if ($row) {
                return $row['rol']; // Geef de rol terug
            }
        }
    }
    return 'user'; // Standaardrol als de gebruiker niet is ingelogd of als er een fout optreedt
}

// Functie om de knop voor het beheren van gebruikers weer te geven op basis van de gebruikersrol
function displayUserManagementButton($role) {
    if ($role === 'admin') {
        echo '<div id="navbar_buttonRight" onclick="ToggleSubMenu()">';
        echo '<img src="../Resources/setting.svg">';
        echo '</div>';
    }
}

// Controleer de gebruikersrol en toon de knop indien nodig
$role = checkUserRole($db);

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

// Check of een POST-verzoek is verzonden om een gebruiker bij te werken
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateUser'])) {
    $accountId = $_POST['accountId'];
    $newPassword = hashPassword($_POST['newPassword']); // Hash het nieuwe wachtwoord
    $newRole = $_POST['newRole'];

    try {
        $stmt = $db->pdo->prepare("UPDATE gebruikers SET wachtwoord = :newPassword, rol = :newRole WHERE gebruiker_id = :accountId");
        $stmt->bindParam(':newPassword', $newPassword);
        $stmt->bindParam(':newRole', $newRole);
        $stmt->bindParam(':accountId', $accountId);
        if ($stmt->execute()) {
            echo "<script>window.location.href = '../Webpages/baqme_homepage.php?edit=true'</script>";
        } else {
            echo "Er is een fout opgetreden bij het bijwerken van de gebruiker.";
            // Debugging: Voeg een regel toe om de query te bekijken die wordt uitgevoerd
            echo "Query: " . $stmt->queryString;
        }
    } catch (PDOException $e) {
        echo "Fout bij het bijwerken van de gebruiker: " . $e->getMessage();
    }
}


// Functie om een accountweergave toe te voegen
function AddAccountPass($gebruiker, $roles)
{
    global $howManyAccounts;
    ?>
    <div class="accountPass">
       <div class="accountPass_pfp">
    <?php 
    $profilePicture = $gebruiker->getProfilePicture();
    if (!empty($profilePicture)) {
        echo '<img src="data:image/jpeg;base64,'.base64_encode($profilePicture).'">';
    } else {
        echo '<img src="placeholder.jpg" alt="Profielfoto">';
    }


   
    ?>
</div>

        <div class="accountPass_details">
            <div id="userData-<?php echo $howManyAccounts ?>">
                <?php echo $gebruiker->getGebruikersnaam(); ?><br>
                <?php echo $gebruiker->getRol(); ?> 
            </div>
            <form id="editForm-<?php echo $howManyAccounts ?>" class="editForm-invis">
                <input type='hidden' name='accountId' value='<?php echo $gebruiker->getGebruikerId(); ?>'>
                <input type="text" readonly required="required" value="<?php echo $gebruiker->getGebruikersnaam(); ?>">
                <input type='password' name='newPassword' placeholder='Nieuw Wachtwoord' >
                <select name='newRole'>
                    <?php foreach (['admin', 'user'] as $roleOption): ?>
                        <option value='<?php echo $roleOption; ?>' <?php if($roleOption === $gebruiker->getRol()) echo 'selected'; ?>><?php echo $roleOption; ?></option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>
        <div>
            <div class="accountPass_functionButton_column" id="accountPass_DeleteButton_<?php echo $howManyAccounts; ?>"
                onclick="ToggleSubmenuButtons('delete', '<?php echo $howManyAccounts; ?>', 'appear');">
                <img src="../Resources/delete.svg">
            </div>
            <div class="accountPass_functionButton_hidden" style="top: 0; right: 30px"
                id="accountPass_confirmDeleteButton_<?php echo $howManyAccounts; ?>">
                <img src="../Resources/check.svg">
            </div>
            <div class="accountPass_functionButton_hidden" style="top: 0; right: 0"
                id="accountPass_cancelDeleteButton_<?php echo $howManyAccounts; ?>"
                onclick="ToggleSubmenuButtons('delete', '<?php echo $howManyAccounts; ?>', 'disappear')">
                <img src="../Resources/remove.svg">
            </div>
            <div class="accountPass_functionButton_column" style="top: 30px" id="accountPass_EditButton_<?php echo $howManyAccounts; ?>"
                onclick="ToggleSubmenuButtons('edit', '<?php echo $howManyAccounts; ?>', 'appear'); 
                AddOrRemoveItemToClassList_ID('remove', 'editForm-<?php echo $howManyAccounts ?>', 'editForm-invis');
                AddOrRemoveItemToClassList_ID('add', 'userData-<?php echo $howManyAccounts ?>', 'editForm-invis');">
                <img src="../Resources/edit.svg">
            </div>
            <div class="accountPass_functionButton_hidden" style="top: 30px; right: 30px"
                id="accountPass_confirmEditButton_<?php echo $howManyAccounts; ?>">
                <img src="../Resources/save.svg">
            </div>
            <div class="accountPass_functionButton_hidden" style="top: 30px; right: 0px"
                id="accountPass_cancelEditButton_<?php echo $howManyAccounts; ?>"
                onclick="ToggleSubmenuButtons('edit', '<?php echo $howManyAccounts; ?>', 'disappear'); 
                AddOrRemoveItemToClassList_ID('remove', 'userData-<?php echo $howManyAccounts ?>', 'editForm-invis');
                AddOrRemoveItemToClassList_ID('add', 'editForm-<?php echo $howManyAccounts ?>', 'editForm-invis');">
                <img src="../Resources/remove.svg">
            </div>
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
<style>
.time_navbar{
        width: 100%;
    height: 30px;
    background-color: rgb(39 57 56);
    display: flex;
}
#navbar_clock{
    font-size: x-large;
    font-family: fantasy;
    color: white;
}
#navbar_timer{
       font-size: x-large;
    font-family: monospace;
    color: white;
    position: absolute;
    right: 50%;
    left: 50%;
    width: 200px;
}
#navbar_user_info{
    font-size: x-large;
    font-family: monospace;
    color: white;
    right: 0;
    position: absolute;
}
</style>
<body>
<div id="bgBlur" onclick="ToggleSubMenu()"></div>
    <nav id="navbar">
    
                <div id="navbar_buttonLeft" onclick="logoutAndRedirect()">
            <img src="../Resources/null.png">
        </div>
        
        <div id="navbar_buttonCenter" onclick="Redirect('../baqme_homepage.php')">
            <img src="../Resources/BQ-Logo-text.png">
        </div>
       
        <?php displayUserManagementButton($role); ?>
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
        <div class="time_navbar">
          <div id="navbar_clock"></div>
     <div id="navbar_timer"></div>
      <div id="navbar_user_info">
            <?php 
            echo "Welkom  " . $_SESSION['gebruikersnaam']; 
            ?>
        </div>
        </div>
    </nav>
  
    <script>
function logoutAndRedirect() {
    window.location.href = "login.php?logout=true";
   
}
var url = window.location.href; 
if(url.includes("navbar.php")){
    window.location.href ="../Webpages/login.php";
}
   // Timer voor automatische vernieuwing van de pagina elke 5 minuten
        var countdown = 300; // Tijd in seconden
        var timerDisplay = document.getElementById("navbar_timer");

        function updateTimer() {
            var minutes = Math.floor(countdown / 60); // Bereken het aantal minuten
            var seconds = countdown % 60; // Bereken het aantal seconden

            // Zet de tijd in het juiste formaat (mm:ss)
            var timeString = minutes.toString().padStart(2, '0') + ":" + seconds.toString().padStart(2, '0');
            timerDisplay.innerText =  timeString;

            countdown--;

            if (countdown < 0) {
                location.reload();
            } else {
                setTimeout(updateTimer, 1000); // Wacht 1 seconde voordat de timer wordt bijgewerkt
            }
        }

        // Start de timer
        updateTimer();
         // Klokfunctie om de huidige tijd weer te geven
        function updateClock() {
            var now = new Date(); // Huidige datum en tijd
            var hours = now.getHours().toString().padStart(2, '0'); // Uur (in 24-uurs formaat)
            var minutes = now.getMinutes().toString().padStart(2, '0'); // Minuten
            var seconds = now.getSeconds().toString().padStart(2, '0'); // Seconden

            // Zet de tijd in het juiste formaat (hh:mm:ss)
            var timeString = hours + ":" + minutes + ":" + seconds;
            document.getElementById("navbar_clock").innerText ="Time : " + timeString; // Update de klok

            // Update de klok elke seconde
            setTimeout(updateClock, 1000);
        }

        // Start de klok wanneer de pagina geladen is
        updateClock();
</script>

</body>
</html>

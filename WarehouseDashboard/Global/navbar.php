<?php
require_once 'DBconnect.php'; 
require_once '../Classes/gebruikers.php'; 
//require de basics

session_start();

// Functie om wachtwoord te hashen
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

if(!isset($_SESSION['loggedInGebruiker']))
{
    header("location: login.php");
}

//haal alle rollen op uit de database om deze in een dropdown te laten zien
function GetAllRoles($db)
{
    $roles = [];
    $stmt = $db->pdo->query("SELECT DISTINCT rol FROM gebruikers");
    if ($stmt) {
        while($row = $stmt->fetch()) {
            $roles[] = $row['rol'];
        }
    }
    return $roles;
}

//helper functie om te kijken of een bepaalt element geladen moet worden
//hangt af van de role van het account
function displayUserManagementButton() {
    global $db;
    $gebruiker = $_SESSION["loggedInGebruiker"];
    $rol = $gebruiker->GetRol();
    if ($gebruiker->GetRol() === 'admin') {
        echo '<div id="navbar_buttonRight" onclick="ToggleSubMenu()">';
            echo '<img src="../Resources/setting.svg">';
        echo '</div>';
        echo '<div id="subMenu">
            <div id="submenuOptions">
            </div>
            <div id="accounts">';

        $stmt = $db->pdo->query("SELECT * FROM gebruikers");

        if ($stmt) {
            while($row = $stmt->fetch()) {
                $gebruiker = new Gebruiker($row["gebruiker_id"], $row["gebruikersnaam"], $row["wachtwoord"], $row["rol"], $row["created_at"], $row["profilepicture"]);
                AddAccountPass($gebruiker, GetAllRoles($db));
            }
        } else {
            echo "Geen gebruikers gevonden.";
        }
            echo "</div>
                    <div class='accountPass'>
                        <div class='accountPass_pfp'>
                            <img src='../Resources/user-add.svg' id='addUserImage'>
                        </div>
                        <form id='editForm-new' action='../Webpages/dashboard.php' method='post' class='accountPass_details'>
                            <input type='text' name='email' placeholder='Email...'>
                            <input type='password' name='password' placeholder='Wachtwoord...' >
                            <select name='role'>
                                    <option value='admin'>Admin</option>
                                    <option value='user'>User</option>
                            </select>
                        
                            <div class='accountPass_functionButtons'>
                            <div class='accountPass_functionButton_column' id='accountPass_SaveButton_newAccount'
                            onclick='ToggleSubmenuButtonsOnNewUser(`open`)'>
                                <img src='../Resources/save.svg' style='position: absolute; right: 0'>
                            </div>
                            <button class='accountPass_functionButton_hidden' id='accountPass_confirmSaveButton_newAccount'
                                        name='new' type='submit' style='top: 0; right: 30px'>
                                <img src='../Resources/check.svg'>
                            </button>
                            <div class='accountPass_functionButton_hidden' id='accountPass_cancelSaveButton_newAccount'
                            onclick='ToggleSubmenuButtonsOnNewUser(`close`)' style='top: 0; right: 0'>
                                <img src='../Resources/remove.svg'>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>";
    }
}


//helper functie om het password te verifyen met die van de database
//deze wordt gebruikt om te kijken of het password dat ingevoert is anders is dan
//degene in de database.
function CheckForUpdatedPw($password)
{
    if(isset($_SESSION["loggedInGebruiker"]))
    {
        $loggedInUser = $_SESSION["loggedInGebruiker"];
        if(password_verify($password, $loggedInUser->getWachtwoord()) || $password == "")
            return "old";
        else
            return "new";
    }
    else
    {
        echo "<script>console.log('Not logged in')</script>";
    }
}

//if-statements om te kijken of we van een redirect kwamen waar een formulier ingevult was
//zo ja, waren alle gegevens ingevult en correct? pas dan de database aan op de gebruiker's request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $accountId = $_POST['accountId'];
    $newPassword = $_POST['password'];
    $oldPassword = $_SESSION["loggedInGebruiker"]->getWachtwoord();
    $newGebruikersnaam = $_POST["gebruikersnaam"];
    $newRol = $_POST["rol"];
    $newUpdated = "1";
    $datetime = Date("Y-m-d h:i:s");
    $newPfp = null;
    $isNewPw = CheckForUpdatedPw($newPassword); //checken of het wachtwoord geupdate is
    try {
        $stmt = $db->pdo->prepare("UPDATE gebruikers SET wachtwoord = :newPassword, 
                                            gebruikersnaam = :newGebruikersnaam,
                                            rol = :newRol,
                                            created_at = :newCreated_at,
                                            updated = :newUpdated,
                                            profilepicture = :newProfilepicture
                                            WHERE gebruiker_id = :accountId");

        if ($isNewPw == "new") { //als het wachtwoord nieuw is moet deze nog gehashed worden
            $newPasswordHashed = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt->bindParam(':newPassword', $newPasswordHashed);
        } else {
            $stmt->bindParam(':newPassword', $oldPassword); //het oude wachtwoord was binnen gekomen als een hash, geen hash meer nodig
        }

        $stmt->bindParam(":newGebruikersnaam", $newGebruikersnaam);
        $stmt->bindParam(":newRol", $newRol);
        $stmt->bindParam(":newCreated_at", $datetime);
        $stmt->bindParam(":newUpdated", $newUpdated);
        $stmt->bindParam(":newProfilepicture", $newPfp);

        $stmt->bindParam(':accountId', $accountId);
        if ($stmt->execute()) {
            header("location: dashboard.php");
        } else {
            echo "<script>console.log('Error')</script>";
            echo "Query: " . $stmt->queryString;
        }
    } catch (PDOException $e) {
        echo "Fout bij het bijwerken van het wachtwoord: " . $e->getMessage();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $accountId = $_POST['accountId'];
    try {
        $stmt = $db->pdo->prepare("DELETE FROM gebruikers WHERE gebruiker_id = :deleteUserId");
        $stmt->bindParam(':deleteUserId', $accountId);
        if ($stmt->execute()) {
            header("location: dashboard.php");
        } else {
            echo "<script>console.log('error')</script>";
            echo "Query: " . $stmt->queryString;
        }
    } catch (PDOException $e) {
        echo "<script>console.log('error')</script>";
        echo "Fout bij het verwijderen van de gebruiker: " . $e->getMessage();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["new"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $role = $_POST["role"];
    $hash = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $db->pdo->prepare("INSERT INTO gebruikers (gebruikersnaam, wachtwoord, rol) VALUES (:_gebruikersnaam, :_wachtwoord, :_rol)");
        $stmt->bindParam(":_gebruikersnaam", $email);
        $stmt->bindParam(":_wachtwoord", $hash);
        $stmt->bindParam(":_rol", $role);
        if($stmt->execute()) {
            header("location: dashboard.php");
        }
        else {
            echo "<script>console.log('error')</script>";
            echo "Query: " . $stmt->queryString;
        }
    } catch (PDOException $e) {
        echo "<script>console.log('error')</script>";
        echo "Fout bij het aanmaken van de gebruiker: " . $e->getMessage();
    }
}





$howManyAccounts = 0;
//helper variable om doorheen te loopen

//Deze function wordt meerdere keren aangeroepen vanuit de plek waar deze ge-displayed moeten worden.
//Voor ieder account dat in de database gevonden is, maak een nieuw "passpoort" aan in. (in de navbar's submenu)
function AddAccountPass($gebruiker)
{
    global $howManyAccounts; //krijg de loop variable
    ?>
    <div class="accountPass">
       <div class="accountPass_pfp">
    <?php 
    $profilePicture = $gebruiker->GetProfilePicture(); //display een profile picture indien de gebruiker en een heeft
    if (!empty($profilePicture)) {
        echo '<img src="data:image/jpeg;base64,'.base64_encode($profilePicture).'">';
    } else {
        echo '<img src="../Resources/user.svg" alt="Profielfoto">';
    }
    ?>
    </div>
        <div class="accountPass_details">
            <div id="userData-<?php echo $howManyAccounts ?>">
                <?php echo $gebruiker->getGebruikersnaam(); ?><br>
                <?php echo $gebruiker->getRol(); ?>
            </div>
            <form id="editForm-<?php echo $howManyAccounts ?>" action="../Webpages/dashboard.php" method="post" class="editForm-invis">
                <input type='hidden' name='accountId' value='<?php echo $gebruiker->getGebruikerId(); ?>'>
                <input type="text" name='gebruikersnaam' value="<?php echo $gebruiker->getGebruikersnaam(); ?>">
                <input type='password' name='password' placeholder='Nieuw Wachtwoord' >
                <select name='rol'>
                    <?php foreach (['Admin', 'User'] as $roleOption): ?>
                        <option value='<?php echo $roleOption; ?>' <?php if($roleOption === $gebruiker->getRol()) echo 'selected'; ?>><?php echo $roleOption; ?></option>
                    <?php endforeach; ?>
                </select>
                </div>
                <div class="accountPass_functionButtons">
                    <!--HELL ON EARTH-->
                    <!--Super ingewikkelde cosmetische knoppen om de edit en verwijderen er mooi at the laten zien.-->
                    <!--De ene knop zorgt ervoor dat die zelf invisible gaat, en de andere twee laat zien-->
                    <!--De andere knop met ToggleSubmenuButtons is dezelfde functionaliteit vise-versa-->
                    <div class="accountPass_functionButton_column" id="accountPass_DeleteButton_<?php echo $howManyAccounts; ?>"
                        onclick="ToggleSubmenuButtons('delete', '<?php echo $howManyAccounts; ?>', 'appear');">
                        <img src="../Resources/delete.svg">
                    </div>
                    <button name="delete" type="submit" class="accountPass_functionButton_hidden" style="top: 0; right: 30px"
                        id="accountPass_confirmDeleteButton_<?php echo $howManyAccounts; ?>">
                        <img src="../Resources/check.svg">
                    </button>
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
                    <button name="update" type="submit" class="accountPass_functionButton_hidden" style="top: 30px; right: 30px"
                        id="accountPass_confirmEditButton_<?php echo $howManyAccounts; ?>">
                        <img src="../Resources/save.svg">
                    </button>
                    <div class="accountPass_functionButton_hidden" style="top: 30px; right: 0px"
                        id="accountPass_cancelEditButton_<?php echo $howManyAccounts; ?>"
                        onclick="ToggleSubmenuButtons('edit', '<?php echo $howManyAccounts; ?>', 'disappear'); 
                        AddOrRemoveItemToClassList_ID('remove', 'userData-<?php echo $howManyAccounts ?>', 'editForm-invis');
                        AddOrRemoveItemToClassList_ID('add', 'editForm-<?php echo $howManyAccounts ?>', 'editForm-invis');">
                        <img src="../Resources/remove.svg">
                    </div>
            </form>
        </div>
    </div>
    <?php
    $howManyAccounts++; //increment de howmanyaccounts var om de volgende loop unieke IDs te krijgen (voor js functions enzo)
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
<div id="bgBlur" onclick="ToggleSubMenu()"></div> <!--Coole blur waarop je kan klikken zodat de navbar's submenu weer weg gaat-->
    <nav id="navbar">
                <div id="navbar_buttonLeft" onclick="Redirect('../Webpages/login.php?logout=true')"> <!--uitlog knop-->
            <img src="../Resources/null.png">
        </div>
        <div id="navbar_buttonCenter" onclick="Redirect('../Webpages/dashboard.php')">
            <img src="../Resources/BQ-Logo-text.png">
        </div>
        <?php displayUserManagementButton(); ?> <!--functie die checkt of de account management knop ge-displayed moet worden-->
        <div class="time_navbar">
            <div id="navbar_clock"></div>
        <div id="navbar_timer"></div>
        <div id="navbar_user_info">
            <?php echo "Welkom  " . $_SESSION['loggedInGebruiker']->GetGebruikersnaam(); ?>
        </div>
        </div>
    </nav>
</body>
</html>

<script>
    var url = window.location.href; 
    if(url.includes("navbar.php")){ //check of the gebruiker handmatig geprobeerd heeft om de navbar url in te vullen
        window.location.href ="../Webpages/login.php";
    }


    //timer voor automatische vernieuwing van de pagina elke 5 minuten
    var countdown = 300; //seconden
    var timerDisplay = document.getElementById("navbar_timer");

    function updateTimer() {
        var minutes = Math.floor(countdown / 60);
        var seconds = countdown % 60;

        var timeString = minutes.toString().padStart(2, '0') + ":" + seconds.toString().padStart(2, '0');
        timerDisplay.innerText = timeString; //display de tijd in minuten

        countdown--;

        if (countdown < 0) {
            location.reload();
        } else {
            setTimeout(updateTimer, 1000); // Wacht 1 seconde voordat de timer wordt bijgewerkt
        }
    }

    //Start de timer
    updateTimer();


    //klok functie om de huidige tijd weer te geven
    function updateClock() {
        var now = new Date(); //huidige datum en tijd
        var hours = now.getHours().toString().padStart(2, '0'); //uur (in 24-uurs formaat)
        var minutes = now.getMinutes().toString().padStart(2, '0');
        var seconds = now.getSeconds().toString().padStart(2, '0');

        // Zet de tijd in het juiste formaat (hh:mm:ss)
        var timeString = hours + ":" + minutes + ":" + seconds;
        document.getElementById("navbar_clock").innerText ="Time : " + timeString; //update de klok

        //Update de klok elke seconde
        setTimeout(updateClock, 1000);
    }

    // Start de klok
    updateClock();
</script>

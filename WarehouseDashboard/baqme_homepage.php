<?php
session_start();

// Als de gebruiker niet is ingelogd, stuur ze naar de inlogpagina
if (!isset($_SESSION['gebruiker_id'])) {
    header("Location: login.php");
    exit;
}

require_once "Classes/vehicles.php";
require_once "Classes/joyride.php";
require_once "Classes/wh-issues.php";
require_once "Classes/open-issues.php";
require_once "Global/DBconnect.php"; // Inclusief het bestand voor databaseverbinding
global $db;

// Controleer de rol van de ingelogde gebruiker
$rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : '';

// Uitlogfunctionaliteit
if (isset($_GET['logout'])) {
    // Vernietig de sessie
    session_unset();
    session_destroy();
    // Stuur de gebruiker door naar de inlogpagina
    header("Location: login.php");
    exit;
}

// Steden ophalen uit de database met behulp van de PDO-verbinding
$stmt = $db->pdo->query("SELECT DISTINCT fleet FROM vehicles WHERE fleet <> ''"); // Alleen niet-lege fleets ophalen
$steden = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Controleren of de stad is doorgegeven via GET
if (isset($_GET['stad'])) {
    $stad = $_GET['stad'];

    // Query om fietsen op te halen die zich in het magazijn bevinden (warehouse) en in de gekozen stad
    $stmt = $db->pdo->prepare("
        SELECT title, fleet, vehicletype, deploy
        FROM vehicles
        WHERE fleet = ? AND title IN (
            SELECT name FROM joyride WHERE reason = 'in warehouse'
        )
    ");

    $stmt->execute([$stad]);
    $fietsen_warehouse = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Query om fietsen op te halen die klaar zijn om te gaan (deploy == 1) en in de gekozen stad
    $stmt = $db->pdo->prepare("
        SELECT title, fleet, vehicletype, deploy
        FROM vehicles
        WHERE fleet = ? AND deploy = 1
    ");

    $stmt->execute([$stad]);
    $fietsen_klaar = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // HTML genereren voor de fietsen per stad
    $html_warehouse = '<h2>Fietsen in Warehouse voor ' . $stad . '</h2>';
    $html_klaar = '<h2>Fietsen Klaar voor ' . $stad . '</h2>';

    // HTML genereren voor de knoppen per stad
    $html_steden_buttons = '<h2>Steden Categorie</h2><div id="steden-list">';
    foreach ($steden as $stad) {
        $html_steden_buttons .= '<div><button class="stad-button" data-stad="' . $stad . '">' . $stad . '</button></div>';
    }
    $html_steden_buttons .= '</div>';
    echo $html_steden_buttons;

    // Gegevens verwerken met behulp van de Vehicle klasse voor fietsen in warehouse
    foreach ($fietsen_warehouse as $fiets) {
        $html_warehouse .= "<p>Title: " . $fiets['title'] . ", Fleet: " . $fiets['fleet'] . ", Vehicle Type: " . $fiets['vehicletype'] . ", Deploy: " . $fiets['deploy'] . "</p>";
    }

    // Gegevens verwerken met behulp van de Vehicle klasse voor fietsen klaar om te gaan
    foreach ($fietsen_klaar as $fiets) {
        $html_klaar .= "<p>Title: " . $fiets['title'] . ", Fleet: " . $fiets['fleet'] . ", Vehicle Type: " . $fiets['vehicletype'] . ", Deploy: " . $fiets['deploy'] . "</p>";
    }

    // HTML-uitvoer teruggeven
    echo '<div id="warehouse-container">' . $html_warehouse . '</div>';
    echo '<div id="klaar-container">' . $html_klaar . '</div>';
}
?>


<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Welkom bij baqme</title>
</head>
<body>
<header>
    <div>logo met a herf #
    </div>
    <nav>
        <?php if ($rol === 'admin'): ?>
            <a href="registeren.php">Registreren</a>
        <?php endif; ?>
        <a href="?logout">Uitloggen</a>
    </nav>
</header>

<!-- HTML voor het weergeven van de knoppen en fietsen -->
<div id="steden-buttons">
    <?php if (!empty($steden)): ?>
        <h2>Steden Categorie</h2>
        <div id="steden-list">
            <!-- Hier worden de knoppen voor elke stad toegevoegd -->
            <?php foreach ($steden as $stad) : ?>
                <div>
                    <button class="stad-button" data-stad="<?php echo $stad; ?>"><?php echo $stad; ?></button>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<div id="warehouse-container">
    <!-- Hier worden de fietsen in warehouse weergegeven -->
</div>

<div id="klaar-container">
    <!-- Hier worden de fietsen klaar om te gaan weergegeven -->
</div>

<script>
    // JavaScript om fietsen op te halen en weer te geven bij het klikken op een stadknop
    document.addEventListener('DOMContentLoaded', function() {
        var stadButtons = document.querySelectorAll('.stad-button');

        stadButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var stad = this.getAttribute('data-stad');
                // AJAX-verzoek om fietsen op te halen die in de gekozen stad zijn
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == XMLHttpRequest.DONE) {
                        if (xhr.status == 200) {
                            // Verkregen fietsgegevens invoegen in de DOM
                            var response = xhr.responseText;
                            document.getElementById('warehouse-container').innerHTML = response;
                            document.getElementById('klaar-container').innerHTML = response;
                        } else {
                            console.error('Er is een fout opgetreden bij het ophalen van fietsgegevens');
                        }
                    }
                };
                xhr.open('GET', 'baqme_homepage.php?stad=' + encodeURIComponent(stad), true);
                xhr.send();
            });
        });
    });
</script>

</body>
</html>

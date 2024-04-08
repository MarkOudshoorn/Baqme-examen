<?php
session_start();

// Als de gebruiker niet is ingelogd, stuur ze naar de inlogpagina
if (!isset($_SESSION['gebruiker_id'])) {
    header("Location: login.php");
    exit;
}

require_once "Classes/wh-issues.php";
require_once "Classes/open-issues.php";
require_once "Classes/vehicles.php";
require_once "Classes/joyride.php";
require_once "Classes/gps.php";
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
$stmt = $db->pdo->query("SELECT DISTINCT fleet FROM vehicles");
$steden = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Controleren of de stad is doorgegeven via GET
if (isset($_GET['stad'])) {
    $stad = $_GET['stad'];

    // Query om fietsen op te halen die zich in de opgegeven stad bevinden, inclusief informatie uit wh-issues en open-issues
    $stmt = $db->pdo->prepare("
        SELECT v.*, wh.title AS wh_issue_title, wh.content AS wh_issue_content, oi.title AS open_issue_title, oi.content AS open_issue_content
        FROM vehicles v
        LEFT JOIN wh_issues wh ON v.title = wh.name
        LEFT JOIN open_issues oi ON v.title = oi.name
        WHERE v.fleet = ?
    ");

    $stmt->execute([$stad]);
    $fietsen = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // HTML genereren voor de wh-issues
    $whIssuesHTML = '<h2>WH Issues</h2>';
    foreach ($fietsen as $fiets) {
        if ($fiets['wh_issue_title'] && $fiets['wh_issue_content']) {
            $whIssuesHTML .= '<div>';
            $whIssuesHTML .= '<strong>Titel:</strong> ' . $fiets['wh_issue_title'] . '<br>';
            $whIssuesHTML .= '<strong>Inhoud:</strong> ' . $fiets['wh_issue_content'] . '<br>';
            $whIssuesHTML .= '</div>';
        }
    }

    // HTML genereren voor de open-issues
    $openIssuesHTML = '<h2>Open Issues</h2>';
    foreach ($fietsen as $fiets) {
        if ($fiets['open_issue_title'] && $fiets['open_issue_content']) {
            $openIssuesHTML .= '<div>';
            $openIssuesHTML .= '<strong>Titel:</strong> ' . $fiets['open_issue_title'] . '<br>';
            $openIssuesHTML .= '<strong>Inhoud:</strong> ' . $fiets['open_issue_content'] . '<br>';
            $openIssuesHTML .= '</div>';
        }
    }

    // JSON-respons samenstellen met wh-issues en open-issues
    $response = array(
        'whIssuesHTML' => $whIssuesHTML,
        'openIssuesHTML' => $openIssuesHTML
    );

    // JSON-respons teruggeven
    echo json_encode($response);
    exit;
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
    <h2>Steden Categorie</h2>
    <div id="steden-list">
        <!-- Hier worden de knoppen voor elke stad toegevoegd -->
        <?php foreach ($steden as $stad) : ?>
            <div>
                <button class="stad-button" data-stad="<?php echo $stad; ?>"><?php echo $stad; ?></button>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div id="wh-issues-container">
    <!-- Hier worden de wh-issues weergegeven -->
</div>

<div id="open-issues-container">
    <!-- Hier worden de open-issues weergegeven -->
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
                            // Verkregen fietsgegevens omzetten naar HTML
                            var response = JSON.parse(xhr.responseText);
                            document.getElementById('wh-issues-container').innerHTML = response.whIssuesHTML;
                            document.getElementById('open-issues-container').innerHTML = response.openIssuesHTML;
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

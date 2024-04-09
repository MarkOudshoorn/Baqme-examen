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
    <h1>Welkom bij baqme</h1>
    <nav>
        <ul>
            <?php if ($rol === 'admin'): ?>
                <li><a href="registeren.php">Registreren</a></li>
            <?php endif; ?>
            <li><a href="?logout">Uitloggen</a></li>
        </ul>
    </nav>
</header>

<main>
    <?php


    // Maak een lege array om de WHissues objecten op te slaan
    $issues = [];

    // Query om gegevens uit de database op te halen
    $sql = "SELECT id, name, title, content FROM wh_issues";

    // Voer de query uit
    $stmt = $db->pdo->prepare($sql);
    $stmt->execute();


    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Maak een nieuw WHissue object met de gegevens uit de database
        $issue = new WHissue($row);
    
        // Voeg het object toe aan de array
        $issues[] = $issue;
    }

    // Loop door de array met WHissue objecten en toon de gegevens
    foreach ($issues as $issue) {
        echo "ID: " . $issue->Get("id") . "<br>";
        echo "Naam: " . $issue->Get("name") . "<br>";
        echo "Titel: " . $issue->Get("title") . "<br>";
        echo "Inhoud: " . $issue->Get("content") . "<br>";
        echo "----------------------<br>";
    }
    ?>
</main>
</body>
</html>

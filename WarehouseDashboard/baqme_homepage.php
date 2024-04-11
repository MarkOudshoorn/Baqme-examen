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
$stmt = $db->pdo->query("SELECT DISTINCT fleet FROM vehicles WHERE fleet <> ''"); // Alle fleets ophalen, inclusief lege
$steden = $stmt->fetchAll(PDO::FETCH_COLUMN);

?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Welkom bij baqme</title>
</head>
<body>
<?php

// Loop door alle steden om fietsen op te halen en weer te geven
foreach ($steden as $stad) {
    // Query om fietsen op te halen die zich in het magazijn bevinden (warehouse) en in de gekozen stad
    $stmt_warehouse = $db->pdo->prepare("
        SELECT v.title, v.vehicletype, j.status AS joyride_status, GROUP_CONCAT(DISTINCT oi.title) AS open_issues, GROUP_CONCAT(DISTINCT wh.title) AS wh_issues
        FROM vehicles v
        LEFT JOIN joyride j ON v.title = j.name
        LEFT JOIN open_issues oi ON v.title = oi.name
        LEFT JOIN wh_issues wh ON v.title = wh.name
        WHERE (v.fleet = ? OR v.fleet = '') AND j.reason = 'in warehouse'
        GROUP BY v.title
    ");

    $stmt_warehouse->execute([$stad]);
    $fietsen_warehouse = $stmt_warehouse->fetchAll(PDO::FETCH_ASSOC);

    // HTML genereren voor de fietsen per stad
    $html_warehouse = '<div><h2>IN Warehouse ' . $stad . '</h2>';

    // Gegevens verwerken voor fietsen in het magazijn
    foreach ($fietsen_warehouse as $fiets) {
        $html_warehouse .= "<div class='fiets-container'>";
        $html_warehouse .= "<div>" . $fiets['title'] . "</div>";
        $html_warehouse .= "<div>" . $fiets['vehicletype'] . "</div>";
        $html_warehouse .= "<div>" . $fiets['joyride_status'] . "</div>";
        $html_warehouse .= "<div>" . $fiets['open_issues'] . "</div>";
        $html_warehouse .= "<div>" . $fiets['wh_issues'] . "</div>";
        $html_warehouse .= '</div>';
    }

    // HTML-uitvoer teruggeven
    echo $html_warehouse . '</div>';
    
    // Query om fietsen op te halen die klaar zijn om te gaan (deploy == 1) en in de gekozen stad
    $stmt_klaar = $db->pdo->prepare("
        SELECT v.title, v.vehicletype, j.status AS joyride_status, GROUP_CONCAT(DISTINCT oi.title) AS open_issues, GROUP_CONCAT(DISTINCT wh.title) AS wh_issues
        FROM vehicles v
        LEFT JOIN joyride j ON v.title = j.name
        LEFT JOIN open_issues oi ON v.title = oi.name
        LEFT JOIN wh_issues wh ON v.title = wh.name
        WHERE (v.fleet = ? OR v.fleet = '') AND v.deploy = '1'
        GROUP BY v.title
    ");

    $stmt_klaar->execute([$stad]);
    $fietsen_klaar = $stmt_klaar->fetchAll(PDO::FETCH_ASSOC);

    // HTML genereren voor de fietsen klaar om te gaan per stad
    $html_klaar = '<div><h2>To go ' . $stad . '</h2>';

    // Gegevens verwerken voor fietsen klaar om te gaan
    foreach ($fietsen_klaar as $fiets) {
        $html_klaar .= "<div class='fiets-container'>";
        $html_klaar .= "<div>" . $fiets['title'] . "</div>";
        $html_klaar .= "<div>" . $fiets['vehicletype'] . "</div>";
        $html_klaar .= "<div>" . $fiets['joyride_status'] . "</div>";
        $html_klaar .= "<div>" . $fiets['open_issues'] . "</div>";
        $html_klaar .= "<div>" . $fiets['wh_issues'] . "</div>";
        $html_klaar .= '</div>';
    }

    // HTML-uitvoer teruggeven
    echo $html_klaar . '</div>';
}
?>

</body>
</html>
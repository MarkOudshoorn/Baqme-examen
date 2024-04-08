<?php
session_start();

// Als de gebruiker niet is ingelogd, stuur ze naar de inlogpagina
if (!isset($_SESSION['gebruiker_id'])) {
    header("Location: login.php");
    exit;
}

require_once "Classes/wh-issues.php";
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

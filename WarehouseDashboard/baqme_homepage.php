<?php
session_start();

// Als de gebruiker niet is ingelogd, stuur ze naar de inlogpagina
if (!isset($_SESSION['gebruiker_id'])) {
    header("Location: login.php");
    exit;
}

require_once "DBconnecting.php"; // Inclusief het bestand voor databaseverbinding

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
    require_once "wh-issuesklass.php";

    // Maak een lege array om de WHissues objecten op te slaan
    $issues = [];

    // Query om gegevens uit de database op te halen
    $sql = "SELECT id, name, title, content FROM wh_issues";

    // Voer de query uit
    $result = $pdo->query($sql);

    // Controleer of er resultaten zijn
    if ($result->rowCount() > 0) {
        // Loop door de resultaten en maak voor elk resultaat een WHissues object
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            // Maak een nieuw WHissues object met de gegevens uit de database
            $issue = new WHissues($row['id'], $row['name'], $row['title'], $row['content']);

            // Voeg het object toe aan de array
            $issues[] = $issue;
        }
    } else {
        echo "Geen resultaten gevonden.";
    }

    // Loop door de array met WHissues objecten en toon de gegevens
    foreach ($issues as $issue) {
        echo "ID: " . $issue->getId() . "<br>";
        echo "Naam: " . $issue->getName() . "<br>";
        echo "Titel: " . $issue->getTitle() . "<br>";
        echo "Inhoud: " . $issue->getContent() . "<br>";
        echo "----------------------<br>";
    }
    ?>
</main>
</body>
</html>

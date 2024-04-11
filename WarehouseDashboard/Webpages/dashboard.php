<?php
session_start();
require_once("../Global/navbar.php");


// Als de gebruiker niet is ingelogd, stuur ze naar de inlogpagina
if (!isset($_SESSION['gebruiker_id'])) {
    echo '<script>Redirect("login.php");</script>';
    exit;
}

require_once "../Classes/vehicles.php";
require_once "../Classes/joyride.php";
require_once "../Classes/wh-issues.php";
require_once "../Classes/open-issues.php";
require_once "../Global/DBconnect.php"; // Inclusief het bestand voor databaseverbinding
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

<body>
    <div id="listsContainer">
        <?php foreach ($steden as $stad) : ?>
                <?php
                // Query for warehouse lists
                $fietsen_warehouse = Query_warehouse($stad);
                ?>
                <div class="warehouse-list">
                    <h2 class="listHeader-0"><?= $stad ?></h2>
                    <h2 class="listHeader-1">To-do</h2>
                    <?php foreach ($fietsen_warehouse as $fiets) : ?>
                        <?php
                            $open_issues = explode(',', $fiets['open_issues']);
                            $wh_issues = explode(',', $fiets['wh_issues']);
                        ?>
                        <div class="fiets-container">
                            <div class="issue-header"><b style="color: white;"><?= $fiets['title'] ?></b> <small class="subHeader"><?= $fiets['vehicletype'] ?></small></div>
                            <div class="issues-container">
                                <?php foreach ($open_issues as $issue) : ?>
                                    <?php $trimmed = trim($issue); 
                                    if($trimmed != "")
                                        echo '<div class="issue">' . $trimmed . '</div>'; ?>

                                <?php endforeach; ?>

                                <?php foreach ($wh_issues as $issue) : ?>
                                    <?php $trimmed = trim($issue); 
                                    if($trimmed != "")
                                        echo '<div class="issue">' . $trimmed . '</div>'; ?>
                                <?php endforeach; ?>
                            </div>
                            <div class="JRIssues"><?= $fiets["joyride_status"] ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php
                // Query for to-go lists
                $fietsen_klaar = Query_done($stad);
                ?>
                <div class="togo-list">
                    <h2 class="listHeader-2">Ready</h2>
                    <?php foreach ($fietsen_klaar as $fiets) : ?>
                        <div class="fiets-container">
                        <div style="font-weight: bold;"><?= $fiets['title'], $fiets['vehicletype'] ?></div><

                            <?php
                            $open_issues = explode(',', $fiets['open_issues']);
                            $wh_issues = explode(',', $fiets['wh_issues']);
                            ?>
                            <div class="issues-container">
                                <?php foreach ($open_issues as $issue) : ?>
                                    <div class="issue"><?php echo "-", trim($issue); ?></div>
                                <?php endforeach; ?>

                                <?php foreach ($wh_issues as $issue) : ?>
                                    <div class="issue"><?php echo "-", trim($issue); ?></div>
                                <?php endforeach; ?>
                            </div>
                            <div class="JRIssues">wasd <?= $fiets["joyride_status"] ?> </div>
                        </div>
                    <?php endforeach; ?>
                </div>
        <?php endforeach; ?>
    </div>
</body>
</html>

<?php

function Query_warehouse($stad) //heb het in een function gedaan zodat de html wat overzichtelijker was -mark
{
    global $db;
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
    return $stmt_warehouse->fetchAll(PDO::FETCH_ASSOC);
}

function Query_done($stad)
{
    global $db;
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
    return $stmt_klaar->fetchAll(PDO::FETCH_ASSOC);
}
?>
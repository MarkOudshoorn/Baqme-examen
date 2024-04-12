<?php
require_once("../Global/navbar.php");


// Als de gebruiker niet is ingelogd, stuur ze naar de inlogpagina
if (!isset($_SESSION['loggedInGebruiker'])) {
    echo '<script>Redirect("login.php");</script>';
    exit;
}

require_once "../Classes/vehicles.php";
require_once "../Classes/joyride.php";
require_once "../Classes/wh-issues.php";
require_once "../Classes/open-issues.php";
require_once "../Global/DBconnect.php"; // Inclusief het bestand voor databaseverbinding
global $db;


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
            // Query for to-go lists
            $fietsen_klaar = Query_done($stad);
            ?>
            <div class="city-list">
                <div class="listHeaders">
                    <h2 class="listHeader-0"><?= $stad ?></h2>
                    <div class="listSubheader">
                        <h2 class="listHeader-1">To-do</h2>
                        <h2 class="listHeader-2">Ready</h2>
                    </div>
                </div>
                <div style="display: flex;">
                    <div class="todo-list">
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
                                        if ($trimmed != "") echo '<div class="issue">' . $trimmed . '</div>'; ?>
                                    <?php endforeach; ?>

                                    <?php foreach ($wh_issues as $issue) : ?>
                                        <?php $trimmed = trim($issue);
                                        if ($trimmed != "") echo '<div class="issue">' . $trimmed . '</div>'; ?>
                                    <?php endforeach; ?>
                                    <div class="JRIssues"><?= $fiets["joyride_status"] ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="ready-list">
                        <?php foreach ($fietsen_klaar as $fiets) : ?>
                            <?php
                            $open_issues = explode(',', $fiets['open_issues']);
                            $wh_issues = explode(',', $fiets['wh_issues']);
                            ?>
                            <div class="fiets-container">
                                <div class="issue-header"><b style="color: white;"><?= $fiets['title'] ?></b> <small class="subHeader"><?= $fiets['vehicletype'] ?></small></div>
                                <div class="issues-container">
                                    <?php foreach ($open_issues as $issue) : ?>
                                        <?php $trimmed = trim($issue);
                                        if ($trimmed != "") echo '<div class="issue">' . $trimmed . '</div>'; ?>
                                    <?php endforeach; ?>

                                    <?php foreach ($wh_issues as $issue) : ?>
                                        <?php $trimmed = trim($issue);
                                        if ($trimmed != "") echo '<div class="issue">' . $trimmed . '</div>'; ?>
                                    <?php endforeach; ?>
                                    <div class="JRIssues"><?= $fiets["joyride_status"] ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
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
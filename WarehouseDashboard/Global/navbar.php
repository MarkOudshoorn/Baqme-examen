<?php
    $howManyAccounts = 0;

    $editIcon = "../Resources/edit.svg";
    function AddAccountPass($name, $email, $date, $pfp)
    {
        global $howManyAccounts, $editIcon;
        echo '<div class="accountPass" id="accountPass_' . $howManyAccounts . '">
                <div class="accountPass_pfp" id="accountPass_pfp_' . $howManyAccounts . '">
                    <img src="' . $pfp . '">
                </div>
                <div class="accountPass_details" id="accountPass_details_' . $howManyAccounts . '">
                    ' . $name . '<br>
                    ' . $email . '<br>
                    <br>
                    ' . $date . '
                </div>
                <div class="accountPass_options" id="accountPass_options_' . $howManyAccounts . '">
                <div>
                    <div class="accountPass_functionButton_column" id="accountPass_DeleteButton_' . $howManyAccounts . '"
                        onclick="ToggleSubmenuButtons(\'delete\', \'' . $howManyAccounts . '\', \'appear\')">
                        <img src="../Resources/delete.svg"></div>
                    <div class="accountPass_functionButton_hidden" style="top: 0; right: 30px" id="accountPass_confirmDeleteButton_' . $howManyAccounts . '">
                        <img src="../Resources/check.svg"></div>
                    <div class="accountPass_functionButton_hidden" style="top: 0; right: 0" id="accountPass_cancelDeleteButton_' . $howManyAccounts . '"
                        onclick="ToggleSubmenuButtons(\'delete\', \'' . $howManyAccounts . '\', \'disappear\')">
                        <img src="../Resources/remove.svg"></div></div>
                <div>
                    <div class="accountPass_functionButton_column" style="top: 30px" id="accountPass_EditButton_' . $howManyAccounts . '"
                        onclick="ToggleSubmenuButtons(\'edit\', \'' . $howManyAccounts . '\', \'appear\')">
                        <img src="../Resources/edit.svg"></div>
                    <div class="accountPass_functionButton_hidden" style="top: 30px; right: 30px" id="accountPass_confirmEditButton_' . $howManyAccounts . '">
                        <img src="../Resources/save.svg"></div>
                    <div class="accountPass_functionButton_hidden" style="top: 30px; right: 0px" id="accountPass_cancelEditButton_' . $howManyAccounts . '"
                        onclick="ToggleSubmenuButtons(\'edit\', \'' . $howManyAccounts . '\', \'disappear\')">
                        <img src="../Resources/remove.svg"></div></div>
            </div>
        </div>';
        $howManyAccounts++;
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../stylesheet.css">
    <script src="jsFunctions.js"></script>
    <title>Dashboard</title>
</head>
<div id="bgBlur" onclick="ToggleSubMenu()"></div>
<nav id="navbar">
    <div id=navbar_buttonLeft onclick="Redirect('../login.php?logout=true')">
        <img src="../Resources/null.png">
    </div>
    <div id="navbar_buttonCenter" onclick="Redirect('../baqme_homepage.php')">
        <img src="../Resources/BQ-Logo-text.png">
    </div>
    <div id="navbar_buttonRight" onclick="ToggleSubMenu()">
        <img src="../Resources/setting.svg">
    </div>
    <div id="subMenu">
        <div id="accounts">
            <?php 
            for($i = 0; $i < 100; $i++)
            {
                AddAccountPass("John Doe", "J0hnnyD0e", "4/9/2024", "../Resources/user.svg");
            }
            ?>
        </div>
    </div>
</nav>
<body>
<button style="width:500px; height:500px; background-color:red; margin-top:100px;">hello world!</button>
</body>
</html>
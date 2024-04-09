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
        <img src="../Resources/power.svg">
    </div>
    <div id="navbar_buttonCenter" onclick="Redirect('../baqme_homepage.php')">
        <img src="../Resources/BQ-Logo-text.png">
    </div>
    <div id="navbar_buttonRight" onclick="ToggleSubMenu()">
        <img src="../Resources/setting.svg">
    </div>
    <div id="subMenu">
        <div id="accounts">
            <div class="accountPass">
                <div class="accountPass_pfp">
                    <img src="../Resources/user.svg">
                </div>
                <div class="accountPass_details">
                    John Doe<br>
                    ********<br>
                    <br>
                    20-5-1999
                </div>
                <div class="accountPass_editIcon">
                    <img src="../Resources/menu-01.svg">
                </div>
                <div class="accountPass_corner"></div>
            </div>
        </div>
    </div>
</nav>
<body>
<button style="width:500px; height:500px; background-color:red; margin-top:100px;">hello world!</button>
</body>
</html>
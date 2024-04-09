<?php
//Ibrahim:
//SELECT * FROM gebruikers
//require_once("gebruikers.php")
//new gebruiker($row)
//Account($gebruiker->email, $gebruiker->wachtwoord)


$defaultpfp = "Resources/user.svg";
function Account($email, $wachtwoord, $rol, $timestamp, $updated)
{
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheet.css">
    <title>Account manager</title>
</head>
<body id="accountViewBody">
    <div id="accounts">
        <div class="accountPass">
            <div class="accountPass_pfp">
                <img src="Resources/user.svg">
            </div>
            <div class="accountPass_details">
                John Doe<br>
                ********<br>
                <br>
                20-5-1999
            </div>
            <div class="accountPass_editIcon">
                <img src="Resources/menu-01.svg">
            </div>
            <div class="accountPass_corner"></div>
        </div>

        <div class="accountPass">
            <div class="accountPass_pfp">
                <img src="Resources/user.svg">
            </div>
            <div class="accountPass_details">

            </div>
            <div class="accountPass_corner"></div>
        </div>

        <div class="accountPass">
            <div class="accountPass_pfp">
                <img src="Resources/user.svg">
            </div>
            <div class="accountPass_details">

            </div>
            
            <div class="accountPass_corner"></div>
        </div>

        <div class="accountPass">
            <div class="accountPass_pfp">
                <img src="Resources/user.svg">
            </div>
            <div class="accountPass_details">

            </div>
            <div class="accountPass_corner"></div>
        </div>
    </div>
</body>
</html>
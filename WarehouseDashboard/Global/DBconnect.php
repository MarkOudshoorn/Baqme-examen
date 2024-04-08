<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "baqmedb";

class DBConnection
{
    public $pdo; //Gebruik deze variable
    public string $servername;
    public string $username;
    public string $password;
    public string $DBName;

    public function __construct($_servername, $_username, $_password, $_DBName)
    {
        $this->servername = $_servername;
        $this->username = $_username;
        $this->password = $_password;
        $this->DBName = $_DBName;
        $this->pdo = new PDO("mysql:host=" . $this->servername . ";dbname=" . $this->DBName, $this->username, $this->password);
    }
}

$db = new DBConnection($servername, $username, $password, $dbname);

//in een ander script
// global $db;
// $stmt = $db->pdo->prepare("SELECT * FROM joyride");
// $stmt->execute();
?>

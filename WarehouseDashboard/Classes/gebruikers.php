<?php
class gebruiker
{
    private $gebruiker_id;
    private $gebruikersnaam; 
    private $wachtwoord;
    private $rol;

    public function __construct($row)
    {
        $this->gebruiker_id = $row["gebruiker_id"];
        $this->gebruikersnaam = $row["gebruikersnaam"];
        $this->wachtwoord = $row["wachtwoord"];
        $this->rol = $row["rol"];
    }
}
?>
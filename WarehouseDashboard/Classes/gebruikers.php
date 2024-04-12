<?php
class Gebruiker
{
    private $gebruiker_id;
    private $gebruikersnaam;
    private $wachtwoord;
    private $rol;
    private $created_at;
    private $profilepicture;

    public function __construct($gebruiker_id, $gebruikersnaam, $wachtwoord, $rol, $created_at, $profilepicture)
    {
        $this->gebruiker_id = $gebruiker_id;
        $this->gebruikersnaam = $gebruikersnaam;
        $this->wachtwoord = $wachtwoord;
        $this->rol = $rol;
        $this->created_at = $created_at;
        $this->profilepicture = $profilepicture;
    }

    // Getters
    public function GetGebruikerId()
    {
        return $this->gebruiker_id;
    }

    public function GetGebruikersnaam()
    {
        return $this->gebruikersnaam;
    }

    public function GetWachtwoord()
    {
        return $this->wachtwoord;
    }

    public function GetRol()
    {
        return $this->rol;
    }
    public function GetCreatedAt()
    {
        return $this->created_at;
    }
    public function GetProfilePicture()
    {
        if($this->profilepicture == null || $this->profilepicture == "")
            return null;
        else
            return $this->profilepicture;
    }

    // Setters
    public function SetGebruikerId($gebruiker_id)
    {
        $this->gebruiker_id = $gebruiker_id;
    }

    public function SetGebruikersnaam($gebruikersnaam)
    {
        $this->gebruikersnaam = $gebruikersnaam;
    }

    public function SetWachtwoord($wachtwoord)
    {
        $this->wachtwoord = $wachtwoord;
    }

    public function SetRol($rol)
    {
        $this->rol = $rol;
    }
     public function SetCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }
    public function SetProfilePicture($profilepicture)
    {
        $this->profilepicture = $profilepicture;
    }

}
?>

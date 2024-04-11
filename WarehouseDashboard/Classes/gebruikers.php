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
    public function getGebruikerId()
    {
        return $this->gebruiker_id;
    }

    public function getGebruikersnaam()
    {
        return $this->gebruikersnaam;
    }

    public function getWachtwoord()
    {
        return $this->wachtwoord;
    }

    public function getRol()
    {
        return $this->rol;
    }
    public function getCreatedAt()
    {
        return $this->created_at;
    }
      public function getProfilePicture()
    {
        return $this->profilepicture;
    }

    // Setters
    public function setGebruikerId($gebruiker_id)
    {
        $this->gebruiker_id = $gebruiker_id;
    }

    public function setGebruikersnaam($gebruikersnaam)
    {
        $this->gebruikersnaam = $gebruikersnaam;
    }

    public function setWachtwoord($wachtwoord)
    {
        $this->wachtwoord = $wachtwoord;
    }

    public function setRol($rol)
    {
        $this->rol = $rol;
    }
     public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }
    public function setProfilePicture($profilepicture)
    {
        $this->profilepicture = $profilepicture;
    }

}
?>

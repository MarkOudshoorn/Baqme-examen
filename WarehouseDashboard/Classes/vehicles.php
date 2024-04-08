<?php

  
class Vehicle {
    private $title;
    private $fleet;
    private $vehicletype;
    private $deploy;
    
    public function __construct($title, $fleet, $vehicletype, $deploy) {
        $this->title = $title;
        $this->fleet = $fleet;
        $this->vehicletype = $vehicletype;
        $this->deploy = $deploy;
    }
      // Getter method
    public function Get($property)
    {
        switch ($property) {
           
            case "title":
                return $this->title;
                break;
            
            case "vehicletype":
                return $this->vehicletype;
                break;
           
            case "fleet":
                return $this->fleet;
                break;
            
            case "deploy":
                return $this->deploy;
                break;
           
            default:
                return null; // Return null for non-existent properties
        }
    }

    // Setter method
    public function Set($property, $value)
    {
        switch ($property) {
         
            case "title":
                $this->title = $value;
                break;
          
            case "vehicletype":
                $this->vehicletype = $value;
                break;
            
            case "fleet":
                $this->fleet = $value;
                break;
            
            case "deploy":
                $this->deploy = $value;
                break;
           
        }
    }

}

?>
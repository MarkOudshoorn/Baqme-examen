<?php
require_once "DBconnecting.php";
class Joyride {
    public $name;
    public $status;
    public $reason;
    public $lat;
    public $lon;
    public $last_event_time;

    // Constructor
    public function __construct($name, $status, $reason, $lat, $lon, $last_event_time) {
        $this->name = $name;
        $this->status = $status;
        $this->reason = $reason;
        $this->lat = $lat;
        $this->lon = $lon;
        $this->last_event_time = $last_event_time;
    }

    
}


?>

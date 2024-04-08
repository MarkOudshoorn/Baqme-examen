<?php
class Joyride {
    public $name;
    public $status;
    public $reason;
    public $lat;
    public $lon;
    public $last_event_time;

    // Constructor
    public function __construct($row) {
        $this->name = $row["name"];
        $this->status = $row["status"];
        $this->reason = $row["reason"];
        $this->lat = $row["lat"];
        $this->lon = $row["lon"];
        $this->last_event_time = $row["last_event_time"];
    }
}


?>

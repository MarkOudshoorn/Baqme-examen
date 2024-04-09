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

    // Getter methods
    public function getName() {
        return $this->name;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getReason() {
        return $this->reason;
    }

    public function getLat() {
        return $this->lat;
    }

    public function getLon() {
        return $this->lon;
    }

    public function getLastEventTime() {
        return $this->last_event_time;
    }

    // Setter methods
    public function setName($name) {
        $this->name = $name;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setReason($reason) {
        $this->reason = $reason;
    }

    public function setLat($lat) {
        $this->lat = $lat;
    }

    public function setLon($lon) {
        $this->lon = $lon;
    }

    public function setLastEventTime($last_event_time) {
        $this->last_event_time = $last_event_time;
    }
}
?>

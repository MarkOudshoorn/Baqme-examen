<?php
class VehicleStatus {
    public $title;
    public $status;
    public $reason;

    // Constructor
    public function __construct($row) {
        $this->title = $row["title"];
        $this->status = $row["status"];
        $this->reason = $row["reason"];
    }

    // Getter methods
    public function getTitle() {
        return $this->title;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getReason() {
        return $this->reason;
    }

    // Setter methods
    public function setTitle($title) {
        $this->title = $title;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setReason($reason) {
        $this->reason = $reason;
    }
}
?>

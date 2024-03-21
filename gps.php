<?php
require_once "DBconnecting.php";
class GPSData {
    private $id;
    private $title;
    private $attribute_b2b;
    private $attribute_firmware;
    private $attribute_guarded;
    private $attribute_alarm;
    private $attribute_lastAlarm;
    private $groupId;
    private $uniqueId;
    private $stat;
    private $lastUpdate;
    private $positionId;
    private $geofenceIds;
    private $phone;
    private $model;
    private $contact;
    private $category;
    private $isDisabled;
    private $positions_id;
    private $positions_armed;
    private $positions_charge;
    private $positions_ignition;
    private $positions_stat;
    private $positions_distance;
    private $positions_totalDistance;
    private $positions_motion;
    private $positions_batteryLevel;
    private $positions_hours;
    private $deviceId;
    private $thisType;
    private $protocol;
    private $serverTime;
    private $deviceTime;
    private $fixTime;
    private $outdated;
    private $valid;
    private $latitude;
    private $longitude;
    private $altitude;
    private $speed;
    private $course;
    private $thisAddress;
    private $accuracy;
    private $network;

    public function __construct($row) {
        $this->id = $row['id'];
        $this->title = $row['title'];
        $this->attribute_b2b = $row['attribute_b2b'];
        $this->attribute_firmware = $row['attribute_firmware'];
        $this->attribute_guarded = $row['attribute_guarded'];
        $this->attribute_alarm = $row['attribute_alarm'];
        $this->attribute_lastAlarm = $row['attribute_lastAlarm'];
        $this->groupId = $row['groupId'];
        $this->uniqueId = $row['uniqueId'];
        $this->stat = $row['stat'];
        $this->lastUpdate = $row['lastUpdate'];
        $this->positionId = $row['positionId'];
        $this->geofenceIds = $row['geofenceIds'];
        $this->phone = $row['phone'];
        $this->model = $row['model'];
        $this->contact = $row['contact'];
        $this->category = $row['category'];
        $this->isDisabled = $row['isDisabled'];
        $this->positions_id = $row['positions_id'];
        $this->positions_armed = $row['positions_armed'];
        $this->positions_charge = $row['positions_charge'];
        $this->positions_ignition = $row['positions_ignition'];
        $this->positions_stat = $row['positions_stat'];
        $this->positions_distance = $row['positions_distance'];
        $this->positions_totalDistance = $row['positions_totalDistance'];
        $this->positions_motion = $row['positions_motion'];
        $this->positions_batteryLevel = $row['positions_batteryLevel'];
        $this->positions_hours = $row['positions_hours'];
        $this->deviceId = $row['deviceId'];
        $this->thisType = $row['thisType'];
        $this->protocol = $row['protocol'];
        $this->serverTime = $row['serverTime'];
        $this->deviceTime = $row['deviceTime'];
        $this->fixTime = $row['fixTime'];
        $this->outdated = $row['outdated'];
        $this->valid = $row['valid'];
        $this->latitude = $row['latitude'];
        $this->longitude = $row['longitude'];
        $this->altitude = $row['altitude'];
        $this->speed = $row['speed'];
        $this->course = $row['course'];
        $this->thisAddress = $row['thisAddress'];
        $this->accuracy = $row['accuracy'];
        $this->network = $row['network'];
    }
}
?>
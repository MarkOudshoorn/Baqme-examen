<?php
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
      // Getter method
    public function Get($property) {
        switch ($property) {
            case 'id':
                return $this->id;
            case 'title':
                return $this->title;
            case 'attribute_b2b':
                return $this->attribute_b2b;
            case 'attribute_firmware':
                return $this->attribute_firmware;
            case 'attribute_guarded':
                return $this->attribute_guarded;
            case 'attribute_alarm':
                return $this->attribute_alarm;
            case 'attribute_lastAlarm':
                return $this->attribute_lastAlarm;
            case 'groupId':
                return $this->groupId;
            case 'uniqueId':
                return $this->uniqueId;
            case 'stat':
                return $this->stat;
            case 'lastUpdate':
                return $this->lastUpdate;
            case 'positionId':
                return $this->positionId;
            case 'geofenceIds':
                return $this->geofenceIds;
            case 'phone':
                return $this->phone;
            case 'model':
                return $this->model;
            case 'contact':
                return $this->contact;
            case 'category':
                return $this->category;
            case 'isDisabled':
                return $this->isDisabled;
            case 'positions_id':
                return $this->positions_id;
            case 'positions_armed':
                return $this->positions_armed;
            case 'positions_charge':
                return $this->positions_charge;
            case 'positions_ignition':
                return $this->positions_ignition;
            case 'positions_stat':
                return $this->positions_stat;
            case 'positions_distance':
                return $this->positions_distance;
            case 'positions_totalDistance':
                return $this->positions_totalDistance;
            case 'positions_motion':
                return $this->positions_motion;
            case 'positions_batteryLevel':
                return $this->positions_batteryLevel;
            case 'positions_hours':
                return $this->positions_hours;
            case 'deviceId':
                return $this->deviceId;
            case 'thisType':
                return $this->thisType;
            case 'protocol':
                return $this->protocol;
            case 'serverTime':
                return $this->serverTime;
            case 'deviceTime':
                return $this->deviceTime;
            case 'fixTime':
                return $this->fixTime;
            case 'outdated':
                return $this->outdated;
            case 'valid':
                return $this->valid;
            case 'latitude':
                return $this->latitude;
            case 'longitude':
                return $this->longitude;
            case 'altitude':
                return $this->altitude;
            case 'speed':
                return $this->speed;
            case 'course':
                return $this->course;
            case 'thisAddress':
                return $this->thisAddress;
            case 'accuracy':
                return $this->accuracy;
            case 'network':
                return $this->network;
            default:
                return null;
        }
    }

    // Setter method
    public function Set($property, $value) {
        switch ($property) {
            case 'id':
                $this->id = $value;
                break;
            case 'title':
                $this->title = $value;
                break;
            case 'attribute_b2b':
                $this->attribute_b2b = $value;
                break;
            case 'attribute_firmware':
                $this->attribute_firmware = $value;
                break;
            case 'attribute_guarded':
                $this->attribute_guarded = $value;
                break;
            case 'attribute_alarm':
                $this->attribute_alarm = $value;
                break;
            case 'attribute_lastAlarm':
                $this->attribute_lastAlarm = $value;
                break;
            case 'groupId':
                $this->groupId = $value;
                break;
            case 'uniqueId':
                $this->uniqueId = $value;
                break;
            case 'stat':
                $this->stat = $value;
                break;
            case 'lastUpdate':
                $this->lastUpdate = $value;
                break;
            case 'positionId':
                $this->positionId = $value;
                break;
            case 'geofenceIds':
                $this->geofenceIds = $value;
                break;
            case 'phone':
                $this->phone = $value;
                break;
            case 'model':
                $this->model = $value;
                break;
            case 'contact':
                $this->contact = $value;
                break;
            case 'category':
                $this->category = $value;
                break;
            case 'isDisabled':
                $this->isDisabled = $value;
                break;
            case 'positions_id':
                $this->positions_id = $value;
                break;
            case 'positions_armed':
                $this->positions_armed = $value;
                break;
            case 'positions_charge':
                $this->positions_charge = $value;
                break;
            case 'positions_ignition':
                $this->positions_ignition = $value;
                break;
            case 'positions_stat':
                $this->positions_stat = $value;
                break;
            case 'positions_distance':
                $this->positions_distance = $value;
                break;
            case 'positions_totalDistance':
                $this->positions_totalDistance = $value;
                break;
            case 'positions_motion':
                $this->positions_motion = $value;
                break;
            case 'positions_batteryLevel':
                $this->positions_batteryLevel = $value;
                break;
            case 'positions_hours':
                $this->positions_hours = $value;
                break;
            case 'deviceId':
                $this->deviceId = $value;
                break;
            case 'thisType':
                $this->thisType = $value;
                break;
            case 'protocol':
                $this->protocol = $value;
                break;
            case 'serverTime':
                $this->serverTime = $value;
                break;
            case 'deviceTime':
                $this->deviceTime = $value;
                break;
            case 'fixTime':
                $this->fixTime = $value;
                break;
            case 'outdated':
                $this->outdated = $value;
                break;
            case 'valid':
                $this->valid = $value;
                break;
            case 'latitude':
                $this->latitude = $value;
                break;
            case 'longitude':
                $this->longitude = $value;
                break;
            case 'altitude':
                $this->altitude = $value;
                break;
            case 'speed':
                $this->speed = $value;
                break;
            case 'course':
                $this->course = $value;
                break;
            case 'thisAddress':
                $this->thisAddress = $value;
                break;
            case 'accuracy':
                $this->accuracy = $value;
                break;
            case 'network':
                $this->network = $value;
                break;
        }
    }
}
?>
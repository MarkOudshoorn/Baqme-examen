<?php
class vehicle
{
    private $id;
    private $title;
    private $stat;
    private $content;
    private $created;
    private $last_modified;
    private $edit_lock;
    private $edit_last;
    private $tracker;
    private $vehicletype;
    private $adjust;
    private $fleet;
    private $last_maintenance;
    private $last_report;
    private $deploy;
    private $b2blocation;
    private $b2blocation_coordinates;
    private $sleutelcode;
    private $station_based;
    private $project;
    private $special_project_desc;
    private $lastpump;
    private $station_coords;
    private $yeply;

    public function __construct($row)
    {
        $this->id = $row["id"];
        $this->title = $row["title"];
        $this->stat = $row["stat"];
        $this->content = $row["content"];
        $this->created = $row["created"];
        $this->last_modified = $row["last_modified"];
        $this->edit_lock = $row["edit_lock"];
        $this->edit_last = $row["edit_last"];
        $this->tracker = $row["tracker"];
        $this->vehicletype = $row["vehicletype"];
        $this->adjust = $row["adjust"];
        $this->fleet = $row["fleet"];
        $this->last_maintenance = $row["last_maintenance"];
        $this->last_report = $row["last_report"];
        $this->deploy = $row["deploy"];
        $this->b2blocation = $row["b2blocation"];
        $this->b2blocation_coordinates = $row["b2blocation_coordinates"];
        $this->sleutelcode = $row["sleutelcode"];
        $this->station_based = $row["station_based"];
        $this->project = $row["project"];
        $this->special_project_desc = $row["special_project_desc"];
        $this->lastpump = $row["lastpump"];
        $this->station_coords = $row["station_coordinates"];
        $this->yeply = $row["yeply"];
    }
      // Getter method
    public function Get($property)
    {
        switch ($property) {
            case "id":
                return $this->id;
                break;
            case "title":
                return $this->title;
                break;
            case "stat":
                return $this->stat;
                break;
            case "content":
                return $this->content;
                break;
            case "created":
                return $this->created;
                break;
            case "last_modified":
                return $this->last_modified;
                break;
            case "edit_lock":
                return $this->edit_lock;
                break;
            case "edit_last":
                return $this->edit_last;
                break;
            case "tracker":
                return $this->tracker;
                break;
            case "vehicletype":
                return $this->vehicletype;
                break;
            case "adjust":
                return $this->adjust;
                break;
            case "fleet":
                return $this->fleet;
                break;
            case "last_maintenance":
                return $this->last_maintenance;
                break;
            case "last_report":
                return $this->last_report;
                break;
            case "deploy":
                return $this->deploy;
                break;
            case "b2blocation":
                return $this->b2blocation;
                break;
            case "b2blocation_coordinates":
                return $this->b2blocation_coordinates;
                break;
            case "sleutelcode":
                return $this->sleutelcode;
                break;
            case "station_based":
                return $this->station_based;
                break;
            case "project":
                return $this->project;
                break;
            case "special_project_desc":
                return $this->special_project_desc;
                break;
            case "lastpump":
                return $this->lastpump;
                break;
            case "station_coords":
                return $this->station_coords;
                break;
            case "yeply":
                return $this->yeply;
                break;
            default:
                return null; // Return null for non-existent properties
        }
    }

    // Setter method
    public function Set($property, $value)
    {
        switch ($property) {
            case "id":
                $this->id = $value;
                break;
            case "title":
                $this->title = $value;
                break;
            case "stat":
                $this->stat = $value;
                break;
            case "content":
                $this->content = $value;
                break;
            case "created":
                $this->created = $value;
                break;
            case "last_modified":
                $this->last_modified = $value;
                break;
            case "edit_lock":
                $this->edit_lock = $value;
                break;
            case "edit_last":
                $this->edit_last = $value;
                break;
            case "tracker":
                $this->tracker = $value;
                break;
            case "vehicletype":
                $this->vehicletype = $value;
                break;
            case "adjust":
                $this->adjust = $value;
                break;
            case "fleet":
                $this->fleet = $value;
                break;
            case "last_maintenance":
                $this->last_maintenance = $value;
                break;
            case "last_report":
                $this->last_report = $value;
                break;
            case "deploy":
                $this->deploy = $value;
                break;
            case "b2blocation":
                $this->b2blocation = $value;
                break;
            case "b2blocation_coordinates":
                $this->b2blocation_coordinates = $value;
                break;
            case "sleutelcode":
                $this->sleutelcode = $value;
                break;
            case "station_based":
                $this->station_based = $value;
                break;
            case "project":
                $this->project = $value;
                break;
            case "special_project_desc":
                $this->special_project_desc = $value;
                break;
            case "lastpump":
                $this->lastpump = $value;
                break;
            case "station_coords":
                $this->station_coords = $value;
                break;
            case "yeply":
                $this->yeply = $value;
                break;
        }
    }

}

?>
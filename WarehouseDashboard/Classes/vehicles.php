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

}

?>
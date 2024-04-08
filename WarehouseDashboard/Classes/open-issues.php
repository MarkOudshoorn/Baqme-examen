<?php
class Openissues {
    public $name;
    private $id;
    private $title;
    private $content;

    // Constructor
    public function __construct($row) {
        $this->id = $row["id"];
        $this->name = $row["name"];
        $this->title = $row["title"];
        $this->content = $row["content"];
    }
}

?>

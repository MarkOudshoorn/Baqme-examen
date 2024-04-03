<?php
class WHissue {
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

    public function Get($whatToGet)
    {
        switch($whatToGet)
        {
            case "id":
                return $this->id;
                break;
            case "name":
                return $this->name;
                break;
            case "title":
                return $this->title;
                break;
            case "content":
                return $this->content;
                break;
            default:
                return "No valid field found.";
        }
    }
}

?>

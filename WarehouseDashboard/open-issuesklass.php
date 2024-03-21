<?php
require_once "DBconnecting.php";
class Openissues {
    public $name;
    private $id;
    private $title;
    private $content;

    // Constructor
    public function __construct($id, $name, $title, $content) {
        $this->id = $id;
        $this->name = $name;
        $this->title = $title;
        $this->content = $content;
    }

    // Getters en setters
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getContent() {
        return $this->content;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    
}

?>

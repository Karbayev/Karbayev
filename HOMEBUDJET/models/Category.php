<?php

class Category {
    private $id;
    private $user_id;
    private $name;
    private $color;

    public function __construct($user_id, $name, $color, $id = null) {
        $this->user_id = $user_id;
        $this->name = $name;
        $this->color = $color;
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getName() {
        return $this->name;
    }

    public function getColor() {
        return $this->color;
    }
}
?>

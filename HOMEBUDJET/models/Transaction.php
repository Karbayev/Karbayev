<?php

class Transaction {
    private $id;
    private $user_id;
    private $amount;
    private $category_id;
    private $type; // income or expense
    private $created_at;

    public function __construct($user_id, $amount, $category_id, $type, $created_at = null, $id = null) {
        $this->user_id = $user_id;
        $this->amount = $amount;
        $this->category_id = $category_id;
        $this->type = $type;
        $this->created_at = $created_at ? $created_at : date('Y-m-d H:i:s');
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function getCategoryId() {
        return $this->category_id;
    }

    public function getType() {
        return $this->type;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }
}
?>

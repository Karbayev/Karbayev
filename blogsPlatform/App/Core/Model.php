<?php

namespace App\Core;

use App\Core\Database;

abstract class Model
{
    protected Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }
}

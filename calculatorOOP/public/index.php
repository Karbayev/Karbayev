<?php

require '../app/controllers/CalculatorController.php';

$url = isset($_GET['url']) ? $_GET['url'] : '';

$controller = new CalculatorController();
$controller->index($url);


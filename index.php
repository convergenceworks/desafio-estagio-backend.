<?php
header("Content-type: application/json; charset=utf-8");

require_once __DIR__ . "/vendor/autoload.php";

$route = new \Src\Core\Api();

$route->get('/noticia', 'Reader', 'bootstrap');


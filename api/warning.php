<?php

require '../framework/bootstrap.inc.php';

$data = file_get_contents('php://input');

$data = json_decode($data,true);


$data = $_POST;
if (!empty($data)) {
    pdo_insert('wristband_warning', $data);
}
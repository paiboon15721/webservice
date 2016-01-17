<?php
require '../core/init.php';
header('Content-Type: application/json');
echo Consule::get(
 array(
   )
)->getJSON();
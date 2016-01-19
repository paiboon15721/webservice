<?php
require '../core/init.php';
header('Content-Type: application/json');
echo Title::get(
 array(
   )
)->getJSON();
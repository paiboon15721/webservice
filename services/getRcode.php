<?php
require '../core/init.php';
header('Content-Type: application/json');
echo Rcode::get(
 array(
       Input::get('rcode'),
   )
)->getJSON();
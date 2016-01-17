<?php
require '../core/init.php';
header('Content-Type: application/json');
echo CC::get(
 array(
       Input::get('description'),
       Input::get('flagAll'),
   )
)->getJSON();
<?php
require '../core/init.php';
header('Content-Type: application/json');
echo AA::get(
 array(
       Input::get('cc'),
       Input::get('flagAll'),
   )
)->getJSON();
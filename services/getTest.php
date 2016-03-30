<?php
require '../core/init.php';
header('Content-Type: application/json');
echo Test::get(
 array(
       Input::get('description'),
       Input::get('flagAll'),
   )
)->getJSON();
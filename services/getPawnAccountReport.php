<?php
require '../core/init.php';
header('Content-Type: application/json');
echo PawnAccountReport::get(
 array(
       Input::get('licRcode'),
       Input::get('licId'),
       Input::get('year'),
   )
)->getJSON();
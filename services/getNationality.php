<?php
require '../core/init.php';
header('Content-Type: application/json');
echo Nationality::get(
 array(
       Input::get('flagOrder'),
   )
)->getJSON();
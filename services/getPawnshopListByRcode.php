<?php
require '../core/init.php';
header('Content-Type: application/json');
echo PawnshopListByRcode::get(
 array(
       Input::get('licRcode'),
   )
)->getJSON();
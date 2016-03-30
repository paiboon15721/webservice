<?php
require '../core/init.php';
header('Content-Type: application/json');
echo PawnshopDetail::get(
 array(
       Input::get('licRcode'),
       Input::get('licId'),
       Input::get('siteId'),
   )
)->getJSON();
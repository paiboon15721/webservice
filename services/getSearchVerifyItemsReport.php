<?php
require '../core/init.php';
header('Content-Type: application/json');
echo SearchVerifyItemsReport::get(
 array(
       Input::get('licRcode'),
       Input::get('licId'),
   )
)->getJSON();
<?php
require '../core/init.php';
header('Content-Type: application/json');
echo PawnTicket::get(
 array(
       Input::get('licRcode'),
       Input::get('licId'),
       Input::get('issueNo'),
       Input::get('flag'),
   )
)->getJSON();
<?php
require '../core/init.php';
header('Content-Type: application/json');
echo PawnTicketDate::get(
 array(
       Input::get('licRcode'),
       Input::get('licId'),
       Input::get('issueNo'),
   )
)->getJSON();
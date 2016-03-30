<?php
require '../core/init.php';
header('Content-Type: application/json');
echo PawnTicketDetail::get(
 array(
       Input::get('licRcode'),
       Input::get('licId'),
       Input::get('seq'),
       Input::get('issueNo'),
   )
)->getJSON();
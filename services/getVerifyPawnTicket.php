<?php
require '../core/init.php';
header('Content-Type: application/json');
echo VerifyPawnTicket::get(
 array(
       Input::get('licRcode'),
       Input::get('licId'),
       Input::get('updEmp'),
       Input::get('issueNo'),
       Input::get('checkDate'),
   )
)->getJSON();
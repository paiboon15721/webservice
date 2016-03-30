<?php
require '../core/init.php';
header('Content-Type: application/json');
echo UpdatePawnTicketDate::get(
 array(
       Input::get('licRcode'),
       Input::get('licId'),
       Input::get('issueNo'),
       Input::get('datePost'),
       Input::get('dateExpire'),
       Input::get('updEmp'),
   )
)->getJSON();
<?php
require '../core/init.php';
header('Content-Type: application/json');
echo VerifyPawnAccount::get(
 array(
       Input::get('rcode'),
       Input::get('month'),
       Input::get('year'),
   )
)->getJSON();
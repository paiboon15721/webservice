<?php
require '../core/init.php';
header('Content-Type: application/json');
echo DeletePawnAccount::get(
 array(
       Input::get('licRcode'),
       Input::get('licId'),
       Input::get('month'),
       Input::get('year'),
       Input::get('accountId'),
   )
)->getJSON();
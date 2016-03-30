<?php
require '../core/init.php';
header('Content-Type: application/json');
echo DatePost::get(
 array(
       Input::get('licRcode'),
       Input::get('licId'),
       Input::get('issueNo'),
   )
)->getJSON();
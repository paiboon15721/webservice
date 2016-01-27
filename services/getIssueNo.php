<?php
require '../core/init.php';
header('Content-Type: application/json');
echo IssueNo::get(
 array(
       Input::get('licRcode'),
       Input::get('licId'),
   )
)->getJSON();
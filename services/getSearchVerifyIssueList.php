<?php
require '../core/init.php';
header('Content-Type: application/json');
echo SearchVerifyIssueList::get(
 array(
       Input::get('licRcode'),
       Input::get('month'),
       Input::get('year'),
       Input::get('licId'),
   )
)->getJSON();
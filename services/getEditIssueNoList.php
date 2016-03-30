<?php
require '../core/init.php';
header('Content-Type: application/json');
echo EditIssueNoList::get(
 array(
       Input::get('licRcode'),
       Input::get('licId'),
   )
)->getJSON();
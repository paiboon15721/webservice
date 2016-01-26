<?php
require '../core/init.php';
header('Content-Type: application/json');
echo ItemsReport::get(
 array(
       Input::get('month'),
       Input::get('year'),
       Input::get('flag'),
   )
)->getJSON();
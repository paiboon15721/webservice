<?php
require '../core/init.php';
header('Content-Type: application/json');
echo TT::get(
 array(
       Input::get('ccaa'),
       Input::get('flagAll'),
   )
)->getJSON();
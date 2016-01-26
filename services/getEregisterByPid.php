<?php
require '../core/init.php';
header('Content-Type: application/json');
echo EregisterByPid::get(
 array(
       Input::get('licReg'),
       Input::get('pid'),
   )
)->getJSON();
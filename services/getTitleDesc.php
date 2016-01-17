<?php
require '../core/init.php';
header('Content-Type: application/json');
echo TitleDesc::get(
 array(
       Input::get('titleCode'),
   )
)->getJSON();